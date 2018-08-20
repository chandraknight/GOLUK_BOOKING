<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelStoreRequest extends FormRequest
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
            
            'name'=>'required',
            'email'=>'required',
            'description'=>'required',
            'address'=>'required',
            'no_rooms'=>'required',
            'contact'=>'required',
            'logo'=>'image|max:1999'
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Name is Required',
            'email.required' => 'Email is Required',
            'description.required'=>'Description is Required',
            'address.required' => 'Address is Required',
            'no_rooms.required' => 'No of rooms is Required',
            'contact.required' => 'Contact number is Required',
            'logo.required'=>'Upload a logo image',
        ];
    }
}
