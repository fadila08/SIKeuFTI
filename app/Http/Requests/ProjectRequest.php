<?php

namespace App\Http\Requests;

use App\Project;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'project_name' => [
                'required', 'min:3', Rule::unique((new Project)->getTable())->ignore($this->route('project') ?? null)
            ],
            'id_cust' => [
                'required', 
            ],
            'id_service' => [
                'required',  
            ],
            'project_started' => [
                'required', 'date_format:Y-m-d'
            ],
            'project_ended' => [
                'required', 'date_format:Y-m-d'
            ],
            'project_cost' => [
                'required', 
            ],
            'project_status' => [
                'required', 
            ]

        ];
    }
}
