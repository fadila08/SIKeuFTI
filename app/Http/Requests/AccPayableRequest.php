<?php

namespace App\Http\Requests;

use App\Acc_payable;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AccPayableRequest extends FormRequest
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
            'id_transaction' => [
                'required'
            ],
            'debet' => [
                'required'
            ],
            'credit' => [
                'required'
            ],
            'remaining_debt' => [
                'required', 
            ]
        ];
    }
}
