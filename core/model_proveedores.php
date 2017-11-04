<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 16/04/2017
 * Time: 09:42 PM
 */

namespace core;
include "seguridad.class.php";

class model_proveedores extends seguridad
{
    protected $idempresa;
    protected $idproveedor;
    protected $nombre_proveedor;
    protected $descripcion_proveedor;
    protected $telefono01;
    protected $telefono02;
    protected $correo;
    protected $celular;
    protected $direccion;
    protected $idestado;
    protected $fecha_alta;
    protected $usuario_alta;
    protected $fecha_um;
    protected $usuario_um;

    public function getNombreProveedor(){return $this->nombre_proveedor;}
    public function getDescripcionProveedor(){return $this->descripcion_proveedor;}
    public function getTelefono1(){return $this->telefono01;}
    public function getTelefono2(){return $this->telefono02;}
    public function getCorreo(){return $this->correo;}
    public function getCelular(){return $this->celular;}
    public function getDireccion(){return $this->direccion;}

    public function getUsuarioAlta(){return $this->usuario_alta;}
    public function getUsuarioUM(){return $this->usuario_um;}
    public function getFechaAlta(){return $this->fecha_alta;}
    public function getFechaUM(){return $this->fecha_um;}
    public function getNoEstado(){return $this->idestado;}

    public function set_proveedor($data_array = array()){

        if(
            array_key_exists('idempresa',$data_array) ||
            array_key_exists('nombre_proveedor',$data_array) ||
            array_key_exists('direccion_proveedor',$data_array) ||
            array_key_exists('descripcion_proveedor',$data_array)
        ){
            //validar que no exista ya el proveedor
            $this->_query = "
                  SELECT nombre_proveedor 
                  FROM proveedores 
                  where 
                    nombre_proveedor = '$data_array[nombre_proveedor]' AND 
                    idempresa = '$data_array[idempresa]' 
            ";

            $this->get_result_query();

            if(count($this->_rows) >= 1 ){

                $this->_confirm = false;
                $this->_message = "El nombre del proveedor ya existe";

            }else{

                echo $this->_query = "
                INSERT INTO proveedores VALUES 
                (
                0,
                '$data_array[idempresa]',
                '$data_array[nombre_proveedor]',
                '$data_array[descripcion_proveedor]',
                '$data_array[telefono1_proveedor]',
                '$data_array[telefono2_proveedor]',
                '$data_array[telefono3_proveedor]',
                '$data_array[celular_proveedor]',
                '$data_array[correo_proveedor]',
                '$data_array[direccion_proveedor]',
                '$data_array[idestado]',
                '$data_array[idusuario_alta]',
                '$data_array[idusuario_alta]',
                '$data_array[fecha_alta]',
                '$data_array[fecha_alta]'
                )
                ";
                $this->execute_query();
                $this->_confirm = true;

            }

        }else{
            $this->_confirm = false;
            $this->_message = "Error al recibir los parametros";
        }

    }

    public function get_proveedor($idProveedor,$idEmpresa){

        //funcion para  traer la informacion del proveedor;
        if($idProveedor != '' || $idEmpresa != ''){

            $this->_query =
                "
                select 
                  idproveedor,
                  idempresa,
                  nombre_proveedor,
                  descripcion_proveedor,
                  telefono01,
                  telefono02,
                  correo,
                  celular,
                  direccion,
                  idestado,
                  fecha_alta,
                  fecha_um,
                  idusuario_alta,
                  idusuario_um
                from 
                  proveedores 
                WHERE 
                  idproveedor = $idProveedor AND
                  idempresa = '$idEmpresa' 
                ORDER BY nombre_proveedor DESC 
                ";

            $this->get_result_query();

        }

        if(count($this->_rows) == 1){

            foreach ($this->_rows[0] as $campo => $valor){
                $this->$campo = $valor ;
            }

            $this->_confirm = true ;
            $this->_message = "Se encontro el proveedor";

        }else{
            $this->_confirm = false ;
            $this->_message = "No se encontro el proveedor" ;
        }

    }

    public function edit_proveedor($data_array = array()){

        if(array_key_exists('idempresa',$data_array) || array_key_exists('idproveedor',$data_array) || array_key_exists('nombre_proveedor',$data_array) ){

            //validar que no exita ya el proveeodr
            $this->_query = "SELECT nombre_proveedor FROM proveedores WHERE nombre_proveedor = '$data_array[nombre_proveedor]' AND idproveedor != '$data_array[idproveedor]' AND idempresa = '$data_array[idempresa]' ";
            $this->get_result_query();

            if(count($this->_rows) >= 1 ){

                $this->_confirm = false ;
                $this->_message = "el proveedor ya existe";

            }else{
                //editar el proveedor
                unset($this->_rows) ;
                $FechaAlta = date("Y-m-d H:i:s");

                $this->_query =
                    "UPDATE proveedores 
                      SET 
                        nombre_proveedor = '$data_array[nombre_proveedor]',
                        descripcion_proveedor = '$data_array[descripcion_proveedor]',
                        telefono01 = '$data_array[telefono01]',
                        telefono02 = '$data_array[telefono02]',
                        celular = '$data_array[celular]',
                        correo = '$data_array[correo]',
                        direccion = '$data_array[direccion]',
                        idestado = '$data_array[idestado]',
                        idusuario_um = '$data_array[idusuario_um]',
                        fecha_um = '$FechaAlta'
                      WHERE 
                        idproveedor = '$data_array[idproveedor]' AND 
                        idempresa = '$data_array[idempresa]' 
                    ";


                $this->execute_query();
                $this->_confirm = true;
                $this->_message = "proveedor editado correctamente";
            }
        }else{
            $this->_confirm = false ;
            $this->_message = "No se encontraron los datos para editar el proveedor";
        }

    }

    public function get_lista_proveedores($opcion,$idEmpresa){

        $this->_query =
            "
            select 
              idproveedor,
              idempresa,
              nombre_proveedor,
              descripcion_proveedor,
              telefono01,
              telefono02,
              correo,
              celular,
              direccion,
              fecha_alta
            from 
              proveedores 
            WHERE 
              idempresa = '$idEmpresa' AND 
              idestado = 1 
            ORDER BY idproveedor DESC ";

        $this->get_result_query();
        return $this->_rows ;


    }

}