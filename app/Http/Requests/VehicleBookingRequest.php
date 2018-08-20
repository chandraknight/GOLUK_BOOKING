<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleBookingRequest extends FormRequest
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
            'customer_name'=>'required',
            'customer_address'>'required',
            'customer_email'=>'required|email',
            'customer_contact'=>'required'
        ];
    }

    public function messages() {
        'customer_name.required'=>'Provide your full name',
        'customer_address.required'=>'Provide your full Address',
        'customer_email.required'=>'Provide your email address',
        'customer_email.email'=>'Provide a valid email address',
        'customer_contact'=>'Provide your contact number'
    }
}
