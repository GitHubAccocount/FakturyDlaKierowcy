<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellerBuyerRequest extends FormRequest
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
            'company' => ['required', 'string'],
            'street' => ['required', 'string'],
            'main_number' => ['required', 'integer', 'gt:0'],
            'local_number' => ['integer', 'gt:0', 'nullable'],
            'city' => ['required', 'string'],
            'postal_code_1' => ['required', 'integer', 'gt:0', 'digits:2'],
            'postal_code_2' => ['required', 'integer', 'gt:0', 'digits:3'],
            'nip' => ['required', 'integer', 'gt:0', 'digits:10'],
            'authorized_person' => ['required', 'string'],
        ];
    }
}
