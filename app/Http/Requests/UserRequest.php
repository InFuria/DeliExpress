<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name'      => 'required|unique:users',
            'phone'     => 'string',
            'email'     => 'required|unique:users',
            'password'  => 'required|min:6',
            'img'       => 'image'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'img.required' => 'El campo de imagen es obligatorio.',
            'img.image' => 'El campo de imagen debe ser un archivo de imagen valido.',
            'password.required' => 'El campo de contraseña es obligatorio.',
            'email.required' => 'El campo email es obligatorio.',
            'email.unique' => 'El email ingresado ya esta registrado.',
            'name.required' => 'El campo de nombre es obligatorio.',
            'password.confirmed' => 'Las contraseñas no coinciden.'
        ];
    }
}
