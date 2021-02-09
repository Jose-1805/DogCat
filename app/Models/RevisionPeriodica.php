<?php

namespace DogCat\Models;

use DogCat\User;
use Illuminate\Database\Eloquent\Model;

class RevisionPeriodica extends Model
{
    protected $table = "revisiones_periodicas";

    protected $fillable = [
    ];

    public function siguiente(){
        $clave_actual = array_search($this->item_actual,config('params.items_revisiones'));
        if($clave_actual>=0){
            $clave_actual++;
            if(array_key_exists($clave_actual,config('params.items_revisiones'))){
                $this->item_actual = config('params.items_revisiones')[$clave_actual];
            }else{
                //si no existen màs items de revisiones finalizamos la revision
                $this->estado = 'terminada';
            }
            $this->save();
        }
    }

    public function usuario(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function items(){
        return $this->hasMany(ItemRevisionPeriodica::class,'revision_periodica_id');
    }
}