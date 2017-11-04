<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 23/09/2017
 * Time: 10:04 PM
 */


include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();

header("ContentType:application/json");

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $Folio = $_POST['folio'];

    switch ($_POST['opc']){
        case 6: //Mostrar Lista de Pagos

            $connect->_query= "
            SELECT 
              idmovimiento,NoPago,Importe,TotalPagado,
              TotalRecibido,FechaMovimiento,FechaMovimiento,idestatus 
            FROM 
              movimientos_caja 
            where 
              idventa = $Folio 
            ORDER BY FechaMovimiento desc
            ";

            $connect->get_result_query();

            if(count($connect->_rows) > 0 ) {

                for ($i = 0; $i < count($connect->_rows); $i++) {
                    $data[] = array(
                        "FolioMovimiento"=>$connect->getFormatFolio($connect->_rows[$i][0],4),
                        "idMovimiento"=>$connect->_rows[$i][0],
                        "NoPago"=>$connect->_rows[$i][1],
                        "ImporteVenta"=>$connect->_rows[$i][2],
                        "ImportePagado"=>$connect->_rows[$i][3],
                        "ImporteRecibido"=>$connect->_rows[$i][4],
                        "Estatus"=>$connect->_rows[$i][7],
                        "FechaMovimiento"=>$connect->_rows[$i][5],
                        "FechaRegistro"=>$connect->_rows[$i][6],
                        "idVenta"=>$Folio
                    );
                }

                echo json_encode(
                    array(
                        "result" =>true,
                        "message" =>"consulta exitosa",
                        "data" =>$data
                    )
                );
            }else{

                echo json_encode(
                    array(
                        "result"=>false,
                        "message"=>"No se encontro el folio",
                        "data"=>array()
                    )
                );

            }
            break;
        case 7: //Realizar Cancelacion de pago

            $NoUsuario = $_SESSION['data_login']['idusuario'];
            $idMovimiento = $_POST['pago'];

            $connect->_query= "
            UPDATE movimientos_caja SET idestatus ='C',idusuario_cancela=$NoUsuario,FechaCancelacion=now() WHERE idmovimiento = $idMovimiento
            ";

            $connect->_query = "call sp_CancelarNotaVenta('1','$idMovimiento','$NoUsuario')";

            $connect->execute_query();
            echo json_encode(
                array(
                    "result" =>true,
                    "message" =>"consulta exitosa",
                    "data" =>array()
                )
            );

            break;
        default:
            echo json_encode(
                array(
                    "result"=>false,
                    "message"=>"No se encontro la opcion para esta solicitud",
                    "data"=>array()
                )
            );
            break;
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