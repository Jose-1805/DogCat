<?php

namespace DogCat\Models;

use DogCat\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Correo extends Model
{
    protected $table = 'correos';
    protected $fillable = [
        'tipo',
        'fecha_programada',
        'estado',
        'asunto',
        'titulo',
        'mensaje',
        'boton',
        'texto_boton',
        'url_boton',
        'correos_destinatarios'
    ];

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'correos_users', 'correo_id', 'user_id');
    }


    /**
     * Valida y registra la información de un correo en la db
     *
     * @param $tipo => tipo de correo 'programado', 'prioritario'
     * @param null $fecha_programada => Fecha de envio si el tipo es programado
     * @param string $asunto => texto
     * @param string $titulo => texto
     * @param string $mensaje => html
     * @param bool $boton => si el correo debe tener un botón
     * @param string $texto_boton
     * @param string $url_boton
     * @param array $remitentes => array con ids de remitentes del correo
     * @return array => ['success'=>true] -> correo registrado con éxito ******* ['success'=>false,'error'=>''] -> correo con errores y detalle del error
     */
    private static function crear($tipo, $fecha_programada = null, $asunto = '', $titulo = '', $mensaje = '', $boton = false, $texto_boton = '', $url_boton = '', Collection $remitentes)
    {
        //validacion de correo de remitentes
        foreach ($remitentes as $remitente) {
            if(!filter_var($remitente->email,FILTER_VALIDATE_EMAIL)){
                return [
                    'success' => false,
                    'error' => 'El email "'.$remitente->email.'" no contiene un formato correcto.'
                ];
            }
        }


        $correo = new Correo();
        //validacion de tipo de correo
        if ($tipo != 'programado' && $tipo != 'prioritario') {
            return [
                'success' => false,
                'error' => 'El tipo de correo debe estar entre los valores (programado o prioritario)'
            ];
        }
        $correo->tipo = $tipo;

        //validacion de fecha
        if ($tipo == 'programado') {
            if ($fecha_programada == null) {
                return [
                    'success' => false,
                    'error' => 'La fecha de envio programado es obligatoria cuando el tipo de correo es "programado"'
                ];
            }
            $hoy = strtotime(date('Y-m-d'));
            $fecha_programada_time = strtotime($fecha_programada);
            if ($hoy > $fecha_programada_time) {
                return [
                    'success' => false,
                    'error' => 'La fecha de envío programado no debe ser menor a la fecha actual'
                ];
            }

            $correo->fecha_programada = $fecha_programada;
        }

        //mensaje obligatotio
        if ($mensaje == '') {
            return [
                'success' => false,
                'error' => 'El mensaje del correo es obligatorio'
            ];
        }

        $correo->mensaje = $mensaje;

        if($asunto != null)
            $correo->asunto = $asunto;

        if($titulo != null)
            $correo->titulo = $titulo;

        if($boton){
            $correo->boton = 'si';
            $correo->texto_boton = $texto_boton;
            $correo->url_boton = $url_boton;
        }

        //validacion de remitentes
        if (!count($remitentes)) {
            return [
                'success' => false,
                'error' => 'La información de los remitentes es obligatoria'
            ];
        }


        DB::beginTransaction();
        $correo->save();
        $text_remitentes = '';
        foreach ($remitentes as $remitente) {
                if($remitente->exists)
                    $correo->usuarios()->save($remitente);
                else
                    $text_remitentes .= $remitente->email.';';
        }
        if($text_remitentes != ''){
            $correo->correos_destinatarios = trim($text_remitentes,';');
            $correo->save();
        }
        DB::commit();
        return ['success'=>true];
    }


    /**
     * Registro de correos de creación de cuenta de una veterinaria
     *
     * @param Veterinaria $veterinaria
     * @param bool $create_password => true -> Indica si se debe generar link para ingreso de contraseña
     *                                  false -> Indica que el usuario ya tiene contraseña y debe ingresar con los datos existentes
     * @return array
     */
    public static function nuevaCuentaVeterinaria(Veterinaria $veterinaria,$create_password = false,$clave = null){

        $usuario = $veterinaria->administrador;

        if(!$usuario){
            return [
                'success' => false,
                'error' => 'No se ha encontrado información relacionada con el administrador de la veterinaria.'
            ];
        }
        $tipo = 'prioritario';
        //$tipo = 'programado';
        $asunto = 'Nueva cuenta DogCat';
        $titulo = 'Bienvenid@ a DogCat';


        $mensaje = view('emails.contenidos.nueva_cuenta_veterinaria')
            ->with('veterinaria',$veterinaria)
            ->with('create_password',$create_password)
            ->with('clave',$clave)
            ->render();

        return self::crear($tipo,date('Y-m-d'),$asunto,$titulo,$mensaje,false,null,null,new Collection([$usuario]));
    }


    /**
     * Registro de correos de creación de cuenta de un usuario
     *
     * @param User $usuario
     * @param bool $create_password => true -> Indica si se debe generar link para ingreso de contraseña
     *                                  false -> Indica que el usuario ya tiene contraseña y debe ingresar con los datos existentes
     * @return array
     */
    public static function nuevaCuentaUsuario(User $usuario,$create_password = false,$clave = null){

        $tipo = 'prioritario';
        //$tipo = 'programado';
        $asunto = 'Nueva cuenta DogCat';
        $titulo = 'Bienvenid@ a DogCat';


        $mensaje = view('emails.contenidos.nueva_cuenta_usuario')
            ->with('usuario',$usuario)
            ->with('create_password',$create_password)
            ->with('clave',$clave)
            ->render();

        return self::crear($tipo,date('Y-m-d'),$asunto,$titulo,$mensaje,false,null,null,new Collection([$usuario]));
    }


    /**
     * Registro de correos de creación de cuenta de un usuario por medio de un registro
     *
     * @param User  $user
     * @return array
     */
    public static function nuevaCuentaUsuarioRegistro(User $usuario){

        $tipo = 'prioritario';
        //$tipo = 'programado';
        $asunto = 'Nueva cuenta DogCat';
        $titulo = 'Bienvenid@ a DogCat';


        $mensaje = view('emails.contenidos.registro.nuevo_usuario')
            ->with('usuario',$usuario)
            ->with('rol',$usuario->rol)
            ->render();

        return self::crear($tipo,date('Y-m-d'),$asunto,$titulo,$mensaje,false,null,null,new Collection([$usuario]));
    }


    /**
     * Registro de correos de creación de cuenta de un usuario por medio de un registro
     *
     * @param User  $user
     * @return array
     */
    public static function nuevaCuentaVeterinariaRegistro(Veterinaria $veterinaria,$rol){

        $tipo = 'prioritario';
        //$tipo = 'programado';
        $asunto = 'Nueva cuenta DogCat';
        $titulo = 'Bienvenid@ a DogCat';


        $mensaje = view('emails.contenidos.registro.nueva_veterinaria')
            ->with('veterinaria',$veterinaria)
            ->with('rol',$rol)
            ->render();

        $usuario = new User();
        $usuario->email = $veterinaria->correo;
        return self::crear($tipo,date('Y-m-d'),$asunto,$titulo,$mensaje,false,null,null,new Collection([$usuario]));
    }


    /**
     * Registro de correos de registro de pago exitoso en el sistema
     *
     * @param Afiliacion $afiliacion
     * @return array
     */
    public static function pagoDeAfiliacionExitoso(Afiliacion $afiliacion,Ingreso $ingreso){

        $tipo = 'prioritario';
        //$tipo = 'programado';
        $asunto = 'Pago de afiliación DogCat';
        $titulo = '';


        $mensaje = view('emails.contenidos.afiliaciones.comprobacion_pago')
            ->with('afiliacion',$afiliacion)
            ->with('ingreso',$ingreso)
            ->render();

        $usuario = $afiliacion->userAfiliado;
        return self::crear($tipo,date('Y-m-d'),$asunto,$titulo,$mensaje,false,null,null,new Collection([$usuario]));
    }


    /**
     * Registro de correos de recordatorios del sistema
     *
     * @param Afiliacion $afiliacion
     * @return array
     */
    public static function recordatorio(Recordatorio $recordatorio,User $user){

        $tipo = 'prioritario';
        //$tipo = 'programado';
        $asunto = 'Recordatorio';
        $titulo = 'Recordatorio';


        $mensaje = view('emails.contenidos.recordatorio')
            ->with('recordatorio',$recordatorio)
            ->with('usuario',$user)
            ->render();

        return self::crear($tipo,date('Y-m-d'),$asunto,$titulo,$mensaje,$recordatorio->url?true:false,'ABRIR',$recordatorio->url,new Collection([$user]));
    }

}