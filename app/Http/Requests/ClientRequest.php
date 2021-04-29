<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
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
            "first_name"        => "required|string",
            "second_name"       => "nullable|string",
            "first_lastname"    => "required|string",
            "second_lastname"   => "nullable|string",
            "phone"             => "nullable|string",
            "mobile"            => "required|string",
            "email"             => ["required", "string", Rule::unique('clients')->ignore($this->client)]
        ];
    }
}
