<?php

namespace DogCat\Http\Controllers\Api\V1\DogcatQR;

use DogCat\Http\Controllers\Controller;
use DogCat\Models\Imagen;
use DogCat\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AfiliadoController extends Controller
{

    public $privilegio_superadministrador = true;
    protected $identificador_modulo = 10;

    function __construct()
    {
        $this->middleware('permisoModulo:'.$this->identificador_modulo.',' . $this->privilegio_superadministrador,['except'=>['validarCuenta','validarCuentaSend','passwordEmpresario','passwordEmpresarioSend']]);
    }
    //$2y$10$aNN5AwSvGWLvHy/WNzjKzuZXWrMQBF079yDkBOjNo1Rz470am3KyC/+-*/123456789
    public function data(Request $request){

        if($request->has('qr_code')){
            $data = explode('/+-*/',$request->qr_code);

            if(count($data) == 2){
              $id_crypt = $data[0];
              $identificacion = $data[1];

              $afiliado = User::afiliados()->select('users.*')
                  ->where('identificacion',$identificacion)->first();

              if($afiliado){
                  if(Hash::check($afiliado->id,$id_crypt)){
                      $mascotas_ = $afiliado->mascotasAflliadas();

                      $mascotas = [];

                      foreach ($mascotas_ as $mascota){
                          $imagen = $mascota->imagen;
                          $mascota->raza_mascota = $mascota->raza->nombre;

                          if($imagen){
                              $mascota->url_imagen = $imagen->urlAlmacen();
                          }else{
                              if(strtolower($mascota->raza->tipoMascota->nombre) == 'perro'){
                                  $mascota->url_imagen = Imagen::urlSiluetaPerro();
                              }else{
                                  $mascota->url_imagen = Imagen::urlSiluetaGato();
                              }
                          }
                          $mascotas[] = $mascota;
                      }

                      return [
                          'cliente'=>$afiliado,
                          'mascotas'=>$mascotas
                      ];
                  }
              }
            }
        }

        return [
            'success'=>false,
            'mensaje'=>'No se ha encontrado ningún cliente con la información enviada'
        ];
    }
}
