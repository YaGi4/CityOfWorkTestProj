<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        return view('authors.index', compact('authors'));
    }

    public function create()
    {
        return view('authors.form');
    }

    public function store(CreateAuthorRequest $request)
    {
        $data = $request->validated();

        Author::create($data);

        return redirect()->route('authors.index')->with('success', 'Автор добавлен!');
    }

    public function edit(Author $author)
    {
        return view('authors.form', compact('author'));
    }

    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $data = $request->validated();

        $author->update($data);

        return redirect()->route('authors.index')->with('success', 'Автор обновлен!');
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return redirect()->route('books.index')->with('success', 'Автор удален!');
    }
}
