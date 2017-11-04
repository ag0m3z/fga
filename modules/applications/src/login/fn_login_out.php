<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 06/01/2017
 * Time: 04:38 PM
 */

include '../../../../core/core.class.php';
include "../../../../core/sesiones.class.php";

$sesiones = new \core\sesiones();
$core = new \core\core();

$sesiones->delete_sesion();

if(!$sesiones->validar_sesion()){
    $core->returnHome();
}



