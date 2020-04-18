<?php

namespace App\Http\Requests;

use App\Project;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProjectTrcRequest extends FormRequest
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
            'id_project' => [
                'required'
            ],
            'date' => [
                'required'
            ],
            'description' => [
                'required'
            ],
            'nominal' => [
                'required'
            ],
            'id_debet_acc' => [
                'required'
            ],
            'id_cred_acc' => [
                'required'
            ]
        ];
    }
}