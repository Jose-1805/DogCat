<?php

namespace DogCat\Http\Controllers;

use DogCat\Http\Requests\RequestRegistro;
use DogCat\Http\Requests\RequestRegistroHistorial;
use DogCat\Models\Comentario;
use DogCat\Models\Imagen;
use DogCat\Models\LikePublicacion;
use DogCat\Models\Notificacion;
use DogCat\Models\Publicacion;
use DogCat\Models\Registro;
use DogCat\Models\RegistroHistorial;
use DogCat\Models\Rol;
use DogCat\User;
use Google\Auth\Credentials\ServiceAccountCredentials;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Facades\Datatables;

class PublicacionController extends Controller
{
    public $privilegio_superadministrador = true;
    public $identificador_modulo = 1;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('permisoModulo:'.$this->identificador_modulo.',' . $this->privilegio_superadministrador);
    }

    /**s
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$notificacion = Notificacion::first();
        $notificacion->enviarFirebaseUsers();
        dd('ok');*/
        /*$file_name = storage_path('app/restringido/').'dogcat-1526672577530-firebase-adminsdk-pumwk-ccf50812ef.json';
        $data = file_get_contents($file_name);
        $data = json_decode($data, true);

        $client = new ServiceAccountCredentials([
            'https://www.googleapis.com/auth/firebase.messaging',
        ],$file_name);
        dd($client->fetchAuthToken()['access_token']);


        $client->setAuthConfig($file_name);
        $client->setAccessType("offline");        // offline access
        $client->setIncludeGrantedScopes(true);   // incremental auth
        $client->addScope(\Google_Service_Oauth2::PLUS_ME);
        $client->addScope(\Google_Service_Oauth2::PLUS_LOGIN);
        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php');
dd($client);*/
        /*$cliente = new Client();
        $origen = '2.452093,-76.62840039999998';
        $destino = '2.450463709163391,-76.627863958197';
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=$origen&destinations=$destino&mode=walking&key=".config('params.google_maps_api_key');
        $res = $cliente->request('GET', $url);
        echo $res->getStatusCode();
        // "200"
        //dd($res->getHeader('content-type'));
        // 'application/json; charset=utf8'
        $body = $res->getBody();
        $data = \GuzzleHttp\json_decode($body->read($body->getSize()));
        dd($data->rows[0]->elements[0]->duration->value);
        // {"type":"User"...'
        dd('ok');*/
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'ver', $this->privilegio_superadministrador))
            return redirect('/');
        $cant_publicaciones = Publicacion::permitidos()->select('publicaciones.*')->orderBy('publicaciones.created_at','DESC')->get()->count();
        return view('publicacion/index')
            ->with('cant_publicaciones',$cant_publicaciones)
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function nueva(Request $request)
    {
        if(Auth::user()->tieneFuncion($this->identificador_modulo,'crear',$this->privilegio_superadministrador)) {
            if (!$request->has('publicacion') && !$request->hasFile('imagen_principal'))
                return response(['error' => ['Para guardar una publicación ingrese la imagen principal o el texto de la publicación']], 422);

            DB::beginTransaction();
            $publicacion = new Publicacion();
            if($request->has('publicacion'))
                $publicacion->publicacion = $request->input('publicacion');
            $publicacion->user_id = Auth::user()->id;
            $publicacion->save();

            if(Auth::user()->tieneFuncion($this->identificador_modulo,'uploads',$this->privilegio_superadministrador)) {
                if ($request->hasFile('imagen_principal')) {
                    $imagen = $request->file('imagen_principal');
                    $nombre = $imagen->getClientOriginalName();
                    $nombre = str_replace('-', '_', $nombre);
                    $ruta = config('params.storage_img_publicaciones'). $publicacion->id . '/principal';
                    $imagen->move(storage_path('app/'.$ruta), $nombre);

                    $imagen_obj = new Imagen();
                    $imagen_obj->nombre = $nombre;
                    $imagen_obj->ubicacion = $ruta;
                    $imagen_obj->save();
                    $publicacion->imagenes()->save($imagen_obj, ['principal' => 'si']);
                    if ($request->hasFile('imagen')) {
                        $imagenes = $request->file('imagen');
                        foreach ($imagenes as $imagen) {
                            $nombre = $imagen->getClientOriginalName();
                            $nombre = str_replace('-', '_', $nombre);
                            $ruta = config('params.storage_img_publicaciones') . $publicacion->id;
                            $i = 0;
                            while (true) {
                                if (file_exists(storage_path() . '/app/' . $ruta . '/' . $nombre)) {
                                    $i++;
                                    $nombre_aux = str_replace('.' . $imagen->getClientOriginalExtension(), '', $imagen->getClientOriginalName());
                                    $nombre = $nombre_aux . '(' . $i . ').' . $imagen->getClientOriginalExtension();
                                } else {
                                    break;
                                }
                            }
                            $imagen->move(storage_path('app/'.$ruta), $nombre);

                            $imagen_obj = new Imagen();
                            $imagen_obj->nombre = $nombre;
                            $imagen_obj->ubicacion = $ruta;
                            $imagen_obj->save();
                            $publicacion->imagenes()->save($imagen_obj);
                        }
                    }
                }
            }

            $vista = view('publicacion.publicacion.index')
                ->with('identificador_modulo',$this->identificador_modulo)
                ->with('privilegio_superadministrador',$this->privilegio_superadministrador)
                ->with('publicacion',$publicacion)->render();
            DB::commit();
            return ['success'=>true,'vista'=>$vista,'publicacion'=>$publicacion->id];
        }else{
            return response(['error'=>['Unauthorized.']],401);
        }
    }

    public function likePublicacion(Request $request){
        if($request->has('publicacion')){
            $publicacion = Publicacion::permitidos()->select('publicaciones.*')->find($request->input('publicacion'));
            if($publicacion){
                if(!$publicacion->userLike(Auth::user()->id)){
                    $like = new LikePublicacion();
                    $like->user_id = Auth::user()->id;
                    $like->publicacion_id = $publicacion->id;
                    $like->save();
                }
                return ['success'=>true];
            }
        }
        return response(['error'=>['La información enviada es incorrecta']],422);
    }

    public function comentarioPublicacion(Request $request){
        if($request->has('publicacion') && $request->has('comentario')){
            $publicacion = Publicacion::permitidos()->select('publicaciones.*')->find($request->input('publicacion'));
            if($publicacion){
                $comentario = new Comentario();
                $comentario->user_id = Auth::user()->id;
                $comentario->publicacion_id = $publicacion->id;
                $comentario->comentario = $request->input('comentario');
                $comentario->save();
                return ['success'=>true];
            }
        }
        return response(['error'=>['La información enviada es incorrecta']],422);
    }

    public function imagen($pubicacion,$imagen,$principal){
        $pubicacion_obj = Publicacion::permitidos()->select('publicaciones.*')->find($pubicacion);
        if($pubicacion_obj) {
            $path = storage_path('app/'.config('params.storage_img_publicaciones'). $pubicacion);
            if ($principal != 0)
                $path .= '/principal';

            $path .= '/' . $imagen;
            if (!File::exists($path)) abort(404);

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;
        }
    }


    /**
     * Retorna la vista de items de publicaciones anteriores a un maximo id si es enviado
     * o desde la ultima hacia atras en el caso de no enviar un id.
     *
     * Recibe un array de excepciones que son las publicaciones que no se deben cargar porque ya estan en la vista
     */
    public function anteriores_publicaciones(Request $request){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'ver', $this->privilegio_superadministrador)){
            if($request->ajax())return response(['error' => ['Unauthorized.']], 401);
            else return redirect('/');
        }
        // se utiliza para cargae publicaciones anteriores a la correspondiente con el id contenido en la variable
        $maximo_id = null;
        $limit = 10;
        $excepciones = [];

        if($request->has('limit'))$limit = $request->input('limit');

        if($request->has('excepciones')){
            $maximo_id = max($request->input('excepciones'));
            $excepciones = $request->input('excepciones');
        }

        $publicaciones = Publicacion::permitidos()->select('publicaciones.*')->orderBy('publicaciones.created_at','DESC');

        if($maximo_id != null){
            $publicaciones = $publicaciones->where('publicaciones.id','<',$maximo_id);
        }

        if($request->has('excepciones')){
            $publicaciones->whereNotIn('publicaciones.id',$request->input('excepciones'));
        }

        $publicaciones = $publicaciones->limit($limit)->get();

        $vista = view('publicacion.publicaciones')
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador)
            ->with('publicaciones',$publicaciones)->render();

        $nuevos_id = $publicaciones->map(function ($item, $key) {
            return $item->id;
        });

        $excepciones =  array_merge($excepciones,$nuevos_id->toArray());

        $continuar_scroll = true;
        if(count($publicaciones)==0){
            $continuar_scroll = false;
            $vista = "<div class='text-center margin-top-50 col-12 alert alert-info' role='alert'>No existen publicaciones más antiguas!!</div>";
        }

        return ['success'=>true,'vista'=>$vista,'excepciones'=>$excepciones,'continuar_scroll'=>$continuar_scroll];
    }

    public function data(Request $request){
        if($request->has('publicacion')){
            $publicacion = Publicacion::permitidos()->select('publicaciones.*')->find($request->input('publicacion'));
            if($publicacion){

                $last_comment = $request->input('last_comment');
                $comentarios_ = $publicacion->comentarios()->where('comentarios.id','>',$last_comment)->get();
                $cometarios = view('publicacion.publicacion.lista_comentarios')
                    ->with('comentarios',$comentarios_)
                    ->with('last_comment',$last_comment)
                    ->with('identificador_modulo',$this->identificador_modulo)
                    ->with('privilegio_superadministrador',$this->privilegio_superadministrador)
                    ->render();

                $likes = view('publicacion.publicacion.likes')
                    ->with('publicacion',$publicacion)
                    ->with('identificador_modulo',$this->identificador_modulo)
                    ->with('privilegio_superadministrador',$this->privilegio_superadministrador)
                    ->render();
                return ['comentarios'=>$cometarios,'likes'=>$likes,'cantidad_comentarios'=>$publicacion->comentarios()->count()];
            }
        }
        return response(['error'=>['La información enviada es incorrecta']],422);
    }


    /**********************************************************
     ********* FUNCIONES CREADAS PARA EL API ******************
     *********************************************************/

    /*public function all(){
        return Publicacion::permitidos()->select('publicaciones.*')->all();
    }*/
}