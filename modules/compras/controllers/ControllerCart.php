<?php

/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 03/05/2017
 * Time: 01:28 PM
 */

class ControllerCart
{


    public function __construct()
    {
        $this->num_productos = 0;

    }

    public function introduce_producto($id_prod,$tipo_producto,$nombre_prod,$precio_compra,$cantidad,$precio_venta){


        $_SESSION['cart'][] = array(
            'id'=>$id_prod,
            'tipo'=>$tipo_producto,
            'nombre'=>$nombre_prod,
            'cantidad'=>$cantidad,
            'precio_compra'=>$precio_compra,
            'precio_venta'=>$precio_venta
        );
    }

    public function elimina_producto($linea){

        array_splice($_SESSION['cart'],$linea,1);

        //$this->array_id_prod[$linea]=0;
    }

    public function imprime_carrito(){

        $total_precio=0;

        for ($i=0;$i<count($_SESSION['cart']);$i++){

            $total_precio = ($_SESSION['cart'][$i]['precio_compra'] * $_SESSION['cart'][$i]['cantidad']);

            $data[] = array(
                "idarticulo"=>$_SESSION['cart'][$i]['id'],
                "tipo_producto"=>$_SESSION['cart'][$i]['tipo'],
                "nombre"=>$_SESSION['cart'][$i]['nombre'],
                "precio_compra"=>$_SESSION['cart'][$i]['precio_compra'],
                "precio_venta"=>$_SESSION['cart'][$i]['precio_venta'],
                "cantidad"=>$_SESSION['cart'][$i]['cantidad'],
                "total"=>$total_precio
            );
        }

        return $data;
    }

}