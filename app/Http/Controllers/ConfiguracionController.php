<?php

namespace DogCat\Http\Controllers;

use DogCat\Http\Requests\CambioPasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ConfiguracionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function cambiarPassword(CambioPasswordRequest $request){
        $user = Auth::user();
        if(Hash::check($request->input('password_old'),$user->password)){
            $user->password = Hash::make($request->input('password'));
            $user->save();
            return ['success'=>true];
        }else{
            return response(['error'=>['La contraseña antigua es incorrecta']],422);
        }
    }
}
