<?php

namespace DogCat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestModulo extends FormRequest
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
        if($this->has('modulo')){
            return [
                'nombre'=>'required|max:150|unique:modulos,nombre,'.$this->input('modulo').',id',
                //'identificador'=>'required|numeric|unique:modulos,identificador,'.$this->input('modulo').',id',
                'etiqueta'=>'required|max:150',
                'url'=>'required|max:150|unique:modulos,url,'.$this->input('modulo').',id',
                'agrupacion'=>'max:100',
                'orden_menu'=>'integer|unique:modulos,orden_menu,'.$this->input('modulo').',id',
                'estado'=>'required|in:Activo,Inactivo',
            ];
        }
        return [
            'nombre'=>'required|max:150|unique:modulos,nombre',
            'identificador'=>'required|numeric|unique:modulos,identificador',
            'etiqueta'=>'required|max:150',
            'url'=>'required|max:150|unique:modulos,url',
            'agrupacion'=>'max:100',
            'orden_menu'=>'integer|unique:modulos,orden_menu',
            'estado'=>'required|in:Activo,Inactivo',
        ];
    }

    public function messages(){
        return[
            'agrupacion.max'=>'El campo agrupación debe contener 100 caracteres como máximo.',

            'orden_menu.integer'=>'El campo orden menú debe ser un número entero.',
            'orden_menu.unique'=>'El elemento orden menú ya está en uso.',
        ];
    }
}
