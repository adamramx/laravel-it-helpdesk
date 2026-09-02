@extends('layouts.app')

@section('title', 'User Management')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>User Management</h2>

            <p class="text-muted mb-0">
                Kelola akun User dan IT Support.
            </p>
        </div>

        <a
            href="{{ route('admin.users.create') }}"
            class="btn btn-primary"
        >
            + Tambah User
        </a>

    </div>


    {{-- Success --}}
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
                action="{{ route('admin.users.index') }}"
                method="GET"
            >

                <div class="row g-3">

                    <div class="col-md-5">

                        <label class="form-label">
                            Cari
                        </label>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Nama atau email..."
                            value="{{ request('search') }}"
                        >

                    </div>


                    <div class="col-md-3">

                        <label class="form-label">
                            Role
                        </label>

                        <select
                            name="role"
                            class="form-select"
                        >

                            <option value="">
                                Semua Role
                            </option>

                            <option
                                value="user"
                                {{ request('role') === 'user' ? 'selected' : '' }}
                            >
                                User
                            </option>

                            <option
                                value="it_support"
                                {{ request('role') === 'it_support' ? 'selected' : '' }}
                            >
                                IT Support
                            </option>

                        </select>

                    </div>


                    <div class="col-md-4 d-flex align-items-end gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            🔍 Cari
                        </button>

                        <a
                            href="{{ route('admin.users.index') }}"
                            class="btn btn-outline-secondary"
                        >
                            Reset
                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- User Table --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Dibuat</th>
                            <th>Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($users as $user)

                            <tr>

                                <td>
                                    #{{ $user->id }}
                                </td>

                                <td>
                                    <strong>
                                        {{ $user->name }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $user->email }}
                                </td>

                                <td>

                                    @if($user->role === 'it_support')

                                        <span class="badge bg-warning text-dark">
                                            IT Support
                                        </span>

                                    @else

                                        <span class="badge bg-primary">
                                            User
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $user->created_at->format('d/m/Y') }}
                                </td>

                                <td>

                                    <a
                                        href="{{ route(
                                            'admin.users.edit',
                                            $user
                                        ) }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        Edit
                                    </a>


                                    <form
                                        action="{{ route(
                                            'admin.users.destroy',
                                            $user
                                        ) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm(
                                            'Yakin ingin menghapus user ini?'
                                        )"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center py-5 text-muted"
                                >
                                    Belum ada user.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <div class="mt-3">

                {{ $users->links() }}

            </div>

        </div>

    </div>

</div>

@endsection