@extends('layouts.app')

@section('title', 'Tickets')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Tickets</h2>

            <p class="text-muted mb-0">
                Daftar laporan masalah IT.
            </p>
        </div>

        @if(auth()->user()->role === 'user')

            <a
                href="{{ route('tickets.create') }}"
                class="btn btn-primary"
            >
                + Buat Ticket
            </a>

        @endif

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    {{-- Filter --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form
                action="{{ route('tickets.index') }}"
                method="GET"
            >

                <div class="row g-3">

                    {{-- Search --}}
                    <div class="col-md-4">

                        <label class="form-label">
                            Cari Ticket
                        </label>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Cari judul atau deskripsi..."
                            value="{{ request('search') }}"
                        >

                    </div>


                    {{-- Category --}}
                    <div class="col-md-2">

                        <label class="form-label">
                            Category
                        </label>

                        <select
                            name="category_id"
                            class="form-select"
                        >

                            <option value="">
                                Semua Category
                            </option>

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}
                                >
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Priority --}}
                    <div class="col-md-2">

                        <label class="form-label">
                            Priority
                        </label>

                        <select
                            name="priority"
                            class="form-select"
                        >

                            <option value="">
                                Semua Priority
                            </option>

                            <option
                                value="low"
                                {{ request('priority') === 'low' ? 'selected' : '' }}
                            >
                                Low
                            </option>

                            <option
                                value="medium"
                                {{ request('priority') === 'medium' ? 'selected' : '' }}
                            >
                                Medium
                            </option>

                            <option
                                value="high"
                                {{ request('priority') === 'high' ? 'selected' : '' }}
                            >
                                High
                            </option>

                        </select>

                    </div>


                    {{-- Status --}}
                    <div class="col-md-2">

                        <label class="form-label">
                            Status
                        </label>

                        <select
                            name="status"
                            class="form-select"
                        >

                            <option value="">
                                Semua Status
                            </option>

                            <option
                                value="open"
                                {{ request('status') === 'open' ? 'selected' : '' }}
                            >
                                Open
                            </option>

                            <option
                                value="processing"
                                {{ request('status') === 'processing' ? 'selected' : '' }}
                            >
                                Processing
                            </option>

                            <option
                                value="resolved"
                                {{ request('status') === 'resolved' ? 'selected' : '' }}
                            >
                                Resolved
                            </option>

                            <option
                                value="closed"
                                {{ request('status') === 'closed' ? 'selected' : '' }}
                            >
                                Closed
                            </option>

                        </select>

                    </div>


                    {{-- Buttons --}}
                    <div class="col-md-2 d-flex align-items-end gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            🔍 Cari
                        </button>

                        <a
                            href="{{ route('tickets.index') }}"
                            class="btn btn-outline-secondary"
                        >
                            Reset
                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Ticket Table --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="mb-0">
                    Daftar Ticket
                </h5>

                <span class="text-muted">
                    {{ $tickets->total() }} ticket
                </span>

            </div>


            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Assignee</th>
                            <th>Action</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($tickets as $ticket)

                            <tr>

                                {{-- ID --}}
                                <td>
                                    #{{ str_pad(
                                        $ticket->id,
                                        4,
                                        '0',
                                        STR_PAD_LEFT
                                    ) }}
                                </td>


                                {{-- Title --}}
                                <td>

                                    <strong>
                                        {{ $ticket->title }}
                                    </strong>

                                    <br>

                                    <small class="text-muted">
                                        {{ $ticket->user->name }}
                                    </small>

                                </td>


                                {{-- Category --}}
                                <td>
                                    {{ $ticket->category->name }}
                                </td>


                                {{-- Priority --}}
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


                                {{-- Status --}}
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


                                {{-- Assignee --}}
                                <td>

                                    {{ $ticket->assignee->name ?? 'Belum ditugaskan' }}

                                </td>


                                {{-- Action --}}
                                <td>

                                    <a
                                        href="{{ route(
                                            'tickets.show',
                                            $ticket
                                        ) }}"
                                        class="btn btn-sm btn-primary"
                                    >
                                        Detail
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center py-5"
                                >

                                    <div style="font-size: 40px;">
                                        🎫
                                    </div>

                                    <h5 class="mt-3">
                                        Ticket Tidak Ditemukan
                                    </h5>

                                    <p class="text-muted mb-0">
                                        Coba ubah kata pencarian atau filter.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            <div class="mt-3">

                {{ $tickets->links() }}

            </div>

        </div>

    </div>

</div>

@endsection