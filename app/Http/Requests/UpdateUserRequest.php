<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name' => [
                'min:3',
                'max:25',
                'regex:/[a-zA-Z]/'
            ],
            'email' => [
                'required',
                'min:3',
                'max:40',
                'email'
            ],
            'role' => [
                'required',
                Rule::in(['user', 'admin'])
            ]
        ];
    }
}
