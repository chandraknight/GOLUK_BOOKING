<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleSearchRequest extends FormRequest
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
            'location'=>'required|string',
            'destination'=>'required|string',
            'from_date'=>'date|required|after:today',
            'till_date'=>'date|required',
            'passenger'=>'required|integer'
        ];
    }

    public function messages()
    {
        return [
          'location.required'=>'Please provide pick up location.',
          'location.string'=>'Please enter valid place',
          'destination.required'=>'Please Provide drop destination',
          'destination.string'=>'Please enter valid location',
          'from_date.after'=>'Enter valid pick up date',
          'till_date.after'=>'Enter valid drop date',
          'passenger.required'=>'Please provide number of people',
          'passenger.integer'=>'Please provide valid number of people'
          
        ];
    }
}
