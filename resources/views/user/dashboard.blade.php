@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')

<div class="container-fluid">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="mb-4">

        <h2>
            User Dashboard
        </h2>

        <p class="text-muted">

            Selamat datang,
            <strong>{{ auth()->user()->name }}</strong>

        </p>

    </div>


    {{-- ========================================================= --}}
    {{-- STATISTIK --}}
    {{-- ========================================================= --}}

    <div class="row g-4">


        {{-- Total Tickets --}}
        <div class="col-md-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Tickets
                    </h6>

                    <h2>
                        {{ $totalTickets }}
                    </h2>

                    <small class="text-muted">
                        Semua ticket saya
                    </small>

                </div>

            </div>

        </div>


        {{-- Open --}}
        <div class="col-md-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h6 class="text-muted">
                        Open
                    </h6>

                    <h2>
                        {{ $openTickets }}
                    </h2>

                    <small class="text-muted">
                        Menunggu diproses
                    </small>

                </div>

            </div>

        </div>


        {{-- Processing --}}
        <div class="col-md-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h6 class="text-muted">
                        Processing
                    </h6>

                    <h2>
                        {{ $processingTickets }}
                    </h2>

                    <small class="text-muted">
                        Sedang ditangani
                    </small>

                </div>

            </div>

        </div>


        {{-- Resolved --}}
        <div class="col-md-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h6 class="text-muted">
                        Resolved
                    </h6>

                    <h2>
                        {{ $resolvedTickets }}
                    </h2>

                    <small class="text-muted">
                        Sudah selesai
                    </small>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- MY TICKETS --}}
    {{-- ========================================================= --}}

    <div class="card border-0 shadow-sm mt-4">

        <div class="card-body">


            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h5 class="mb-1">
                        My Tickets
                    </h5>

                    <small class="text-muted">
                        Ticket yang kamu buat
                    </small>

                </div>


                <a href="{{ route('tickets.create') }}"
                   class="btn btn-primary">

                    + Buat Ticket

                </a>

            </div>


            <div class="table-responsive">

                <table class="table table-hover align-middle mt-3">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Ticket</th>

                            <th>Category</th>

                            <th>Priority</th>

                            <th>Status</th>

                            <th></th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($recentTickets as $ticket)

                            <tr>


                                {{-- ID --}}
                                <td>

                                    #{{ str_pad($ticket->id, 3, '0', STR_PAD_LEFT) }}

                                </td>


                                {{-- Title --}}
                                <td>

                                    <div class="fw-bold">

                                        {{ $ticket->title }}

                                    </div>

                                    <small class="text-muted">

                                        {{ $ticket->created_at->format('d M Y H:i') }}

                                    </small>

                                </td>


                                {{-- Category --}}
                                <td>

                                    {{ $ticket->category->name ?? '-' }}

                                </td>


                                {{-- Priority --}}
                                <td>

                                    @if($ticket->priority === 'high')

                                        <span class="badge bg-danger">
                                            High
                                        </span>

                                    @elseif($ticket->priority === 'medium')

                                        <span class="badge bg-primary">
                                            Medium
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Low
                                        </span>

                                    @endif

                                </td>


                                {{-- Status --}}
                                <td>

                                    @if($ticket->status === 'open')

                                        <span class="badge bg-info text-dark">
                                            Open
                                        </span>

                                    @elseif($ticket->status === 'processing')

                                        <span class="badge bg-warning text-dark">
                                            Processing
                                        </span>

                                    @elseif($ticket->status === 'resolved')

                                        <span class="badge bg-success">
                                            Resolved
                                        </span>

                                    @elseif($ticket->status === 'closed')

                                        <span class="badge bg-secondary">
                                            Closed
                                        </span>

                                    @else

                                        <span class="badge bg-dark">
                                            {{ ucfirst($ticket->status) }}
                                        </span>

                                    @endif

                                </td>


                                {{-- Detail --}}
                                <td class="text-end">

                                    <a href="{{ route('tickets.show', $ticket) }}"
                                       class="btn btn-sm btn-outline-primary">

                                        Detail

                                    </a>

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center text-muted py-4">

                                    Belum ada ticket.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


</div>

@endsection