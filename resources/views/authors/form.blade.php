@extends('layouts.app')

@section('title', isset($author) ? 'Редактировать автора' : 'Добавить автора')

@section('content')
    <h1>{{ isset($author) ? 'Редактировать автора' : 'Добавить автора' }}</h1>

    <form action="{{ isset($author) ? route('authors.update', $author) : route('authors.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($author))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label>Имя</label>
            <input type="text" name="first_name" class="form-control" value="{{ old('author', $author->first_name ?? '') }}">
        </div>
        <div class="mb-3">
            <label>Фамилия</label>
            <input type="text" name="second_name" class="form-control" value="{{ old('author', $author->second_name ?? '') }}">
        </div>
        <div class="mb-3">
            <label>Отчество</label>
            <input type="text" name="patronymic" class="form-control" value="{{ old('author', $author->patronymic ?? '') }}">
        </div>
        <button type="submit" class="btn btn-success">{{ isset($author) ? 'Обновить' : 'Добавить' }}</button>
    </form>
@endsection
