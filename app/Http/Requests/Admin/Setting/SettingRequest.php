<?php

namespace App\Http\Requests\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'app_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            'developed_by' => 'required',
            'timezone' => 'required',
            'address' => 'required',
            'description' => 'required'
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'app_name.required' => 'This field is required.',
    //         'email.required' => 'This field is required',
    //         'phone.required' => 'This field is required.',
    //         'developed_by.required' => 'This field is required.',
    //         'timezone.required' => 'This field is required.',
    //         'address.required' => 'This field is required.',
    //         'description.required' => 'This field is required.',
    //     ];
    // }
}
