<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 04/06/2017
 * Time: 12:17 AM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();


//Sanatizacion de datos
$_POST = $connect->get_sanatiza($_POST);

$NombreEmpresa = $_POST['nombreEmpresa'];
$DescripcionEmpresa = $_POST['descripcionEmpresa'];
$CorreoEmpresa = $_POST['correoNotify'];

$costo_trabajo_cp = $_POST['costo_trabajo_cp'];
$mayoreo_costo_trabajo_cp = $_POST['mayoreo_costo_trabajo_cp'];
$costo_trabajo_mayoreo_cp = $_POST['costo_trabajo_mayoreo_cp'];

$costo_trabajo_sp = $_POST['costo_trabajo_sp'];
$mayoreo_costo_trabajo_sp = $_POST['mayoreo_costo_trabajo_sp'];
$costo_trabajo_mayoreo_sp = $_POST['costo_trabajo_mayoreo_sp'];

$pago_minimo_credito = $_POST['pago_minimo_credito'];

$connect->_query = "
UPDATE sys_config
  SET costo_trabajo_cp = '$costo_trabajo_cp',
      pago_minimo_credito = $pago_minimo_credito
WHERE idempresa = 1;
";

$connect->execute_query();
$connect->_query = "
  UPDATE empresas 
    SET 
      nombre_empresa = '$NombreEmpresa',
      descripcion_empresa='$DescripcionEmpresa',
      correo = '$CorreoEmpresa' 
  WHERE idempresa = 1;";
$connect->execute_query();

echo "<script>getMessage('Datos Guardados correctamente','Parametros del sistma','success',4000)</script>";