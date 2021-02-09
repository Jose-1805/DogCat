<?php

namespace DogCat\Http\Requests;

use DogCat\Models\Veterinaria;
use Illuminate\Foundation\Http\FormRequest;

class RequestEntidad extends FormRequest
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
            //datos basicos entidad
            'nit'=>'required|max:20|unique:veterinarias,nit',
            'nombres'=>'required|max:200',
            'correo'=>'required|email|max:250',
            'telefono'=>'required|max:20',
            'web_site'=>'max:250',
            'logo'=>'file|mimes:jpeg,jpg,png|max:500',

            //datos de ubicacion entidad
            'ciudad_veterinaria'=>'required|exists:ciudades,id',
            'barrio_veterinaria'=>'required|max:255',
            'calle_veterinaria'=>'required_without:carrera_veterinaria|max:20',
            'carrera_veterinaria'=>'required_without:calle_veterinaria|max:20',
            'numero_veterinaria'=>'required|max:20',
            'especificaciones_veterinaria'=>'max:255',


            //datos personales administrador
            'tipo_identificacion'=>'required|in:C.C,NIT',
            'identificacion'=>'required|max:15|unique:users,identificacion',
            'nombres'=>'required|max:150',
            'apellidos'=>'required|max:150',
            'email'=>'required|email|max:150|unique:users,email',
            'telefono_administrador'=>'required|max:15',
            'genero'=>'required|in:masculino,femenino',
            'fecha_nacimiento'=>'required|date',
            'rol'=>'required|exists:roles,id',

            //datos de ubicación administrador
            'ciudad_administrador'=>'required|exists:ciudades,id',
            'barrio_administrador'=>'required|max:255',
            'calle_administrador'=>'required_without:carrera_administrador|max:20',
            'carrera_administrador'=>'required_without:calle_administrador|max:20',
            'numero_administrador'=>'required|max:20',
            'especificaciones_administrador'=>'max:255',

            //'password'=>'same:password_confirm',
            //'password_confirm'=>'min:6',
            'imagen'=>'file|mimes:jpeg,jpg,png|max:500'
        ];

        if($this->has('veterinaria')){
            $veterinaria = Veterinaria::where('entidad','si')->find($this->input('veterinaria'));
            $data['nit'] = 'required|max:20|unique:veterinarias,nit,'.$veterinaria->id.',id';
            $data['identificacion'] = 'required|max:15|unique:users,identificacion,'.$veterinaria->administrador_id.',id';
            $data['email'] = 'required|email|max:150|unique:users,email,'.$veterinaria->administrador_id.',id';
        }
        return $data;
    }

    public function messages(){
        return[

            //datos basicos entidad
            'nit.required'=>'El campo nit, en la información básica de la entidad, es obligatorio.',
            'nit.max'=>'El campo nit, en la información básica de la entidad, puede contener máximo 20 caracteres.',
            'nit.unique'=>'El campo nit, en la información básica de la entidad, ya está en uso.',

            'nombres.required'=>'El campo nombres, en la información básica de la entidad, es obligatorio.',
            'nombres.mas'=>'El campo nombres, en la información básica de la entidad, puede contener máximo 200 caracteres.',

            'correo.required'=>'El campo correo, en la información básica de la entidad, es obligatorio.',
            'correo.email'=>'El campo correo, en la información básica de la entidad, no contiene el formato correcto.',
            'correo.max'=>'El campo correo, en la información básica de la entidad, puede contener máximo 250 caracteres.',

            'telefono.required'=>'El campo teléfono, en la información básica de la entidad, es obligatorio.',
            'telefono.max'=>'El campo teléfono, en la información básica de la entidad, puede contener máximo 20 caracteres.',
            'telefono.numeric'=>'El campo teléfono, en la información básica de la entidad, debe ser numérico.',

            'web_site.required'=>'El campo web site, en la información básica de la entidad, es obligatorio.',
            'web_site.max'=>'El campo web site, en la información básica de la entidad, puede contener máximo 250 caracteres.',
            'web_site.url'=>'El campo web site, en la información básica de la entidad, no contiene una url correcta.',

            'logo.file'=>'El campo logo, en la información básica de la entidad, es incorrecto.',
            'logo.mimes'=>'El campo logo, en la información básica de la entidad, debe pertenecer a uno de los formatos (jpeg,jpg o png).',
            'logo.max'=>'El campo logo, en la información básica de la entidad, es demasiado pesado (Máx. 500Kb).',


            //datos de ubicacion entidad
            'ciudad_veterinaria.required'=>'El campo ciudad, en la información de ubicación de la entidad, es obligatorio.',
            'ciudad_veterinaria.exists'=>'La información enviada es incorrecta.',

            'barrio_veterinaria.required'=>'El campo barrio, en la información de ubicación de la entidad, es obligatorio.',
            'barrio_veterinaria.max'=>'El campo barrio, en la información de ubicación de la entidad, puede contener máximo 255 caracteres.',

            'calle_veterinaria.required_without'=>'El campo calle, en la información de ubicación de la entidad, es obligatorio si no està el campo carrera.',
            'calle_veterinaria.max'=>'El campo calle, en la información de ubicación de la entidad, puede contener màximo 20 caracteres.',

            'carrera_veterinari.required_without'=>'El campo carrera, en la información de ubicación de la entidad, es obligatorio si no està el campo calle.',
            'carrera_veterinari.max'=>'El campo carrera, en la información de ubicación de la entidad, puede contener màximo 20 caracteres.',

            'numero_veterinaria.required'=>'El campo nùmero, en la información de ubicación de la entidad, es obligatorio.',
            'numero_veterinaria.max'=>'El campo nùmero, en la información de ubicación de la entidad, puede contener màximo 20 caracteres.',

            'especificaciones_veterinaria.max'=>'El campo especificaciones, en la información de ubicación de la entidad, puede contener màximo 255 caracteres.',



            //datos personales administrador
            'tipo_identificacion.required'=>'El campo tipo de identificación, en los datos personales del administrador, es obligatorio.',
            'tipo_identificacion.in'=>'El campo tipo de identificación, en los datos personales del administrador, debe ser igual a uno de estos valores C.C, NIT.',

            'identificacion.required'=>'El campo identificación, en los datos personales del administrador, es obligatorio.',
            'identificacion.max'=>'El campo identificación, en los datos personales del administrador, debe contener 15 caracteres como máximo.',
            'identificacion.unique'=>'El campo identificación, en los datos personales del administrador, ya està en uso.',

            'nombres.required'=>'El campo nombres, en los datos personales del administrador, es obligatorio',
            'nombres.max'=>'El campo nombres, en los datos personales del administrador, puede contener màximo 150 caracteres',

            'apellidos.required'=>'El campo apellidos, en los datos personales del administrador, es obligatorio',
            'apellidos.max'=>'El campo apellidos, en los datos personales del administrador, puede contener màximo 150 caracteres',

            'email.required'=>'El campo correo, en los datos personales del administrador, es obligatorio',
            'email.email'=>'El campo correo, en los datos personales del administrador, no contiene el formato correcto',
            'email.max'=>'El campo correo, en los datos personales del administrador, puede contener màximo 150 caracteres',
            'email.unique'=>'El campo correo, en los datos personales del administrador, ya està en uso',

            'telefono_administrador.required'=>'El campo teléfono, en los datos personales del administrador, es obligatorio',
            'telefono_administrador.max'=>'El campo teléfono, en los datos personales del administrador, puede contener màximo 15 dìgitos',
            'telefono_administrador.numeric'=>'El campo teléfono, en los datos personales del administrador, debe ser numèrico',

            'genero.required'=>'El campo gènero, en los datos personales del administrador, es obligatorio',
            'genero,in'=>'El campo gènero, en los datos personales del administrador, debe ser igual a uno de estos valors (masculino o femenino)',

            'fecha_nacimiento.required'=>'El campo fecha de nacimiento, en los datos personales del administrador, es obligatorio',
            'fecha_nacimiento.date'=>'El campo fecha de nacimiento, en los datos personales del administrador, no contiene el formato correcto',

            'rol.required'=>'El campo rol, en los datos personales del administrador, es obligatorio',
            'rol.exists'=>'La información enviada es incorrecta',


            //datos de ubicación administrador
            'ciudad_administrador.required'=>'El campo ciudad, en la información de ubicación del administrador, es obligatorio.',
            'ciudad_administrador.exists'=>'La información enviada es incorrecta.',

            'barrio_administrador.required'=>'El campo barrio, en la información de ubicación del administrador, es obligatorio.',
            'barrio_administrador.max'=>'El campo barrio, en la información de ubicación del administrador, puede contener máximo 255 caracteres.',

            'calle_administrador.required_without'=>'El campo calle, en la información de ubicación del administrador, es obligatorio si no està el campo carrera.',
            'calle_administrador.max'=>'El campo calle, en la información de ubicación del administrador, puede contener màximo 20 caracteres.',

            'carrera_veterinaria.required_without'=>'El campo carrera, en la información de ubicación del administrador, es obligatorio si no està el campo calle.',
            'carrera_veterinaria.max'=>'El campo carrera, en la información de ubicación del administrador, puede contener màximo 20 caracteres.',

            'numero_administrador.required'=>'El campo nùmero, en la información de ubicación del administrador, es obligatorio.',
            'numero_administrador.max'=>'El campo nùmero, en la información de ubicación del administrador, puede contener màximo 20 caracteres.',

            'especificaciones_administrador.max'=>'El campo especificaciones, en la información de ubicación del administrador, puede contener màximo 255 caracteres.',

            'imagen'=>'file|mimes:jpeg,jpg,png|max:500',
            'imagen.file'=>'El campo imagen, en los datos personales del administrador, es incorrecto.',
            'imagen.mimes'=>'El campo imagen, en los datos personales del administrador, debe pertenecer a uno de los formatos (jpeg,jpg o png).',
            'imagen.max'=>'El campo imagen, en los datos personales del administrador, es demasiado pesado (Máx. 500Kb).',

            'password.required'=>'El campo contraseña es obligatorio.',
            'password.min'=>'El campo contraseña debe contener 6 caracteres como mínimo.',
            'password.same'=>'El campo contraseña y confirmación de contraseña deben coincidir.',
            'password_confirm.required'=>'El campo confirmación de contraseña es obligatorio.',
            'password_confirm.min'=>'El campo confirmación de contraseña debe contener 6 caracteres como mínimo.',
        ];
    }
}
