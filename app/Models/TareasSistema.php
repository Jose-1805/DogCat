<?php
/**
 * Created by PhpStorm.
 * User: jose1805
 * Date: 12/05/18
 * Time: 04:50 PM
 */

namespace DogCat\Models;


class TareasSistema
{

    public static function addCero($data){
        if(strlen($data) == 1){
            return '0'.$data;
        }
        return $data;
    }

    public static function ordenarArrayAgenda($datos){
        $retorno = [];
        $indice = 0;
        foreach ($datos as $d){
            if(count($retorno) == 0){
                $retorno[$indice] = $d;
                //echo '*Agregado '.$indice;
            }else{
                if(!array_key_exists(($indice-1),$retorno)) {
                    var_dump($d);
                    dd($d);
                }
                $dato_anterior = $retorno[$indice-1];
                $hora_item_anterior = intval($dato_anterior['hora_inicio']);
                $minuto_item_anterior = intval($dato_anterior['minuto_inicio']);
                $hora_item_actual = intval($d['hora_inicio']);
                $minuto_item_actual = intval($d['minuto_inicio']);

                $agregado = true;
                if($hora_item_actual > $hora_item_anterior){
                    $retorno[$indice] = $d;
                    //echo '*_1_Agregado '.$indice;
                }else if($hora_item_actual == $hora_item_anterior){
                    if($minuto_item_anterior < $minuto_item_actual) {
                        $retorno[$indice] = $d;
                        //echo '*_2_Agregado ' . $indice;
                    }else {
                        $agregado = false;
                    }
                }else{
                    $agregado = false;
                }

                if(!$agregado){
                    $parar = false;
                    $indice_aux = $indice;
                    $retorno[$indice] = $d;
                    //echo '*_3_Agregado '.$indice;
                    while (!$parar){
                        $anterior = $retorno[$indice_aux-1];
                        $actual = $retorno[$indice_aux];
                        $retorno[$indice_aux-1] = $actual;
                        $retorno[$indice_aux] = $anterior;
                        if($indice_aux-2 >= 0) {
                            $nuevo_anterior = $retorno[$indice_aux - 2];
                            if(intval($nuevo_anterior['hora_inicio'])<$hora_item_actual){
                                $parar = true;
                            }elseif(intval($nuevo_anterior['hora_inicio'])==$hora_item_actual) {
                                if(intval($nuevo_anterior['minuto_inicio'])<$minuto_item_actual){
                                    $parar = true;
                                }else{
                                    $indice_aux--;
                                }
                            }else{
                                $indice_aux--;
                            }
                        }else{
                            if($indice_aux == 1){
                                $anterior = $retorno[0];
                                $actual = $retorno[1];
                                if(intval($anterior['hora_inicio'])==intval($actual['hora_inicio'])) {
                                    if(intval($anterior['minuto_inicio'])>intval($actual['minuto_inicio'])) {
                                        $retorno[0] = $actual;
                                        $retorno[1] = $anterior;
                                    }
                                }
                            }
                            $parar = true;
                        }
                    }
                }
            }
            $indice++;
        }
        return $retorno;
    }
}