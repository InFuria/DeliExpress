<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name'      => 'required',
            'username'  => ['required', Rule::unique('users')->ignore($this->user)],
            'phone'     => 'string',
            'email'     => ['required', Rule::unique('users')->ignore($this->user)],
            'password'  => 'min:6',
            'photo'     => 'image'
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
            'photo.image'       => 'El campo de imagen debe ser un archivo de imagen valido.',
            'email.required'    => 'El campo email es obligatorio.',
            'email.unique'      => 'El email ingresado ya esta registrado.',
            'name.required'     => 'El campo de nombre es obligatorio.',
            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.unique'   => 'El nombre de usuario ya esta en uso.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min'      => 'La contraseña debe tener como minimo 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.'
        ];
    }
}
