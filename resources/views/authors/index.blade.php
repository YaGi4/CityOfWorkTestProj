@extends('layouts.app')

@section('title', 'Список авторов')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="me-3">Список авторов</h1>
        @auth
            <a href="{{ route('authors.create') }}" class="btn btn-primary">Добавить автора</a>
        @endauth
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Имя</th>
        </tr>
        </thead>
        <tbody>
        @foreach($authors as $author)
            <tr>
                <td>{{ $author->first_name }}</td>
                <td>{{ $author->second_name }}</td>
                <td>{{ $author->patronymic }}</td>
                @auth
                    <td>
                        <a href="{{ route('authors.edit', $author) }}" class="btn btn-sm btn-primary">Редактировать</a>
                        <form action="{{ route('authors.destroy', $author) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Удалить автора?')">Удалить</button>
                        </form>
                    </td>
                @endauth
            </tr>
        @endforeach
        </tbody>
    </table>

    @if($authors->hasPages())
        <div class="mb-4">
            {{ $authors->links() }}
        </div>
    @endif
@endsection
