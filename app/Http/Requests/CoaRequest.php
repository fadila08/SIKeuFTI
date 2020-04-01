<?php

namespace App\Http\Requests;

use App\Coa;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CoaRequest extends FormRequest
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
            'acc_code' => [
                'required', 'min:3', Rule::unique((new Coa)->getTable())->ignore($this->route('coa') ?? null)
            ],
            'acc_name' => [
                'required', 'min:3'
            ],
            'id_account_group' => [
                'required'
            ],
            'id_normal_balance' => [
                'required'
            ]
        ];
    }
}
