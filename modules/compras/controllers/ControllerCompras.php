<?php

/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 25/09/2017
 * Time: 09:38 PM
 */
include "../../../core/seguridad.class.php";
class ControllerCompras extends \core\seguridad
{
    //Traer la informacion de la compra
    public function getInformacionCompra($dataCompra = array("idcompra"=>null,"idempresa"=>null)){

        if(array_key_exists("idcompra",$dataCompra) &&array_key_exists("idempresa",$dataCompra)){
            return true;
        }else{
            return false;
        }

    }

    public function getListaCompra($dataCompra = array("idcompra"=>null,"idempresa"=>null)){

        if(array_key_exists("idcompra",$dataCompra) &&array_key_exists("idempresa",$dataCompra)){

            $this->_query = "
            SELECT 
                a.iddetalle_compra,a.idempresa,a.idcompra,lpad(a.idcompra,4,'0'),a.tipo_articulo,a.idarticulo,
                c.nombre_articulo,a.cantidad,a.precio_compra,
                b.precio_iva,b.idproveedor,d.nombre_proveedor,d.telefono01,date(b.fecha_alta),b.fecha_alta,e.nombre_departamento,e.domicilio,e.telefono01,e.telefono02,f.nombre_almacen 
            FROM detalle_compra as a 
            JOIN compra as b 
            on a.idcompra = b.idcompra 
            JOIN articulos as c 
            on a.idarticulo = c.idarticulo 
            JOIN proveedores as d 
            on b.idproveedor = d.idproveedor 
            LEFT JOIN almacen as f 
            ON b.iddepartamento_entrega = f.idalmacen
            LEFT JOIN departamentos as e 
            ON f.idalmacen = e.idalmacen 
            WHERE a.idcompra = '$dataCompra[idcompra]' AND b.idempresa = '$dataCompra[idempresa]' ORDER BY b.fecha_alta DESC
            ";

            $this->get_result_query();
            return $this->_rows;

        }
    }

    public function setEliminarArticulo($iCompra,$idArticulo){

    }

}