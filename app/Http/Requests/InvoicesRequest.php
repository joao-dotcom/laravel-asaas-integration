<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoicesRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'value' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:500',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'value.required' => 'O valor da cobrança é obrigatório.',
            'value.numeric' => 'O valor deve ser numérico.',
            'value.min' => 'O valor deve ser maior que zero.',
        ];
    }
}