<?php

namespace DogCat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CambioPasswordRequest extends FormRequest
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
            'password'=>'required|min:6|same:password_confirm',
            'password_confirm'=>'required|min:6',
            'password_old'=>'required|min:6',
        ];
    }

    public function messages(){
        return[
            'password.required'=>'El campo contraseña nueva es obligatorio.',
            'password.min'=>'El campo contraseña nueva debe contener 6 caracteres como mínimo.',
            'password.same'=>'El campo contraseña nueva y confirmación de contraseña deben coincidir.',

            'password_confirm.required'=>'El campo confirmación de contraseña es obligatorio.',
            'password_confirm.min'=>'El campo confirmación de contraseña debe contener 6 caracteres como mínimo.',

            'password_old.required'=>'El campo contraseña antigua es obligatorio.',
            'password_old.min'=>'El campo contraseña antigua debe contener 6 caracteres como mínimo.',
        ];
    }
}
