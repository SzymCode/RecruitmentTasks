<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required', 
                'min:5', 
                'max:25'
            ],
            'description' => [
                'required', 
                'min:20',
                'max:255'
            ],
            'created_at' => [
                'required',
                'regex:/^\d{4}-\d{2}-\d{2}/'
            ],
            'updated_at' => [
                'regex:/^\d{4}-\d{2}-\d{2}/'
            ],
        ];
    }
}
