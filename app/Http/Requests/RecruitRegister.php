<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Toastr;

class RecruitRegister extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'email'      => 'required|email|unique:users',
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'address'    => 'required|string',
            'mobile'     => 'required|string'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($validator->failed()) {
                foreach ($validator->errors()->all() as $error) {
                    Toastr::error($error, 'Failed', ['timeOut' => 100000]);
                }
            }
        });
    }
}
