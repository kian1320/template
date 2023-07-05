<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SummaryFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'month' => [
                'required',
                'string',
                'max:200'
            ],

            'year' => [
                'required',
                'string',
                'max:200'
            ],

            'totalstr' => [
                'nullable',
                'string',
                'max:200'
            ],

            'aftexpenses' => [
                'nullable',
                'string',
                'max:200'
            ],





        ];
        return $rules;
    }
}
