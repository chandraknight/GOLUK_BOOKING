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
            'activitydestination' => 'required|string',
            'activityfrom' => 'required|date|after:today',
            'activitypeople' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'activitydestination.required'=>'Please enter a valid destination',
            'activityfrom.required'=>'Enter valid starting date.',
            'activityfrom.date'=>'Please Enter a valid starting date',
            'activityfrom.after'=>'Please provide valid starting date',
            'activitypeople.required'=>'Please Specify number of people',
            'activitypeople.integer'=>'Enter valid number of people'
        ];
    }
}