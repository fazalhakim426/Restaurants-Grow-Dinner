<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'last_name' => 'required',  
            'email' => ['required','unique:users', 'string', 'email'],
            'phone' => ['required','unique:users', 'string','min:11','max:14'],
            'address' => 'required', 
            'country_id' => 'required',
            'password' => 'required', 
            'salary' => 'required' ,
            'social_nr' => 'required',
            'bank_account' => 'required' ,
            'documents' => 'required|mimes:pdf,jpg,png,xlx,csv|max:2048', 
            'department_id' => 'required',
        ];
    }
}
