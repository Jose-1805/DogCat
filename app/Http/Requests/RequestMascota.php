<?php

namespace DogCat\Http\Requests;

use DogCat\Models\Mascota;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RequestMascota extends FormRequest
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
            'usuario'=>'required|exists:users,id',
            'imagen'=>'file|mimes:jpg,jpeg,png|max:'.config('params.maximo_peso_archivos'),
            'nombre'=>'required|max:100',
            'fecha_nacimiento'=>'required|date',
            'sexo'=>'required|in:Macho,Hembra',
            'peso'=>'required|numeric',
            'color'=>'required|max:255',
            'tipo_mascota'=>'required|exists:tipos_mascotas,id',
            'raza'=>'required|exists:razas,id',
            'pelaje'=>'required|max:100',
            'cola'=>'required|max:100',
            'patas'=>'required|max:100',
            'orejas'=>'required|max:100',
            'ojos'=>'required|max:100',
            'manchas'=>'max:100',
            'esterilizado'=>'required|in:si,no',
            'otras_caracteristicas'=>'max:1000',
            'vacunas_file'=>'required|file|max:'.config('params.maximo_peso_archivos').'|mimes:pdf,jpeg,jpg,png',
            'vacunas'=>'required|max:250',
        ];

        if($this->has('mascota')){
            unset($data['usuario']);
            $data['vacunas_file'] = 'file|max:'.config('params.maximo_peso_archivos').'|mimes:pdf,jpeg,jpg,png';
            $data['vacunas'] = 'max:250';
        }

        if(Auth::user()->getTipoUsuario() == 'afiliado' || Auth::user()->getTipoUsuario() == 'registro')unset($data['usuario']);

        if($this->has('mascota')){
            $mascota = Mascota::findOrFail($this->mascota);

            if($mascota->validado == 'si' && !Auth::user()->esSuperadministrador()){
                $data = [
                    'peso'=>'required|numeric',
                    'otras_caracteristicas'=>'max:1000',
                    'vacunas_file'=>'file|max:'.config('params.maximo_peso_archivos').'|mimes:pdf,jpeg,jpg,png',
                    'vacunas'=>'required_with:vacunas_file|max:250',
                ];

                if($mascota->esterilizado == 'no'){
                    $data['esterilizado'] = 'required|in:si,no';
                }
            }
        }

        return $data;
        /*return [
            'imagen'=>'file|mimes:jpg,jpeg,png|max:500',
            'nombre'=>'required|max:100',
            'fecha_nacimiento'=>'required|date',
            'sexo'=>'required|in:Macho,Hembra',
            'peso'=>'required|numeric',
            'color'=>'required|max:255',
            'tipo_mascota'=>'required|exists:tipos_mascotas,id',
            'raza'=>'required|exists:razas,id',
        ];*/
    }

    public function messages()
    {
        return [
            'usuario.required'=>'El campo usuario es requerido',
            'usuario.exists'=>'La información enviada es incorrecta',

            'imagen.file'=>'El campo de imagen es incorrecto',
            'imagen.mimes'=>'La imagen seleccionada debe ser de tipo (jpg, jpeg o png)',
            'imagen.max'=>'La imagen debe pesar máximo '.config('params.maximo_peso_archivos').' kb',

            'nombre.required'=>'El campo nombre es requerido',
            'nombre.alpha'=>'El campo nombre no debe incluir caracteres especiales',
            'nombre.max'=>'El campo nombre debe tener máximo 100 caracteres',

            'fecha_nacimiento.required'=>'EL campo fecha de nacimiento es requerido',
            'fecha_nacimiento.date'=>'EL campo fecha de nacimiento debe ser de tipo fecha',

            'sexo.required'=>'EL campo sexo es requerido',
            'sexo.in'=>'La información enviada es incorrecta',

            'peso.required'=>'EL campo peso es requerido',
            'peso.numeric'=>'El campo peso debe ser de tipo numérico',

            'color.required'=>'EL campo color es requerido',
            'color.alpha'=>'El campo color no debe incluir caracteres especiales',
            'color.max'=>'El campo color debe tener máximo 255 caracteres',

            'tipo_mascota.required'=>'EL campo tipo de mascota es requerido',
            'tipo_mascota.exists'=>'La información enviada es incorrecta',

            'raza.required'=>'EL campo raza es requerido',
            'raza.exists'=>'La información enviada es incorrecta',
        ];
    }
}