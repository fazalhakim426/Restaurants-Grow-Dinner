<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantUpdateRequest extends FormRequest
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
            // 'photo' => 'mimes:pdf,jpg,png,xlx,csv|max:2048', 
            // 'menu'  => 'mimes:pdf,jpg,png,xlx,csv|max:2048',  
        ];
    }
}
