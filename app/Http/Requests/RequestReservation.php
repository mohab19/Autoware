<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RequestReservation extends Request
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
            'client_id' => 'required',
            'car_id' => 'required',
            'start_duration' => 'required',
            'end_duration' => 'required',
            'DiscountOption' => 'required',
            'discount' => 'required_if:DiscountOption,1|numeric',
            'paid' => 'required|numeric',
        ];
    }
}
