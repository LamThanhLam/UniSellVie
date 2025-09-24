<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'releaseDate' => 'required|date',
            'developer' => 'required|string|max:255', // Add rule for developer
            'publisher' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
        ];
    }
}
