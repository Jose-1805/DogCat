<?php

namespace DogCat\Models;

use DogCat\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Servicio extends Model
{
    protected $table = "servicios";

    protected $fillable = [
        'nombre',
        'estado',
        'duracion_1_10',
        'duracion_10_25',
        'duracion_mayor_25',
    ];

    public static function permitidos(){
        if(Auth::user()->getTipoUsuario() == 'empleado'){
            $veterinaria = Auth::user()->getVeterinaria();
            return Servicio::where('servicios.veterinaria_id',$veterinaria->id);
        }elseif (Auth::user()->getTipoUsuario() == 'personal dogcat'){
            return Servicio::whereNotNull('servicios.id');
        }
        return Servicio::whereNull('servicios.id');
    }

    /**
     * Determina los servicios para los cuales se puede pedir cita para la mascota enviada como parametro
     * No se tiene en cuenta el estado de la mascota o la validación
     *
     * @param Mascota $mascota
     * @return mixed
     */
    public static function permitidosCitasMascota(Mascota $mascota){
        $usuario = $mascota->user;
        $veterinaria_id = $usuario->veterinaria_afiliado_id;
        $tipo_mascota = $mascota->raza->tipoMascota->nombre;

        $servicios = Servicio::select('servicios.*')
            ->where('servicios.citas','si')
            ->leftJoin('veterinarias','servicios.veterinaria_id','=','veterinarias.id')
            ->where('servicios.estado','Activo')
            ->where(function ($q) use ($veterinaria_id){
                $q->whereNull('servicios.veterinaria_id')
                  ->orWhere('servicios.veterinaria_id',$veterinaria_id)
                  ->orWhere('veterinarias.entidad','si');
            });

        if($tipo_mascota == 'Perro'){
            $servicios = $servicios->where('aplicable_perros','si');
        }else if($tipo_mascota == 'Gato'){
            $servicios = $servicios->where('aplicable_gatos','si');
        }

        return $servicios;
    }

    public static function propios(){
        if(Auth::user()->getTipoUsuario() == 'empleado'){
            $veterinaria = Auth::user()->getVeterinaria();
            return Servicio::where('servicios.veterinaria_id',$veterinaria->id);
        }elseif (Auth::user()->getTipoUsuario() == 'personal dogcat'){
            return Servicio::whereNull('servicios.veterinaria_id');
        }
        return Servicio::whereNull('servicios.id');
    }

    public function historialPreciosSericios(){
        return $this->hasMany(HistorialPrecioServicio::class,'servicio_id');
    }

    public function ultimoHistorialPrecioServicio(){
        return $this->historialPreciosSericios()->orderBy('id','DESC')->first();
    }

    public function usuarios(){
        return $this->belongsToMany(User::class,'users_servicios','servicio_id','user_id');
    }

    public function tieneUsuario($id){
        return $this->usuarios()->where('users.id',$id)->first()?true:false;
    }

    public function dataPreciosMascota(Mascota $mascota){
        $historial_precios = $this->ultimoHistorialPrecioServicio();
        /*if($mascota->peso <= 10)
            return [
                'largo'=>$historial_precios->largo_1_10,
                'corto'=>$historial_precios->corto_1_10,
                'descuento'=>$historial_precios->descuento
            ];
        if($mascota->peso > 10 && $mascota->peso <= 25)
            return [
                'largo'=>$historial_precios->largo_10_25,
                'corto'=>$historial_precios->corto_10_25,
                'descuento'=>$historial_precios->descuento
            ];
        if($mascota->peso > 25)
            return [
                'largo'=>$historial_precios->largo_mayor_25,
                'corto'=>$historial_precios->corto_mayor_25,
                'descuento'=>$historial_precios->descuento
            ];*/

        return [
            'valor'=>$historial_precios->valor,
            'descuento'=>$historial_precios->descuento
            ];
    }
}
