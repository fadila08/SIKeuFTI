<?php

namespace App\Http\Requests;

use App\Creditor;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreditorRequest extends FormRequest
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

        // dd($this->route('cust'));
        return [
            'cred_name' => [
                'required', 'min:3', Rule::unique((new Creditor)->getTable())->ignore($this->route('cred') ?? null)
            ],
            'cred_address' => [
                'required', 'min:3'
            ],
            'cred_email' => [
                'required', 'email' 
            ],
            'cred_phone' => [
                'required', 'min:3'
            ]
        ];
    }
}
