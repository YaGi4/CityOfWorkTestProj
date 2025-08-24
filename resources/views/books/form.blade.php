@extends('layouts.app')

@section('title', isset($book) ? 'Редактировать книгу' : 'Добавить книгу')

@section('content')
    <h1>{{ isset($book) ? 'Редактировать книгу' : 'Добавить книгу' }}</h1>

    <form action="{{ isset($book) ? route('books.update', $book) : route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($book))
            @method('PATCH')
        @endif

        <label>Автор</label>
        <select id="author" name="author_id" class="form-select mb-3" required></select>

         <script>
             $(document).ready(function() {
                 $('#author').select2({
                     placeholder: 'Выберите автора',
                     allowClear: true,
                     minimumInputLength: 1,
                     ajax: {
                         url: '{{ route("authors.search") }}',
                         dataType: 'json',
                         delay: 250,
                         data: function(params) {
                             return { search: params.term };
                         },
                         processResults: function(data) {
                             return {
                                 results: data.map(author => ({
                                     id: author.id,
                                     text: author.second_name + ' ' + author.first_name + (author.patronymic ? ' ' + author.patronymic : '')
                                 }))
                             };
                         }
                     },
                     width: '100%'
                 });
             });
         </script>

        <div class="mb-3 mt-3">
            <label>Название</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $book->title ?? '') }}">
            @error('title')
              <div class="text-red-500">{{ "Длина должна быть от 3 до 255" }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label>Год выпуска</label>
            <input type="number" name="year" class="form-control" value="{{ old('year', $book->year ?? '') }}">
            @error('year')
            <div class="text-red-500">{{ "Значение должно быть от 0 до 2025" }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label>Жанр</label>
            <input type="text" name="genre" class="form-control" value="{{ old('genre', $book->genre ?? '') }}">
            @error('genre')
            <div class="text-red-500">{{ "Длина должна быть от 3 до 255" }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label>Количество страниц</label>
            <input type="number" name="pages" class="form-control" value="{{ old('pages', $book->pages ?? '') }}">
            @error('pages')
            <div class="text-red-500">{{ "Значение должно быть от 1 до 9999" }}</div>
            @enderror
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
