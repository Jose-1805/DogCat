<?php

namespace DogCat\Http\Controllers;

use DogCat\Http\Requests\RequestAfiliacion;
use DogCat\Models\Afiliacion;
use DogCat\Models\Correo;
use DogCat\Models\CuotaCredito;
use DogCat\Models\HistorialPrecioAfiliacion;
use DogCat\Models\HistorialPrecioFuneraria;
use DogCat\Models\Ingreso;
use DogCat\Models\Mascota;
use DogCat\Models\MascotaRenovacion;
use DogCat\Models\Notificacion;
use DogCat\Models\Raza;
use DogCat\Models\Renovacion;
use DogCat\Models\SolicitudAfiliacion;
use DogCat\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;

class SimuladorAfiliacionController extends Controller
{
    public $privilegio_superadministrador = true;
    public $identificador_modulo = 19;
    static $identificador_modulo_static = 19;

    public function __construct()
    {
        $this->middleware('permisoModulo:'.$this->identificador_modulo.',' . $this->privilegio_superadministrador);
    }

    public function index(){
        return view('simulador_afiliacion.index')
            ->with('razas_perros',Raza::json_autocomplete('Perro'))
            ->with('razas_gatos',Raza::json_autocomplete('Gato'));
    }


    /**
     * Calcula el valor de una afiliaciòn segùn los parametros enviados
     * @return valor de la afiliaciòn
     */
    public function getValor(Request $request){
        return Afiliacion::getValorAfiliacionSimulador($request);
    }

    public function detalleAfiliacion(Request $request){
        $detalle = Afiliacion::getDetalleAfiliacionSimulador($request);
        return view('simulador_afiliacion.detalle')
            ->with('detalle',$detalle);
    }
}