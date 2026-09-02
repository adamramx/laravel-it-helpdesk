<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketActivity;
use App\Models\TicketComment;
use Illuminate\Http\Request;

class TicketCommentController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {
            // Admin boleh komentar.
        } elseif ($user->role === 'it_support') {

            if ($ticket->assigned_to !== $user->id) {
                abort(403);
            }

        } elseif ($user->role === 'user') {

            if ($ticket->user_id !== $user->id) {
                abort(403);
            }

        } else {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'comment' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Simpan Comment
        |--------------------------------------------------------------------------
        */

        TicketComment::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'comment' => $validated['comment'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Simpan Activity
        |--------------------------------------------------------------------------
        */

        TicketActivity::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'action' => 'comment',
            'description' => 'Menambahkan komentar pada ticket.',
        ]);

        return redirect()
            ->route('tickets.show', $ticket)
            ->with(
                'success',
                'Komentar berhasil ditambahkan.'
            );
    }
}