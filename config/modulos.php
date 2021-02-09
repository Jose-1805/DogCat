<?php
    return [
        /**
         * El elemento funciones almacena la información de los nombres y las funciones que se pueden realizar en un módulo del sistema
         * no se deben cambiar los valores porque la información se compara directamente en el código fuente del sistema
         */
        "funciones"=>[
            [
                "identificador"=>"1",
                "nombre"=>"Crear",
            ],
            [
                "identificador"=>"2",
                "nombre"=>"Ver",
            ],
            [
                "identificador"=>"3",
                "nombre"=>"Editar",
            ],
            [
                "identificador"=>"4",
                "nombre"=>"Eliminar",
            ],
            [
                "identificador"=>"5",
                "nombre"=>"Uploads",
            ],
        ],

        /**
         * El elemento modulos almacena la información de todos los módulos que contiene el sistema
         * y la relación con las funciones que se pueden realizar en dicho modulo
         *
         * **********************************
         * ********** IMPORTANTE ************
         * **********************************
         *
         * NO CAMBIAR EL CAMPO NOMBRE YA QUE SE UTILIZA PARA COMPARACIONES DENTRO DEL CÓDIGO
         * EL CAMPO ETIQUETA SI SE PUEDE EDITAR YA QUE ES EL QUE SE UTILIZA PARA MOSTRAR EN LA VISTA A LOS USUARIOS
         * NO CAMBIAR EL CAMPO IDENTIFICADOR YA QUE SE UTILIZA PARA COMPARACIONES DENTRO DEL CÓDIGO (Debe ser unico)
         */

        "modulos"=>[
            [
                "nombre"=>"publicacion",
                "identificador"=>"1",
                "etiqueta"=>"Publicaciones",
                "base_url"=>Config('app.url')."/publicacion",
                "funciones"=>[1,2,3,4,5]
            ],
            [
                "nombre"=>"usuarios",
                "identificador"=>"2",
                "etiqueta"=>"Usuario",
                "base_url"=>Config('app.url')."/usuario",
                "funciones"=>[1,2,3,4,5]
            ],
            [
                "nombre"=>"roles",
                "identificador"=>"3",
                "etiqueta"=>"Roles",
                "base_url"=>Config('app.url')."/rol",
                "funciones"=>[1,2,3,4]
            ],
            [
                "nombre"=>"mascotas",
                "identificador"=>"4",
                "etiqueta"=>"Mascotas",
                "base_url"=>Config('app.url')."/mascota",
                "funciones"=>[1,2,3,4,5]
            ],
        ]

    ];