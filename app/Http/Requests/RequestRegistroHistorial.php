<?php

namespace DogCat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestRegistroHistorial extends FormRequest
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
            'estado'=>'required|in:registrado,en proceso,completo,descartado',
            'observaciones'=>'required',
            'rol'=>'required_if:estado,completo'
        ];
    }

    public function messages(){
        return[
        ];
    }
}
