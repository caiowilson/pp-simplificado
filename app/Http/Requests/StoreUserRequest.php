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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            [
                'name' => 'required|string|max:255',
                'document' => 'required|string|max:14|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'is_seller' => 'nullable|boolean'
            ]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must have a maximum of 255 characters',
            'cpf_cnpj.required' => 'CPF/CNPJ is required',
            'cpf_cnpj.string' => 'CPF/CNPJ must be a string',
            'cpf_cnpj.max' => 'CPF/CNPJ must have a maximum of 14 characters',
            'cpf_cnpj.unique' => 'CPF/CNPJ must be unique',
            'email.required' => 'Email is required',
            'email.string' => 'Email must be a string',
            'email.email' => 'Email must be a valid email',
            'email.max' => 'Email must have a maximum of 255 characters',
            'email.unique' => 'Email must be unique',
            'password.required' => 'Password is required',
            'password.string' => 'Password must be a string',
            'password.min' => 'Password must have a minimum of 8 characters',
            'is_seller.boolean' => 'Is seller must be a boolean',
        ];
    }

    public function passedValidation()
    {
        if (count($this->document) > 11) {
            $this->replace(['is_seller' => true]);
        }
        $this->merge([
            'balance' => 0,
        ]);
    }
}
