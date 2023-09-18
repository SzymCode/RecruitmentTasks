<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|min:5',
            'description' => 'required|min:20',
            'created_at' => 'required|regex:/^\d{4}-\d{2}-\d{2}/',
            'tags' => 'nullable|min:3',
        ];
    }
}
