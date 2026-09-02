@extends('layouts.app')

@section('title', 'Category Detail')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h2>Category Detail</h2>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <h4>
                {{ $category->name }}
            </h4>

            <hr>

            <p>

                <strong>Description:</strong>

            </p>

            <p class="text-muted">

                {{ $category->description ?? 'Tidak ada deskripsi.' }}

            </p>


            <a href="{{ route('categories.index') }}"
               class="btn btn-secondary">

                Back

            </a>

            <a href="{{ route('categories.edit', $category) }}"
               class="btn btn-warning">

                Edit

            </a>

        </div>

    </div>

</div>

@endsection
