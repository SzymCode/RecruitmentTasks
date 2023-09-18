<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:3|regex:/[a-zA-Z]/',
            'email' => 'required|email|unique:users',
            'role' => ['required', Rule::in(['user', 'admin'])],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!#%^&*:_]/'
            ],
            'confirm_password' => 'required|same:password'
        ];
    }
}
