<?php

namespace DogCat\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperadministradorAutenticado
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->esSuperadministrador())
        return $next($request);

        if($request->ajax())
            return response("No autorizado",401);

        return redirect("/");
    }
}
