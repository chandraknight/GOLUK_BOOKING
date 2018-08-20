<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
            'destination'=>'required|string',
            'from_date'=>'required|after:yesterday',
            'till_date'=>'required|after:from_date',
            'no_adults'=>'required|integer'
        ];
    }

    public function messages(){
        return [
          'destination.required'=>'Destination is required.',
          'from_date.required'=>'Starting Date is required',
          'from_date.after'=>'Enter a valid starting date',
          'till_date.required'=>'Ending date is required',
          'till_date.after'=>'Enter a valid ending date',
          'no_adults.required'=>'Number of adults is required.',
          'no_adults.integer'=>'Enter valid number of adults',
        ];
    }
}
