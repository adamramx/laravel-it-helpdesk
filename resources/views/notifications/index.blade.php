@extends('layouts.app')

@section('title', 'Notifications')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Notifications</h2>

            <p class="text-muted mb-0">
                Informasi terbaru mengenai ticket Anda.
            </p>
        </div>

        @if($notifications->where('is_read', false)->count() > 0)

            <form
                action="{{ route('notifications.read-all') }}"
                method="POST"
            >
                @csrf

                <button
                    type="submit"
                    class="btn btn-outline-primary"
                >
                    Tandai Semua Dibaca
                </button>
            </form>

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


    {{-- Notification List --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            @forelse($notifications as $notification)

                <div
                    class="p-4 border-bottom
                    {{ !$notification->is_read ? 'bg-light' : '' }}"
                >

                    <div class="d-flex justify-content-between align-items-start">

                        {{-- Notification Content --}}
                        <div class="d-flex">

                            {{-- Icon --}}
                            <div class="me-3">

                                @if($notification->type === 'success')

                                    <span
                                        class="badge bg-success rounded-circle p-2"
                                    >
                                        ✓
                                    </span>

                                @elseif($notification->type === 'warning')

                                    <span
                                        class="badge bg-warning text-dark rounded-circle p-2"
                                    >
                                        !
                                    </span>

                                @else

                                    <span
                                        class="badge bg-primary rounded-circle p-2"
                                    >
                                        i
                                    </span>

                                @endif

                            </div>


                            {{-- Text --}}
                            <div>

                                <h6 class="mb-1">

                                    {{ $notification->title }}

                                    @if(!$notification->is_read)

                                        <span class="badge bg-danger ms-2">
                                            Baru
                                        </span>

                                    @endif

                                </h6>


                                <p class="mb-1 text-muted">

                                    {{ $notification->message }}

                                </p>


                                <small class="text-muted">

                                    {{ $notification->created_at->diffForHumans() }}

                                </small>

                            </div>

                        </div>


                        {{-- Action --}}
                        <div>

                            @if(!$notification->is_read)

                                <form
                                    action="{{ route(
                                        'notifications.read',
                                        $notification->id
                                    ) }}"
                                    method="POST"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-primary"
                                    >
                                        Lihat
                                    </button>

                                </form>

                            @elseif($notification->url)

                                <a
                                    href="{{ $notification->url }}"
                                    class="btn btn-sm btn-outline-primary"
                                >
                                    Buka
                                </a>

                            @endif

                        </div>

                    </div>

                </div>

            @empty

                {{-- Empty State --}}
                <div class="text-center py-5">

                    <div class="mb-3" style="font-size: 40px;">
                        🔔
                    </div>

                    <h5>
                        Belum Ada Notifikasi
                    </h5>

                    <p class="text-muted mb-0">
                        Notifikasi ticket Anda akan muncul di sini.
                    </p>

                </div>

            @endforelse

        </div>

    </div>


    {{-- Pagination --}}
    <div class="mt-3">

        {{ $notifications->links() }}

    </div>

</div>

@endsection