<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveAuthorRequest;
use App\Models\Author;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\View\View;

final class AuthorController extends Controller
{
    public function index(): View
    {
        $authors = Author::paginate(15);
        return view('authors.index', compact('authors'));
    }

    public function create(): View
    {
        return view('authors.form');
    }

    public function store(SaveAuthorRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Author::create($data);

        return redirect()->route('authors.index')->with('success', 'Автор добавлен!');
    }

    public function edit(Author $author): View
    {
        return view('authors.form', compact('author'));
    }

    public function update(SaveAuthorRequest $request, Author $author): RedirectResponse
    {
        $data = $request->validated();

        $author->update($data);

        return redirect()->route('authors.index')->with('success', 'Автор обновлен!');
    }

    public function destroy(Author $author): RedirectResponse
    {
        $author->delete();
        return redirect()->route('books.index')->with('success', 'Автор удален!');
    }

    public function search(Request $request): Collection
    {
        $query = Author::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('first_name', 'like', "%{$search}%")
                ->orWhere('second_name', 'like', "%{$search}%")
                ->orWhere('patronymic', 'like', "%{$search}%");
        }

        return $query->limit(20)->get();
    }
}
