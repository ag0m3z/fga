<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 06/10/2017
 * Time: 10:02 AM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../controller/ClassControllerTrabajos.php";

$connect = new \ventas\controller\ControllerTrabajos\ClassControllerTrabajos();
$connect->valida_session_id();

header("ContentType:application/json");

if($_SERVER['REQUEST_METHOD'] == "GET"){

    switch ($_GET['opc']){
        case 1: // Lista de Trabajos pendientes
            $lista = $connect->getTrabajosPendientes(array("idperfil"=>$_SESSION['data_login']['idperfil'],"iddepartamento"=>$_SESSION['data_home']['iddepartamento'],"idempresa"=>$_SESSION['data_home']['idempresa']));
            break;
        case 2:
            break;
        default:
            echo json_encode(array("result"=>false,"message"=>"opcion no valida","data"=>array()));
            break;
    }

    if($connect->_confirm){

        $Folio=array();
        for($i=0;$i<count($lista);$i++){

           if(in_array($lista[$i],$lista[$i])){

           }else{
               $Folio[] = $lista[$i]['idventa'];
           }
        }

        $Folio = array_unique($Folio);

        echo json_encode(array("result"=>true,"message"=>$connect->_message,"data"=>$Folio,"trabajo"=>$Trabajo,"detalle"=>$lista));
    }else{
        echo json_encode(array("result"=>false,"message"=>$connect->_message,"data"=>array()));
    }

}else{
    echo json_encode(array("result"=>false,"message"=>"Metodo no soportado","data"=>array()));
}
