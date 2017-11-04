<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 25/10/2017
 * Time: 09:12 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();

header("ContentType:application/json");

sleep(4);


if($_SERVER['REQUEST_METHOD'] == "POST"){

    if($_POST['idcompra']){

        $idCompra = $_POST['idcompra'];
        $idempresa = IDEMPRESA ;
        $UsuarioRegistra = IDUSUARIO;
        $UsuarioAutoriza = 0;

        $connect->_query = "
        select b.iddepartamento_entrega,a.tipo_articulo,a.idarticulo,a.cantidad from detalle_compra as a left join compra as b on a.idcompra = b.idcompra where a.idcompra = $idCompra
        ";

        $connect->get_result_query();
        $detalleCompra = $connect->_rows ;

        $AlmacenOrigen = 1;
        $AlmacenDestino = $detalleCompra[0][0];
        $idestado = "1";
        $UsuarioSolicita = IDUSUARIO;
        $FechaActual = date("Y-m-d H:i:s");

        if(count($detalleCompra)>0){

            $connect->_query = "INSERT INTO traspasos (
            idempresa,
            idalmacen_origen,
            idalmacen_destino,
            idestado,
            idusuario_solicita,
            idusuario_registra,
            idusuario_autoriza,
            fecha_alta,
            idusuario_alta,
            fecha_um,
            idusuario_um
            ) VALUES (
            '$idempresa',
            '$AlmacenOrigen',
            '$AlmacenDestino',
            '$idestado',
            '$UsuarioSolicita',
            '$UsuarioRegistra',
            '$UsuarioAutoriza',
            '$FechaActual',
            '$UsuarioRegistra',
            '$FechaActual',
            '$UsuarioRegistra'
            )";

            $connect->execute_query();
            $connect->_query = "SELECT @@identity AS id";
            $connect->get_result_query();
            $idTraspaso = $connect->_rows[0][0];

            for($i=0;$i < count($detalleCompra); $i++){

                $TipoArticulo = $detalleCompra[$i]['tipo_articulo'];
                $IDArticulo = $detalleCompra[$i]['idarticulo'];
                $Cantidad = $detalleCompra[$i]['cantidad'];

                $connect->_query = "CALL sp_registra_detalle_traspaso(
                '1',
                '$idempresa',
                '$idTraspaso',
                '$idestado',
                '$UsuarioAutoriza',
                '$AlmacenOrigen',
                '$AlmacenDestino',
                '$TipoArticulo',
                '$IDArticulo',
                '$Cantidad'
                )";

                $connect->get_result_query();
            }
            echo json_encode(
                array(
                    "result"=>"ok",
                    "mensaje"=>"Registrado Correctamente",
                    "id"=>$idTraspaso,
                    "total"=>count($detalleCompra)
                )
            );


        }else{

            echo json_encode(
                array(
                    "result"=>false,
                    "message"=>"Error no se encontro el id de compra",
                    "data"=>array()
                )
            );

        }


    }else{

        echo json_encode(
            array(
                "result"=>false,
                "message"=>"Error no se encontro el id de compra",
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