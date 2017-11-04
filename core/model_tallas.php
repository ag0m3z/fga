<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 16/04/2017
 * Time: 02:02 PM
 */

namespace core;
include_once "seguridad.class.php";

class model_tallas extends seguridad
{
    protected $idempresa;
    protected $opc_catalogo;
    protected $nombre_catalogo;
    protected $descripcion_catalogo;
    protected $idestado;
    protected $fecha_alta;
    protected $idusuario_alta;
    protected $fecha_um;
    protected $idusuario_um;


    public function getNombreTalla(){return $this->nombre_catalogo;}
    public function getDescripcionTalla(){return $this->descripcion_catalogo;}
    public function getUsuarioAlta(){return $this->idusuario_alta;}
    public function getUsuarioUM(){return $this->idusuario_um;}
    public function getFechaAlta(){return $this->fecha_alta;}
    public function getFechaUM(){return $this->fecha_um;}
    public function getNoEstado(){return $this->idestado;}


    public function set_talla($data_array = array()){

        if( array_key_exists('idempresa',$data_array) || array_key_exists('nombre_talla',$data_array) || array_key_exists('descripcion_talla',$data_array)){

            //validar que no exista ya la categoria
            $this->_query = "SELECT nombre_catalogo FROM catalogo_general where nombre_catalogo = '$data_array[nombre_talla]' AND idcatalogo = 3 AND idempresa = '$data_array[idempresa]' ";
            $this->get_result_query();

            if(count($this->_rows) >= 1 ){

                $this->_confirm = false;
                $this->_message = "El nombre de la talla ya existe";

            }else{

                $this->_query = "SELECT count(opc_catalogo) + 1 FROM catalogo_general where idcatalogo = 3 AND idempresa = '$data_array[idempresa]' ";
                $this->get_result_query();

                $idTalla = $this->_rows[0][0];

                $this->_query = "
                INSERT INTO catalogo_general VALUES 
                (
                '3',
                '$data_array[idempresa]',
                '$idTalla',
                '0',
                '0',
                '$data_array[nombre_talla]',
                '$data_array[descripcion_talla]',
                '0',
                '0',
                '0',
                '1',
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

    public function get_talla($idTalla,$idEmpresa){

        //funcion para  traer la informacion de las tallas;

        if($idTalla != '' || $idEmpresa != ''){

            $this->_query = "
                    SELECT a.idempresa,a.opc_catalogo,a.nombre_catalogo,a.descripcion_catalogo,a.idestado,a.fecha_alta,b.nick_name as idusuario_alta,a.fecha_um,c.nick_name as idusuario_um 
                    FROM catalogo_general as a 
                    LEFT JOIN perfil_usuarios as b 
                    ON a.idusuario_alta = b.idusuario 
                     LEFT JOIN perfil_usuarios as c 
                    ON a.idusuario_um = c.idusuario 
                    WHERE  a.idcatalogo = 3 AND a.idempresa = '$idEmpresa' AND a.opc_catalogo = '$idTalla' ";

            $this->get_result_query();

        }

        if(count($this->_rows) == 1){

            foreach ($this->_rows[0] as $campo => $valor){
                $this->$campo = $valor ;
            }

            $this->_confirm = true ;
            $this->_message = "Se encontro la talla";

        }else{
            $this->_confirm = false ;
            $this->_message = "No se encontro la talla" ;
        }

    }

    public function edit_talla($data_array = array()){

        if(array_key_exists('idempresa',$data_array) || array_key_exists('idtalla',$data_array) || array_key_exists('nombre_talla',$data_array) ){
            //Validar que la categoria no exista

            //validar que no exita ya la categoría
            $this->_query = "SELECT nombre_catalogo FROM catalogo_general WHERE  nombre_catalogo = '$data_array[nombre_talla]' AND opc_catalogo != '$data_array[idtalla]'  AND idempresa = '$data_array[idempresa]' AND idcatalogo = 3 ";
            $this->get_result_query();

            if(count($this->_rows) >= 1 ){

                $this->_confirm = false ;
                $this->_message = "La talla ya existe";

            }else{
                //editar la categoria
                unset($this->_rows) ;
                $FechaAlta = date("Y-m-d H:i:s");

                $this->_query =
                    "UPDATE catalogo_general 
                      SET 
                        nombre_catalogo = '$data_array[nombre_talla]',
                        descripcion_catalogo = '$data_array[descripcion_talla]',
                        idestado = '$data_array[idestado]',
                        idusuario_um = '$data_array[idusuario_um]',
                        fecha_um = '$FechaAlta'
                      WHERE 
                        opc_catalogo = '$data_array[idtalla]' AND 
                        idempresa = '$data_array[idempresa]' AND 
                        idcatalogo = 3 AND 
                        opc_catalogo2 = 0 AND opc_catalogo3 = 0
                    ";


                $this->execute_query();
                $this->_confirm = true;
                $this->_message = "talla editada correctamente";
            }
        }else{
            $this->_confirm = false ;
            $this->_message = "No se encontraron los datos para editar la talla";
        }

    }

    public function get_lista_tallas($opcion,$idEmpresa){

        $this->_query = "select opc_catalogo,idempresa,nombre_catalogo,descripcion_catalogo,fecha_alta,fecha_um,idestado from catalogo_general WHERE idcatalogo = 3 AND idempresa = '$idEmpresa' AND idestado = 1 ORDER BY opc_catalogo DESC ";
        $this->get_result_query();

        return $this->_rows ;


    }

}