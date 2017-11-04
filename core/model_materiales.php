<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 25/04/2017
 * Time: 05:18 PM
 */

namespace core;
include "seguridad.class.php";

class model_materiales extends seguridad
{
    protected $idarticulo;
    protected $idempresa;
    protected $nombre_articulo;
    protected $descripcion;
    protected $precio_compra;
    protected $precio_venta;
    protected $stock_minimo;
    protected $stock_maximo;
    protected $idcolor;
    protected $nombre_catalogo;
    protected $descripcion_catalogo;
    protected $fecha_alta;
    protected $UsuarioAlta;
    protected $fecha_um;
    protected $UsuarioUM;
    protected $idestado;
    protected $Utilidad;

    // retoranar el id del material
    public function getIdMaterial(){return $this->idarticulo ;}
    // retornar el nombre del material
    public function getNombreMaterial(){return $this->nombre_articulo;}
    // Descripcion del material
    public function getDescripcionMaterial(){return $this->descripcion;}

    public function getUtilidad(){return $this->Utilidad;}

    public function getPrecioCompra(){return $this->precio_compra;}
    public function getPrecioVenta(){return $this->precio_venta;}
    public function getStockMinimo(){return $this->stock_minimo;}
    public function getStoclMaximo(){return $this->stock_maximo;}
    public function getIdColor(){return $this->idcolor;}
    public function getCodigoColor(){return $this->nombre_catalogo;}
    public function getNombreColor(){return $this->descripcion_catalogo;}

    //Usuario Alta
    public function getUsuarioAlta(){return $this->UsuarioAlta;}
    public function getUsuarioUM(){return $this->UsuarioUM;}
    public function getFechaAlta(){return $this->fecha_alta;}
    public function getFechaUM(){return $this->fecha_um;}
    public function getNoEstado(){return $this->idestado;}

    public function set_materiales($data_array = array()){

        if( array_key_exists('idempresa',$data_array) || array_key_exists('nombre_material',$data_array) || array_key_exists('descripcion_material',$data_array)){

            //validar que no exista ya el almacén
            $this->_query = "SELECT nombre_articulo FROM articulos where nombre_articulo = '$data_array[nombre_material]' AND idempresa = '$data_array[idempresa]' ";
            $this->get_result_query();

            if(count($this->_rows) >= 1 ){

                $this->_confirm = false;
                $this->_message = "El nombre del material ya existe";

            }else{

                $this->_query = "call sp_registra_material
                (
                    '1',
                    '0',
                    '$data_array[idempresa]',
                    '$data_array[nombre_material]',
                    '$data_array[descripcion_material]',
                    '$data_array[idcolor]',
                    '$data_array[tipo_unidad]',
                    '$data_array[precio_compra]',
                    '$data_array[precio_venta]',
                    '$data_array[stock_minimo]',
                    '$data_array[stock_maximo]',
                    '$data_array[idestado]',
                    '$data_array[idusuario_alta]',
                    '$data_array[fecha_alta]'
                )";
                $this->execute_query();
                $this->_confirm = true;

            }

        }else{
            $this->_confirm = false;
            $this->_message = "Error al recibir los parametros";
        }

    }

    public function get_materiales($idmateriales,$idEmpresa){

        if($idmateriales != ''){

            $this->_query = "
            SELECT 
            a.idarticulo,a.nombre_articulo,a.descripcion,a.idcolor,a.precio_compra,a.precio_venta,a.stock_minimo,a.stock_maximo,
            a.idcolor,b.nombre_catalogo,b.descripcion_catalogo,a.idusuario_alta,c.nick_name as UsuarioAlta,a.idusuario_um,
            d.nick_name as UsuarioUM,a.fecha_alta,a.fecha_um,
             ((a.precio_venta - a.precio_compra) / a.precio_compra ) * 100 as Utilidad
            FROM articulos as a JOIN catalogo_general as b 
              ON a.idcolor = b.opc_catalogo AND b.idcatalogo = 4  AND b.idestado = 1
            JOIN perfil_usuarios as c ON a.idusuario_alta = c.idusuario 
            LEFT JOIN perfil_usuarios as d on a.idusuario_um = d.idusuario 
            WHERE a.idempresa = '$idEmpresa' AND a.idarticulo = '$idmateriales' ORDER BY a.nombre_articulo DESC 
            ";

            $this->get_result_query();

        }

        if(count($this->_rows) == 1){

            foreach ($this->_rows[0] as $campo => $valor){
                $this->$campo = $valor ;
            }
            $this->_confirm = true ;
            $this->_message = "Se encontro el material";

        }else{
            $this->_confirm = false ;
            $this->_message = "No se encontro el material" ;
        }

    }

    public function edit_materiales($data_array = array()){

        if(
            array_key_exists('idempresa',$data_array) &&
            array_key_exists('idmaterial',$data_array) &&
            array_key_exists('nombre_material',$data_array)
        ){
            //validar que no exita ya el materiales
            $this->_query =
                "
                SELECT nombre_material
                FROM materiales
                WHERE
                  nombre_material = '$data_array[nombre_material]' AND
                  idmateriales != '$data_array[idmaterial]'  AND
                  idempresa = '$data_array[idempresa]'
                ";
            $this->get_result_query();

            if(count($this->_rows) >= 1 ){

                $this->_confirm = false ;
                $this->_message = "El almacén ya existe";

            }else{
                //editar la almacén
                unset($this->_rows) ;
                $FechaAlta = date("Y-m-d H:i:s");

                $this->_query = "call sp_registra_material
                (
                    '2',
                    '$data_array[idmaterial]',
                    '$data_array[idempresa]',
                    '$data_array[nombre_material]',
                    '$data_array[descripcion_material]',
                    '$data_array[idcolor]',
                    '$data_array[tipo_unidad]',
                    '$data_array[precio_compra]',
                    '$data_array[precio_venta]',
                    '$data_array[stock_minimo]',
                    '$data_array[stock_maximo]',
                    '$data_array[idestado]',
                    '$data_array[idusuario_alta]',
                    '$data_array[fecha_alta]'
                )";
                $this->execute_query();
                $this->_confirm = true;
                $this->_message = "Caracteristica editada correctamente";
            }
        }else{
            $this->_confirm = false ;
            $this->_message = "No se encontraron los datos para editar la caracteristica";
        }

    }

    public function get_lista_materiales($opcion,$idEmpresa){

        $this->_query = " 
        select 
          a.idarticulo,
          a.nombre_articulo,
          a.idcolor,
          b.nombre_catalogo,
          b.descripcion_catalogo,
          a.idusuario_alta,
          c.nick_name,
          a.fecha_alta
        from 
          articulos as a 
        JOIN catalogo_general as b 
          ON a.idcolor = b.opc_catalogo AND b.idcatalogo = 4  AND b.idestado = 1
        JOIN perfil_usuarios as c 
          ON a.idusuario_alta = c.idusuario 
        where 
          a.tipo = 2 AND
          a.idempresa = $idEmpresa AND
          a.idestado = 1 ORDER BY a.nombre_articulo DESC
        ";

        $this->get_result_query();

        return $this->_rows ;


    }

}