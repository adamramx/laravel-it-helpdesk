<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Notification;
use App\Models\Ticket;
use App\Models\TicketActivity;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Menampilkan daftar ticket.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Ticket::with([
            'user',
            'category',
            'assignee',
        ]);

        if ($user->role === 'it_support') {
            $query->where('assigned_to', $user->id);
        } elseif ($user->role === 'user') {
            $query->where('user_id', $user->id);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tickets = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view(
            'tickets.index',
            compact('tickets', 'categories')
        );
    }


    /**
     * Form membuat ticket.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view(
            'tickets.create',
            compact('categories')
        );
    }


    /**
     * Simpan ticket baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],

            'priority' => [
                'required',
                'in:low,medium,high',
            ],
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'open';

        $ticket = Ticket::create($validated);


        /*
        |--------------------------------------------------------------------------
        | ACTIVITY: TICKET CREATED
        |--------------------------------------------------------------------------
        */

        TicketActivity::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'action' => 'created',
            'description' => 'Membuat ticket baru.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | NOTIFICATION: TICKET BARU UNTUK ADMIN
        |--------------------------------------------------------------------------
        */

        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'Ticket Baru',
                'message' => "Ticket baru dibuat: {$ticket->title}",
                'type' => 'info',
                'url' => route('tickets.show', $ticket),
            ]);
        }


        return redirect()
            ->route('tickets.index')
            ->with(
                'success',
                'Ticket berhasil dibuat.'
            );
    }


    /**
     * Detail ticket.
     */
    public function show(Ticket $ticket)
    {
        $this->authorizeTicket($ticket);

        $ticket->load([
            'user',
            'category',
            'assignee',
            'comments.user',
            'activities.user',
        ]);

        $itSupports = collect();

        if (auth()->user()->role === 'admin') {
            $itSupports = User::where(
                'role',
                'it_support'
            )
                ->orderBy('name')
                ->get();
        }

        return view(
            'tickets.show',
            compact(
                'ticket',
                'itSupports'
            )
        );
    }


    /**
     * Form edit ticket.
     */
    public function edit(Ticket $ticket)
    {
        $this->authorizeTicket($ticket);

        $categories = Category::orderBy('name')->get();

        return view(
            'tickets.edit',
            compact(
                'ticket',
                'categories'
            )
        );
    }


    /**
     * Update ticket.
     */
    public function update(
        Request $request,
        Ticket $ticket
    ) {
        $this->authorizeTicket($ticket);

        $user = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | USER
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'user') {
            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'priority' => 'required|in:low,medium,high',
            ]);

            $ticket->update($validated);
        }


        /*
        |--------------------------------------------------------------------------
        | IT SUPPORT
        |--------------------------------------------------------------------------
        */

        elseif ($user->role === 'it_support') {
            $validated = $request->validate([
                'status' => [
                    'required',
                    'in:open,processing,resolved,closed',
                ],
            ]);

            $oldStatus = $ticket->status;

            $ticket->update($validated);


            if ($oldStatus !== $ticket->status) {

                /*
                |--------------------------------------------------------------------------
                | ACTIVITY: STATUS CHANGED
                |--------------------------------------------------------------------------
                */

                TicketActivity::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $user->id,
                    'action' => 'status_changed',
                    'description' =>
                        "Mengubah status dari {$oldStatus} menjadi {$ticket->status}.",
                ]);


                /*
                |--------------------------------------------------------------------------
                | NOTIFICATION: PEMILIK TICKET
                |--------------------------------------------------------------------------
                */

                Notification::create([
                    'user_id' => $ticket->user_id,
                    'title' => 'Status Ticket Berubah',
                    'message' =>
                        "Status ticket '{$ticket->title}' berubah menjadi {$ticket->status}.",
                    'type' => 'success',
                    'url' => route('tickets.show', $ticket),
                ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        elseif ($user->role === 'admin') {

            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',

                'title' => 'required|string|max:255',

                'description' => 'required|string',

                'priority' => 'required|in:low,medium,high',

                'status' => 'required|in:open,processing,resolved,closed',

                'assigned_to' => [
                    'nullable',
                    'exists:users,id',
                ],
            ]);


            /*
            |--------------------------------------------------------------------------
            | PASTIKAN ASSIGNEE ADALAH IT SUPPORT
            |--------------------------------------------------------------------------
            */

            if (!empty($validated['assigned_to'])) {

                $isITSupport = User::where(
                    'id',
                    $validated['assigned_to']
                )
                    ->where(
                        'role',
                        'it_support'
                    )
                    ->exists();

                if (!$isITSupport) {
                    return back()
                        ->withErrors([
                            'assigned_to' =>
                                'User yang dipilih bukan IT Support.',
                        ])
                        ->withInput();
                }
            }


            /*
            |--------------------------------------------------------------------------
            | SIMPAN NILAI LAMA
            |--------------------------------------------------------------------------
            */

            $oldStatus = $ticket->status;
            $oldAssignedTo = $ticket->assigned_to;


            /*
            |--------------------------------------------------------------------------
            | UPDATE TICKET
            |--------------------------------------------------------------------------
            */

            $ticket->update($validated);


            /*
            |--------------------------------------------------------------------------
            | ACTIVITY + NOTIFICATION: ASSIGNED
            |--------------------------------------------------------------------------
            */

            if ($oldAssignedTo != $ticket->assigned_to) {

                $ticket->load('assignee');

                $assigneeName = $ticket->assignee
                    ? $ticket->assignee->name
                    : 'Tidak ada';


                TicketActivity::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $user->id,
                    'action' => 'assigned',
                    'description' =>
                        "Ticket ditugaskan kepada {$assigneeName}.",
                ]);


                /*
                |--------------------------------------------------------------------------
                | NOTIFICATION: IT SUPPORT
                |--------------------------------------------------------------------------
                */

                if ($ticket->assigned_to) {

                    Notification::create([
                        'user_id' => $ticket->assigned_to,
                        'title' => 'Ticket Ditugaskan',
                        'message' =>
                            "Anda mendapat ticket: {$ticket->title}",
                        'type' => 'warning',
                        'url' => route(
                            'tickets.show',
                            $ticket
                        ),
                    ]);
                }
            }


            /*
            |--------------------------------------------------------------------------
            | ACTIVITY + NOTIFICATION: STATUS
            |--------------------------------------------------------------------------
            */

            if ($oldStatus !== $ticket->status) {

                TicketActivity::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $user->id,
                    'action' => 'status_changed',
                    'description' =>
                        "Mengubah status dari {$oldStatus} menjadi {$ticket->status}.",
                ]);


                /*
                |--------------------------------------------------------------------------
                | NOTIFICATION: PEMILIK TICKET
                |--------------------------------------------------------------------------
                */

                Notification::create([
                    'user_id' => $ticket->user_id,
                    'title' => 'Status Ticket Berubah',
                    'message' =>
                        "Status ticket '{$ticket->title}' berubah menjadi {$ticket->status}.",
                    'type' => 'success',
                    'url' => route(
                        'tickets.show',
                        $ticket
                    ),
                ]);
            }
        }


        return redirect()
            ->route('tickets.show', $ticket)
            ->with(
                'success',
                'Ticket berhasil diperbarui.'
            );
    }


    /**
     * Hapus ticket.
     */
    public function destroy(Ticket $ticket)
    {
        $user = auth()->user();

        if (
            $user->role !== 'admin'
            && $ticket->user_id !== $user->id
        ) {
            abort(403);
        }

        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->with(
                'success',
                'Ticket berhasil dihapus.'
            );
    }


    /**
     * Memastikan user boleh mengakses ticket.
     */
    private function authorizeTicket(Ticket $ticket): void
    {
        $user = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | IT SUPPORT
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'it_support') {

            if ($ticket->assigned_to !== $user->id) {
                abort(403);
            }

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | USER
        |--------------------------------------------------------------------------
        */

        if ($ticket->user_id !== $user->id) {
            abort(403);
        }
    }
}
