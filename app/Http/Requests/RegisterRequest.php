<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegisterRequest extends Request
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
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'birthdate' => 'required|max:255',
                'phone' => 'required|numeric',
                'address' => 'required|max:255',
                'national_id' => 'required|numeric',
                'salary' => 'required|numeric',
                'email' => 'required|max:255|email|unique:users',
                'password' => 'required|max:255|confirmed'
            ];
    }
}
