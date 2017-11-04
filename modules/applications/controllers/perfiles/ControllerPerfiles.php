<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 29/04/2017
 * Time: 09:11 AM
 */

include "../../../../core/seguridad.class.php";

class ControllerPerfiles extends \core\seguridad
{
    protected $idempresa;
    protected $opc_catalogo;
    protected $nombre_catalogo;
    protected $descripcion_catalogo;
    protected $idusuario_alta;
    protected $UsuarioAlta;
    protected $idusuario_um;
    protected $UsuarioUM;
    protected $fecha_alta;
    protected $fecha_um;
    protected $idestado;

    public function getIDEmpresa(){return $this->idempresa;}
    public function getNombrePerfil(){return $this->nombre_catalogo;}
    public function getDescripcion(){return $this->descripcion_catalogo;}
    public function getIDUsuarioAlta(){return $this->idusuario_alta;}
    public function getUsuarioAlta(){return $this->UsuarioAlta ;}
    public function getUsuarioUM(){return $this->UsuarioUM;}
    public function getFechaAlta(){return $this->fecha_alta;}
    public function getFechaUM(){return $this->fecha_um;}
    public function getIDEstado(){return $this->idestado;}

    public function set_perfil($data_array = array()){
        //Funcion para registrar los nuevos perfiles

        if(
            array_key_exists('nombre_perfil',$data_array) &&
            array_key_exists('idempresa',$data_array)
        ){
            //Validar que no exista ya el perfil

            $this->_query = "SELECT nombre_catalogo FROM catalogo_general WHERE idempresa = '$data_array[idempresa]' AND idcatalogo = 5 AND nombre_catalogo = '$data_array[nombre_perfil]' ";
            $this->get_result_query();

            if( count($this->_rows) > 0 ){
                $this->_confirm = false;
                $this->_message = "El nombre del perfil <b>".$data_array['nombre_perfil']."</b> ya existe";
            }else{

                $this->_query = "SELECT IFNULL(MAX(opc_catalogo), 0) + 1 FROM catalogo_general WHERE idempresa = '$data_array[idempresa]' AND idcatalogo = 5 ";
                $this->get_result_query();

                if(count($this->_rows) > 0 ){

                    $idPerfil = $this->_rows[0][0];

                    $this->_query =
                        "
                    INSERT INTO catalogo_general (
                    idcatalogo,
                    idempresa,
                    opc_catalogo,
                    opc_catalogo2,
                    opc_catalogo3,
                    nombre_catalogo,
                    descripcion_catalogo,
                    idestado,
                    idusuario_alta,
                    fecha_alta
                    ) 
                    VALUES (
                    '5',
                    '$data_array[idempresa]',
                    '$idPerfil',
                    '0',
                    '0',
                    '$data_array[nombre_perfil]',
                    '$data_array[descripcion]',
                    '$data_array[idestado]',
                    '$data_array[idusuario_alta]',
                    '$data_array[fecha_alta]'                    
                    )
                    ";
                    $this->execute_query();
                    $this->_confirm = true;
                    $this->_message = "Perfil registrado correctamente";
                }elsE{

                    $this->_confirm = false;
                    $this->_message = "Error no se encontraron los parametros para el registro del nuevo perfil.";

                }

            }

        }else{
            $this->_confirm = false;
            $this->_message = "Error no se encontraron los parametros para el registro del nuevo perfil.";
        }

    }
    public function get_perfil($idperfil='',$idempresa = ''){

        if($idperfil != '' && $idempresa != '' ){

            $this->_query = "SELECT 
                              a.idempresa,
                              a.opc_catalogo,
                              a.nombre_catalogo,
                              a.descripcion_catalogo,
                              a.idusuario_alta,
                              b.nick_name as UsuarioAlta,
                              a.idusuario_um,
                              c.nick_name as UsuarioUM,
                              a.fecha_alta,
                              a.fecha_um,
                              a.idestado
                            FROM 
                              catalogo_general as a 
                              LEFT JOIN perfil_usuarios as b 
                                ON a.idusuario_alta = b.idusuario 
                              LEFT JOIN perfil_usuarios as c 
                                ON a.idusuario_um = c.idusuario
                            WHERE 
                              a.idcatalogo = 5 AND 
                              a.idempresa = '$idempresa' AND a.opc_catalogo = '$idperfil' ORDER BY a.fecha_alta DESC
                        ";

            $this->get_result_query();


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

        }else{
            $this->_confirm = false;
            $this->_message = "Error no se encontro el identificador del perfil, para realizar los cambios";
        }


    }
    public function edit_perfil($data_array = array()){

        if(array_key_exists('nombre_perfil',$data_array) && array_key_exists('idempresa',$data_array) && array_key_exists('idperfil',$data_array)){

            //validar que no exista ya el nombre
            $this->_query = "select nombre_catalogo from catalogo_general WHERE opc_catalogo != '$data_array[idperfil]' AND idcatalogo = 5 AND idempresa = '$data_array[idempresa]'  AND nombre_catalogo = '$data_array[nombre_perfil]' ";
            $this->get_result_query();

            if(count($this->_rows) > 0 ){
                $this->_confirm = false;
                $this->_message = "El nombre del perfil ".$data_array['nombre_perfil']." ya existe";
            }else{

                $this->_query = "
                UPDATE catalogo_general
                    SET
                      nombre_catalogo = '$data_array[nombre_perfil]',
                      descripcion_catalogo = '$data_array[descripcion]',
                      idestado = '$data_array[idestado]',
                      fecha_um = '$data_array[fecha_um]',
                      idusuario_um = '$data_array[idusurio_um]'
                WHERE idempresa = '$data_array[idempresa]' AND idcatalogo = 5 AND opc_catalogo = '$data_array[idperfil]'
                ";
                $this->execute_query();
                $this->_confirm = true;
                $this->_message = "Perfil editado correctamente";
            }

        }else{
            $this->_confirm = false;
            $this->_message = "Error no se encontro el identificador del perfil, para realizar los cambios";
        }

    }


    public function get_list($opcion = 1,$idempresa){

        $this->_query = "
            SELECT 
              idempresa,
              opc_catalogo,
              nombre_catalogo,
              descripcion_catalogo,
              idusuario_alta,
              fecha_alta,
              idestado
            FROM 
              catalogo_general 
            WHERE 
              idcatalogo = 5 AND 
              idempresa = '$idempresa' AND idestado = 1 ORDER BY fecha_alta DESC
         ";

        $this->get_result_query();
        return $this->_rows ;

    }

}