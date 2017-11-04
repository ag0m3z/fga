<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 08/06/2017
 * Time: 10:03 PM
 */

include "../../../../core/seguridad.class.php";

class ClassControllerReports extends \core\seguridad {


    public function getCorteDiario($data_array = array()){

        if(array_key_exists('idperfil',$data_array)){
            $this->_query = "
                    SELECT 
                        a.idmovimiento,a.tipo_venta,a.idventa,a.NoPago,a.idusuario_regitra,a.idestatus,
                        a.importe_venta,sum(importe_pagado) as ImportePagado,a.importe_recibido,a.tipo_pago,a.pago_efectivo,a.pago_voucher,b.idcliente,c.nombre_completo,d.nombre_departamento
                    FROM movimientos_caja as a 
                    JOIN venta as b 
                    ON a.idventa = b.idventa 
                    JOIN clientes as c 
                    ON b.idcliente = c.idcliente 
                    JOIN departamentos as d 
                    ON b.iddepartamento = d.iddepartamento 
                    WHERE
                        date(a.fecha_movimiento) = date(now()) AND b.iddepartamento = '$data_array[iddepartamento]'
                    group by a.idventa
                    ";

            $this->get_result_query();
            return $this->_rows;

        }else{
            $this->_confirm = false;
            $this->_message = "Error no se encontro el perfil para realizar la consulta";
        }
    }

    public function getMovimientosDiario($data_array = array()){

        if(array_key_exists('idperfil',$data_array)){

            $this->_query = "
                    SELECT 
                        a.idmovimiento,a.tipo_venta,a.idventa,a.NoPago,a.idusuario,a.idestatus,
                        a.importe_venta,sum(importe_pagado) as ImportePagado,a.importe_recibido,a.tipo_pago,a.pago_efectivo,a.pago_voucher,b.idcliente,c.nombre_completo,d.nombre_departamento
                    FROM movimientos_caja as a 
                    JOIN venta as b 
                    ON a.idventa = b.idventa 
                    JOIN clientes as c 
                    ON b.idcliente = c.idcliente 
                    JOIN departamentos as d 
                    ON b.iddepartamento = d.iddepartamento 
                    WHERE
                        date(a.fecha_movimiento) = date(now()) AND b.iddepartamento = '$data_array[iddepartamento]'
                    group by a.idventa
                    ";

            $this->get_result_query();
            return $this->_rows;

        }else{
            $this->_confirm = false;
            $this->_message = "Error no se encontro el perfil para realizar la consulta";
        }

    }

}