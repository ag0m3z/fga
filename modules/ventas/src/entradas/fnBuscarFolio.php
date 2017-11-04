<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 08/10/2017
 * Time: 01:19 AM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();

$idEmpresa = $_SESSION['data_home']['idempresa'];
$idDepartamento = $_SESSION['data_home']['iddepartamento'];
$Folio = $_GET['Folio'];

header("ContentType:application/json");

if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(empty($_GET['Folio'])){
        echo json_encode(array("result"=>false,"message"=>"Folio invalido","data"=>array()));
    }else{

        if($_GET['Tipo'] != ""){
            $Tipo = " AND a.idtipo = '$_GET[Tipo]'  ";
        }else{$Tipo='';}

        $connect->_query = "
        SELECT 
            a.Folio,
            a.FolioLlave,
            a.idempresa,
            a.iddepartamento,
            b.nombre_departamento,
            a.idtipo,
            a.idconcepto,
            a.importe,
            a.observaciones,
            a.idusuario_solicita,
            c.nick_name,
            a.idusuario_autoriza,
            d.nick_name,
            a.idusuario_cancela,
            e.nick_name,
            a.idestatus,
            a.fecha_registro,
            date(a.fecha_registro)as Fecha,
            time(a.fecha_registro)as Hora 
        FROM entradas as a 
        LEFT JOIN departamentos as b 
        ON a.iddepartamento = b.iddepartamento 
        LEFT JOIN perfil_usuarios as c 
        ON a.idusuario_solicita = c.idusuario
        LEFT JOIN perfil_usuarios as d 
        ON a.idusuario_autoriza = d.idusuario
        LEFT JOIN perfil_usuarios as e 
        ON a.idusuario_cancela = e.idusuario
        where a.Folio = '$Folio' AND a.idempresa = $idEmpresa AND a.iddepartamento = $idDepartamento $Tipo
        ";

        $connect->get_result_query();
        if(count($connect->_rows)<=0){
            echo json_encode(array("result"=>false,"message"=>"No se encontraron resultados","data"=>array()));
        }else{

            $idTipo = $connect->_rows[0][5];
            if($idTipo == "E"){$idTipo = "Entrada";}else{$idTipo = "Salida";}

            $Concepto = $connect->_rows[0][6];
            $Importe =  $connect->_rows[0][7];
            $Descripcion = $connect->_rows[0][8];

            //Si viene de para una cancelacion
            //Validar que no este cancelado
            $connect->_confirm = false;
            if($_GET['Tipo'] != ""){

                if($connect->_rows[0][15] == "C"){
                    echo json_encode(array("result"=>false,"message"=>"El Folio ya se encuentra Cancelado","data"=>array()));
                    exit();
                }else{
                    $connect->_confirm = true;
                }

            }else{
                $connect->_confirm = true;
            }

            if($connect->_confirm){
                echo json_encode(array("result"=>true,"message"=>"Todo correcto: ".$_GET['Tipo'],"data"=>
                        array(
                            "tipo"=>$idTipo,
                            "concepto"=>$Concepto,
                            "importe"=>$Importe,
                            "descripcion"=>$Descripcion
                        )
                    )
                );
            }

        }

    }

}else{
    echo json_encode(array("result"=>false,"message"=>"Metodo no soportado","data"=>array()));
}