<?php

namespace DogCat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestRegistro extends FormRequest
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
            'nombre'=>'required|max:150',
            'email'=>'required|max:150|email|unique:registros,email|unique:users|email',
            'telefono'=>'required|numeric|digits_between:6,15',
            'direccion'=>'required|max:300',
            'barrio'=>'required|max:150',
        ];
    }

    public function messages(){
        return[
            'nombre.required'=>'El campo nombre es obligatorio',
            'nombre.max'=>'El campo nombre debe contener 150 caracteres como máximo',

            'email.required'=>'El campo correo es obligatorio',
            'email.max'=>'El campo correo debe contener 150 caracteres como máximo',
            'email.email'=>'El campo correo no corresponde con una dirección de correo válida.',

            'telefono.required'=>'El campo celular es obligatorio',
            'telefono.numeric'=>'El campo celular debe ser de tipo numérico',
            'telefono.digits_between'=>'El campo celular debe contener entre 6 y 15 digitos',

            'direccion.required'=>'El campo dirección es obligatorio',
            'direccion.max'=>'El campo dirección debe contener 300 caracteres como máximo',
        ];
    }
}
