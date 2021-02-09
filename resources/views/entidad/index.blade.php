@extends('layouts.app')

@section('content')
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Entidades</h3>
            <div class="col-12 no-padding">
                @include('layouts.alertas',['id_contenedor'=>'alertas-veterinarias'])
            </div>
            <div class="col-12 no-padding">
                @if(Auth::user()->tieneFuncion($identificador_modulo, 'crear', $privilegio_superadministrador))
                    <a href="{{url('/entidad/crear')}}"  class="btn btn-primary right margin-right-none"><i class="fa fa-plus-circle margin-right-10"></i>Nueva entidad</a>
                @endif
            </div>

            <table id="tabla-veterinarias" class="table-hover DataTable">
                <thead>
                    <th width="300">Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Ubicación</th>
                    <th>Estado</th>
                    <th>Administrador</th>
                    @if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones($identificador_modulo,['editar','eliminar'],false,$privilegio_superadministrador))
                        <th class="text-center">Opciones</th>
                    @endif
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-desactivar-veterinaria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Desactivar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Desactivar una entidad bloqueará todas las funcionalidades relacionadas con la misma.</p>
                    <p>¿Está seguro de desactivar la entidad seleccionada?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger btn-submit" id="btn-desactivar">Si</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-activar-veterinaria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Activar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Activar una entidad activará todas las funcionalidades relacionadas con la misma</p>
                    <p>¿Está seguro de activar la entidad seleccionada?</p>
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
    <script src="{{asset('js/entidad/index.js')}}"></script>
    <script>
        var tiene_opciones = false;

        @if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones($identificador_modulo,['editar','eliminar'],false,$privilegio_superadministrador))
            tiene_opciones = true;
        @endif

        $(function () {


            if(tiene_opciones){
                var cols = [
                    {data: 'nombre', name: 'nombre'},
                    {data: 'correo', name: 'correo'},
                    {data: 'telefono', name: 'telefono'},
                    {data: 'direccion', name: 'direccion'},
                    {data: 'ubicacion', name: 'ubicacion'},
                    {data: 'estado', name: 'estado'},
                    {data: 'administrador', name: 'administrador'},
                    {data: 'opciones', name: 'opciones', orderable: false, searchable: false,"className": "text-center"}
                ];
            }else{
                var cols = [
                    {data: 'nombre', name: 'nombre'},
                    {data: 'correo', name: 'correo'},
                    {data: 'telefono', name: 'telefono'},
                    {data: 'direccion', name: 'direccion'},
                    {data: 'ubicacion', name: 'ubicacion'},
                    {data: 'estado', name: 'estado'},
                    {data: 'administrador', name: 'administrador'},
                ]
            }

            setCols(cols);
            cargarTablaVeterinarias();
        })
    </script>
@stop