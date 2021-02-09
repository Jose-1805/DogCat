<?php

namespace DogCat\Http\Middleware;

use Closure;
use DogCat\Http\Controllers\SimuladorAfiliacionController;
use DogCat\Models\Modulo;
use Illuminate\Support\Facades\Auth;

class AuthApiRol
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  $identificador -> numero entero identificador del modulo
     * @param  \Closure  $privilegio_superadministrador -> (true -> continua si es superadministrador)
     * @return mixed
     */
    public function handle($request, Closure $next, $rol)
    {
        $rol_obj = Auth::user()->rol;
        switch ($rol){
            case 'paseador':
                if($rol_obj->esPaseador())
                    return $next($request);
                break;
            case 'entidad':
                if($rol_obj->esEntidad())
                    return $next($request);
                break;
        }

        if($request->ajax())
            return response("Unauthorized.",401);

        return redirect("/");
    }
}
