<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'long_name'         => 'required|string',
            'short_name'        => 'required|string',
            'description'       => 'required|string',
            'address'           => 'required|string',
            'phone'             => 'required|string',
            'mobile'            => 'required|string',
            'email'             => 'required|string',
            'logo'              => Rule::dimensions()->maxWidth(600)->maxHeight(600),
            'cover'             => Rule::dimensions()->maxWidth(1000)->maxHeight(300),
            'department_id'     => 'required|integer',
            'municipality_id'   => 'required|integer',
            'zone_id'           => 'required|integer',
            'categories'        => 'required'
        ];
    }
}
