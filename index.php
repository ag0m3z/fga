<?php

/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 06/01/2017
 * Time: 10:38 AM
 */
namespace applicacion ;
use core\sesiones;
use core\views;

class SistemIkro
{

    public static function init(){

        include "core/sesiones.class.php";
        include "core/views.class.php";

        $vista = new views();
        $sesiones = new sesiones();

        if($sesiones->validar_sesion()){

            $vista->call_view(
                array(
                    'applications',
                    'home',
                    'frmHome'
                )
            );

        }else{

            $vista->call_view(
                array(
                    'applications',
                    'login',
                    'frmloginIn'
                )
            );
        }
    }
}

SistemIkro::init();