<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class SearchFlightRequest extends FormRequest
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
            'flight_depart'=>'required',
            'flight_arrival'=>'required|different:flight_depart',
            'flight_date'=>'required|after:today',
            'flight_adults'=>'required_without:flight_childs|min:1',
            'flight_childs'=>'required_without:flight_adults|min:1',
            'flight_return'=>'after_or_equal:flight_date',
        ];
    }
    public function messages()
    {
        return [
            'flight_depart.required'=>'Provide Departure Location.',
            'flight_arrival.required'=>'Provide Arrival Location.',
            'flight_arrival.different'=>'Select different destination.',
            'flight_date.required'=>'Provide flight date.',
            'flight_date.after'=>'Flight date is invalid.',
            'flight_adults.required_without'=>'Provide number of adults.',
            'flight_childs.required_without'=>'Provide number of childs.',
            'flight_return.after_or_equal'=>'Return date is invalid.'
        ];
    }

    public function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();
        $validator->after(function(Validator $validator){
            if(($this->input('flight_adults') + $this->input('flight_childs')) > 6 || ($this->input('flight_adults') + $this->input('flight_childs')) < 1){
                $validator->errors()->add('flight_adults','Total passengers must be between 1-6.');
            }
        });

        return $validator;
    }
}
