<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 16/09/2017
 * Time: 04:02 PM
 */


include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();


$_SESSION['myPrint'] = $_POST['nameprinter'];