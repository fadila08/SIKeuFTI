<?php

namespace App\Http\Requests;

use App\Acc_receivable;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AccReceivableRequest extends FormRequest
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
                $this->route('accReceivable') ? '' : 'required'
            ],
            'debet' => [
                $this->route('accReceivable') ? '' : 'required'
            ],
            'credit' => [
                $this->route('accReceivable') ? '' : 'required'
            ],
            'remaining_debt' => [
                $this->route('accReceivable') ? '' : 'required'
            ]
        ];
    }
}
