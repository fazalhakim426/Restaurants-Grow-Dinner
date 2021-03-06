<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'promo_code' => 'required',
            'start_at'   => 'required|date',
            'end_at'     => 'required|date',
            'is_fixed'   => 'required',
            'amount'     => 'required',
            'min_amount' => 'required',
        ];
    }
}
