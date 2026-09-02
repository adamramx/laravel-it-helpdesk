<?php

namespace App\Http\Controllers\ITSupport;

use App\Http\Controllers\Controller;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $assignedTickets = Ticket::where(
            'assigned_to',
            $user->id
        )->count();

        $processingTickets = Ticket::where(
            'assigned_to',
            $user->id
        )
            ->where('status', 'processing')
            ->count();

        $resolvedTickets = Ticket::where(
            'assigned_to',
            $user->id
        )
            ->where('status', 'resolved')
            ->count();

        $recentTickets = Ticket::with([
            'user',
            'category',
        ])
            ->where('assigned_to', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view(
            'it.dashboard',
            compact(
                'assignedTickets',
                'processingTickets',
                'resolvedTickets',
                'recentTickets'
            )
        );
    }
}