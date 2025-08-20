@extends('layouts.app')

@section('title', isset($book) ? 'Редактировать книгу' : 'Добавить книгу')

@section('content')
    <h1>{{ isset($book) ? 'Редактировать книгу' : 'Добавить книгу' }}</h1>

    <form action="{{ isset($book) ? route('books.update', $book) : route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($book))
            @method('PUT')
        @endif

        <label>Автор</label>
        <select name="author_id" class="form-select mb-3" required>
            <option value="">Выберите автора</option>
            @foreach($authors as $author)
                <option value="{{ $author->id }}"
                    {{ old('author_id', $book->author_id ?? '') == $author->id ? 'selected' : '' }}>
                    {{ $author->second_name . " " . strtoupper(mb_substr($author->first_name, 0, 1)) . ". " . strtoupper(mb_substr($author->patronymic, 0, 1)). "." }}
                </option>
            @endforeach
        </select>
        <div class="mb-3">
            <label>Название</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $book->title ?? '') }}">
        </div>
        <div class="mb-3">
            <label>Год выпуска</label>
            <input type="number" name="year" class="form-control" value="{{ old('year', $book->year ?? '') }}">
        </div>
        <div class="mb-3">
            <label>Жанр</label>
            <input type="text" name="genre" class="form-control" value="{{ old('genre', $book->genre ?? '') }}">
        </div>
        <div class="mb-3">
            <label>Количество страниц</label>
            <input type="number" name="pages" class="form-control" value="{{ old('pages', $book->pages ?? '') }}">
        </div>
        <div class="mb-3">
            <label>Обложка</label>
            <input type="file" name="cover" class="form-control">
            @if(isset($book) && $book->cover)
                <img src="{{ Storage::url($book->cover) }}" width="100" class="mt-2 img-thumbnail">
            @endif
        </div>
        <button type="submit" class="btn btn-success">{{ isset($book) ? 'Обновить' : 'Добавить' }}</button>
    </form>
@endsection
