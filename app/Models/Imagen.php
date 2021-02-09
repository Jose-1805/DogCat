<?php

namespace DogCat\Models;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $table = "imagenes";

    protected $fillable = [
        'nombre',
        'ubicacion',
    ];

    public function urlAlmacen(){
        $ubicaion = str_replace('/','-',$this->ubicacion).'-'.$this->nombre;
        return url('almacen/'.$ubicaion);
    }

    public static function urlSiluetaPerro(){
        return url('/imagenes/sistema/silueta_perro.png');
    }

    public static function urlSiluetaGato(){
        return url('/imagenes/sistema/silueta_gato.png');
    }

    public function mimeType(){
        $data = explode('.',$this->nombre);
        return $data[count($data)-1];
    }
}