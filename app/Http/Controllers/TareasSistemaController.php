<?php

namespace DogCat\Http\Controllers;

use DogCat\Http\Requests\RequestRegistro;
use DogCat\Http\Requests\RequestRegistroHistorial;
use DogCat\Models\Ciudad;
use DogCat\Models\Departamento;
use DogCat\Models\Registro;
use DogCat\Models\RegistroHistorial;
use DogCat\Models\Rol;
use DogCat\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\Datatables\Facades\Datatables;

class TareasSistemaController extends Controller
{
    public $privilegio_superadministrador = true;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }


    public function selectDepartamentos(Request $request){
        $departamentos = [''=>'Seleccione un departamento']+Departamento::pluck('nombre','id')->toArray();
        $name = 'departamento';
        if($request->has('pais')){
            $departamentos = [''=>'Seleccione un departamento']+Departamento::where('pais_id',$request->input('pais'))->pluck('nombre','id')->toArray();
        }

        if($request->has('name'))$name = $request->input('name');

        return view('layouts.componentes.select')
            ->with('elementos',$departamentos)
            ->with('name',$name)->render();
    }

    public function selectCiudades(Request $request){
        $ciudades = [''=>'Seleccione una ciudad']+Ciudad::pluck('nombre','id')->toArray();
        $name = 'ciudad';
        if($request->has('departamento')){
            $ciudades = [''=>'Seleccione una ciudad']+Ciudad::where('departamento_id',$request->input('departamento'))->pluck('nombre','id')->toArray();
        }

        if($request->has('name'))$name = $request->input('name');

        return view('layouts.componentes.select')
            ->with('elementos',$ciudades)
            ->with('name',$name)->render();
    }

    public function selectAfiliados(Request $request){
        $usuarios = [''=>'Seleccione un usuario']+User::afiliados()->where('estado','activo')->select('users.id',\Illuminate\Support\Facades\DB::raw('CONCAT(nombres," ",apellidos," - ",tipo_identificacion," ",identificacion) as afiliado'))->pluck('afiliado','id')->toArray();
        $name = 'usuario';
        if($request->has('veterinaria')){
            $usuarios = [''=>'Seleccione un usuario']+User::afiliados()->where('estado','activo')->select('users.id',\Illuminate\Support\Facades\DB::raw('CONCAT(nombres," ",apellidos," - ",tipo_identificacion," ",identificacion) as afiliado'))->where('veterinaria_afiliado_id',$request->input('veterinaria'))->pluck('afiliado','id')->toArray();
        }

        if($request->has('name'))$name = $request->input('name');

        return view('layouts.componentes.select')
            ->with('elementos',$usuarios)
            ->with('name',$name)->render();
    }

    public function selectAfiliadosSinAfiliacion(Request $request){
        $usuarios = [''=>'Seleccione un usuario']+User::afiliadosSinAfiliacion()->where('estado','activo')->select('users.id',\Illuminate\Support\Facades\DB::raw('CONCAT(nombres," ",apellidos," - ",tipo_identificacion," ",identificacion) as afiliado'))->pluck('afiliado','id')->toArray();
        $name = 'usuario';
        if($request->has('veterinaria')){
            $usuarios = [''=>'Seleccione un usuario']+User::afiliadosSinAfiliacion()->where('estado','activo')->select('users.id',\Illuminate\Support\Facades\DB::raw('CONCAT(nombres," ",apellidos," - ",tipo_identificacion," ",identificacion) as afiliado'))->where('veterinaria_afiliado_id',$request->input('veterinaria'))->pluck('afiliado','id')->toArray();
        }

        if($request->has('name'))$name = $request->input('name');

        return view('layouts.componentes.select')
            ->with('elementos',$usuarios)
            ->with('name',$name)->render();
    }
}