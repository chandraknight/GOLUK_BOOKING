<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleStoreRequest extends FormRequest
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
            'description'=>'required',
            'location'=>'required',
            'contact'=>'required',
            'email'=>'required|email',
            'no_of_people'=>'required|integer',
            'rate_per_day'=>'required|integer',
            'fuel'=>'required'
        ];
    }

    public function messages() {
        return [
            'name'=>'Enter your Vehicle Name',
            'description'=>'Provide short vehicle description',
            'location'=>'Provide vehicle location',
            'contact'=>'Provide Vehicle Contact Number',
            'email'=>'Provide Vehicle Email address',
            'no_of_people'=>'Provide maximum number of passengers',
            'rate_per_day'=>'Provide your flat rate per day',
            'fuel'=>'Select Your Vehicle Fuel Type'
        ];
    }
}
