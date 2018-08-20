<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TourSearchRequest extends FormRequest
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
            'destination' => 'required|string',
            'from' => 'required|date|after:today',
            'people' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'destination.required'=>'Please enter a valid destination',
            'from.required'=>'Enter valid starting date.',
            'from.date'=>'Please Enter a valid starting date',
            'people.required'=>'Please Specify number of people',
            'people.integer'=>'Enter valid number of people'
        ];
    }
}