<?php

namespace DogCat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestNuevaCuenta extends FormRequest
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
            'tipo_identificacion'=>'required|in:C.C,NIT',
            'identificacion'=>'required|max:15|unique:users,identificacion',
            'nombres'=>'required|max:150',
            'apellidos'=>'required|max:150',
            'telefono'=>'max:15',
            'estado_civil'=>'required|in:Casado(a),Soltero(a),Unión marital de hecho',
            'genero'=>'required|in:masculino,femenino',
            'fecha_nacimiento'=>'required|date|before:'.date('Y-m-d',strtotime('-'.config('params.edad_minima').' years')),
            'veterinaria'=>'required|exists:veterinarias,id',
            'ciudad'=>'required|exists:ciudades,id',
            'barrio'=>'required|max:255',
            'calle'=>'required_without_all:carrera,transversal|max:20',
            'carrera'=>'required_without_all:calle,transversal|max:20',
            'transversal'=>'required_without_all:calle,carrera|max:20',
            'numero'=>'required|max:20',
            'especificaciones'=>'max:255',
            'password'=>'required|min:6|same:password_confirm',
            'password_confirm'=>'required|min:6',
            'imagen'=>'file|mimes:jpeg,jpg,png|max:500'
        ];
    }

    public function messages(){
        return[
            'tipo_identificacion.required'=>'El campo tipo de identificación es obligatorio.',
            'tipo_identificacion.in'=>'El campo tipo de identificación debe ser igual a uno de estos valores C.C, NIT.',
            'identificacion.required'=>'El campo identificación es obligatorio.',
            'identificacion.max'=>'El campo identificación debe contener 15 caracteres como máximo.',
            'password.required'=>'El campo contraseña es obligatorio.',
            'password.min'=>'El campo contraseña debe contener 6 caracteres como mínimo.',
            'password.same'=>'El campo contraseña y confirmación de contraseña deben coincidir.',
            'password_confirm.required'=>'El campo confirmación de contraseña es obligatorio.',
            'password_confirm.min'=>'El campo confirmación de contraseña debe contener 6 caracteres como mínimo.',
            'genero.in'=>'El campo gènero debe ser igual a uno de estos valors (masculino o femenino)',
            'telefono.max'=>'El campo N° de teléfono fijo puede contener màximo 15 dìgitos',
            'telefono.numeric'=>'El campo N° de teléfono fijo debe ser numèrico',
        ];
    }
}
