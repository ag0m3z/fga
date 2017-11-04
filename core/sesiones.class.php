<?php
namespace core;
error_reporting(0);
date_default_timezone_set('America/Monterrey');

//error_reporting ( E_ALL ^ E_NOTICE );

header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_name("syskro001");
session_start();
session_id();

//DATOS DEL SISTEMA
define("APPVERSION","1.0");

//DATOS DEL USUARIO
define("IDUSUARIO", $_SESSION['data_login']['idusuario']);
define("NICKNAME",$_SESSION['data_login']['nick_name']);

//DATOS DEL DEPARTAMENTO
define("ALMACEN", $_SESSION['data_home']['almacen']);

//DATOS DE LA EMPRESA
define("IDEMPRESA", $_SESSION['data_home']['idempresa']);
define("NOMBREEMPRESA",$_SESSION['data_home']['nombre_empresa']);
define("ALMACENGENERAL", $_SESSION['sys_config']['almacen']);


//CONFIGURACION DE LA EMPRESA







class sesiones
{

    public function set($nombre_array,$datos = array()){

        $_SESSION[$nombre_array] = $datos ;
    }

    public function get($nombre_array,$nombre) {

        if (isset ( $_SESSION [$nombre_array][$nombre] )) {

            return $_SESSION [$nombre_array][$nombre];

        } else {

            return false;

        }
    }

    static function borrar_variable($nombre_array,$nombre) {
        unset ($_SESSION [$nombre_array][$nombre] );
    }

    public function validar_sesion(){

        if(array_key_exists('data_login',$_SESSION)){

            if(!isset($_SESSION['data_login']['idusuario'])){
                $this->delete_sesion();
                return false;
            }else{
                return true;
            }

        }else{
            $this->delete_sesion();
            return false;
        }

    }

    public function delete_sesion() {

        session_unset ();
        session_destroy ();
        session_start();
        session_regenerate_id(true);
    }
}

