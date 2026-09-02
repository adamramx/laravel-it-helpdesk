<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function index(): RedirectResponse
    {
        $user = auth()->user();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'it_support' => redirect()->route('it.dashboard'),
            'user' => redirect()->route('user.dashboard'),
            default => abort(403),
        };
    }
}