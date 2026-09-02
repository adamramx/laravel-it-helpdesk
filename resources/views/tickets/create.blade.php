@extends('layouts.app')

@section('title', 'Buat Ticket')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h2>Buat Ticket</h2>

        <p class="text-muted">
            Laporkan masalah IT yang kamu alami.
        </p>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <form action="{{ route('tickets.store') }}"
                  method="POST">

                @csrf


                {{-- Category --}}

                <div class="mb-3">

                    <label class="form-label">
                        Kategori
                    </label>

                    <select name="category_id"
                            class="form-select @error('category_id') is-invalid @enderror">

                        <option value="">
                            -- Pilih Kategori --
                        </option>

                        @foreach($categories as $category)

                            <option value="{{ $category->id }}"
                                @selected(old('category_id') == $category->id)>

                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>

                    @error('category_id')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- Title --}}

                <div class="mb-3">

                    <label class="form-label">
                        Judul Masalah
                    </label>

                    <input type="text"
                           name="title"
                           value="{{ old('title') }}"
                           class="form-control @error('title') is-invalid @enderror"
                           placeholder="Contoh: Laptop tidak bisa menyala">

                    @error('title')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- Description --}}

                <div class="mb-3">

                    <label class="form-label">
                        Deskripsi Masalah
                    </label>

                    <textarea name="description"
                              rows="6"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Jelaskan masalah secara detail...">{{ old('description') }}</textarea>

                    @error('description')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- Priority --}}

                <div class="mb-4">

                    <label class="form-label">
                        Priority
                    </label>

                    <select name="priority"
                            class="form-select @error('priority') is-invalid @enderror">

                        <option value="low"
                            @selected(old('priority') === 'low')>

                            Low

                        </option>

                        <option value="medium"
                            @selected(old('priority', 'medium') === 'medium')>

                            Medium

                        </option>

                        <option value="high"
                            @selected(old('priority') === 'high')>

                            High

                        </option>

                    </select>

                    @error('priority')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <div class="d-flex gap-2">

                    <a href="{{ route('tickets.index') }}"
                       class="btn btn-secondary">

                        Batal

                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        Submit Ticket

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection