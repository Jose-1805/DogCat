<?php

namespace DogCat\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FirebaseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function actualizarTokenRegistro(Request $request){
        $user = Auth::user();
        if($request->permitir_notificaciones == 'no'){
            $user->permitir_firebase_notificaciones = 'no';
            $user->firebase_token = null;
        }else {
            $user->permitir_firebase_notificaciones = 'si';
            if ($request->has('token') && $request->token)
                $user->firebase_token = $request->token;
            else
                $user->firebase_token = null;
        }
        $user->save();
    }
}
