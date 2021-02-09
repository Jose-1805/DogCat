<?php

namespace DogCat\Http\Controllers;

use DogCat\Http\Requests\RequestRegistro;
use DogCat\Models\Registro;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisoModulo:5,true');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('api/index');
    }

    public function registro(RequestRegistro $request){
        $registro = new Registro();
        $registro->fill($request->all());
        $registro->save();
        return ["success"=>true];
    }
}
