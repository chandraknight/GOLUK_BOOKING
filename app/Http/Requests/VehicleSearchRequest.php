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
            'vehiclelocation'=>'required|string',
            'vehiclefrom_date'=>'date|required|after:today',
            'vehicletill_date'=>'date|required|after:today',
            'vehiclepassenger'=>'required|integer'
        ];
    }

    public function messages()
    {
        return [
          'vehiclelocation.required'=>'Please provide pick up location.',
          'vehiclelocation.string'=>'Please enter valid place',
          'vehiclefrom_date.after'=>'Enter valid pick up date',
          'vehicletill_date.after'=>'Enter valid drop date',
          'vehiclepassenger.required'=>'Please provide number of people',
          'vehiclepassenger.integer'=>'Please provide valid number of people'
          
        ];
    }
}
