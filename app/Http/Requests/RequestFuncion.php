<?php

namespace DogCat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestFuncion extends FormRequest
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
        if($this->has('funcion')){
            return [
                'nombre'=>'required|max:150|unique:funciones,nombre,'.$this->input('funcion').',id',
                //'identificador'=>'required|numeric|unique:funciones,identificador,'.$this->input('funcion').',id',
            ];
        }
        return [
            'nombre'=>'required|max:150|unique:funciones,nombre',
            'identificador'=>'required|numeric|unique:funciones,identificador',
        ];
    }

    public function messages(){
        return[
        ];
    }
}
