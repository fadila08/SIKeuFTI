<?php

namespace App\Http\Requests;

use App\Tax;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TaxRequest extends FormRequest
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
                $this->route('tax') ? '' : 'required'
            ],
            'pay_status' => [
                $this->route('tax') ? '' : 'required'
            ]
        ];
    }
}
