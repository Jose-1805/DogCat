<?php
    if(!isset($id_contenedor))$id_contenedor="alertas";
?>
<div class="" id="{{$id_contenedor}}">
    <div class="alert @if(!session()->has('msj_success')) d-none @endif col-12 alert-success alert-dismissible" role="alert">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <div class="mensaje">
            @if(session()->has('msj_success'))
                {!! session('msj_success') !!}
            @endif
        </div>
    </div>

    <div class="alert @if(!session()->has('msj_info')) d-none @endif col-12 alert-info alert-dismissible" role="alert">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <div class="mensaje">
            @if(session()->has('msj_info'))
                {!! session('msj_info') !!}
            @endif
        </div>
    </div>

    <div class="alert @if(!session()->has('msj_warning')) d-none @endif col-12 alert-warning alert-dismissible" role="alert">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <div class="mensaje">
            @if(session()->has('msj_warning'))
                {!! session('msj_warning') !!}
            @endif
        </div>
    </div>

    <div class="alert @if(!session()->has('msj_danger')) d-none @endif col-12 alert-danger alert-dismissible" role="alert">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <div class="mensaje">
            @if(session()->has('msj_danger'))
                {!! session('msj_danger') !!}
            @endif
        </div>
    </div>
</div>

@php
    session()->forget('msj_success');
    session()->forget('msj_info');
    session()->forget('msj_warning');
    session()->forget('msj_danger');
@endphp