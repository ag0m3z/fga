<?php
/**
 * Created by PhpStorm.
 * User: USUARIO
 * Date: 28/04/2017
 * Time: 12:22 AM
 */
include "../../../../core/seguridad.class.php";

class ClassControllerClientes extends \core\seguridad
{
    protected $idcliente;
    protected $nombre_completo;
    protected $telefono;
    protected $celular;
    protected $correo;
    protected $UsuarioAlta;
    protected $UsuarioUM;
    protected $fecha_alta;
    protected $fecha_um;
    protected $idestado;

    public function getIDCliente(){return $this->idcliente;}
    public function getNombreCliente(){return $this->nombre_completo;}
    public function getTelefono(){return $this->telefono ;}
    public function getCelular(){return $this->celular;}
    public function getCorreo(){return $this->correo;}
    public function getUsuarioAlta(){return $this->UsuarioAlta;}
    public function getUsuarioUM(){return $this->UsuarioUM;}
    public function getFechaAlta(){return $this->fecha_alta;}
    public function getFechaUM(){return $this->fecha_um;}
    public function getIDEstado(){return $this->idestado;}

    public function set_cliente($data_array = array()){

        if(array_key_exists('nombre_cliente',$data_array) && array_key_exists('idempresa',$data_array) ){

            //validar que exista el cliente

            $this->_query = "SELECT nombre_completo FROM clientes WHERE nombre_completo = '$data_array[nombre_cliente]' and idempresa = '$data_array[idempresa]' ";
            $this->get_result_query();

            if(count($this->_rows) > 0 ){
                $this->_confirm = false;
                $this->_message = "El cliente ".$data_array['nombre_cliente']." ya se encuentra registrado.";
            }else{

                $this->_query =
                    "call sp_registra_cliente(
                    '1',
                    '0',
                    '$data_array[idempresa]',
                    '$data_array[nombre_cliente]',
                    '$data_array[correo]',
                    '$data_array[telefono]',
                    '$data_array[celular]',
                    '$data_array[idestado]',
                    '$data_array[idusuario_alta]',
                    '$data_array[fecha_alta]'
                    )";
                $this->execute_query();

                $this->_confirm = true;
                $this->_message = "cliente registrado correctamente";

            }

        }else{
            $this->_confirm = false;
            $this->_message = "Error no se encontraron los datos para registrar el cliente en: ClassControlleCliente ";
        }

    }
    public function get_cliente($idcliente,$idempresa){

        if($idcliente != '' && $idempresa != ''){

            $this->_query = "SELECT 
                            a.idcliente,a.nombre_completo,
                            a.telefono,a.celular,a.correo,
                            a.idusuario_alta,b.nick_name as UsuarioAlta,a.idusuario_um,c.nick_name as UsuarioUM,
                            a.fecha_alta,a.fecha_um,a.idestado 
                        FROM clientes as a 
                        LEFT JOIN perfil_usuarios as b 
                        ON a.idusuario_alta = b.idusuario 
                        LEFT JOIN perfil_usuarios as c 
                        ON a.idusuario_um = c.idusuario WHERE a.idcliente = '$idcliente' AND a.idempresa = '$idempresa' ORDER BY a.fecha_alta DESC ";

            $this->get_result_query();

        }

        if(count($this->_rows) == 1){

            foreach ($this->_rows[0] as $campo => $valor){
                $this->$campo = $valor ;
            }

            $this->_confirm = true ;
            $this->_message = "Se encontro el cliente";

        }else{
            $this->_confirm = false ;
            $this->_message = "No se encontro el cliente" ;
        }

    }
    public function edit_cliente($data_array=array()){

        if(array_key_exists('idempresa',$data_array) || array_key_exists('idcliente',$data_array) || array_key_exists('nombre_cliente',$data_array) ){

            //validar que no exita ya el proveeodr
            $this->_query = "SELECT nombre_completo FROM clientes WHERE nombre_completo = '$data_array[nombre_cliente]' AND idcliente != '$data_array[idcliente]' AND idempresa = '$data_array[idempresa]' ";
            $this->get_result_query();

            if(count($this->_rows) >= 1 ){

                $this->_confirm = false ;
                $this->_message = "el cliente ya existe";

            }else{
                //editar el cliente
                $this->_query =
                    "call sp_registra_cliente(
                    '2',
                    '$data_array[idcliente]',
                    '$data_array[idempresa]',
                    '$data_array[nombre_cliente]',
                    '$data_array[correo]',
                    '$data_array[telefono]',
                    '$data_array[celular]',
                    '$data_array[idestado]',
                    '$data_array[idusuario_alta]',
                    '$data_array[fecha_alta]'
                    )";
                $this->execute_query();

                $this->_confirm = true;
                $this->_message = "cliente editado correctamente";
            }
        }else{
            $this->_confirm = false ;
            $this->_message = "No se encontraron los datos para editar el cliente";
        }

    }

    public function get_list($opcion,$idempresa){

        $this->_query = "SELECT 
                            a.idcliente,a.nombre_completo,
                            a.telefono,a.celular,a.correo,
                            a.idusuario_alta,b.nick_name as UsuarioAlta,a.idusuario_um,c.nick_name as UsuarioUM,
                            a.fecha_alta,a.fecha_um,a.idestado 
                        FROM clientes as a 
                        LEFT JOIN perfil_usuarios as b 
                        ON a.idusuario_alta = b.idusuario 
                        LEFT JOIN perfil_usuarios as c 
                        ON a.idusuario_um = c.idusuario WHERE a.idempresa = '$idempresa' ORDER BY a.fecha_alta DESC ";

        $this->get_result_query();
        return $this->_rows;

    }


}