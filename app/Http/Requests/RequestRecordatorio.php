<?php

namespace DogCat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestRecordatorio extends FormRequest
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
            'mensaje'=>'required|max:250',
            'fecha_recordatorio'=>'required|after_or_equal:'.date('Y-m-d'),
            'hora'=>'required|in:00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23',
            'minuto'=>'required|in:'
                .'00,01,02,03,04,05,06,07,08,09,'
                .'10,11,12,13,14,15,16,17,18,19,'
                .'20,21,22,23,24,25,26,27,28,29,'
                .'30,31,32,33,34,35,36,37,38,39,'
                .'40,41,42,43,44,45,46,47,48,49,'
                .'50,51,52,53,54,55,56,57,58,59',
            'importancia'=>'required|in:alta,media,baja'
        ];
    }

    public function messages(){
        return[
            'hora.in'=>'La información enviada es incorrecta',
            'minuto.in'=>'La información enviada es incorrecta',
        ];
    }
}
