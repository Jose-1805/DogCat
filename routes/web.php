<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(\Illuminate\Support\Facades\Auth::check())return redirect("/home");
    return view('bienvenido');
});

Auth::routes();

Route::get('/informacion-veterinarias',function (){
    $veterinarias = \DogCat\Models\Veterinaria::where('estado','aprobada')->where('veterinaria','si')->orderBy('created_at')->get();
    return view('informacion_veterinarias')->with('veterinarias',$veterinarias);
});

Route::group(['prefix'=>'simulador-afiliacion'],function (){
    Route::get('/','SimuladorAfiliacionController@index');
    Route::post('/get-valor','SimuladorAfiliacionController@getValor');
    Route::post('/detalle-afiliacion','SimuladorAfiliacionController@detalleAfiliacion');
});

Route::group(['middleware' => 'guest'], function () {
    Route::post('/registro', "HomeController@registro");
    Route::get('/nueva-cuenta/{token}/{id}', "HomeController@nuevaCuenta");
    Route::post('/store-nueva-cuenta', "HomeController@storeNuevaCuenta");
    Route::get('/nueva-cuenta-veterinaria/{token}/{id}', "HomeController@nuevaCuentaVeterinaria");
    Route::post('/store-nueva-cuenta-veterinaria', "HomeController@storeNuevaCuentaVeterinaria");
    Route::get('/create-password/{token}/{id}', "HomeController@createPassword");
    Route::post('/store-password', "HomeController@storePassword");
});

/**
 * TAREAS GENERALES DEL SISTEMA
 */
Route::group(['prefix' => 'tareas-sistema'],function () {
    Route::post('/select-departamentos', 'TareasSistemaController@selectDepartamentos');
    Route::post('/select-ciudades', 'TareasSistemaController@selectCiudades');
    Route::post('/select-afiliados', 'TareasSistemaController@selectAfiliados');
    Route::post('/select-afiliados-sin-afiliacion', 'TareasSistemaController@selectAfiliadosSinAfiliacion');
});

/**
 * AUTENTICADO
 */
Route::get('/home', function (){
    return redirect('/inicio');
});
Route::get('/inicio', 'HomeController@index');
Route::get('/api', 'ApiController@index');

/**
 * IMAGENES DEL SISTEMA
 */
Route::get('/almacen/{path}',function (\Illuminate\Http\Request $request, $path){
    $data = explode('-',$path);
    //desde esta url no se puede acceder a contenido almacenado en la carpeta restringido
    if($data[0] == 'restringido'){
        if($request->ajax())
            return response(['errors'=>['Unathorized.']],401);
        else
            return redirect()->back();
    }

    //si no se ha iniciado sesión solo se pueden ver archivos de la carpeta public y las imagenes de las mascotas
    if(\Illuminate\Support\Facades\Auth::guest()){
        if($data[0] != 'public' && $data[0] != 'mascotas'){
            if($request->ajax())
                return response(['errors'=>['Unathorized.']],401);
            else
                return redirect('/');
        }
    }

    $path = storage_path() .'/app/'. str_replace('-','/', $path);
    if(!File::exists($path)) abort(404);

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('bienvenida-usuario','HomeController@bienvenidaUsuario');
    Route::get('terminos-condiciones','HomeController@terminosCondiciones');
    Route::post('aprobar-terminos-condiciones','HomeController@aprobarTerminosCondiciones');

    Route::group(['prefix' => 'configuracion'],function (){
        Route::post('cambio-password','ConfiguracionController@cambiarPassword');
    });

    /**
     * PUBLICACIONES
     */
    //Route::get('/', 'PublicacionController@index');
    Route::group(['prefix' => 'publicacion'],function (){
        Route::get('/', 'PublicacionController@index');
        Route::post('/anteriores-publicaciones', 'PublicacionController@anteriores_publicaciones');
        Route::post('/nueva', 'PublicacionController@nueva');
        Route::post('/like-publicacion', 'PublicacionController@likePublicacion');
        Route::post('/comentario-publicacion', 'PublicacionController@comentarioPublicacion');
        Route::get('/imagen/{publicacion}/{imagen}/{principal}', 'PublicacionController@imagen');
        Route::post('/data', 'PublicacionController@data');
    });


    /**
     * REGISTROS
     */
    Route::group(['prefix' => 'registro'],function (){
        Route::get('/', 'RegistroController@index');
        Route::get('/datos', 'RegistroController@datos');
        Route::get('/historial/{id}', 'RegistroController@historial');
        Route::post('/lista-historial', 'RegistroController@listaHistorial');
        Route::post('/store-historial', 'RegistroController@storeHistorial');
        Route::post('/asignar', 'RegistroController@asignar');
    });

    /**
     * MODULOS Y FUNCIONES
     */
    Route::group(['prefix' => 'modulos-funciones'],function (){
        Route::get('/', 'ModulosFuncionesController@index');
        Route::post('/vista-modulos', 'ModulosFuncionesController@vistaModulos');
        Route::post('/vista-funciones', 'ModulosFuncionesController@vistaFunciones');
        Route::post('/actualizar-relacion', 'ModulosFuncionesController@actualizarRelacion');
        Route::post('/nuevo-modulo', 'ModulosFuncionesController@nuevoModulo');
        Route::post('/nueva-funcion', 'ModulosFuncionesController@nuevaFuncion');
        Route::post('form-modulo', 'ModulosFuncionesController@formModulo');
        Route::post('editar-modulo', 'ModulosFuncionesController@editarModulo');
        Route::post('form-funcion', 'ModulosFuncionesController@formFuncion');
        Route::post('editar-funcion', 'ModulosFuncionesController@editarFuncion');
    });

    /**
     * ROLES DEL SISTEMA
     */
    Route::group(['prefix' => 'rol'],function (){
        Route::get('/', 'RolController@index');
        Route::post('vista-roles', 'RolController@vistaRoles');
        Route::post('vista-privilegios', 'RolController@vistaPrivilegios');
        Route::post('crear', 'RolController@crear');
        Route::post('form', 'RolController@form');
        Route::post('editar', 'RolController@editar');
    });

    /**
     *  MASCOTAS
     */
    Route::group(['prefix' => 'mascota'],function (){
        Route::get('/lista', 'MascotaController@lista');
        Route::get('/nueva/{usuario?}/{asistido?}', 'MascotaController@nueva');
        Route::get('/{id?}', 'MascotaController@index');
        Route::get('/vacuna/{vacuna}', 'MascotaController@vacuna');
        Route::get('/editar/{mascota}', 'MascotaController@vistaEditar');
        Route::post('/crear', 'MascotaController@crear');
        Route::post('/editar', 'MascotaController@editar');
        Route::post('/form-vacunas', 'MascotaController@formVacunas');
        Route::post('/validar', 'MascotaController@validar');
        Route::post('/validar-informacion', 'MascotaController@validarInformacion');
        Route::get('/revision/{id}', 'MascotaController@revision');
        Route::get('/revision-pdf/{mascota}/{revision}', 'MascotaController@revisionPdf');
        Route::post('/lista-revisiones', 'MascotaController@listaRevisiones');
        Route::get('/nueva-revision/{id}', 'MascotaController@nuevaRevision');
        Route::post('/guardar-revision', 'MascotaController@guardarRevision');
        Route::post('/datos-revision', 'MascotaController@datosRevision');
        Route::get('/evidencia-revision/{mascota}/{evidencia}', 'MascotaController@evidenciaRevision');
        Route::post('/edad', 'MascotaController@edad');
    });

    /**
     *  AFILIACIONES
     */
    Route::group(['prefix' => 'afiliacion'],function (){
        Route::get('/', 'AfiliacionController@index');
        Route::get('/nueva/{solicitud?}/{usuario?}', 'AfiliacionController@nueva');
        Route::get('/ver/{solicitud}', 'AfiliacionController@ver');
        Route::post('/guardar', 'AfiliacionController@guardar');
        Route::post('/lista-mascotas', 'AfiliacionController@listaMascotas');
        Route::get('/lista', 'AfiliacionController@lista');
        Route::post('/marcar-pagada', 'AfiliacionController@marcarPagada');
        Route::post('/get-valor', 'AfiliacionController@getValor');
        Route::post('/form-marcar-pagada', 'AfiliacionController@formMarcarPagada');
        /*Route::get('/editar/{afiliacion}', 'AfiliacionController@vistaEditar');
        Route::post('/crear', 'AfiliacionController@crear');
        Route::post('/editar', 'AfiliacionController@editar');
        Route::post('/form-vacunas', 'AfiliacionController@formVacunas');
        Route::post('/datos-aproximados-afiliacion', 'AfiliacionController@datosAproximadosAfiliacion');*/
    });


    /**
     *  VETERINARIAS
     */
    Route::group(['prefix' => 'veterinaria'],function (){
        Route::get('/', 'VeterinariaController@index');
        Route::get('/lista', 'VeterinariaController@lista');
        Route::get('/crear', 'VeterinariaController@crear');
        Route::post('/guardar', 'VeterinariaController@guardar');
        Route::get('/editar/{id}', 'VeterinariaController@editar');
        Route::post('/actualizar', 'VeterinariaController@actualizar');
        Route::post('/activar', 'VeterinariaController@activar');
        Route::post('/desactivar', 'VeterinariaController@desactivar');
    });


    /**
     *  ENTIDADES
     */
    Route::group(['prefix' => 'entidad'],function (){
        Route::get('/', 'EntidadController@index');
        Route::get('/lista', 'EntidadController@lista');
        Route::get('/crear', 'EntidadController@crear');
        Route::post('/guardar', 'EntidadController@guardar');
        Route::get('/editar/{id}', 'EntidadController@editar');
        Route::post('/actualizar', 'EntidadController@actualizar');
        Route::post('/activar', 'EntidadController@activar');
        Route::post('/desactivar', 'EntidadController@desactivar');
    });

    /**
     *  EMPLEADOS
     */
    Route::group(['prefix' => 'empleado'],function (){
        Route::get('/', 'EmpleadoController@index');
        Route::get('/lista', 'EmpleadoController@lista');
        Route::get('/crear', 'EmpleadoController@crear');
        Route::post('/guardar', 'EmpleadoController@guardar');
        Route::get('/editar/{id}', 'EmpleadoController@editar');
        Route::post('/actualizar', 'EmpleadoController@actualizar');
        Route::post('/activar', 'EmpleadoController@activar');
        Route::post('/desactivar', 'EmpleadoController@desactivar');
    });

    /**
     *  USUARIOS
     */
    Route::group(['prefix' => 'afiliado'],function (){
        Route::get('/', 'AfiliadoController@index');
        Route::get('/lista', 'AfiliadoController@lista');
        Route::get('/crear/{assisted?}', 'AfiliadoController@crear');
        Route::post('/guardar', 'AfiliadoController@guardar');
        Route::get('/editar/{id}', 'AfiliadoController@editar');
        Route::post('/actualizar', 'AfiliadoController@actualizar');
        Route::post('/activar', 'AfiliadoController@activar');
        Route::post('/desactivar', 'AfiliadoController@desactivar');
    });

    /**
     *  SOLICITUDES DE AFILIACIONES
     */
    Route::group(['prefix' => 'solicitud-afiliacion'],function (){
        Route::get('/', 'SolicitudAfiliacionController@index');
        Route::get('/lista', 'SolicitudAfiliacionController@lista');
        Route::post('/enviar', 'SolicitudAfiliacionController@enviar');
        Route::get('/historial/{id}', 'SolicitudAfiliacionController@historial');
        Route::post('/lista-historial', 'SolicitudAfiliacionController@listaHistorial');
        Route::post('/store-historial', 'SolicitudAfiliacionController@storeHistorial');
        Route::post('/asignar', 'SolicitudAfiliacionController@asignar');
    });

    /**
     *  SERVICIOS
     */
    Route::group(['prefix' => 'servicio'],function (){
        Route::get('/', 'ServicioController@index');
        Route::get('/lista', 'ServicioController@lista');
        Route::get('/crear', 'ServicioController@crear');
        Route::post('/guardar', 'ServicioController@guardar');
        Route::get('/editar/{id}', 'ServicioController@editar');
        Route::post('/actualizar', 'ServicioController@actualizar');
        Route::post('/activar', 'ServicioController@activar');
        Route::post('/desactivar', 'ServicioController@desactivar');
        Route::get('/asignar', 'ServicioController@asignar');
        Route::post('/vista-servicios', 'ServicioController@vistaServicios');
        Route::post('/vista-usuarios', 'ServicioController@vistaUsuarios');
        Route::post('/actualizar-relacion', 'ServicioController@actualizarRelacion');
    });

    Route::group(['prefix'=>'disponibilidad'],function (){
        Route::get('/','DisponibilidadController@index');
        Route::post('/lista','DisponibilidadController@lista');
        Route::post('/guardar','DisponibilidadController@guardar');
        Route::post('/eliminar','DisponibilidadController@eliminar');
    });

    Route::group(['prefix'=>'cita'],function (){
        Route::get('/','CitaController@index');
        Route::post('/select-afiliados','CitaController@selectAfiliados');
        Route::post('/select-mascotas','CitaController@selectMascotas');
        Route::post('/select-encargados','CitaController@selectEncargados');
        Route::post('/get-disponibilidades','CitaController@getDisponibilidades');
        Route::post('/get-agenda','CitaController@getAgenda');
        Route::post('/gestion-cita','CitaController@gestionCita');
        Route::post('/guardar','CitaController@guardar');
        Route::post('/agenda-fecha','CitaController@getAgendaFecha');
        Route::get('/lista','CitaController@lista');
        Route::post('/get-datos','CitaController@getDatos');
        Route::post('/cancelar','CitaController@cancelar');
        Route::post('/pagar','CitaController@pagar');
        Route::post('/finalizar','CitaController@finalizar');
        Route::post('/get-info-valor-pago','CitaController@getInfoValorPago');
    });

    Route::group(['prefix' => 'firebase'],function (){
        Route::post('actualizar-token-registro','FirebaseController@actualizarTokenRegistro');
    });

    Route::group(['prefix' => 'recordatorio'],function (){
        Route::post('crear','RecordatorioController@crear');
        Route::post('lista','RecordatorioController@lista');
    });

    Route::group(['prefix' => 'notificacion'],function (){
        Route::post('lista','NotificacionController@lista');
    });

    Route::post('actualizar-sistema',function (){
       \Illuminate\Support\Facades\Auth::user()->actualizarSistema();
    });

    /**
     * FINANZAS DEL SISTEMA
     */
    //Route::get('/', 'PublicacionController@index');
    Route::group(['prefix' => 'finanzas'],function (){
        Route::get('/', 'FinanzasController@index');
        Route::get('/lista-ingresos', 'FinanzasController@listaIngresos');
        Route::get('/lista-egresos', 'FinanzasController@listaEgresos');
        Route::post('/nuevo-egreso', 'FinanzasController@nuevoEgreso');
        Route::get('/evidencia-egreso/{id}', 'FinanzasController@evidenciaEgreso');
        Route::post('/nuevo-ingreso', 'FinanzasController@nuevoIngreso');
        Route::get('/evidencia-ingreso/{id}', 'FinanzasController@evidenciaIngreso');
        Route::post('/datos-grafica-ingresos-egresos-utilidades', 'FinanzasController@datosGraficaIngresosEgresosUtilidades');
    });

    /**
     * CRÉDITOS DE AFILIACIONES
     */
    //Route::get('/', 'PublicacionController@index');
    Route::group(['prefix' => 'credito-afiliacion'],function (){
        Route::get('/', 'CreditoAfiliacionController@index');
        Route::get('/lista', 'CreditoAfiliacionController@lista');
        Route::get('/cuotas/{id}', 'CreditoAfiliacionController@cuotas');
    });
});

