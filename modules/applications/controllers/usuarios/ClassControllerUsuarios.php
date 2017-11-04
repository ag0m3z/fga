<?php

/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 30/05/2017
 * Time: 04:41 PM
 */

include "../../../../core/seguridad.class.php";

class ClassControllerUsuarios extends \core\seguridad
{


    public function get_list($opcion,$idusuario){

            $this->_query = "SELECT 
                                a.idusuario,concat_ws(' ',b.nombre,b.apaterno,b.amaterno)as NombreCompleto,
                                a.iddepartamento,c.nombre_departamento,d.descripcion_catalogo,a.correo as UsuarioLogin,a.fecha_alta
                            FROM usuarios as a 
                            LEFT JOIN perfil_usuarios as b
                            ON a.idusuario = b.idusuario 
                            left JOIN departamentos as c 
                            ON a.iddepartamento = c.iddepartamento 
                            left join catalogo_general as d 
                            on a.idtipo_usuario = d.opc_catalogo AND d.idcatalogo = 5 
                             ORDER BY a.fecha_alta DESC ";

        $this->get_result_query();
        return $this->_rows;

    }


    public function  set_usuario($data_array = array()){


        if(
            array_key_exists('nombre',$data_array) &&
            array_key_exists('apaterno',$data_array) &&
            array_key_exists('amaterno',$data_array) &&
            array_key_exists('departamento',$data_array) &&
            array_key_exists('nickname',$data_array) &&
            array_key_exists('usuario_login',$data_array) &&
            array_key_exists('clave1',$data_array) &&
            array_key_exists('clave2',$data_array) &&
            array_key_exists('perfil',$data_array)

        ){

            //Validar que no exista ya el usuario

            $this->_query = "SELECT correo FROM usuarios WHERE correo = '$data_array[usuario_login]' ";
            $this->get_result_query();

            if(count($this->_rows) > 0){
                $this->_confirm = false;
                $this->_message = "El usuario ya se encuentra registrado";
            }else{

                 $this->_query = "
                call sp_registra_usuario(
                '1',
                '0',
                '$data_array[idempresa]',
                '$data_array[departamento]',
                '$data_array[perfil]',
                '$data_array[usuario_login]',
                '$data_array[clave1]',
                '$data_array[clave2]',
                '$data_array[intentos]',
                '$data_array[idestado]',
                '$data_array[idusuario_alta]',
                '$data_array[fecha_alta]'
                )";

                $this->get_result_query();
                $idUsuario = $this->_rows[0][0];

                 $this->_query = "
                INSERT INTO perfil_usuarios VALUES ('','$idUsuario','$data_array[nombre]','$data_array[apaterno]','$data_array[amaterno]','$data_array[nickname]',
                '$data_array[telefono]','$data_array[cecular]','default.png','$data_array[fecha_alta]','$data_array[fecha_alta]')";
                $this->execute_query();

                $this->_confirm = true;
                $this->_message = $idUsuario;


            }


        }else{
                $this->_confirm = false;
                $this->_message = "Error no se encontraron los parametros para el registro";
        }


    }

}