<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|max:255|unique:users,email',
            'password'        => 'required|string|min:6',
            'cpfCnpj'         => 'required|string|max:18',
            'phone_number'    => 'required|string|max:20',
            'mobile_phone'    => 'required|string|max:20',
            'address'         => 'required|string|max:255',
            'addressNumber'   => 'required|string|max:20',
            'complement'      => 'nullable|string|max:255',
        ];
    }
}