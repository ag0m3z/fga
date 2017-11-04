<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 16/04/2017
 * Time: 04:30 PM
 */

namespace core;
include "seguridad.class.php";

class model_almacen extends seguridad
{
    protected $idalmacen;
    protected $idempresa;
    protected $nombre_almacen;
    protected $descripcion;
    protected $idestado;
    protected $fecha_alta;
    protected $usuario_alta;
    protected $fecha_um;
    protected $usuario_um;
    protected $opcion_traspaso;

    public function getNombreAlmacen(){return $this->nombre_almacen;}
    public function getDescripcionAlmacen(){return $this->descripcion;}
    public function getUsuarioAlta(){return $this->usuario_alta;}
    public function getUsuarioUM(){return $this->usuario_um;}
    public function getFechaAlta(){return $this->fecha_alta;}
    public function getFechaUM(){return $this->fecha_um;}
    public function getNoEstado(){return $this->idestado;}
    public function getOpcionTraspaso(){return $this->opcion_traspaso;}

    public function set_almacen($data_array = array()){

        if( array_key_exists('idempresa',$data_array) || array_key_exists('nombre_almacen',$data_array) || array_key_exists('descripcion_almacen',$data_array)){

            //validar que no exista ya el almacén
            $this->_query = "SELECT nombre_almacen FROM almacen where nombre_almacen = '$data_array[nombre_almacen]' AND idempresa = '$data_array[idempresa]' ";
            $this->get_result_query();

            if(count($this->_rows) >= 1 ){

                $this->_confirm = false;
                $this->_message = "El nombre del almacén ya existe";

            }else{

                $this->_query = "
                INSERT INTO almacen 
                    VALUES  
                    (
                    0,
                    '$data_array[idempresa]',
                    '$data_array[nombre_almacen]',
                    '$data_array[descripcion_almacen]',
                    '$data_array[opcion_traspaso]',
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

    public function get_almacen($idAlmacen,$idEmpresa){

        if($idAlmacen != ''){

            $this->_query = "
                SELECT 
                    a.idalmacen,a.idempresa,a.nombre_almacen,
                    a.descripcion,a.idestado,a.idusuario_alta,b.nick_name as usuario_alta,
                    a.idusuario_um,c.nick_name as usuario_um,a.fecha_alta,a.fecha_um,a.opcion_traspaso 
                FROM almacen as a 
                LEFT JOIN perfil_usuarios as b
                ON a.idusuario_alta = b.idusuario 
                LEFT JOIN perfil_usuarios as c
                ON a.idusuario_um = c.idusuario 
                WHERE a.idalmacen = $idAlmacen AND idempresa = $idEmpresa 
            ";

            $this->get_result_query();

        }

        if(count($this->_rows) == 1){

            foreach ($this->_rows[0] as $campo => $valor){
                $this->$campo = $valor ;
            }
            $this->_confirm = true ;
            $this->_message = "Se encontro el almacen";

        }else{
            $this->_confirm = false ;
            $this->_message = "No se encontro el almacen" ;
        }

    }

    public function edit_almacen($data_array = array()){

        if(array_key_exists('idempresa',$data_array) || array_key_exists('idalmacen',$data_array) || array_key_exists('nombre_almacen',$data_array) ){

            //validar que no exita ya el almacen
            $this->_query = "SELECT nombre_almacen FROM almacen WHERE  nombre_almacen = '$data_array[nombre_almacen]' AND idalmacen != '$data_array[idalmacen]'  AND idempresa = '$data_array[idempresa]' ";
            $this->get_result_query();

            if(count($this->_rows) >= 1 ){

                $this->_confirm = false ;
                $this->_message = "El almacén ya existe";

            }else{
                //editar la almacén
                unset($this->_rows) ;
                $FechaAlta = date("Y-m-d H:i:s");

                $this->_query =
                    "UPDATE almacen  
                      SET 
                        nombre_almacen = '$data_array[nombre_almacen]',
                        descripcion = '$data_array[descripcion_almacen]',
                        opcion_traspaso = '$data_array[opcion_traspaso]',
                        idestado = '$data_array[idestado]',
                        idusuario_um = '$data_array[idusuario_um]',
                        fecha_um = '$FechaAlta'
                      WHERE 
                        idalmacen = '$data_array[idalmacen]' AND 
                        idempresa = '$data_array[idempresa]'
                    ";

                $this->execute_query();
                $this->_confirm = true;
                $this->_message = "Almacén editada correctamente";
            }
        }else{
            $this->_confirm = false ;
            $this->_message = "No se encontraron los datos para editar el almacén";
        }

    }

    public function get_lista_almacenes($opcion,$idEmpresa){

        $this->_query = "
        SELECT idalmacen,idempresa,nombre_almacen,descripcion,opcion_traspaso,idestado,idusuario_alta,fecha_alta FROM almacen WHERE idempresa = '$idEmpresa' AND idestado = 1 ORDER BY idalmacen DESC
        ";
        $this->get_result_query();

        return $this->_rows ;


    }

}