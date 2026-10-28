@extends('layouts.app')

@section('title', 'Detail Ticket')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2>
                Detail Ticket
            </h2>

            <p class="text-muted mb-0">

                #{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}

                -
                {{ $ticket->title }}

            </p>

        </div>


        <div class="d-flex gap-2">

            <a
                href="{{ route('tickets.index') }}"
                class="btn btn-secondary"
            >
                ← Kembali
            </a>


            @if(
                auth()->user()->role === 'user'
                && $ticket->user_id === auth()->id()
            )

                <a
                    href="{{ route('tickets.edit', $ticket) }}"
                    class="btn btn-warning"
                >
                    Edit
                </a>

            @endif

        </div>

    </div>


    {{-- SUCCESS MESSAGE --}}

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


    @if($errors->any())

        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

    @endif


    <div class="row g-4">

        {{-- INFORMASI TICKET --}}

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start mb-4">

                        <div>

                            <h4 class="mb-1">
                                {{ $ticket->title }}
                            </h4>

                            <small class="text-muted">

                                Dibuat
                                {{ $ticket->created_at->format('d M Y H:i') }}

                            </small>

                        </div>


                        {{-- STATUS --}}

                        @if($ticket->status === 'open')

                            <span class="badge bg-primary fs-6">
                                Open
                            </span>

                        @elseif($ticket->status === 'processing')

                            <span class="badge bg-warning text-dark fs-6">
                                Processing
                            </span>

                        @elseif($ticket->status === 'resolved')

                            <span class="badge bg-success fs-6">
                                Resolved
                            </span>

                        @else

                            <span class="badge bg-secondary fs-6">
                                Closed
                            </span>

                        @endif

                    </div>


                    {{-- DESCRIPTION --}}

                    <div class="mb-4">

                        <h6 class="fw-bold">
                            Deskripsi
                        </h6>

                        <div class="bg-light rounded p-3">

                            {!! nl2br(e($ticket->description)) !!}

                        </div>

                    </div>


                    {{-- DETAIL --}}

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <small class="text-muted">
                                Pembuat
                            </small>

                            <div class="fw-semibold">

                                {{ $ticket->user->name }}

                            </div>

                        </div>


                        <div class="col-md-6 mb-3">

                            <small class="text-muted">
                                Category
                            </small>

                            <div class="fw-semibold">

                                {{ $ticket->category->name }}

                            </div>

                        </div>


                        <div class="col-md-6 mb-3">

                            <small class="text-muted">
                                Priority
                            </small>

                            <div>

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

                            </div>

                        </div>


                        <div class="col-md-6 mb-3">

                            <small class="text-muted">
                                Assigned To
                            </small>

                            <div class="fw-semibold">

                                {{ $ticket->assignee->name ?? 'Belum ditugaskan' }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- KOMENTAR --}}

            <div class="card border-0 shadow-sm mt-4">

                <div class="card-body">

                    <h5 class="mb-4">
                        Komentar
                    </h5>


                    @forelse($ticket->comments as $comment)

                        <div class="border-bottom pb-3 mb-3">

                            <div class="d-flex justify-content-between">

                                <strong>
                                    {{ $comment->user->name }}
                                </strong>

                                <small class="text-muted">

                                    {{ $comment->created_at->format('d M Y H:i') }}

                                </small>

                            </div>


                            <div class="mt-2">

                                {!! nl2br(e($comment->comment)) !!}

                            </div>

                        </div>

                    @empty

                        <p class="text-muted">

                            Belum ada komentar.

                        </p>

                    @endforelse


                    {{-- FORM KOMENTAR --}}

                    <form
                        action="{{ route('tickets.comments.store', $ticket) }}"
                        method="POST"
                        class="mt-4"
                    >

                        @csrf


                        <div class="mb-3">

                            <label class="form-label">
                                Tambahkan Komentar
                            </label>

                            <textarea
                                name="comment"
                                class="form-control @error('comment') is-invalid @enderror"
                                rows="4"
                                placeholder="Tulis komentar..."
                            >{{ old('comment') }}</textarea>


                            @error('comment')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Kirim Komentar
                        </button>

                    </form>

                </div>

            </div>

        </div>


        {{-- SIDEBAR --}}

        <div class="col-lg-4">


            {{-- ADMIN CONTROL --}}

            @if(auth()->user()->role === 'admin')

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <h5 class="mb-4">
                            Ticket Management
                        </h5>


                        <form
                            action="{{ route('tickets.update', $ticket) }}"
                            method="POST"
                        >

                            @csrf

                            @method('PUT')


                            {{-- CATEGORY --}}

                            <div class="mb-3">

                                <label class="form-label">
                                    Category
                                </label>

                                <select
                                    name="category_id"
                                    class="form-select"
                                    required
                                >

                                    @foreach(
                                        $categories as $category
                                    )

                                        <option
                                            value="{{ $category->id }}"
                                            @selected(
                                                old('category_id', $ticket->category_id) == $category->id
                                            )
                                        >
                                            {{ $category->name }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- TITLE --}}

                            <div class="mb-3">

                                <label class="form-label">
                                    Title
                                </label>

                                <input
                                    type="text"
                                    name="title"
                                    class="form-control"
                                    value="{{ old('title', $ticket->title) }}"
                                    required
                                >

                            </div>


                            {{-- DESCRIPTION --}}

                            <div class="mb-3">

                                <label class="form-label">
                                    Description
                                </label>

                                <textarea
                                    name="description"
                                    class="form-control"
                                    rows="4"
                                    required
                                >{{ old('description', $ticket->description) }}</textarea>

                            </div>


                            {{-- PRIORITY --}}

                            <div class="mb-3">

                                <label class="form-label">
                                    Priority
                                </label>

                                <select
                                    name="priority"
                                    class="form-select"
                                >

                                    <option
                                        value="low"
                                        @selected(old('priority', $ticket->priority) === 'low')
                                    >
                                        Low
                                    </option>

                                    <option
                                        value="medium"
                                        @selected(old('priority', $ticket->priority) === 'medium')
                                    >
                                        Medium
                                    </option>

                                    <option
                                        value="high"
                                        @selected(old('priority', $ticket->priority) === 'high')
                                    >
                                        High
                                    </option>

                                </select>

                            </div>


                            {{-- STATUS --}}

                            <div class="mb-3">

                                <label class="form-label">
                                    Status
                                </label>

                                <select
                                    name="status"
                                    class="form-select"
                                >

                                    <option
                                        value="open"
                                        @selected(old('status', $ticket->status) === 'open')
                                    >
                                        Open
                                    </option>

                                    <option
                                        value="processing"
                                        @selected(old('status', $ticket->status) === 'processing')
                                    >
                                        Processing
                                    </option>

                                    <option
                                        value="resolved"
                                        @selected(old('status', $ticket->status) === 'resolved')
                                    >
                                        Resolved
                                    </option>

                                    <option
                                        value="closed"
                                        @selected(old('status', $ticket->status) === 'closed')
                                    >
                                        Closed
                                    </option>

                                </select>

                            </div>


                            {{-- ASSIGNEE --}}

                            <div class="mb-3">

                                <label class="form-label">
                                    Assign To
                                </label>

                                <select
                                    name="assigned_to"
                                    class="form-select"
                                >

                                    <option value="">
                                        -- Belum ditugaskan --
                                    </option>


                                    @foreach($itSupports as $itSupport)

                                        <option
                                            value="{{ $itSupport->id }}"
                                            @selected(
                                                old('assigned_to', $ticket->assigned_to) == $itSupport->id
                                            )
                                        >
                                            {{ $itSupport->name }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <button
                                type="submit"
                                class="btn btn-primary w-100"
                            >
                                Simpan Perubahan
                            </button>

                        </form>

                    </div>

                </div>

            @endif


            {{-- IT SUPPORT CONTROL --}}

            @if(auth()->user()->role === 'it_support')

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <h5 class="mb-4">
                            Update Status
                        </h5>


                        <form
                            action="{{ route('tickets.update', $ticket) }}"
                            method="POST"
                        >

                            @csrf

                            @method('PUT')


                            <div class="mb-3">

                                <label class="form-label">
                                    Status
                                </label>

                                <select
                                    name="status"
                                    class="form-select"
                                >

                                    <option
                                        value="open"
                                        @selected($ticket->status === 'open')
                                    >
                                        Open
                                    </option>

                                    <option
                                        value="processing"
                                        @selected($ticket->status === 'processing')
                                    >
                                        Processing
                                    </option>

                                    <option
                                        value="resolved"
                                        @selected($ticket->status === 'resolved')
                                    >
                                        Resolved
                                    </option>

                                    <option
                                        value="closed"
                                        @selected($ticket->status === 'closed')
                                    >
                                        Closed
                                    </option>

                                </select>

                            </div>


                            <button
                                type="submit"
                                class="btn btn-primary w-100"
                            >
                                Update Status
                            </button>

                        </form>

                    </div>

                </div>

            @endif


            {{-- ACTIVITY --}}

            <div class="card border-0 shadow-sm mt-4">

                <div class="card-body">

                    <h5 class="mb-4">
                        Activity
                    </h5>


                    @forelse(
                        $ticket->activities->sortByDesc('created_at')
                        as $activity
                    )

                        <div class="d-flex mb-4">

                            <div class="me-3">

                                <span
                                    class="badge bg-primary rounded-circle p-2"
                                >
                                    •
                                </span>

                            </div>


                            <div>

                                <div class="fw-semibold">

                                    {{ $activity->description }}

                                </div>


                                <small class="text-muted">

                                    {{ $activity->user->name }}

                                    ·

                                    {{ $activity->created_at->format('d M Y H:i') }}

                                </small>

                            </div>

                        </div>

                    @empty

                        <p class="text-muted">

                            Belum ada activity.

                        </p>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>

@endsection