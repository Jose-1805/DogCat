<?php

namespace DogCat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestNuevoIngreso extends FormRequest
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
            'fuente_ingreso'=>'required|in:Afiliación,Servicio,Prestamo,Otro',
            'descripcion_ingreso'=>'required_if:fuente_ingreso,Otro|max:250',
            'numero_factura_ingreso'=>'max:20',
            'valor_ingreso'=>'required|integer',
            'medio_pago_ingreso'=>'required|in:Efectivo,PSE,Consignación,Transferencia',
            'codigo_verificacion_ingreso'=>'max:250',
            'evidencia_ingreso'=>'file|max:'.config('params.maximo_peso_archivos')
        ];

    }

    public function messages()
    {
        return [
            'fuente_ingreso.required'=>'El campo fuente de ingreso es requerido',
            'fuente_ingreso.in'=>'La información enviada es incorrecta',

            'descripcion_ingreso.required_if'=>'El campo descripción es obligatorio',
            'descripcion_ingreso.max'=>'El campo descripción puede contener máximo 250 caracteres',

            'numero_factura_ingreso.max'=>'El campo Nª Factura puede contener máximo 20 caracteres',

            'valor_ingreso.required'=>'EL campo valor es requerido',
            'valor_ingreso.integer'=>'El campo valor sólo permite valores numéricos',

            'medio_pago_ingreso.required'=>'El campo medio de pago es requerido',
            'medio_pago_ingreso.in'=>'La información enviada es incorrecta',

            'codigo_verificacion_ingreso.max'=>'El campo código de verificación puede contener máximo 250 caracteres',

            'evidencia_ingreso.file'=>'El campo evidencia debe ser un archivo',
            'evidencia_ingreso.max'=>'El archivo evidencia debe pesar '.config('params.maximo_peso_archivos').' kilobytes como máximo.',
        ];
    }
}
