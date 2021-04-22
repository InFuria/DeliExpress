<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'name'          => 'required|string',
            'description'   => 'required|string',
            'img'           => Rule::dimensions()->maxWidth(1000)->maxHeight(1000),
            'price'         => 'required|numeric',
            'cost'          => 'numeric',
            'category_id'   => 'required|integer'
        ];
    }
}
