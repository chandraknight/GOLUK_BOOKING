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
            'name.*'=>'required',
            'contact.*'=>'required',
            'dob.*'=>'required',
            'address.*'=>'required',
            'gender.*'=>'required'
        ];
    }

    public function messages() {
        return [
            'name.*.required'=>'Provide name of all People',
            'contact.*.required'=>'Provide Contact Number of all People',
            'dob.*'=>'Provide Date of Birth of all People',
            'address.*.required'=>'Provide address of all People',
            'gender.*.required'=>'Select gender of all people'
        ];
    }
}
