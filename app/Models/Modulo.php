<?php

namespace DogCat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Modulo extends Model
{
    protected $table = "modulos";

    protected $fillable = [
        'nombre',
        'identificador',
        'etiqueta',
        'url',
        'agrupacion',
        'orden_menu',
        'estado',
    ];

    public static function permitidos(){
        if(Auth::user()->esSuperadministrador()){
            return Modulo::where('modulos.id','<>','0');
        }else{

            $privilegios = Auth::user()->rol->privilegios;

            $data = explode('_',$privilegios);
            $modulos = [];
            for ($i = 0; $i < count($data); $i++) {
                //se quitan los caracteres '(' y ')' para pasar de (1,2) a 1,2
                $str_privilegio = trim($data[$i], '(');
                $str_privilegio = trim($str_privilegio, ')');
                // se separa en un array por la coma
                $data_privilegio = explode(',', $str_privilegio);
                //se agrega el identificador del modulo al array
                $modulos[] = $data_privilegio[0];
            }

            return Modulo::whereIn('modulos.identificador',$modulos);
        }
    }

    public function funciones(){
        return $this->belongsToMany(Funcion::class,'modulos_funciones','modulo_id','funcion_id');
    }

    public function tieneFuncion($id){
        $response = $this->funciones()->where("funciones.id",$id)->count();
        if($response)return true;

        return false;
    }

    public function usuarioTieneFuncion($identificador_funcion){
        if(Auth::user()->esSuperadministrador())return true;

        $privilegios = Auth::user()->rol->privilegios;
        $search = '('.$this->identificador.','.$identificador_funcion.')';
        $posicion = strpos($privilegios,$search);

        if($posicion === false)return false;
        return true;
    }
}
