<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        if (empty($request->query())) {
            $books = Book::paginate(9);
            $books->withPath('/books');
            return view('books.index', compact('books'));
        } else {

            $query = Book::query();

            if ($request->filled('author_name')) {
                $authorName = $request->string('author_name')->trim();

                $query->whereHas('author', function (Builder $subQuery) use ($authorName) {
                    $subQuery->where('first_name', 'like', "%{$authorName}%")
                        ->orWhere('second_name', 'like', "%{$authorName}%")
                        ->orWhere('patronymic', 'like', "%{$authorName}%");
                });
            }

            if ($request->filled('year')) {
                $query->where('year', $request->string('year')->trim());
            }

            if ($request->filled('genre')) {
                $query->where('genre', 'like', '%' . $request->string('genre')->trim() . '%');
            }

            $books = $query->paginate(9);
            $books->withPath('/books');
            return view('books.index', compact('books'));
        }
    }

    public function create()
    {
        $authors = Author::all();
        return view('books.form', compact('authors'));
    }

    public function store(CreateBookRequest $request)
    {
        $data = $request->validated();

        $author = Author::findOrFail($request->request->all()['author_id']);

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('books/covers', 'public');
            $data['cover'] = $path;
        }

        $data['author_id'] = $author->id;

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Книга добавлена!');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        return view('books.form', compact('book', 'authors'));
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $data = $request->validated();

        $author = Author::findOrFail($request->request->all()['author_id']);

        $data['author_id'] = $author->id;


        if ($request->hasFile('cover')) {
            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
            }
            $path = $request->file('cover')->store('books/covers', 'public');
            $data['cover'] = $path;
        }

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Книга обновлена!');
    }

    public function destroy(Book $book)
    {
        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Книга удалена!');
    }
}
