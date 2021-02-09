<div class="col-12">
    <input type="checkbox" name="check_patologías" id="check_patologías" class="cursor_pointer consulta-datos-afiliacion"> <label for="check_patologías" class="cursor_pointer">Seleccione esta opción si la mascota presenta patologías que puedan asumir un alto riesgo para la salud del animal.</label>
</div>
<div class="col-12 margin-top-20">
    {!! Form::label('patologias','Patologías') !!}
    {!! Form::textarea('patologias',null,['id'=>'patologias','class'=>'form-control','rows'=>'3','placeholder'=>'Ingrese la descrición de todas las patologías conocidas o halladas en la mascota','maxlength'=>1000]) !!}
    <p class="count-length">1000</p>
</div>