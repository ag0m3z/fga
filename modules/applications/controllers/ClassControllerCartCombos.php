<?php

/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 11/06/2017
 * Time: 02:41 PM
 */


class ClassControllerCartCombos
{

    public function __construct()
    {
        $this->num_productos = 0;
        $_SESSION['cart_combos'];

    }

    public function introduce_producto($id_prod,$nombre_prod,$tipo_producto){

        $_SESSION['cart_combos'][] = array(
            'id'=>$id_prod,
            'nombre'=>$nombre_prod,
            'tipo'=>$tipo_producto
        );

    }

    public function elimina_producto($linea){

        array_splice($_SESSION['cart_combos'],$linea,1);

    }

    public function imprime_carrito(){

        for ($i=0;$i<count($_SESSION['cart_combos']);$i++){

            $data[] = array(
                "idproducto"=>$_SESSION['cart_combos'][$i]['id'],
                "nombre"=>$_SESSION['cart_combos'][$i]['nombre'],
                "tipo_producto"=>$_SESSION['cart_combos'][$i]['tipo']
            );
        }

        return $data;
    }
}