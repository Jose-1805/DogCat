<?php

namespace DogCat\Http\Requests;

use DogCat\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RequestEmpleado extends FormRequest
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
            //datos personales
            'tipo_identificacion'=>'required|in:C.C,NIT',
            'identificacion'=>'required|max:15|unique:users,identificacion',
            'nombres'=>'required|max:150',
            'apellidos'=>'required|max:150',
            'email'=>'required|email|max:150|unique:users,email',
            'celular'=>'required|max:15',
            'telefono'=>'max:15',
            'genero'=>'required|in:masculino,femenino',
            'fecha_nacimiento'=>'required|date|before:'.date('Y-m-d',strtotime('-'.config('params.edad_minima').' years')),

            'rol'=>'required|exists:roles,id',

            //datos de ubicación
            'ciudad'=>'required|exists:ciudades,id',
            'barrio'=>'required|max:255',
            'calle'=>'required_without_all:carrera,transversal|max:20',
            'carrera'=>'required_without_all:calle,transversal|max:20',
            'transversal'=>'required_without_all:calle,carrera|max:20',
            'numero'=>'required|max:20',
            'especificaciones'=>'max:255',

            /*'password'=>'min:6|same:password_confirm',
            'password_confirm'=>'min:6',*/
            'imagen'=>'file|mimes:jpeg,jpg,png|max:'.config('params.maximo_peso_archivos')
        ];

        //es una edición
        if($this->has('usuario')){
            $data['identificacion'] = 'required|max:15|unique:users,identificacion,'.$this->input('usuario').',id';
            $data['email'] = 'required|email|max:150|unique:users,email,'.$this->input('usuario').',id';
        }

        return $data;
    }

    public function messages(){
        return[
            //datos personales
            'tipo_identificacion.required'=>'El campo tipo de identificación es obligatorio.',
            'tipo_identificacion.in'=>'El campo tipo de identificación debe ser igual a uno de estos valores C.C, NIT.',

            'identificacion.required'=>'El campo identificación es obligatorio.',
            'identificacion.max'=>'El campo identificación debe contener 15 caracteres como máximo.',
            'identificacion.unique'=>'El campo identificación ya està en uso.',

            'nombres.required'=>'El campo nombres es obligatorio',
            'nombres.max'=>'El campo nombres puede contener màximo 150 caracteres',

            'apellidos.required'=>'El campo apellidos es obligatorio',
            'apellidos.max'=>'El campo apellidos puede contener màximo 150 caracteres',

            'email.required'=>'El campo correo es obligatorio',
            'email.email'=>'El campo correo no contiene el formato correcto',
            'email.max'=>'El campo correo puede contener màximo 150 caracteres',
            'email.unique'=>'El campo correo ya està en uso',

            'celular.required'=>'El campo celular es obligatorio',
            'celular.max'=>'El campo celular puede contener màximo 15 dìgitos',
            'celular.numeric'=>'El campo celular debe ser numèrico',

            'telefono.max'=>'El campo teléfono puede contener màximo 15 dìgitos',
            'telefono.numeric'=>'El campo teléfono debe ser numèrico',

            'genero.required'=>'El campo género es obligatorio',
            'genero,in'=>'El campo género debe ser igual a uno de estos valors (masculino o femenino)',

            'fecha_nacimiento.required'=>'El campo fecha de nacimiento es obligatorio',
            'fecha_nacimiento.date'=>'El campo fecha de nacimiento no contiene el formato correcto',

            'tipo_usuario.required'=>'El campo tipo de usuario es obligatorio',
            'tipo_usuario,in'=>'El campo tipo de usuario debe ser igual a uno de estos valors (Afiliado o Personal DogCat)',

            'rol.required'=>'El campo rol es obligatorio',
            'rol.exists'=>'La información enviada es incorrecta',

            'veterinaria.required'=>'El campo veterinaria es obligatorio',
            'veterinaria.exists'=>'La información enviada es incorrecta',


            //datos de ubicación
            'ciudad.required'=>'El campo ciudad es obligatorio.',
            'ciudad.exists'=>'La información enviada es incorrecta.',

            'barrio.required'=>'El campo barrio es obligatorio.',
            'barrio.max'=>'El campo barrio puede contener máximo 255 caracteres.',

            'calle.required_without'=>'El campo calle es obligatorio si no està el campo carrera.',
            'calle.max'=>'El campo calle puede contener màximo 20 caracteres.',

            'carrera_veterinaria.required_without'=>'El campo carrera es obligatorio si no està el campo calle.',
            'carrera_veterinaria.max'=>'El campo carrera puede contener màximo 20 caracteres.',

            'numero.required'=>'El campo nùmero es obligatorio.',
            'numero.max'=>'El campo nùmero puede contener màximo 20 caracteres.',

            'especificaciones.max'=>'El campo especificaciones puede contener màximo 255 caracteres.',

            'imagen.file'=>'El campo imagen, es incorrecto.',
            'imagen.mimes'=>'El campo imagen, debe pertenecer a uno de los formatos (jpeg,jpg o png).',
            'imagen.max'=>'El campo imagen, es demasiado pesado (Máx. '.config('params.maximo_peso_archivos').' Kb).',

            'password.required'=>'El campo contraseña es obligatorio.',
            'password.min'=>'El campo contraseña debe contener 6 caracteres como mínimo.',
            'password.same'=>'El campo contraseña y confirmación de contraseña deben coincidir.',
            'password_confirm.required'=>'El campo confirmación de contraseña es obligatorio.',
            'password_confirm.min'=>'El campo confirmación de contraseña debe contener 6 caracteres como mínimo.',
        ];
    }
}
