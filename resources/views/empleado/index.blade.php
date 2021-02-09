@extends('layouts.app')

@section('content')
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Empleados</h3>

            <div class="col-12 no-padding">
                @include('layouts.alertas',['id_contenedor'=>'alertas-usuario'])
            </div>

            <div class="col-12 no-padding">
                @if(Auth::user()->tieneFuncion($identificador_modulo, 'crear', $privilegio_superadministrador))
                    <a href="{{url('/empleado/crear')}}"  class="btn btn-primary right margin-right-none"><i class="fa fa-plus-circle margin-right-10"></i>Nuevo empleado</a>
                @endif
            </div>

            <div class="col-12 no-padding">
                <table id="tabla-usuarios" class="table-hover">
                    <thead>
                    <th>Identificación</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Fecha nacimiento</th>
                    <th>Genero</th>
                    <th>Rol</th>
                    @if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones($identificador_modulo,['editar'],false,$privilegio_superadministrador))
                        <th class="text-center">Opciones</th>
                    @endif
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-desactivar-usuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Desactivar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Desactivar un empelado bloqueará todas las funcionalidades habilitadas para él.</p>
                    <p>¿Está seguro de desactivar el empleado seleccionado?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger btn-submit" id="btn-desactivar">Si</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-activar-usuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Activar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Activar un empleado activará todas las funcionalidades relacionadas a él</p>
                    <p>¿Está seguro de activar el empleado seleccionado?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary btn-submit" id="btn-activar">Si</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('js/empleado/index.js')}}"></script>
    <script>
        var tiene_opciones = false;

        @if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones($identificador_modulo,['editar'],false,$privilegio_superadministrador))
            tiene_opciones = true;
        @endif

        $(function () {

            if(tiene_opciones){
                var cols = [
                    {data: 'identificacion', name: 'identificacion'},
                    {data: 'nombre', name: 'nombre'},
                    {data: 'email', name: 'email'},
                    {data: 'telefono', name: 'telefono'},
                    {data: 'fecha_nacimiento', name: 'fecha_nacimiento'},
                    {data: 'genero', name: 'genero'},
                    {data: 'rol', name: 'rol'},
                    {data: 'opciones', name: 'opciones', orderable: false, searchable: false,"className": "text-center"}
                ];
            }else{
                var cols = [
                    {data: 'identificacion', name: 'identificacion'},
                    {data: 'nombre', name: 'nombre'},
                    {data: 'email', name: 'email'},
                    {data: 'telefono', name: 'telefono'},
                    {data: 'fecha_nacimiento', name: 'fecha_nacimiento'},
                    {data: 'genero', name: 'genero'},
                    {data: 'rol', name: 'rol'}
                ]
            }
            setCols(cols);
            cargarTablaUsuarios();
        })
    </script>
@stop


