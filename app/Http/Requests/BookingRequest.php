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
        $rules = [
            'customer_name'=>'required',
            'customer_email'=>'required|email',
            'customer_phone'=>'required',
            'customer_address'=>'required',
        ];
        
    }

    public function messages(){
        return [
            'customer_name.required'=>'Provide your Full Name',
        ];
    }

    public function checkRoom($room){

    }
}
