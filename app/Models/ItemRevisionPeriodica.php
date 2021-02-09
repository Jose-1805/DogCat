<?php

namespace DogCat\Models;

use Illuminate\Database\Eloquent\Model;

class ItemRevisionPeriodica extends Model
{
    protected $table = "items_revisiones_periodicas";

    protected $fillable = [
    ];

    public function evidencias(){
        return $this->belongsToMany(Imagen::class,'imagenes_items_revisiones_periodicas','item_revision_periodica_id','imagen_id');
    }
}