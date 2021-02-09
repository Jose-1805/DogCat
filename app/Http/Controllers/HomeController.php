<?php

namespace DogCat\Http\Controllers;

use DogCat\Http\Requests\RequestNuevaCuenta;
use DogCat\Http\Requests\RequestNuevaCuentaVeterinaria;
use DogCat\Http\Requests\RequestRegistro;
use DogCat\Models\Imagen;
use DogCat\Models\Notificacion;
use DogCat\Models\Registro;
use DogCat\Models\Ubicacion;
use DogCat\Models\Veterinaria;
use DogCat\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['registro', 'nuevaCuenta', 'storeNuevaCuenta', 'nuevaCuentaVeterinaria', 'storeNuevaCuentaVeterinaria','createPassword','storePassword']]);
    }

    /**
     * Busca el primer módulo activo del usuario y lo redirige
     * Si no encuentra ningún modulo redirecciona a la página de bienvenida de usuario
     *
     * si es un superadministrador abri un modulo
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->rol->superadministrador == 'si') {
            return redirect('/publicacion');
        }

        $privilegios = collect(Auth::user()->rol->dataPrivilegios())->where('estado', 'Activo')->sortBy('orden_menu')->groupBy('agrupacion');
        $url = false;
        $privilegios->each(function ($item, $key) use ($privilegios, &$url) {
            foreach ($item as $i) {
                if (Auth::user()->tieneFuncion($i['identificador'], 'ver', false)) {
                    $url = $i['url'];
                    return false;
                }
            }
        });

        if ($url) {
            return redirect($url);
        } else {
            return redirect('/bienvenida-usuario');
        }
    }

    public function registro(RequestRegistro $request)
    {
        $registro = new Registro();
        $registro->fill($request->all());
        $registro->save();
        Notificacion::nuevoRegistro($registro);
        return ["success" => true];
    }

    public function nuevaCuenta($token, $id_)
    {
        if (Auth::check()) return redirect('/');
        $id = Crypt::decrypt($id_);
        $usuario = User::find($id);
        if ($usuario && $usuario->token != '' && $usuario->token == $token) {
            return view('nueva_cuenta.index')->with('usuario', $usuario)->with('id', $id_)->with('token', $token);
        }
        return redirect('/');
    }

    public function nuevaCuentaVeterinaria($token, $id_)
    {
        if (Auth::check()) return redirect('/');
        $id = Crypt::decrypt($id_);
        $veterinaria = Veterinaria::where('veterinaria','si')->find($id);
        if ($veterinaria && $veterinaria->token != '' && $veterinaria->token == $token) {
            return view('nueva_cuenta_veterinaria.index')->with('veterinaria', $veterinaria)->with('id', $id_)->with('token', $token);
        }
        return redirect('/');
    }

    public function storeNuevaCuenta(RequestNuevaCuenta $request)
    {
        if ($request->has('id') && $request->has('token')) {
            $id = Crypt::decrypt($request->input('id'));
            $usuario = User::find($id);

            $veterinaria = Veterinaria::where('estado','aprobada')->where('veterinaria','si')->where('id',$request->input('veterinaria'))->first();
            if(!$veterinaria)return response(['error' => ['La información enviada es incorrecta']], 422);

            if ($usuario && $usuario->token != '' && $usuario->token == $request->input('token')) {
                DB::beginTransaction();
                $ubicacion = new Ubicacion();
                $ubicacion->fill($request->all());
                $ubicacion->ciudad_id = $request->input('ciudad');
                $ubicacion->save();

                $usuario->fill($request->all());
                $usuario->token = '';
                $usuario->password = Hash::make($request->input('password'));
                $usuario->ubicacion_id = $ubicacion->id;
                $usuario->veterinaria_afiliado_id = $request->input('veterinaria');
                $usuario->save();
                if ($request->hasFile('imagen')) {
                    $imagen = $request->file('imagen');
                    $nombre = $imagen->getClientOriginalName();
                    $nombre = str_replace('-','_',$nombre);
                    $ruta = config('params.storage_img_perfil_usuario') . $usuario->id;
                    $imagen->move(storage_path('app/'.$ruta), $nombre);

                    $imagen_obj = new Imagen();
                    $imagen_obj->nombre = $nombre;
                    $imagen_obj->ubicacion = $ruta;
                    $imagen_obj->save();
                    $usuario->imagen_id = $imagen_obj->id;
                    $usuario->save();
                }
                DB::commit();

                if ($request->has('iniciar')) {
                    Auth::login($usuario);
                }
                return ['success' => true];
            }
        }

        return response(['error' => ['La información enviada es incorrecta']], 422);
    }

    public function storeNuevaCuentaVeterinaria(RequestNuevaCuentaVeterinaria $request){
        if ($request->has('id') && $request->has('token')) {
            $id = Crypt::decrypt($request->input('id'));
            $veterinaria  = Veterinaria::where('veterinaria','si')->find($id);
            if ($veterinaria && $veterinaria->token != '' && $veterinaria->token == $request->input('token')) {
                DB::beginTransaction();

                $ubicacion_veterinaria = new Ubicacion();
                $ubicacion_veterinaria->ciudad_id = $request->input('ciudad_veterinaria');
                $ubicacion_veterinaria->barrio = $request->input('barrio_veterinaria');
                $ubicacion_veterinaria->calle = $request->input('calle_veterinaria');
                $ubicacion_veterinaria->carrera = $request->input('carrera_veterinaria');
                $ubicacion_veterinaria->transversal = $request->input('transversal_veterinaria');
                $ubicacion_veterinaria->numero = $request->input('numero_veterinaria');
                $ubicacion_veterinaria->especificaciones = $request->input('especificaciones_veterinaria');
                $ubicacion_veterinaria->save();

                $veterinaria->nit = $request->input('nit');
                $veterinaria->nombre = $request->input('nombre');
                $veterinaria->correo = $request->input('correo');
                $veterinaria->telefono = $request->input('telefono');
                $veterinaria->web_Site = $request->input('web_Site');
                $veterinaria->ubicacion_id = $ubicacion_veterinaria->id;
                $veterinaria->estado = 'aprobada';
                $veterinaria->token = '';
                $veterinaria->save();

                $ubicacion_administrador = new Ubicacion();
                $ubicacion_administrador->ciudad_id = $request->input('ciudad_administrador');
                $ubicacion_administrador->barrio = $request->input('barrio_administrador');
                $ubicacion_administrador->calle = $request->input('calle_administrador');
                $ubicacion_administrador->carrera = $request->input('carrera_administrador');
                $ubicacion_administrador->transversal = $request->input('transversal_administrador');
                $ubicacion_administrador->numero = $request->input('numero_administrador');
                $ubicacion_administrador->especificaciones = $request->input('especificaciones_administrador');
                $ubicacion_administrador->save();


                $administrador = $veterinaria->administrador;
                $administrador->password = Hash::make($request->input('password'));
                $administrador->ubicacion_id = $ubicacion_administrador->id;
                $administrador->tipo_identificacion = $request->input('tipo_identificacion');
                $administrador->identificacion = $request->input('identificacion');
                $administrador->nombres = $request->input('nombres');
                $administrador->apellidos = $request->input('apellidos');
                $administrador->email = $request->input('email');
                $administrador->celular = $request->input('telefono_celular');
                if($request->has('telefono_administrador'))
                    $administrador->telefono = $request->input('telefono_administrador');
                $administrador->genero = $request->input('genero');
                $administrador->fecha_nacimiento = $request->input('fecha_nacimiento');
                $administrador->save();

                //imagen del administrador
                if ($request->hasFile('imagen')) {
                    $imagen = $request->file('imagen');
                    $nombre = $imagen->getClientOriginalName();
                    $nombre = str_replace('-','_',$nombre);
                    $ruta = config('params.storage_img_perfil_usuario') . $administrador->id;
                    $imagen->move(storage_path('app/'.$ruta), $nombre);

                    $imagen_obj = new Imagen();
                    $imagen_obj->nombre = $nombre;
                    $imagen_obj->ubicacion = $ruta;
                    $imagen_obj->save();
                    $administrador->imagen_id = $imagen_obj->id;
                    $administrador->save();
                }

                //imagen de la veterinaria
                if ($request->hasFile('logo')) {
                    $logo = $request->file('logo');
                    $nombre = $logo->getClientOriginalName();
                    $nombre = str_replace('-','_',$nombre);
                    $ruta = config('params.storage_img_veterinarias') . $veterinaria->id;
                    $logo->move(storage_path('app/'.$ruta), $nombre);

                    $logo_obj = new Imagen();
                    $logo_obj->nombre = $nombre;
                    $logo_obj->ubicacion = $ruta;
                    $logo_obj->save();
                    $veterinaria->imagen_id = $logo_obj->id;
                    $veterinaria->save();
                }
                DB::commit();

                Auth::login($administrador);
                return ['success' => true];
            }
        }

        return response(['error' => ['La información enviada es incorrecta']], 422);
    }

    public function createPassword($token,$id){
        $id = Crypt::decrypt($id);
        $user = User::where('token',$token)->find($id);

        if($user && $user->estado == 'activo') {
            if($user->dependenciasActivas())
                return view('usuario/create_password')->with('user', $user);
        }
        return redirect('/');
    }

    public function storePassword(Request $request){

        $user = User::find($request->input('id'));

        if($user && $user->estado == 'activo') {
            if($user->dependenciasActivas()) {

                //validacion de password
                if($request->has('password') && $request->input('password') != ''){
                    if($request->has('password_confirm')){
                        if(strlen($request->input('password'))<6)
                            return response(['error'=>['La contraseña debe tener 6 caracteres como mínimo.']],422);

                        if($request->input('password') != $request->input('password_confirm'))
                            return response(['error'=>['La contraseña y la verificación no coinciden..']],422);
                    }else{
                        return response(['error'=>['Debe ingresar la confirmación de la contraseña.']],422);
                    }

                    $user->token = null;
                    $user->password = Hash::make($request->input('password'));
                    $user->save();

                    Auth::login($user);

                    return ['success'=>true];
                }else{
                    return response(['error'=>['Todos los campos son obligatorios.']],422);
                }
            }
        }
        return response(['error'=>['La información enviada es incorrecta']],422);
    }

    public function bienvenidaUsuario(){
        return view('bienvenido');
    }

    public function terminosCondiciones(){
        if(!Auth::user()->terminosCondicionesAprobados()){
            return view('terminos_condiciones');
        }
        return redirect('/');
    }

    public function aprobarTerminosCondiciones(){
        if(Auth::check()) {
            $user = \Illuminate\Support\Facades\Auth::user();
            if (!$user->terminosCondicionesAprobados()) {
                $user->terminos_condiciones_aceptados = 'si';
                $user->save();
            }
        }
    }
}