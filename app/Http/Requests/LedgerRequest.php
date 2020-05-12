<?php

namespace App\Http\Requests;

use App\Ledger;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LedgerRequest extends FormRequest
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
            'id_coa' => [
                'required'
            ],
            'id_desc' => [
                'required'
            ],
            'debet_saldo' => [
                'required'
            ],
            'cred_saldo' => [
                'required'
            ]
        ];
    }
}