<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Toastr;

class AdminAccountManager extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->user_type == 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'           => 'required|email|unique:users',
            'activation_code' => 'required|string',
            'first_name'      => 'required|string',
            'last_name'       => 'required|string',
            'address'         => 'required|string',
            'mobile'          => 'required|string',
            'password'        => 'required|string|min:8',
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
