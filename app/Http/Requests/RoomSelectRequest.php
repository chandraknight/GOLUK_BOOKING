<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomSelectRequest extends FormRequest
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
            'no_rooms'=>'required:arrayValidate',


        ];
    }

    public function messages() {
        return [
            'no_rooms.*'=>'Please Enter number of Rooms',
        ];
    }

    public function arrayValidate($rooms){
        if(is_array($rooms)){
            foreach($rooms as $room){
                if($room != null){
                    return true;
                    break;
                }
            }
            return false;
        }
    }

}
