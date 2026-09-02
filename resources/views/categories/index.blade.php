@extends('layouts.app')

@section('title', 'Categories')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">Categories</h2>

            <p class="text-muted mb-0">
                Kelola kategori masalah IT.
            </p>
        </div>

        <a href="{{ route('categories.create') }}"
           class="btn btn-primary">

            + Add Category

        </a>

    </div>


    {{-- Alert Success --}}

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- Validation Error --}}

    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th width="70">
                                #
                            </th>

                            <th>
                                Name
                            </th>

                            <th>
                                Description
                            </th>

                            <th>
                                Created
                            </th>

                            <th width="180">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($categories as $category)

                            <tr>

                                <td>
                                    {{ $categories->firstItem() + $loop->index }}
                                </td>

                                <td>

                                    <strong>
                                        {{ $category->name }}
                                    </strong>

                                </td>

                                <td>

                                    {{ $category->description ?? '-' }}

                                </td>

                                <td>

                                    {{ $category->created_at->format('d M Y') }}

                                </td>

                                <td>

                                    <a href="{{ route('categories.edit', $category) }}"
                                       class="btn btn-sm btn-warning">

                                        Edit

                                    </a>


                                    <form action="{{ route('categories.destroy', $category) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">

                                        @csrf

                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger">

                                            Delete

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="text-center py-4 text-muted">

                                    Belum ada kategori.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <div class="mt-3">

                {{ $categories->links() }}

            </div>

        </div>

    </div>

</div>

@endsection
