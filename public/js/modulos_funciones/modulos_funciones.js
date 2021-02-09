var modulo_seleccionado = null;
var funcion_seleccionada = null;
$(function () {
    cargarModulos();
    cargarFunciones();

    $('body').on('click','.btn-funciones-modulo',function () {
        modulo_seleccionado = $(this).data('modulo');
        cargarFunciones();
    })

    $('body').on('click','.btn-editar-modulo',function () {
        modulo_seleccionado = $(this).data('modulo');
        cargarFormEditar();
    })

    $('body').on('click','.btn-editar-funciones-modulo',function () {
        funcion_seleccionada = $(this).data('funcion');
        cargarFormEditarFuncion();
    })

    $('body').on('click','.cerrar-funciones',function () {
        modulo_seleccionado = null;
        cargarFunciones();
    })

    $('body').on('change','.check-funcion',function () {
        actualizarModuloFuncion($(this));

    })

    $("#btn-nuevo-modulo").click(function () {
        nuevoModulo();
    })

    $("#btn-nueva-funcion").click(function () {
        nuevaFuncion();
    })

    $("#btn-guardar-editar-modulo").click(function () {
        editarModulo();
    })

    $("#btn-guardar-editar-funcion").click(function () {
        editarFuncion();
    })
})

/**
 * Actualiza la relacion entre el módulo (seleccionado en variable modulo_seleccionado)
 * y la funcion perteneciente al checkbox seleccionado.
 *
 * La información se actualiza deacuerdo al estado del checkbox seleccionado
 *
 * @param checkbox_element
 */
function actualizarModuloFuncion(checkbox_element) {
    //accion a realizar con la funcion en el módulo
    var accion = "eliminar";
    //se esta checkeando una opción
    if($(checkbox_element).prop("checked")){
        accion = "agregar";
    }

    var elemento_contenedor = $("#contenedor-funciones");
    abrirBlockUiElemento(elemento_contenedor);

    var params = {_token:$('#general_token').val(),modulo:modulo_seleccionado,funcion:$(checkbox_element).data('funcion'),accion:accion};
    var url = $('#general_url').val()+'/modulos-funciones/actualizar-relacion';
    
    $.post(url,params,function (data) {
        cerrarBlockUiElemento(elemento_contenedor);
    })
}

function cargarModulos() {
    var elemento = $("#contenedor-modulos");
    abrirBlockUiElemento(elemento);
    var url = $('#general_url').val()+'/modulos-funciones/vista-modulos';
    var params = {_token:$('#general_token').val()};

    $.post(url,params,function (data) {
        $(elemento).html(data);
        cerrarBlockUiElemento(elemento);
    })
}

function cargarFunciones() {
    var elemento = $("#contenedor-funciones");
    abrirBlockUiElemento(elemento);
    var url = $('#general_url').val()+'/modulos-funciones/vista-funciones';
    var params = {_token:$('#general_token').val(),modulo:modulo_seleccionado};

    $.post(url,params,function (data) {
        $(elemento).html(data);
        cerrarBlockUiElemento(elemento);
    })
}

function nuevoModulo() {
    var params = $("#form-modulo").serialize();
    var url = $("#general_url").val()+"/modulos-funciones/nuevo-modulo";

    abrirBlockUiCargando('Guardando ');
    
    $.post(url,params)
    .done(function (data) {
        $("#form-modulo")[0].reset();
        cargarModulos();
        cerrarBlockUiCargando();
        $("#modal-nuevo-modulo").modal('hide');
    })
    .fail(function (jqXHR,state,error) {
        abrirAlerta("alertas-nuevo-modulo","danger",JSON.parse(jqXHR.responseText),null,"modal-nuevo-modulo");
        cerrarBlockUiCargando();
    })
}

function nuevaFuncion() {
    var params = $("#form-funcion").serialize();
    var url = $("#general_url").val()+"/modulos-funciones/nueva-funcion";

    abrirBlockUiCargando('Guardando ');

    $.post(url,params)
    .done(function (data) {
        $("#form-funcion")[0].reset();
        cargarFunciones();
        cerrarBlockUiCargando();
        $("#modal-nueva-funcion").modal('hide');
    })
    .fail(function (jqXHR,state,error) {
        abrirAlerta("alertas-nueva-funcion","danger",JSON.parse(jqXHR.responseText),null,"modal-nueva-funcion");
        cerrarBlockUiCargando();
    })
}

function cargarFormEditar(){
    var params = {'_token':$('#general_token').val(),'modulo':modulo_seleccionado};
    var url = $("#general_url").val()+"/modulos-funciones/form-modulo";

    abrirBlockUiCargando('Cargando ');

    $.post(url,params)
        .done(function (data) {
            $("#contenedor-form-editar-modulo").html(data);
            $("#modal-editar-modulo").modal('show');
            cerrarBlockUiCargando();
        })
        .fail(function (jqXHR,state,error) {
            //abrirAlerta("alertas-nuevo-rol","danger",JSON.parse(jqXHR.responseText),null,"modal-nuevo-rol");
            alert('Ocurrio un error inesperado !!');
            cerrarBlockUiCargando();
        })
}

function editarModulo() {
    var params = $("#form-editar-modulo").serialize();
    var url = $("#general_url").val()+"/modulos-funciones/editar-modulo";

    abrirBlockUiCargando('Guardando ');

    $.post(url,params)
        .done(function (data) {
            if(data.success) {
                $("#contenedor-form-editar-modulo").html('');
                $("#modal-editar-modulo").modal('hide');
                cargarModulos();
                cargarFunciones();
                cerrarBlockUiCargando();
            }else{
                window.location.reload();
            }
        })
        .fail(function (jqXHR,state,error) {
            abrirAlerta("alertas-editar-modulo","danger",JSON.parse(jqXHR.responseText),null,"modal-editar-modulo");
            cerrarBlockUiCargando();
        })
}

function cargarFormEditarFuncion(){
    var params = {'_token':$('#general_token').val(),'funcion':funcion_seleccionada};
    var url = $("#general_url").val()+"/modulos-funciones/form-funcion";

    abrirBlockUiCargando('Cargando ');

    $.post(url,params)
        .done(function (data) {
            $("#contenedor-form-editar-funcion").html(data);
            $("#modal-editar-funcion").modal('show');
            cerrarBlockUiCargando();
        })
        .fail(function (jqXHR,state,error) {
            //abrirAlerta("alertas-nuevo-rol","danger",JSON.parse(jqXHR.responseText),null,"modal-nuevo-rol");
            alert('Ocurrio un error inesperado !!');
            cerrarBlockUiCargando();
        })
}

function editarFuncion() {
    var params = $("#form-editar-funcion").serialize();
    var url = $("#general_url").val()+"/modulos-funciones/editar-funcion";

    abrirBlockUiCargando('Guardando ');

    $.post(url,params)
        .done(function (data) {
            if(data.success) {
                $("#contenedor-form-editar-funcion").html('');
                $("#modal-editar-funcion").modal('hide');
                cargarModulos();
                cargarFunciones();
                cerrarBlockUiCargando();
            }else{
                window.location.reload();
            }
        })
        .fail(function (jqXHR,state,error) {
            abrirAlerta("alertas-editar-funcion","danger",JSON.parse(jqXHR.responseText),null,"modal-editar-modulo");
            cerrarBlockUiCargando();
        })
}