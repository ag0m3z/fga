<?php
/**
 * Created by PhpStorm.
 * User: USUARIO
 * Date: 01/05/2017
 * Time: 09:50 AM
 */
include "../../../../core/seguridad.class.php";
class ControllerDepartamentos extends \core\seguridad {

    protected $iddepartamento;
    protected $nombre_departamento;
    protected $idalmacen;
    protected $nombre_almacen;
    protected $total_cajas;
    protected $domicilio;
    protected $correo;
    protected $telefono01;
    protected $telefono02;
    protected $celular;
    protected $horario_semanal;
    protected $horario_findesemana;
    protected $idusuario_alta;
    protected $UsuarioAlta;
    protected $idusuario_um;
    protected $UsuarioUM;
    protected $fecha_alta;
    protected $fecha_um;
    protected $idestado;

    public function getIDDepartamento (){return $this->iddepartamento;}
    public function getNombreDepartamento(){return $this->nombre_departamento;}
    public function getIDAlmacen(){return $this->idalmacen ;}
    public function getNombreAlmacen(){return $this->nombre_almacen;}
    public function getTotalCajas(){return $this->total_cajas;}
    public function getDomicilio(){return $this->domicilio ;}
    public function getCorreo(){return $this->correo ;}
    public function getTelefono01(){return $this->telefono01;}
    public function getTelefono02(){return $this->telefono02;}
    public function getCelular(){return $this->celular ;}
    public function getHorarioSemanal(){return $this->horario_semanal;}
    public function getHorarioFindeSemana(){return $this->horario_findesemana;}
    public function getFechaAlta(){return $this->fecha_alta;}
    public function getFechaUM(){return $this->fecha_um;}
    public function getUsuarioAlta(){return $this->UsuarioAlta;}
    public function getUsuarioUM(){return $this->UsuarioUM ;}
    public function getIDEstado(){return $this->idestado;}

    public function set_departamentos($data_array = array()){

        if( array_key_exists('idempresa',$data_array) &&
            array_key_exists('nombre_departamento',$data_array) &&
            array_key_exists('idalmacen',$data_array) &&
            array_key_exists('total_cajas',$data_array) &&
            array_key_exists('domicilio',$data_array)
        ){
            //Validar que no exista ya el nombre del departamento

            $this->_query = "
            SELECT nombre_departamento FROM departamentos
            WHERE idempresa = '$data_array[idempresa]' AND nombre_departamento = '$data_array[nombre_departamento]'
            ";
            $this->get_result_query();

            if(count($this->_rows) > 0 ){
                $this->_confirm = false;
                $this->_message = "Error el nombre del departamento ya existe";
            }else{

                //Registrar departamento
                $this->_query = "
                call sp_registra_sucursal(
                '1',
                '$data_array[idempresa]',
                '0',
                '$data_array[nombre_departamento]',
                'S',
                '0',
                '$data_array[idalmacen]',
                '$data_array[total_cajas]',
                '$data_array[domicilio]',
                '$data_array[telefono01]',
                '$data_array[telefono02]',
                '$data_array[celular]',
                '$data_array[correo]',
                '$data_array[horario_semanal]',
                '$data_array[horario_findesemana]',
                '1',
                '$data_array[idusuario_alta]',
                '$data_array[fecha_alta]'
                )
                ";
                $this->execute_query();
                $this->_confirm = true;
                $this->_message = "Departamento registrado correctamente";

            }

        }else{
            $this->_confirm = false;
            $this->_message = "Error parametros no encotrados para el registro del departamento";
        }


    }
    public function get_departamentos($iddepartamento='',$idempresa = ''){

        if($iddepartamento != '' && $idempresa != "" ){
            $this->_query = "
            SELECT
              a.iddepartamento,
              a.idempresa,
              a.nombre_departamento,
              a.idalmacen,
              b.nombre_almacen,
              a.total_cajas,
              a.domicilio,
              a.correo,
              a.telefono01,
              a.telefono02,
              a.celular,
              a.horario_semanal,
              a.horario_findesemana,
              a.idusuario_alta,
              c.nick_name as UsuarioAlta,
              a.fecha_alta,
              a.idusuario_um,
              d.nick_name as UsuarioUM,
              a.fecha_um,
              a.idestado
            FROM departamentos as a
            LEFT JOIN almacen as b
              ON a.idalmacen = b.idalmacen
            LEFT JOIN perfil_usuarios as c
              ON a.idusuario_alta = c.idusuario
            LEFT JOIN perfil_usuarios as d
              ON a.idusuario_um = d.idusuario
            WHERE
              a.idempresa = '$idempresa' AND
              a.iddepartamento = '$iddepartamento'
            ";
            $this->get_result_query();

            if(count($this->_rows) == 1){

                foreach ($this->_rows[0] as $campo => $valor){
                    $this->$campo = $valor ;
                }

                $this->_confirm = true ;
                $this->_message = "Se encontro el departamento";

            }else{
                $this->_confirm = false ;
                $this->_message = "No se encontro el departamento" ;
            }

        }else{

            $this->_confirm = false;
            $this->_message = "Error no se encontraron los parametros";

        }

    }
    public function edit_departamentos($data_array = array()){

        if(
            array_key_exists('iddepartamento',$data_array) &&
            array_key_exists('idempresa',$data_array) &&
            array_key_exists('nombre_departamento',$data_array) &&
            array_key_exists('idalmacen',$data_array) &&
            array_key_exists('total_cajas',$data_array) &&
            array_key_exists('domicilio',$data_array)
        ){

            //validar que no exita ya el proveeodr
            $this->_query = "SELECT nombre_completo FROM clientes WHERE nombre_completo = '$data_array[nombre_cliente]' AND idcliente != '$data_array[idcliente]' AND idempresa = '$data_array[idempresa]' ";
            $this->get_result_query();

            if(count($this->_rows) >= 1 ){

                $this->_confirm = false ;
                $this->_message = "el cliente ya existe";

            }else{
                //editar el cliente
                //Registrar departamento
                $this->_query = "
                call sp_registra_sucursal(
                '2',
                '$data_array[idempresa]',
                '$data_array[iddepartamento]',
                '$data_array[nombre_departamento]',
                'S',
                '0',
                '$data_array[idalmacen]',
                '$data_array[total_cajas]',
                '$data_array[domicilio]',
                '$data_array[telefono01]',
                '$data_array[telefono02]',
                '$data_array[celular]',
                '$data_array[correo]',
                '$data_array[horario_semanal]',
                '$data_array[horario_findesemana]',
                '$data_array[idestado]',
                '$data_array[idusuario_alta]',
                '$data_array[fecha_alta]'
                )
                ";
                $this->execute_query();
                $this->_confirm = true;
                $this->_message = "Departamento editado correctamente";
            }
        }else{
            $this->_confirm = false ;
            $this->_message = "No se encontraron los datos para editar el cliente";
        }

    }
    public function get_list($opcion,$idempresa){

        $this->_query = "
        SELECT
          iddepartamento,
          nombre_departamento,
          tipo,encargado,idalmacen,domicilio,telefono01,telefono02,celular,correo,horario_semanal,horario_findesemana,
          idusuario_alta,fecha_alta,idusuario_um,fecha_um
        FROM departamentos
        WHERE idestado = 1 AND idempresa = '$idempresa' ORDER BY fecha_alta DESC
        ";
        $this->get_result_query();

        return $this->_rows;

    }

}