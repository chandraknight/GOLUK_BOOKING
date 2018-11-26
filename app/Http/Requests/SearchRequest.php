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
            'hoteldestination'=>'required|string',
            'hotelfrom_date'=>'required|after:yesterday',
            'hoteltill_date'=>'required|after:hotelfrom_date',
            'hotelno_adults'=>'required|integer'
        ];
    }

    public function messages(){
        return [
          'hoteldestination.required'=>'Destination is required.',
          'hotelfrom_date.required'=>'Check-in date is required',
          'hotelfrom_date.after'=>'Enter a valid check-in date',
          'hoteltill_date.required'=>'Check-out is required',
          'hoteltill_date.after'=>'Enter a valid check-out date',
          'hotelno_adults.required'=>'Number of adults is required.',
          'hotelno_adults.integer'=>'Enter valid number of adults',
        ];
    }
}
