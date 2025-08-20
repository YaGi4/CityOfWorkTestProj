<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'author_id' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'year' => 'required|integer',
            'genre' => 'required|string|max:255',
            'pages' => 'required|integer',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
