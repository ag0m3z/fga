<?php

/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 23/05/2017
 * Time: 11:56 AM
 */
class ControllerCartTraspasos
{

    public function __construct()
    {
        $this->num_productos = 0;
        $_SESSION['cart_traspasos'];

    }

    public function introduce_producto($id_prod,$nombre_prod,$tipo_producto,$cantidad,$idalmacen_origen,$idalmacen_destino,$idusuario_solicita){


        $_SESSION['cart_traspasos'][] = array(
            'id'=>$id_prod,
            'nombre'=>$nombre_prod,
            'tipo'=>$tipo_producto,
            'cantidad'=>$cantidad,
            'idalmacen_origen'=>$idalmacen_origen,
            'idalmacen_destino'=>$idalmacen_destino,
            'idusuario_solicita'=>$idusuario_solicita

        );

    }

    public function elimina_producto($linea){

        array_splice($_SESSION['cart_traspasos'],$linea,1);

    }

    public function imprime_carrito(){

        $total_precio=0;

        for ($i=0;$i<count($_SESSION['cart_traspasos']);$i++){

            $total_precio = ($total_precio + $_SESSION['cart_traspasos'][$i]['cantidad']);

            $data[] = array(
                "idarticulo"=>$_SESSION['cart_traspasos'][$i]['id'],
                "nombre"=>$_SESSION['cart_traspasos'][$i]['nombre'],
                "tipo"=>$_SESSION['cart_traspasos'][$i]['tipo'],
                "cantidad"=>$_SESSION['cart_traspasos'][$i]['cantidad'],
                "idalmacen_origen"=>$_SESSION['cart_traspasos'][$i]['idalmacen_origen'],
                "idalmacen_destino"=>$_SESSION['cart_traspasos'][$i]['idalmacen_destino'],
                "idusuario_solicita"=>$_SESSION['cart_traspasos'][$i]['idusuario_solicita'],
                "total"=>$total_precio
            );
        }

        return $data;
    }

}