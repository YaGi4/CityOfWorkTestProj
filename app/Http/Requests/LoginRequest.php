<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|max:255|min:6',
            'password' => 'required|string|min:8|max:255',
        ];
    }
}
