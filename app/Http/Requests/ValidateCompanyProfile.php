<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateCompanyProfile extends FormRequest
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
            'company_name' => 'required',
            'company_email' => 'required|email',
            'company_phone' => 'required|numeric',
            'company_address' => 'required',
            'hr_name' => 'required',
            'hr_contact' => 'required|numeric',
            'registration_type' => 'required|in:pvt_ltd,public_ltd,others',
            // 'industry_id' => 'required|exists:industries,id',
            'company_logo'=>'nullable|mimes:jpeg,jpg,png|max:2048',
            'id' => 'nullable|exists:company_profiles,id',
        ];
    }
}
