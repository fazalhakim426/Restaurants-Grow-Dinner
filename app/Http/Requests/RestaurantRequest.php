<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantRequest extends FormRequest
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
            'address' => 'required',
            'phone' => 'required',
            'city' => 'required',
            'country' => 'required',
            'password' => 'required',  
            'photo' => 'required|mimes:pdf,jpg,png,xlx,csv|max:2048', 
            'menu' => 'mimes:pdf,jpg,png,xlx,csv|max:2048', 
  
            // $table->foreignId('category_id')->constrained()->cascadeOnDelete()->nullable();;
            // $table->string('closing_time')->nullable();
            // $table->string('opening_time')->nullable();
            // $table->string('contact_number')->nullable();
            // $table->string('latitude')->nullable();
            // $table->string('longitude')->nullable();
            // $table->string('description')->nullable();  
            
            // $table->string('menu')->nullable();//photo
            // $table->string('instagram_link')->nullable();
            // $table->string('facebook_link')->nullable();
            // $table->string('twiter_link')->nullable();
            // $table->string('website_link')->nullable();
            // $table->string('informational_tags')->nullable();
        ];
    }
}
