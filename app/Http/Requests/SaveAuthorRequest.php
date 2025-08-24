<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveAuthorRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255|min:3',
            'second_name' => 'required|string|max:255|min:3',
            'patronymic' => 'required|string|max:255|min:3',
        ];
    }
}
