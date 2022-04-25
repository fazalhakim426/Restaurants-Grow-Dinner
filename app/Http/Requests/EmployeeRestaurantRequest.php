<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRestaurantRequest extends FormRequest
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
            'first_name' => 'required', 
            'email'      => ['unique:users', 'string', 'email'],
            'address'    => 'required',  
            'phone'      => ['required','unique:users', 'string','min:11','max:20'], 
            'photo'      => 'required|mimes:pdf,jpg,png,xlx,csv|max:2048', 
            'menu'       => 'mimes:pdf,jpg,png,xlx,csv|max:2048', 
            'feedback'   => 'required', 
            'visited_at' => 'required|date_format:Y-m-d H:i:s', 
        ];
    }
}
