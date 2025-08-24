<?php

namespace App\Services;

use App\Dto\BookRequestData;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BookService
{

    public function __construct(private readonly StorageService $storageService){}

    public function createBook(BookRequestData $data): void
    {
        $author = Author::findOrFail($data->author_id);

        $data->author_id = $author->id;

        if ($data->cover) {
            $data->cover = $this->storageService->saveCoverFile($data->cover);;
        }

        Book::create($data->all());
    }

    public function updateBook(Book $book, BookRequestData $data): void
    {
        $author = Author::findOrFail($data->author_id);

        $data->author_id = $author->id;

        if ($data->cover) {
            if ($book->cover) {
                $this->storageService->deleteCoverFile($book->cover);
            }
            $data->cover = $this->storageService->saveCoverFile($data->cover);
        } else
        {
            $data->cover = $book->cover;
        }

        $book->update($data->all());
    }

    public function deleteBook(Book $book): void
    {
        if ($book->cover) {
            $this->storageService->deleteCoverFile($book->cover);
        }
        $book->delete();
    }

    public function getBooksWithQuery(Request $request): Builder
    {

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

        if ($request->filled('sort')) {
            switch ($request->string('sort')) {
                case 'author_asc':
                    $query->join('authors', 'books.author_id', '=', 'authors.id')
                        ->orderBy('authors.second_name', 'asc')
                        ->select('books.*');
                    break;
                case 'author_desc':
                    $query->join('authors', 'books.author_id', '=', 'authors.id')
                        ->orderBy('authors.second_name', 'desc')
                        ->select('books.*');
                    break;
                case 'year_asc':
                    $query->orderBy('year', 'asc');
                    break;
                case 'year_desc':
                    $query->orderBy('year', 'desc');
                    break;
                case 'genre_asc':
                    $query->orderBy('genre', 'asc');
                    break;
                case 'genre_desc':
                    $query->orderBy('genre', 'desc');
                    break;
            }
        }

        return $query;
    }
}
