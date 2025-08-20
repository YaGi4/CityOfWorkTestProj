@extends('layouts.app')

@section('title', 'Список книг')

@section('content')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    @if($book->cover)
                        <img src="{{ asset('storage/' . $book->cover) }}" class="card-img-top" alt="{{ $book->title }}">
                    @endif
                    <div class="card-body">
                        <h2 class="card-title">{{ $book->title }}</h2>
                        <h5 class="text-muted mb-3">Автор: {{ $book->author->name }}</h5>

                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item"><strong>Год:</strong> {{ $book->year }}</li>
                            <li class="list-group-item"><strong>Жанр:</strong> {{ $book->genre }}</li>
                            <li class="list-group-item"><strong>Страниц:</strong> {{ $book->pages }}</li>
                        </ul>

                        <a href="{{ route('books.index') }}" class="btn btn-primary">← Назад к списку книг</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
