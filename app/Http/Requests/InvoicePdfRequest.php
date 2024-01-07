<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoicePdfRequest extends FormRequest
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
            'kilometers' => ['required', 'numeric'],
            'invoice_number' => ['required', 'string'],
            'service_name' => ['required', 'string'],
            'first_day_of_month' => ['required', 'date'],
            'last_day_of_month' => ['required', 'date'],
            'last_day_of_month_for_input' => ['required', 'date'],
            'payment_method' => ['required', 'string'],
            'deadline' => ['required', 'date'],
            'additional_info' => ['nullable', 'string'],
        ];
    }
}
