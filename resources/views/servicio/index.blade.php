@extends('layouts.app')

@section('content')
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Servicios</h3>

            <div class="col-12 no-padding">
                @include('layouts.alertas',['id_contenedor'=>'alertas-servicio'])
            </div>

            <div class="col-12 no-padding">
                @if(Auth::user()->tieneFuncion($identificador_modulo, 'crear', $privilegio_superadministrador))
                    <a href="{{url('/servicio/crear')}}"  class="btn btn-primary right margin-right-none"><i class="fa fa-plus-circle margin-right-10"></i>Nuevo servicio</a>
                @endif
                @if(Auth::user()->tieneFuncion($identificador_modulo, 'asignar', $privilegio_superadministrador))
                    <a href="{{url('/servicio/asignar')}}"  class="btn btn-primary right"><i class="fa fa-users margin-right-10"></i>Asignar servicios</a>
                @endif
            </div>

            <div class="col-12 no-padding">
                <table id="tabla-servicios" class="table-hover">
                    <thead>
                    <th>Nombre</th>
                    <th>Estado</th>
                    @if(Auth::user()->getTipoUsuario() == 'personal dogcat')
                        <th>Entidad</th>
                    @endif
                    @if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones($identificador_modulo,['editar'],false,$privilegio_superadministrador))
                        <th class="text-center">Opciones</th>
                    @endif
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-desactivar-servicio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Desactivar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Desactivar un servicio inhabilitará la asignación a usuarios y la solicitud de nuevas citas relacionadas con el servicio.</p>
                    <p>¿Está seguro de desactivar el servicio seleccionado?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger btn-submit" id="btn-desactivar">Si</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-activar-servicio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Activar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Activar un servicio habilitará la asignación a usuarios y la solicitud de nuevas citas relacionadas con el servicio.</p>
                    <p>¿Está seguro de activar el servicio seleccionado?</p>
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
    <script src="{{asset('js/servicio/index.js')}}"></script>
    <script>
        var tiene_opciones = false;

        @if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones($identificador_modulo,['editar'],false,$privilegio_superadministrador))
            tiene_opciones = true;
        @endif

        $(function () {

            @if(Auth::user()->getTipoUsuario() == 'personal dogcat')
            if(tiene_opciones){
                var cols = [
                    {data: 'nombre', name: 'nombre'},
                    {data: 'estado', name: 'estado'},
                    {data: 'entidad', name: 'entidad'},
                    {data: 'opciones', name: 'opciones', orderable: false, searchable: false,"className": "text-center"}
                ];
            }else{
                var cols = [
                    {data: 'nombre', name: 'nombre'},
                    {data: 'estado', name: 'estado'},
                    {data: 'entidad', name: 'entidad'},
                ]
            }
            @else
            if(tiene_opciones){
                var cols = [
                    {data: 'nombre', name: 'nombre'},
                    {data: 'estado', name: 'estado'},
                    {data: 'opciones', name: 'opciones', orderable: false, searchable: false,"className": "text-center"}
                ];
            }else{
                var cols = [
                    {data: 'nombre', name: 'nombre'},
                    {data: 'estado', name: 'estado'},
                ]
            }
            @endif
            setCols(cols);
            cargarTablaServicios();
        })
    </script>
@stop