<?php

namespace App\Http\Requests;

use App\General_ledger;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class GeneralLedgerRequest extends FormRequest
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
        // dd($this->route('projectTransaction') ?? null);
        // dd($this->route('projectTransaction'));
        return [
            'date' => [
                'required'
            ],
            'description' => [
                'required'
            ],
            'proof_num' => [
                'required'
            ],
            'upload_proof' => [
                'required'
            ],
            'id_debet_acc' => [
                $this->route('projectTransaction') ? '' : 'required'
            ],
            'id_cred_acc' => [
                $this->route('projectTransaction') ? '' : 'required'
            ],
            'nominal' => [
                'required'
            ]
        ];
    }
}