<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RequestCar extends Request
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
            'type' => 'required',
            'model' => 'required',
            'color' => 'required',
            'license_number' => 'required|numeric',
            'license_date' => 'required',
            'license_owner' => 'required',
            'KMCounter' => 'required|numeric',
            'plate_number' => 'required',
            'motor_number' => 'required',
            'chassis_number' => 'required',
            'price' => 'required|numeric',
            'user_id' => 'required',
            'rental_type_id' => 'required',
            'renter_commission' => 'required',
            'picture' => 'max:2040'
        ];
    }
}
