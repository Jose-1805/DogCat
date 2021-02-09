<?php

namespace DogCat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestNuevoEgreso extends FormRequest
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
            'tipo'=>'required|in:Pago de funeraria,Pago de servicios,Pago de salarios,Pago de arriendos,Pago de impuestos,Pago de aportes,Compra de insumos,Pago de viáticos,Otro',
            'descripcion'=>'required_if:tipo,Otro|max:250',
            'valor'=>'required|integer',
            'numero_factura'=>'max:20',
            'evidencia'=>'file|max:'.config('params.maximo_peso_archivos')
        ];

    }

    public function messages()
    {
        return [
            'tipo.in'=>'La información enviada es incorrecta',
            'descripcion.required_if'=>'El campo descripción es obligatorio',
            'descripcion.max'=>'El campo descripción puede contener máximo 250 caracteres',
            'valor.required'=>'EL campo valor es requerido',
            'valor.integer'=>'El campo valor sólo permite valores numéricos'
        ];
    }
}
