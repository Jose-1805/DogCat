<div class="col-12">
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="md-form c-select">
                {!! Form::label('pais-veterinaria','Pais',['class'=>'active']) !!}
                {!! Form::select('pais-veterinaria',[''=>'Seleccione un país']+\DogCat\Models\Pais::pluck('nombre','id')->toArray(),null,['id'=>'select-pais-veterinaria','class'=>'form-control']) !!}
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="md-form c-select" id="contenedor-select-departamentos-veterinaria">
                {!! Form::label('departamento-veterinaria','Departamento',['class'=>'active']) !!}
                {!! Form::select('departamento-veterinaria',[''=>'Seleccione un departamento'],null,['id'=>'select-departamento-veterinaria','class'=>'form-control']) !!}
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="md-form c-select" id="contenedor-select-ciudades-veterinaria">
                {!! Form::label('ciudad-veterinaria','Ciudad (*)',['class'=>'active']) !!}
                {!! Form::select('ciudad_veterinaria',[''=>'Seleccione uns ciudad'],null,['id'=>'ciudad-veterinaria','class'=>'form-control']) !!}
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="md-form">
                {!! Form::label('barrio-veterinaria','Barrio (*)') !!}
                {!! Form::text('barrio_veterinaria',null,['id'=>'barrio-veterinaria','class'=>'form-control','maxlength'=>255]) !!}
                <p class="count-length">255</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="md-form">
                {!! Form::label('calle-veterinaria','Calle') !!}
                {!! Form::text('calle_veterinaria',null,['id'=>'calle-veterinaria','class'=>'form-control','maxlength'=>20]) !!}
                <p class="count-length">20</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="md-form">
                {!! Form::label('carrera-veterinaria','Carrera') !!}
                {!! Form::text('carrera_veterinaria',null,['id'=>'carrera-veterinaria','class'=>'form-control','maxlength'=>20]) !!}
                <p class="count-length">20</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="md-form">
                {!! Form::label('transversal-veterinaria','Transversal') !!}
                {!! Form::text('transversal_veterinaria',null,['id'=>'transversal-veterinaria','class'=>'form-control','maxlength'=>20]) !!}
                <p class="count-length">20</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="md-form">
                {!! Form::label('numero-veterinaria','Número (*)') !!}
                {!! Form::text('numero_veterinaria',null,['id'=>'numero-veterinaria','class'=>'form-control']) !!}
            </div>
        </div>

        <div class="col-12">
            <div class="md-form">
                {!! Form::label('especificaciones-veterinaria','Especificaciones') !!}
                {!! Form::textarea('especificaciones_veterinaria',null,['id'=>'especificaciones-veterinaria','class'=>'form-control md-textarea','maxlength'=>255]) !!}
                <p class="count-length">255</p>
            </div>
        </div>
    </div>
</div>