<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 05/06/2017
 * Time: 06:39 PM
 */
/**
 * Incluir las Librerias Principales del Sistema
 * En el Siguiente Orden ruta de libreias: @@/SistemaIntegral/core/
 *
 * 1.- core.php;
 * 2.- sesiones.php
 * 3.- seguridad.php o modelo ( ej: model_aparatos.php)
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

/**
 * 1.- Instanciar la Clase seguridad y pasar como valor la BD del Usuario
 * 2.- Llamar al metodo @@valida_session_id($NoUsuario), para validar que el usuario este conectado y con una sesión valida
 *
 * Ejemplo:
 * Si se requiere cambiar de servidor de base de datos
 * $data_server = array(
 *   'bdHost'=>'192.168.2.5',
 *   'bdUser'=>'sa',
 *   'bdPass'=>'pasword',
 *   'port'=>'3306',
 *   'bdData'=>'dataBase'
 *);
 *
 * Si no es requerdio se puede dejar en null
 *
 * con @data_server
 * @@$seguridad = new \core\seguridad($_SESSION['data_login']['BDDatos'],$data_server);
 *
 * Sin @data_server
 * @@$seguridad = new \core\seguridad($_SESSION['data_login']['BDDatos']);
 *
 * @@$seguridad->valida_session_id($_SESSION['data_login']['NoUsuario']);
 */

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/

$connect = new \core\seguridad();
$connect->valida_session_id();
$idEmpresa = $_SESSION['data_home']['idempresa'];
$idDepartamento = $_SESSION['data_home']['iddepartamento'];
$NoUsuarioAlta = $_SESSION['data_login']['idusuario'];
header("Content-type:application/json");

$FechaActual = date("Y-m-d H:i:s");

switch($_POST['opc']){
    //Validar si ya se realizo el cierre
    case 1:

        $connect->_query = "SELECT date(fecha_cierre) FROM cierre WHERE iddepartamento = 1 ORDER BY date(fecha_cierre ) DESC LIMIT 0,1";
        $connect->get_result_query();
        $UltimoCierre = $connect->_rows[0][0];

        $connect->_query = "SELECT date(fecha_apertura) FROM apertura WHERE iddepartamento = 1 ORDER BY date(fecha_apertura ) DESC LIMIT 0,1";
        $connect->get_result_query();
        $UltimoApertura = $connect->_rows[0][0];

        $FechaActual = date("Y-m-d");


        if($UltimoApertura == null && $UltimoCierre == null){
            //Sistema nuevo
            echo json_encode(array('result'=>'success','mensaje'=>"sistema_nuevo"));
        }else{


            if($UltimoApertura > $UltimoCierre){

                if($FechaActual == $UltimoApertura){
                    echo json_encode(array('result'=>'success','mensaje'=>"Apertura_mayor","data"=>array("ultimo_cierre"=>$UltimoCierre,"ultima_apertura"=>$UltimoApertura,"fecha_actual"=>$FechaActual)));
                }else{
                    echo json_encode(array('result'=>'success','mensaje'=>"cierre_anterior","data"=>array("ultimo_cierre"=>$UltimoCierre,"ultima_apertura"=>$UltimoApertura,"fecha_actual"=>$FechaActual)));
                }


            }else if($UltimoApertura == $UltimoCierre){

                if($FechaActual <= $UltimoApertura){
                    //Dia actual cerrado
                    echo json_encode(array('result'=>'success','mensaje'=>"dia_cerrado","data"=>array("ultimo_cierre"=>$UltimoCierre,"ultima_apertura"=>$UltimoApertura,"fecha_actual"=>$FechaActual)));
                }else{
                    //Realizar nueva apertura
                    echo json_encode(array('result'=>'success','mensaje'=>"sistema_nuevo","data"=>array("ultimo_cierre"=>$UltimoCierre,"ultima_apertura"=>$UltimoApertura,"fecha_actual"=>$FechaActual)));
                }

            }



        }


        break;
    //REALIZAR CIERRE DE CAJA
    case 2:
        /**
         * REALIZAR EL CIERRE DE CAJA
         *
         * SE TOMARA EN CUENTA LOS SIGUIENTES PUNTOS
         *
         * 1.- SALDO INICIAL EN CAJA
         * 2.- TODAS LAS ENTRADAS Y SALIDAS
         * 3.- TODAS LAS APORTACIONES Y RETIROS
         * 4.- TODAS LAS VENTAS TERMINADAS
         * 5.- TODAS LAS VENTAS CON PAGO INICIAL
         */

        $SaldoFinal = $_POST['saldo_final_caja'];
        $FechaCierre = $_POST['fecha_cierre'].' '.date("H:i:s");
        $TotalEntradas = 0;
        $TotalSalidas = 0;
        $TotalAportaciones = 0;
        $TotalRetiros = 0;
        $Total = 0;


        if($Total > $SaldoFinal){
            echo json_encode(array("result"=>"error","mensaje"=>"No se realizo el cierre. el saldo final es inferior al Saldo Total","total"=>$Total,"saldo_final"=>$SaldoFinal));
        }else{
            //$FechaCierre = date("Y-m-d H:i:s");
            $connect->_query = "INSERT INTO cierre (idempresa,iddepartamento,SaldoFinal,idusuario_cierre,fecha_cierre,fecha_registro) VALUES ('$idEmpresa','$idDepartamento','$SaldoFinal','$NoUsuarioAlta','$FechaCierre','$FechaActual')";
            $connect->execute_query();
            echo json_encode(array("result"=>"ok","total"=>$Total,"saldo_final"=>$SaldoFinal));
        }

        break;
    default:
        break;
}

