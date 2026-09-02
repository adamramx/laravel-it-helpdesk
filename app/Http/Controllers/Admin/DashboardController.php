<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTickets = Ticket::count();

        $openTickets = Ticket::where('status', 'open')->count();

        $processingTickets = Ticket::where(
            'status',
            'processing'
        )->count();

        $resolvedTickets = Ticket::where(
            'status',
            'resolved'
        )->count();

        $closedTickets = Ticket::where(
            'status',
            'closed'
        )->count();

        $recentTickets = Ticket::with([
            'user',
            'category',
            'assignee',
        ])
            ->latest()
            ->take(5)
            ->get();

        return view(
            'admin.dashboard',
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