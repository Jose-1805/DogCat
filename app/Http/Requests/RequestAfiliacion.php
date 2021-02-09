<?php

namespace DogCat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestAfiliacion extends FormRequest
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
        $meses = '';
        for($i = 1;$i <= config('params.meses_credito');$i++)$meses .= $i.',';
        $meses = trim($meses,',');
        $data = [
            'usuario'=>'filled|exists:users,id',
            'solicitud'=>'filled|exists:solicitudes_afiliaciones,id',
            'estado'=>'required|filled|in:Pendiente de pago,Pagada',
            'cantidad_pagos'=>'required_if:estado,Pagada|in:'.$meses,
            'medio_pago'=>'required_if:estado,Pagada|in:Efectivo,Consignación,Transferencia',
            'codigo_verificacion'=>'required_if:medio_pago,Consignación,Transferencia',
            'numero_factura'=>'required_if:estado,Pagada',
            'dia_pagar'=>'in:1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31'
        ];

        return $data;
    }

    public function messages()
    {
        return [
            'usuario.exists'=>'La información enviada es incorrecta',
            'solicitud.exists'=>'La información enviada es incorrecta',

            'estado.required'=>'El campo estado de pago es obligatorio',
            'estado.filled'=>'El campo estado de pago es obligatorio',
            'estado.in'=>'El campo estado de pago debe contener el valor "Pendiente de pago" o "Pagada"',

            'medio_pago.required_if'=>'El campo medio de pago es requerido.',
            'medio_pago.in'=>'EL campo medio de pago debe contener uno de estos valores (Efectivo,Consignación,Transferencia).',
            'codigo_verificacion.required_if'=>'El campo còdigo de verificación es requerido.',
            'numero_factura.required_if'=>'El campo nº de factura es requerido.',

            'cantidad_pagos.required_if'=>'El campo crédito a es requerido.',
            'cantidad_pagos.in'=>'La información enviada es incorrecta.',

            'dia_pagar.in'=>'La información enviada es incorrecta.'
        ];
    }
}
