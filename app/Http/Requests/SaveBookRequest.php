<?php

namespace App\Http\Requests;

use App\Dto\BookRequestData;
use Illuminate\Foundation\Http\FormRequest;

class SaveBookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'author_id' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'year' => 'required|integer|min:1|max:2025',
            'genre' => 'required|string|max:255',
            'pages' => 'required|integer|min:1|max:9999',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    public function data($key = null, $default = null): BookRequestData
    {
        return new BookRequestData([
            'author_id' => $this->input('author_id'),
            'title' => $this->input('title'),
            'year' => $this->input('year'),
            'genre' => $this->input('genre'),
            'pages' => $this->input('pages'),
            'cover' => $this->file('cover')
        ]);
    }
}
