<?php

namespace App\Http\Requests;

use App\Account_group;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AccGroupRequest extends FormRequest
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
            'group_name' => [
                'required', 'min:3', Rule::unique((new Account_group)->getTable())->ignore($this->route('accGroup') ?? null)
            ],
        ];
    }
}
