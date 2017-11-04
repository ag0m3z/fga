<?php

/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 22/05/2017
 * Time: 12:33 PM
 */
include "../../../../core/seguridad.class.php";

class model_almacen extends \core\seguridad
{

    public function listar_inventario($tipo_producto,$idalmacen,$idempresa,$idestado){

        if($idalmacen == '999'){
            $this->_query = "SELECT 0,a.idempresa,a.idalmacen,c.nombre_almacen,a.tipo_articulo,a.idarticulo,b.nombre_articulo,a.existencias 
            FROM almacen_articulos as a 
            LEFT JOIN articulos as b 
            ON a.idarticulo = b.idarticulo 
            LEFT JOIN almacen as c 
            ON a.idalmacen = c.idalmacen WHERE a.tipo_articulo = '$tipo_producto' AND a.idempresa = '$idempresa' ";
            $this->get_result_query();

            return $this->_rows;
        }else{


            $this->_query = "SELECT 0,a.idempresa,a.idalmacen,c.nombre_almacen,a.tipo_articulo,a.idarticulo,b.nombre_articulo,a.existencias 
                    FROM almacen_articulos as a 
                    LEFT JOIN articulos as b 
                    ON a.idarticulo = b.idarticulo 
                    LEFT JOIN almacen as c 
                    ON a.idalmacen = c.idalmacen WHERE a.tipo_articulo = '$tipo_producto' AND a.idempresa = '$idempresa' AND a.idalmacen = $idalmacen  ";



            $this->get_result_query();

            return $this->_rows;
        }


    }


}