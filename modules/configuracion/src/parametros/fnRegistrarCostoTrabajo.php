<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 16/09/2017
 * Time: 10:41 AM
 */


include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$idEmpresa = $_SESSION['data_home']['idempresa'];
$NoUsuario = $_SESSION['data_login']['idusuario'];

header("ContentType:applicatin/json");

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $_POST = $connect->get_sanatiza($_POST);

    if(empty($_POST['nombre']) == ""){

        //Valida que  no exista ya el nombre registrado
        $connect->_query = "
        SELECT nombre_catalogo FROM catalogo_general where idcatalogo = 7 and idempresa = $idEmpresa and nombre_catalogo = '$_POST[nombre]'
        ";
        $connect->get_result_query();

        if(count($connect->_rows) > 0){
            //El nombre ya existe
            echo json_encode(
                array(
                    "result"=>false,
                    "message"=>"El nombre para el costo del trabajo ya existe",
                    "data"=>array()
                )
            );
        }else{

            $connect->_query = "SELECT ifnull(max(opc_catalogo),0)+1 FROM catalogo_general where idcatalogo = 7 and idempresa = $idEmpresa ";
            $connect->get_result_query();

            $MaximaID = $connect->_rows[0][0];

            $connect->_query = "
            INSERT INTO catalogo_general VALUES (
            7,
            '$idEmpresa',
            '$MaximaID',
            0,0,
            '$_POST[nombre]',
            '$_POST[nombre]',
            '$_POST[precio]',0,0,1,'$NoUsuario','$NoUsuario',now(),now()
            )
            ";
            $connect->execute_query();

            echo json_encode(
                array(
                    "result"=>true,
                    "message"=>"Costo registrado correctamente",
                    "data"=>array()
                )
            );


        }


    }else{
        echo json_encode(
            array(
                "result"=>false,
                "message"=>"Parametros incorrectos o vacios",
                "data"=>array()
            )
        );
    }


}else{
    echo json_encode(
        array(
            "result"=>false,
            "message"=>"Metodo no soportado",
            "data"=>array()
        )
    );
}