@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h2>User Dashboard</h2>

        <p class="text-muted mb-0">
            Selamat datang,
            <strong>{{ auth()->user()->name }}</strong>
        </p>

    </div>


    {{-- STATISTIK --}}

    <div class="row g-4">

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


    {{-- RECENT TICKETS --}}

    <div class="card border-0 shadow-sm mt-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="mb-0">
                    My Recent Tickets
                </h5>

                <a
                    href="{{ route('tickets.create') }}"
                    class="btn btn-sm btn-primary"
                >
                    + Buat Ticket
                </a>

            </div>


            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Assignee</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($recentTickets as $ticket)

                            <tr>

                                <td>
                                    #{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}
                                </td>


                                <td>

                                    <a
                                        href="{{ route('tickets.show', $ticket) }}"
                                        class="text-decoration-none"
                                    >

                                        <strong>
                                            {{ $ticket->title }}
                                        </strong>

                                    </a>

                                </td>


                                <td>
                                    {{ $ticket->category->name }}
                                </td>


                                <td>

                                    @if($ticket->priority === 'high')

                                        <span class="badge bg-danger">
                                            High
                                        </span>

                                    @elseif($ticket->priority === 'medium')

                                        <span class="badge bg-warning text-dark">
                                            Medium
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Low
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    @if($ticket->status === 'open')

                                        <span class="badge bg-primary">
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

                                    @else

                                        <span class="badge bg-secondary">
                                            Closed
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    {{ $ticket->assignee->name ?? 'Belum ditugaskan' }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center py-5 text-muted"
                                >

                                    Kamu belum memiliki ticket.

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