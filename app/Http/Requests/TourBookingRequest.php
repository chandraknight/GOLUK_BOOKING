<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TourBookingRequest extends FormRequest
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
            'customer_contact'=>'required',
            'customer_email'=>'required|email',
            'customer_address'=>'required',
            'name.*'=>'required',
            'contact.*'=>'required',
            'dob.*'=>'required',
            'address.*'=>'required',
            'gender.*'=>'required'
        ];
    }

    public function messages() {
        return [
            'customer_name.required'=>'Provide Your Name',
            'customer_contact.required'=>'Provide Your Contact Number',
            'customer_email.required'=>'Provide Your Email Address',
            'customer_email.email'=>'Provide a valid Email Address',
            'customer_address.required'=>'Provide Your Address',
            'name.*.required'=>'Provide name of all People',
            'contact.*.required'=>'Provide Contact Number of all People',
            'dob.*'=>'Provide Date of Birth of all People',
            'address.*.required'=>'Provide address of all People',
            'gender.*.required'=>'Select gender of all people'
        ];
    }
}
