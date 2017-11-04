<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 09/10/2017
 * Time: 11:05 AM
 */
include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();

$idEmpresa = $_SESSION['data_home']['idempresa'];
$idDepartamento = $_SESSION['data_home']['iddepartamento'];
$Folio = $_GET['Folio'];
$Tipo = $_GET['TipoAportacion'];

$CondicionTipo = '';

if($Tipo == 1){
    $CondicionTipo = " AND a.idtipo = 'A' ";
}else if($Tipo == 2){
    $CondicionTipo = " AND a.idtipo = 'R' ";
}

header("ContentType:application/json");

if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(empty($_GET['Folio'])){
        echo json_encode(array("result"=>false,"message"=>"Folio invalido","data"=>array()));
    }else{

        $connect->_query = "
        SELECT 
            a.idFolio,
            a.idLlave,
            a.idempresa,
            a.iddepartamento,
            b.nombre_departamento,
            a.idtipo,
            a.importe,
            f.Nombre as Origen,
            g.Nombre as Destino,
            a.descripcion,
            a.idusuario_registro,
            c.nick_name,
            a.idusuario_autoriza,
            d.nick_name,
            a.idusuario_cancelacion,
            e.nick_name,
            a.idestatus,
            a.fecha_registro,
            date(a.fecha_registro)as Fecha,
            time(a.fecha_registro)as Hora,
            a.idestatus_registro 
        FROM aportaciones as a 
        LEFT JOIN departamentos as b 
        ON a.iddepartamento = b.iddepartamento 
        LEFT JOIN perfil_usuarios as c 
        ON a.idusuario_registro = c.idusuario
        LEFT JOIN perfil_usuarios as d 
        ON a.idusuario_autoriza = d.idusuario
        LEFT JOIN perfil_usuarios as e 
        ON a.idusuario_cancelacion = e.idusuario 
        LEFT JOIN cajas as f 
        ON a.idsucursal_origen = f.idcaja 
        LEFT JOIN cajas as g 
        ON a.idsucursal_destino = g.idcaja 
        where a.idFolio = '$Folio' $CondicionTipo
        ";
        $connect->get_result_query();

        if(count($connect->_rows)<=0){
            echo json_encode(array("result"=>false,"message"=>"No se encontraron resultados","data"=>array()));
        }else{



            $NombreDepartamento = $connect->_rows[0][4];
            $TipoEntrada = $connect->_rows[0][5];
            $Solicitante = $connect->_rows[0][11];
            $Autorizante = $connect->_rows[0][13];
            $UsuarioCancela = $connect->_rows[0][15];
            $Importe = $connect->setFormatoMoneda($connect->_rows[0][6],'pesos');
            $Origen = $connect->_rows[0][7];
            $Destino = $connect->_rows[0][8];
            $Descripcion = $connect->_rows[0][9];
            $Estatus = $connect->_rows[0][16];
            $FechaRegistro = $connect->_rows[0][17];

            if($TipoEntrada == "A"){
                $TipoMovimiento = "Aportación";
            }else{
                $TipoMovimiento = "Retiro";
            }

            //Si viene de  una cancelacion
            //Validar que no este cancelado
            if($Tipo != ""){

                if($connect->_rows[0][16] == "C"){
                    echo json_encode(array("result"=>false,"message"=>"El Folio ya se encuentra Cancelado","data"=>array()));
                    exit();
                }else{
                    $connect->_confirm = true;
                }

            }else{
                $connect->_confirm = true;
            }

            if($connect->_confirm){
                echo json_encode(array("result"=>true,"message"=>"Todo correcto: ".$_GET['Folio'],"data"=>
                        array(
                            "tipo"=>$TipoMovimiento,
                            "origen"=>$Origen,
                            "destino"=>$Destino,
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