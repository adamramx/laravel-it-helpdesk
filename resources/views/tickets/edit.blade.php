@extends('layouts.app')

@section('title', 'Edit Ticket')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h2>Edit Ticket</h2>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <form action="{{ route('tickets.update', $ticket) }}"
                  method="POST">

                @csrf

                @method('PUT')


                <div class="mb-3">

                    <label class="form-label">
                        Kategori
                    </label>

                    <select name="category_id"
                            class="form-select">

                        @foreach($categories as $category)

                            <option value="{{ $category->id }}"
                                @selected($ticket->category_id == $category->id)>

                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="mb-3">

                    <label class="form-label">
                        Judul
                    </label>

                    <input type="text"
                           name="title"
                           value="{{ $ticket->title }}"
                           class="form-control">

                </div>


                <div class="mb-3">

                    <label class="form-label">
                        Deskripsi
                    </label>

                    <textarea name="description"
                              rows="6"
                              class="form-control">{{ $ticket->description }}</textarea>

                </div>


                <div class="mb-4">

                    <label class="form-label">
                        Priority
                    </label>

                    <select name="priority"
                            class="form-select">

                        <option value="low"
                            @selected($ticket->priority === 'low')>

                            Low

                        </option>

                        <option value="medium"
                            @selected($ticket->priority === 'medium')>

                            Medium

                        </option>

                        <option value="high"
                            @selected($ticket->priority === 'high')>

                            High

                        </option>

                    </select>

                </div>


                <a href="{{ route('tickets.show', $ticket) }}"
                   class="btn btn-secondary">

                    Batal

                </a>

                <button type="submit"
                        class="btn btn-primary">

                    Simpan Perubahan

                </button>

            </form>

        </div>

    </div>

</div>

@endsection