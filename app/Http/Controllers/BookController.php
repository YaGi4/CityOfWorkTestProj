<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

final class BookController extends Controller
{
    public function __construct(
        private readonly BookService $bookService
    ) {}

    public function index(Request $request): View
    {
        if (empty($request->query())) {
            $books = Book::paginate(9);
        } else {
            $query = $this->bookService->getBooksWithQuery($request);
            $books = $query->paginate(9);
        }
        return view('books.index', compact('books'));
    }

    public function create(): View
    {
        return view('books.form');
    }

    public function store(SaveBookRequest $request): RedirectResponse
    {
        $this->bookService->createBook($request->data());
        return redirect()->route('books.index');
    }

    public function show(Book $book): View
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book): View
    {
        return view('books.form', compact('book'));
    }

    public function update(SaveBookRequest $request, Book $book): RedirectResponse
    {
        $this->bookService->updateBook($book, $request->data());
        return redirect()->route('books.index');
    }

    public function destroy(Book $book): RedirectResponse
    {
        $this->bookService->deleteBook($book);
        return redirect()->route('books.index')->with('success', 'Книга удалена!');
    }
}
