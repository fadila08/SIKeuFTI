<?php

namespace App\Http\Requests;

use App\Service;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'service_name' => [
                'required', 'min:3', Rule::unique((new Service)->getTable())->ignore($this->route('services') ?? null)
            ],
        ];
    }
}
