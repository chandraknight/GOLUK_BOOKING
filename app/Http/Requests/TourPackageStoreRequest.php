<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TourPackageStoreRequest extends FormRequest
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
            'location'=>'required',
            'description'=>'required',
            'email'=>'required',
            'contact'=>'required',
            'itenary'=>'required',
            'price'=>'required',
            'duration'=>'required'
        ];
    }

    public function messages() {
        return [
            'name.required'=>'Tour Name is Required',
            'location.required'=>'Tour Destination is Required',
            'description.required'=>'Provide Short Tour Description',
            'email.required'=>'Enter valid Email Address',
            'contact.required'=>'Provide Phone Contact',
            'itenary.required'=>'Provide your Tour Itenary',
            'price.required'=>'Enter your individual Tour Cost',
            'duration.required'=>'Provide your Tour Duration'
        ];
    }
}
