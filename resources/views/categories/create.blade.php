@extends('layouts.app')

@section('title', 'Add Category')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h2>Add Category</h2>

        <p class="text-muted">
            Tambahkan kategori masalah IT.
        </p>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <form action="{{ route('categories.store') }}"
                  method="POST">

                @csrf


                <div class="mb-3">

                    <label class="form-label">
                        Category Name
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Contoh: Hardware">

                    @error('name')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <div class="mb-3">

                    <label class="form-label">
                        Description
                    </label>

                    <textarea name="description"
                              rows="4"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Deskripsi kategori...">{{ old('description') }}</textarea>

                    @error('description')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <div class="d-flex gap-2">

                    <a href="{{ route('categories.index') }}"
                       class="btn btn-secondary">

                        Back

                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        Save Category

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
