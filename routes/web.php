<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\LoginController;

Route::get('/', function () { return redirect()->route('books.index');});

Route::get('/login', [LoginController::class, 'index']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::patch('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
});

Route::get('books', [BookController::class, 'index'])->name('books.index');
Route::get('books/{book}', [BookController::class, 'show'])->name('books.show');

Route::middleware('auth')->group(function () {
    Route::get('/authors/create', [AuthorController::class, 'create'])->name('authors.create');
    Route::get('/authors/{author}/edit', [AuthorController::class, 'edit'])->name('authors.edit');
    Route::patch('/authors/{author}', [AuthorController::class, 'update'])->name('authors.update');
    Route::delete('/authors/{author}', [AuthorController::class, 'destroy'])->name('authors.destroy');
    Route::post('/authors', [AuthorController::class, 'store'])->name('authors.store');
});

Route::get('authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/authors/search', [AuthorController::class, 'search'])->name('authors.search');
