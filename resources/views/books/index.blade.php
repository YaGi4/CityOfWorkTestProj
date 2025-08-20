@extends('layouts.app')

@section('title', 'Список книг')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="me-3">Список книг</h1>
        @auth
            <a href="{{ route('books.create') }}" class="btn btn-primary">Добавить книгу</a>
        @endauth
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Сортировка</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('books.index') }}" method="GET" enctype="text/plain">
                        <div class="input-group mb-3">
                            <div class="mb-3">
                                <label class="form-label">Автор:</label>
                                <input type="text" name="author_name" class="form-control"
                                    @if(request()->filled('author_name'))
                                        value="{{ request()->string('author_name')->trim() }}"
                                    @endif>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Год:</label>
                                <input type="text" name="year" class="form-control"
                                    @if(request()->filled('year'))
                                        value="{{ request()->string('year')->trim() }}"
                                    @endif>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Жанр:</label>
                                <input type="text" name="genre" class="form-control"
                                    @if(request()->filled('genre'))
                                    value="{{ request()->string('genre')->trim() }}"
                                    @endif>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Применить</button>
                            @if(request()->anyFilled('author_name', 'year', 'genre'))
                                <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Сбросить</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="row">
                @foreach($books as $book)
                    <div class="col-md-4 mb-4 d-flex">
                        <div class="card w-100 d-flex flex-column position-relative">
                            @if($book->cover)
                                <img src="{{ asset('storage/' . $book->cover) }}" class="card-img-top h-100 w-100 object-fit-cover" alt="cover" style="height: 200px;">
                            @else
                                <img src="{{ asset('storage/books/covers/stock_bock_img.jpg') }}" class="card-img-top h-100 w-100 object-fit-cover" alt="cover" style="height: 200px;">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $book->title }}</h5>
                                <p class="card-text">
                                    Автор: {{ $book->author->second_name . " " . strtoupper(mb_substr($book->author->first_name, 0, 1)) . ". " . strtoupper(mb_substr($book->author->patronymic, 0, 1)). "." }}<br>
                                    Год: {{ $book->year }}<br>
                                    Жанр: {{ $book->genre }}<br>
                                    Страницы: {{ $book->pages }}
                                </p>
                                <a href="{{ route('books.show', $book) }}" class="stretched-link"></a>
                            </div>
                            @auth
                                <div class="card-footer d-flex justify-content-between">
                                    <a href="{{ route('books.edit', $book) }}" class="btn btn-sm btn-primary position-relative" style="z-index: 2;">Редактировать</a>
                                    <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger position-relative" style="z-index: 2;" onclick="return confirm('Удалить книгу?')">Удалить</button>
                                    </form>
                                </div>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


        @if($books->hasPages())
            <div class="mb-4">
                {{ $books->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection
