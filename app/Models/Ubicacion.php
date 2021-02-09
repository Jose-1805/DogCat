<?php

namespace DogCat\Models;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $table = "ubicaciones";

    protected $fillable = [
        'carrera',
        'calle',
        'transversal',
        'numero',
        'barrio',
        'especificaciones',
    ];

    public function ciudad(){
        return $this->belongsTo(Ciudad::class,'ciudad_id');
    }

    public function stringDireccion($maps = false){
        $direccion = "";
        //direccion mas especifica para google maps
        if($maps){
            $ciudad = $this->ciudad;
            $departamento = $ciudad->departamento;
            $pais = $departamento->pais->nombre;
            $ciudad = $ciudad->nombre;
            $departamento = $departamento->nombre;
            $calle = false;
            $carrera = false;
            if ($this->calle) {
                $direccion = "Cl. " . $this->calle;
                $calle = true;
            }

            if ($this->carrera && !$calle) {
                $direccion = "Cra. " . $this->carrera;
                $carrera = true;
            }

            if ($this->transversal && !$calle && !$carrera) {
                $direccion = "Tv. " . $this->transversal;
            }

            $direccion .= " " . $this->numero . ", $ciudad - $departamento - $pais";
            $direccion = str_replace('#','',$direccion);
        }else {
            $calle = false;
            $carrera = false;
            if ($this->calle) {
                $direccion = "Calle " . $this->calle;
                $calle = true;
            }

            if ($this->carrera && !$calle) {
                $direccion = "Carrera " . $this->carrera;
                $carrera = true;
            }

            if ($this->transversal && !$calle && !$carrera) {
                $direccion = "Transversal " . $this->transversal;
            }

            $direccion .= " # " . $this->numero . " (" . $this->barrio . ")";
        }
        return $direccion;
    }
}