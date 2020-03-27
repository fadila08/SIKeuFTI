<?php

namespace App\Http\Requests;

use App\Customer;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cust_name' => [
                'required', 'min:3', Rule::unique((new Customer)->getTable())->ignore($this->route()->customer->id ?? null)
            ],
            'cust_address' => [
                'required', 'min:3'
            ],
            'cust_email' => [
                'required', 'email' 
            ],
            'cust_phone' => [
                'required', 'min:3'
            ]
        ];
    }
}
