var key_codes = [
    8, //Borrar
    46, //suprimir
    35, //fin
    36, //inicio
    37,//izquierda
    39,//derecha
    13];//enter
$(function () {
    $('body').on('keydown','.alphanumeric',function (e) {
        if(parseInt(key_codes.indexOf(e.keyCode))>=0) {
            return true;
        }

        var regex = new RegExp(/[A-Za-z0-9]/);
        //var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        var str = e.originalEvent.key;
        if (regex.test(str)) {
            return true;
        }

        e.preventDefault();
        return false;

    });
    $('body').on('keydown','.alphanumeric_space',function (e) {
        if(parseInt(key_codes.indexOf(e.keyCode))>=0) {
            return true;
        }

        var regex = new RegExp(/[A-Za-z0-9 ]/);
        //var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        var str = e.originalEvent.key;
        if (regex.test(str)) {
            return true;
        }

        e.preventDefault();
        return false;

    });
    $('body').on('keydown','.alphabetical',function (e) {
        if(parseInt(key_codes.indexOf(e.keyCode))>=0) {
            return true;
        }

        var regex = new RegExp(/[A-Za-z]/);
        //var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        var str = e.originalEvent.key;
        if (regex.test(str)) {
            return true;
        }

        e.preventDefault();
        return false;

    });
    $('body').on('keydown','.alphabetical_space',function (e) {
        if(parseInt(key_codes.indexOf(e.keyCode))>=0) {
            return true;
        }

        var regex = new RegExp(/[A-Za-z ]/);
        //var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        var str = e.originalEvent.key;
        if (regex.test(str)) {
            return true;
        }

        e.preventDefault();
        return false;

    });

    $('body').on('keydown','.numeric',function (e) {
        if(parseInt(key_codes.indexOf(e.keyCode))>=0) {
            return true;
        }

        var regex = new RegExp(/[0-9]/);
        //var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        var str = e.originalEvent.key;
        if (regex.test(str)) {
            return true;
        }

        e.preventDefault();
        return false;
    });
})