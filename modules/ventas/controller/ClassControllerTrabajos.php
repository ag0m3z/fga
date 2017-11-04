<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 06/10/2017
 * Time: 10:03 AM
 */

namespace ventas\controller\ControllerTrabajos;

use core\seguridad;

include "../../../../core/seguridad.class.php";


class ClassControllerTrabajos extends seguridad
{

    public function getTrabajosPendientes($arrayData){

        if(array_key_exists('idempresa',$arrayData) && array_key_exists('iddepartamento',$arrayData) && array_key_exists('idperfil',$arrayData)){

            if($arrayData['idperfil'] == 1){
                $this->_query = "
                SELECT 
                    b.idventa,
                    lpad(b.idventa,4,'0')as Folio,
                    g.nombre_departamento,
                    e.nick_name,
                    f.nombre_completo as NombreCliente,
                    d.nombre_articulo,
                    b.cantidad,
                    b.precio_compra,
                    b.tipo_articulo,
                    b.descripcion,
                    b.costo_trabajo_cp,
                    a.idcliente,
                    a.iddepartamento,
                    a.idusuario,
                    a.descripcion_general,
                    a.idtipo_venta,
                    date(a.fecha_venta) as FechaVenta,
                    date(a.fecha_promesa) as FechaPromesa
                FROM detalle_venta as b 
                left join venta as a 
                on b.idventa = a.idventa
                left join articulos as d 
                on b.idarticulo= d.idarticulo
                left join perfil_usuarios as e 
                on a.idusuario = e.idusuario 
                left join clientes as f 
                on a.idcliente = f.idcliente 
                left join departamentos as g 
                on a.iddepartamento = g.iddepartamento
                 WHERE 
                  a.idestatus = 1 AND 
                  a.idempresa = '$arrayData[idempresa]' 
                ORDER BY a.fecha_promesa ASC";
            }else{
                $this->_query = "
                SELECT 
                    b.idventa,
                    lpad(b.idventa,4,'0')as Folio,
                    g.nombre_departamento,
                    e.nick_name,
                    f.nombre_completo as NombreCliente,
                    d.nombre_articulo,
                    b.cantidad,
                    b.precio_compra,
                    b.tipo_articulo,
                    b.descripcion,
                    b.costo_trabajo_cp,
                    a.idcliente,
                    a.iddepartamento,
                    a.idusuario,
                    a.descripcion_general,
                    a.idtipo_venta,
                    date(a.fecha_venta) as FechaVenta,
                    date(a.fecha_promesa) as FechaPromesa
                FROM detalle_venta as b 
                left join venta as a 
                on b.idventa = a.idventa
                left join articulos as d 
                on b.idarticulo= d.idarticulo
                left join perfil_usuarios as e 
                on a.idusuario = e.idusuario 
                left join clientes as f 
                on a.idcliente = f.idcliente 
                left join departamentos as g 
                on a.iddepartamento = g.iddepartamento
                 WHERE 
                  a.idestatus = 1 AND 
                  a.idempresa = '$arrayData[idempresa]' AND  
                  a.iddepartamento = '$arrayData[iddepartamento]'  
                ORDER BY a.fecha_promesa ASC";
            }

            $this->get_result_query(true);

            $this->_message = "consulta exitosa c";
            $this->_confirm = true;
            return $this->_rows;


        }else{
            $this->_message = "Llaves no encontradas";
            $this->_confirm = false;
        }

    }

}