<?php

namespace core;
include "contenido.class.php";

class seguridad extends contenido
{
    public function loginIn($usuario,$password){

        $this->_query = "SELECT 
                            a.intentos,a.idusuario,a.idempresa,b.nombre_empresa,b.idestado as estado_empresa,
                            c.nombre,c.apaterno,c.amaterno,c.nick_name,a.correo,a.idtipo_usuario,a.idestado,a.pass,
                            b.idservicio,d.tema,d.mayoreo_menudeo,d.fecha_caducidad,e.idalmacen as AlmacenDepartamento,
                            d.costo_trabajo_cp,d.cantidad_mayoreo_cp,d.costo_trabajo_mayoreo_cp,d.costo_trabajo_sp,
                            d.cantidad_mayoreo_sp,
                            d.costo_trabajo_mayoreo_sp,d.pago_minimo_credito,a.iddepartamento,e.nombre_departamento,f.nombre_almacen,
                            b.logotipo,b.descripcion_empresa,b.correo as correoEmpresa
                        FROM usuarios as a
                            LEFT JOIN empresas as b 
                                ON a.idempresa = b.idempresa 
                            LEFT JOIN perfil_usuarios as c 
                                ON a.idusuario = c.idusuario
                            LEFT JOIN sys_config as d 
                            ON a.idempresa = d.idempresa 
                            LEFT JOIN departamentos as e 
                            ON a.iddepartamento = e.iddepartamento 
                             LEFT JOIN almacen as f 
                             ON f.idalmacen = e.idalmacen 
                        WHERE a.correo = '".$usuario."' LIMIT 0,1";

        $this->get_result_query();

        if(count($this->_rows[0]) > 0 ){

            if($this->_rows[0]['intentos'] >= 3 ){

                $this->_confirm = false;
                $this->_message = "Lo sentimos el usuario se encuentra bloqueado, por intentos fallidos";

            }else if($this->_rows[0]['idestado'] == 0  ){

                $this->_confirm = false;
                $this->_message = "El usuario se encuentra desactivado";

            }else if($this->_rows[0]['estado_empresa'] == 0 ){

                $this->_confirm = false;
                $this->_message = "La empresa a la que pertecene no se encuentra activa";

            }else if( $this->_rows[0]['pass'] != md5($password)){
                $this->_confirm = false;
                $this->_message = "La contraseña es incorrecta";

                $Intentos = $this->_rows[0]['intentos'] + 1 ;
                $this->_query = "UPDATE usuarios SET intentos = '$Intentos' WHERE idusuario =  ".$this->_rows[0]['idusuario']." " ;
                $this->execute_query();

            }else{

                $this->_confirm = true;

            }


        }else{

            $this->_confirm = false;
            $this->_message = "El usuario no se encuntra registrado en el sistema";

        }


    }

    public function loginOut(){

    }

    public function valida_session_id($NoUsuario = null ){

        //NoUsuario,init_time,session_id

        if($NoUsuario == null){
            $NoUsuario = $_SESSION['data_login']['idusuario'];
        }

        if(array_key_exists('data_login',$_SESSION)){

            if(!isset($_SESSION['data_login']['idusuario'])){
                session_unset ();
                session_destroy ();
                session_start();
                session_regenerate_id(true);
                echo "<script>location.href ='".core::ROOT_APP()."modules/applications/layout/error/?error=".md5(3)."';</script>";
            }

        }else{
            //no existe session

            session_unset ();
            session_destroy ();
            session_start();
            session_regenerate_id(true);
            echo "<script>location.href ='".core::ROOT_APP()."modules/applications/layout/error/?error=".md5(3)."';</script>";
        }
    }

    public function get_obtener_ip(){

        if($_SERVER['HTTP_X_FORWARDED_FOR']){

            $is_ipaddress = array(
                'LOCAL'=>$_SERVER['REMOTE_ADDR'],
                'PROXY'=>$_SERVER['HTTP_X_FORWARDED_FOR']
            );

        }else{
            $is_ipaddress =  array(
                'LOCAL'=>$_SERVER['REMOTE_ADDR'],
                'PROXY'=>"127.0.0.1"
            );
        }

        return $is_ipaddress ;
    }


}

