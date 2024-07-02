<?php

namespace App\Http\Requests;

use App\Rules\CreditCard;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'source_card_number' => ['required', 'string', new CreditCard],
            'destination_card_number' => ['required', 'string', new CreditCard],
            'amount' => 'required|numeric|min:1000|max:50000000',
        ];
    }
}
