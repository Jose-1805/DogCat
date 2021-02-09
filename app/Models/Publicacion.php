<?php

namespace DogCat\Models;

use DogCat\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Publicacion extends Model
{
    protected $table = "publicaciones";

    protected $fillable = [
        'publicacion',
        'user_id',
    ];

    public static function permitidos(){
        $publicaciones = Publicacion::join('users','publicaciones.user_id','=','users.id')
            ->join('roles','users.rol_id','=','roles.id');
        switch (Auth::user()->getTipoUsuario()){
            case 'empleado':
                $publicaciones = $publicaciones->where(function ($q){
                   $q->where('users.veterinaria_empleo_id',Auth::user()->veterinaria_empleo_id)
                   ->orWhere('users.veterinaria_afiliado_id',Auth::user()->veterinaria_empleo_id)
                   ->orWhere(function ($q1){
                       $q1->whereNull('users.veterinaria_empleo_id')
                           ->whereNull('users.veterinaria_afiliado_id');
                    })
                   ->orWhere(function ($q1){
                       $q1->where('roles.entidades','si');
                   });

                });
                break;
            case 'afiliado':
                $publicaciones = $publicaciones->where(function ($q){
                    $q->where('users.veterinaria_empleo_id',Auth::user()->veterinaria_afiliado_id)
                        ->orWhere('users.veterinaria_afiliado_id',Auth::user()->veterinaria_afiliado_id)
                    ->orWhere(function ($q1){
                        $q1->whereNull('users.veterinaria_empleo_id')
                            ->whereNull('users.veterinaria_afiliado_id');
                    })
                    ->orWhere(function ($q1){
                        $q1->where('roles.entidades','si');
                    });
                });
                break;
            case 'personal dogcat':
                $publicaciones = $publicaciones;
                break;
            default:
                $publicaciones = $publicaciones->whereNull('publicaciones.id');
                break;
        };
        return $publicaciones;
    }

    public function usuario(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function imagenes(){
        return $this->belongsToMany(Imagen::class,'imagenes_publicaciones','publicacion_id','imagen_id');
    }

    public function imagenPrincipal(){
        return $this->imagenes()->where('imagenes_publicaciones.principal','si')->first();
    }

    public function formatoFecha(){
        $time = strtotime($this->created_at);
        $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiempre','Octubre','Noviembre','Diciembre'];
        $dia = date('d',$time);
        $mes = $meses[intval(date('m',$time))];
        $anio = date('Y',$time);
        $hora = date('g',$time).':'.date('i',$time).' '.date('a',$time);

        return $dia.' de '.$mes.' de '.$anio.' ('.$hora.')';
    }

    public function likes(){
        return $this->hasMany(LikePublicacion::class,'publicacion_id');
    }

    public function comentarios(){
        return $this->hasMany(Comentario::class,'publicacion_id');
    }

    /**
     * Determina si un usuario a registrado un like sobre la publicación
     *
     * @param $id => id del usuario
     * @return bool => true => si se ha registrado _____ false => no se ha registrado
     */
    public function userLike($id){
        if($this->likes()->where('user_id',$id)->first())return true;

        return false;
    }
}