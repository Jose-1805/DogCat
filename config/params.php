<?php
    return [
        //NO CAMBIAR
        'funciones'=>[
            'crear'=>1,
            'editar'=>2,
            'ver'=>3,
            'eliminar'=>4,
            'uploads'=>5,
            'like'=>6,
            'comentar'=>7,
            'historial'=>8,
            'pagos'=>9,
            'validar'=>10,
            'asignar'=>11,
            'cancelar'=>12,
            'validar informacion'=>13,
            'ver_revision'=>14,
            'crear_revision'=>15,
            'editar_revision'=>16
        ],

        //URL DE DIRECTORIOS DE STORAGE
        'storage_img_perfil_usuario'=>'usuarios/imagenes/perfil/',
        'storage_img_veterinarias'=>'public/veterinarias/logos/',
        'storage_img_entidades'=>'public/entidades/logos/',
        'storage_img_perfil_mascota'=>'mascotas/imagenes/perfil/',
        'storage_img_publicaciones'=>'restringido/publicaciones/imagenes/',
        'storage_evidencias_revisiones_periodicas'=>'restringido/revisiones_periodicas/',
        'storage_evidencias_egresos'=>'restringido/egreso/',
        'storage_evidencias_ingresos'=>'restringido/ingreso/',
        'storage_vacunas'=>'restringido/mascotas/vacunas/',
        'horas_cancelacion_cita'=>12,
        //tiempo en años para pagar la funeraria por mascota
        'tiempo_pago_funeraria'=>7,
        //Edad minima para registrarse en sistema
        'edad_minima'=>18,
        'google_maps_api_key'=>'AIzaSyCnggMK1arhG7h7PZoHnY0Sw9gijLIRbAc',
        'comision_asesor_funeraria'=>5000,
        //identifica la cantidad máxima de minutos que debe haber entre
        //las ubicaciones de los paseos
        'maximo_minutos_distancia_paseador'=>10,
        'maximo_peso_archivos'=>1024,
        'default_revision_periodica'=>'No se encontraron anomalías en la mascota.',
        'items_revisiones'=>[
            'vista',
            'tegumento',
            'articulaciones',
            'sistema digestivo',
            'miembros posteriores',
            'miembros anteriores',
            'otras caracteristicas'
        ],
        'maxima_edad_prevision'=>9,
        'minima_edad_prevision'=>3,//esto es en meses
        //cantidad máxima de meses para pagar una afilaicion
        'meses_credito'=>11,
        //dias de anterioridad para recordar al cliente el pago de la cuota de su credito de afiliación
        'dias_recordatorio_pago_cuota_credito'=>3,
        //cantidad de dias para recordar al cliente y a los administradores
        //la mora en el pago de la cuota de un credito de afiliación
        'dias_recordatorio_mora_cuota_credito'=>8,
        //valor minimo que se debe pagar por una cuota
        'valor_minimo_cuota_credito'=>65000
    ];
?>