<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalTickets = Ticket::where(
            'user_id',
            $user->id
        )->count();

        $openTickets = Ticket::where(
            'user_id',
            $user->id
        )
            ->where('status', 'open')
            ->count();

        $processingTickets = Ticket::where(
            'user_id',
            $user->id
        )
            ->where('status', 'processing')
            ->count();

        $resolvedTickets = Ticket::where(
            'user_id',
            $user->id
        )
            ->where('status', 'resolved')
            ->count();

        $closedTickets = Ticket::where(
            'user_id',
            $user->id
        )
            ->where('status', 'closed')
            ->count();

        $recentTickets = Ticket::with([
            'category',
            'assignee',
        ])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view(
            'user.dashboard',
            compact(
                'totalTickets',
                'openTickets',
                'processingTickets',
                'resolvedTickets',
                'closedTickets',
                'recentTickets'
            )
        );
    }
}