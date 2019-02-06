<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

     public function __construct(){
        //  dd($this);
     }
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
            'customer_address'=>'required',
            'customer_email'=>'required|email',
            'customer_number'=>'required',
            'guest.*'=>'required',
            'dob.*'=>'required|date|before:',
            'address.*'=>'required',
            'adult_child.*'=>'required',
            'gender.*'=>'required'
        ];
    }

    public function messages() {
        return [
            'customer_name.required'=>'Provide your Full Name',
            'customer_address.required'=>'Provide your full Address',
            'customer_email.required'=>'Provide your valid Email Address',
            'customer_number.required'=>'Provide your Contact Number',
            'customer_email.email'=>'Provide a valid Email Address'
        ];
    }



}
