<?php

use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;

test('api login issues a sanctum token', function () {
    $user = User::factory()->create([
        'email' => 'api-user@example.test',
        'password' => 'password',
    ]);

    $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ])
        ->assertOk()
        ->assertJsonStructure([
            'token',
            'user' => ['id', 'name', 'email', 'role'],
        ]);
});

test('admins can create and edit user accounts', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'user']);

    $this->actingAs($admin)
        ->get(route('admin.users.create'))
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('admin.users.edit', $user))
        ->assertOk();

    $this->actingAs($admin)
        ->post(route('admin.users.store'), [
            'name' => 'Helpdesk Technician',
            'email' => 'technician@example.test',
            'role' => 'it_support',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
        ->assertRedirect(route('admin.users.index'));

    $this->assertDatabaseHas('users', [
        'email' => 'technician@example.test',
        'role' => 'it_support',
    ]);
});

test('a category used by tickets cannot be deleted', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $owner = User::factory()->create(['role' => 'user']);
    $category = Category::create(['name' => 'Hardware']);

    $ticket = Ticket::create([
        'user_id' => $owner->id,
        'category_id' => $category->id,
        'title' => 'Laptop issue',
        'description' => 'The laptop will not start.',
        'priority' => 'medium',
        'status' => 'open',
    ]);

    $this->actingAs($admin)
        ->from(route('categories.index'))
        ->delete(route('categories.destroy', $category))
        ->assertRedirect(route('categories.index'))
        ->assertSessionHasErrors('category');

    $this->assertDatabaseHas('tickets', ['id' => $ticket->id]);
    $this->assertDatabaseHas('categories', ['id' => $category->id]);
});

test('admins can render ticket management and assigned support can render status controls', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $support = User::factory()->create(['role' => 'it_support']);
    $owner = User::factory()->create(['role' => 'user']);
    $category = Category::create(['name' => 'Software']);

    $ticket = Ticket::create([
        'user_id' => $owner->id,
        'category_id' => $category->id,
        'assigned_to' => $support->id,
        'title' => 'Application error',
        'description' => 'The application closes unexpectedly.',
        'priority' => 'high',
        'status' => 'open',
    ]);

    $this->actingAs($admin)
        ->get(route('tickets.show', $ticket))
        ->assertOk();

    $this->actingAs($support)
        ->get(route('tickets.show', $ticket))
        ->assertOk();

    $this->actingAs($support)
        ->get(route('tickets.edit', $ticket))
        ->assertForbidden();
});
