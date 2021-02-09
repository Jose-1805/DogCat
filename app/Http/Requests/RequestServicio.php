<?php

namespace DogCat\Http\Requests;

use DogCat\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RequestServicio extends FormRequest
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
        $data = [
            'nombre'=>'required|max:150',
            'estado'=>'required|in:Activo,Inactivo',
            //'entidad'=>'filled|exists:veterinarias,id',
            'duracion_1_10'=>'required|integer',
            'duracion_10_25'=>'required|integer',
            'duracion_mayor_25'=>'required|integer',
            'valor'=>'nullable|integer',
            'descuento'=>'required|integer|max:100',

        ];

        if($this->has('servicio')){
            if(!Auth::user()->esSuperadministrador()){
                $data = [
                    'nombre'=>'required|max:150',
                    'estado'=>'required|in:Activo,Inactivo',
                    //'entidad'=>'filled|exists:veterinarias,id',
                    'duracion_1_10'=>'required|integer',
                    'duracion_10_25'=>'required|integer',
                    'duracion_mayor_25'=>'required|integer'
                ];
            }
        }

        return $data;
    }

    public function messages(){
        return[
            'entidad.exists'=>'La información enviada es incorrecta.',

            'duracion_1_10.required'=>'El campo entre 0 y 10 KG es requerido',
            'duracion_1_10.integer'=>'El campo entre 0 y 10 KG debe ser de tipo entero',

            'duracion_10_25.required'=>'El campo entre 10 y 25 KG es requerido',
            'duracion_10_25.integer'=>'El campo entre 10 y 25 KG debe ser de tipo entero',

            'duracion_mayor_25.required'=>'El campo mayor a 25 KG es requerido',
            'duracion_mayor_25.integer'=>'El campo mayor a 25 KG debe ser de tipo entero',

            'valor.requiredr'=>'El campo valor es requerido',
            'valor.integer'=>'El campo valor debe ser de tipo entero',

        ];
    }
}
