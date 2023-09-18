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
            'name' => 'required|min:3|regex:/[a-zA-Z]/',
            'email' => 'required',
            'role' => ['required', Rule::in(['user', 'admin'])],
        ];
    }
}
