<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodValidation extends FormRequest
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
            'name' => 'required',
            'id' => 'nullable|exists:payment_methods,id',
            // UPI payment method fields (one group)
            'image' => 'nullable|mimes:jpeg,jpg,png|max:2048|required_with_all:upi_id',
            'upi_id' => 'nullable|string|required_with_all:image',
            
            // Bank transfer fields (other group) - required if neither UPI nor image provided
            'bank_name' => 'nullable|string|required_without_all:upi_id,image',
            'account_name' => 'nullable|string|required_without_all:upi_id,image',
            'branch_name' => 'nullable|string|required_without_all:upi_id,image',
            'account_number' => 'nullable|string|required_without_all:upi_id,image',
            'ifsc_code' => 'nullable|string|required_without_all:upi_id,image',
        ];
    }
}
