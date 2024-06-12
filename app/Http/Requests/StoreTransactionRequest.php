<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;


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
            'payer' => 'required|numeric|exists:users,id',
            'payee' => 'required|numeric|exists:users,id',
            'value' => 'required|numeric|min:0.01',
        ];
    }

    public function messages(): array
    {
        return [
            'payer' => [
                'numeric' => 'Sender ID must be a number',
                'exists' => 'Sender ID must be valid',
                'required' => 'Sender ID is required'
            ],
            'payee' => [
                'numeric' => 'Receiver ID must be a number',
                'exists' => 'Receiver ID must be valid',
                'required' => 'Receiver ID is required'
            ],
            'value' => [
                'numeric' => 'Amount must be a number',
                'min' => 'Amount must be at least 0.01',
                'required' => 'Amount is required'
            ]
        ];
    }
}
