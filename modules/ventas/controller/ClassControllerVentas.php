<?php

/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 09/06/2017
 * Time: 01:27 PM
 */

include "../../../../core/seguridad.class.php";

class ClassControllerVentas extends \core\seguridad
{


    public function putRealizarPago($idFolio = ""){

        if($idFolio != ""){

            $this->_query = "
            SELECT idmovimiento,TipoVenta,idventa,NoPago,Importe,TotalPagado,TotalRecibido,TipoPago,PagoEfectivo,Pago,idestatus,FechaMovimiento,idestatus
            FROM movimientos_caja WHERE idventa = $idFolio ORDER BY NoPago DESC;
            ";

            $this->get_result_query();

            if($this->_rows[0][0] != null){
                $this->_confirm = true;
                $this->_message = "Se encontro el folio: $idFolio";
            }else{
                $this->_message = "No se encontro el folio de venta";
                $this->_confirm = false;

            }



        }else{
            $this->_confirm = false;
            $this->_message = "No se encontro el folio para realizar el pago";
        }

    }

}