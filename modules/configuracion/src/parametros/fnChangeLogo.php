<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 28/10/2017
 * Time: 02:23 AM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";

include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();


// Declaracion de Variables para localizar las Carpetas
$upload_folder =  "../../../../site_design/img/logos/";

// Variables para sacar la Informacion del Archivo a Subir.
$nombre_archivo = $_FILES['archivo']['name'];
$tipo_archivo = $_FILES['archivo']['type'];
$tamano_archivo = $_FILES['archivo']['size'];
$tmp_archivo = $_FILES['archivo']['tmp_name'];
$Archivo = $_FILES['archivo'];

//Sacar la Extencion del Archivo a Subir.
$extension = pathinfo($Archivo['name'], PATHINFO_EXTENSION);

//Extenciones Permitidas
$extension_permitidas = array('jpg','gif','png','JPG','GIF','PNG');

$partes_nombre = explode(".",$nombre_archivo);
$extension2 = end( $partes_nombre );

if(in_array($extension2, $extension_permitidas)){

    //Validar que el Archivo no Este Dañado o Corrupto
    if($_FILES['archivo']['error']>0){
        \core\core::MyAlert( "Error al Subir el Archivo ".$_FILES['archivo']['error'],"alert");
    }else{

        $nombreFoto = "LogoEmpresa.$extension";
        $archivador = $upload_folder."LogoEmpresa.$extension";
        
        if(!move_uploaded_file($tmp_archivo,$archivador)){
            \core\core::MyAlert( "Error al mover el Archivo ".$_FILES['archivo']['error'],"alert");
        }else{

            $connect->_query = "
            UPDATE empresas
                SET logotipo = '$nombreFoto',
                    fecha_um = now()
            WHERE idempresa = 1
            ";

            $connect->execute_query();


        }

    }

}else{
    \core\core::MyAlert("Tipo de documento invalido, Int&eacute;ntelo nuevamente","alert");
}

