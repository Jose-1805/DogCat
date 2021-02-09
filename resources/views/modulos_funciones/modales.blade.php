<div class="modal fade" id="modal-nuevo-modulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            {!! Form::open(['id'=>'form-modulo']) !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Nuevo módulo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    @include('layouts.alertas',['id_contenedor'=>'alertas-nuevo-modulo'])
                    @include('modulos_funciones.form_modulo')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success btn-submit" id="btn-nuevo-modulo">Guardar</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal fade" id="modal-editar-modulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            {!! Form::open(['id'=>'form-editar-modulo']) !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Editar módulo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    @include('layouts.alertas',['id_contenedor'=>'alertas-editar-modulo'])
                    <div id="contenedor-form-editar-modulo"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success btn-submit" id="btn-guardar-editar-modulo">Guardar</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal fade" id="modal-nueva-funcion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['id'=>'form-funcion']) !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Nueva función</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    @include('layouts.alertas',['id_contenedor'=>'alertas-nueva-funcion'])
                    @include('modulos_funciones.form_funcion')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">cerrar</button>
                    <button type="button" class="btn btn-success btn-submit" id="btn-nueva-funcion">Guardar</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal fade" id="modal-editar-funcion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['id'=>'form-editar-funcion']) !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Editar función</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    @include('layouts.alertas',['id_contenedor'=>'alertas-editar-funcion'])
                    <div id="contenedor-form-editar-funcion"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">cerrar</button>
                    <button type="button" class="btn btn-success btn-submit" id="btn-guardar-editar-funcion">Guardar</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>