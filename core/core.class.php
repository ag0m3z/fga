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

class core
{

    static public  $SkinTheme = 'skin-green';

    public static function  THEME_APP($THEME_APP){

        if($THEME_APP == NULL && $THEME_APP == ""){
            $THEME_APP = self::$SkinTheme;
        }

        return $THEME_APP;
    }

    public static  function ROOT_APP(){
        $ruta = '/fga/' ;

        return $ruta;
    }

    public static function NAMEAPP($NombreApp = 'ikro System'){echo $NombreApp;}
    public static function getTitle($title = "ikro System"){

        print "<title>$title</title>";

    }

    public static function includeCSS($dir_path,$all_folder = false){
        if($all_folder){
            // Recorrer todas las hojas de estilo y agregarlas
            $path = $dir_path;
            $handle=opendir($path);
            if($handle){
                while (false !== ($entry = readdir($handle)))  {
                    if($entry!="." && $entry!=".."){
                        $fullpath = $path.$entry;
                        if(!is_dir($fullpath)){
                            echo "<link rel='stylesheet' type='text/css' href='".$fullpath."' />";

                        }
                    }
                }
                closedir($handle);
            }
        }else{
            // Adjuntar solo la Hoja de Estilo solicitada
            echo "<link rel='stylesheet' type='text/css' href='".$dir_path."' />";
        }
    }

    public static function includeJS($dir_path,$all_folder = false){
        if($all_folder){
            // Agregar todos los js y agregarlos
            $path = $dir_path;
            $handle=opendir($path);
            if($handle){
                while (false !== ($entry = readdir($handle)))  {
                    if($entry!="." && $entry!=".."){
                        $fullpath = $path.$entry;
                        if(!is_dir($fullpath)){

                            echo "<script type='text/javascript' src='".$fullpath."'></script>";

                        }
                    }
                }
                closedir($handle);
            }
        }else{
            // Agregar solo el js Solicitado
            echo "<script type='text/javascript' src='".$dir_path."'></script>";
        }
    }

    public static function returnHome( $nameView =array(),$parametros = array()){

        if(count($parametros) > 0 ){
            $url_params = null ;

            foreach( $parametros as $opc => $valor ){

                $url_params .= $opc ."=" . $valor ."&";

            }

            echo "<script>location.href = '?".$url_params."ikro=88';</script>";

        }else{
            echo "<script>location.href ='?log=0';</script>";
        }
    }

    public static function MyAlert($message,$type){

        echo "<script> MyAlert('".$message."','".$type."'); </script>" ;

    }
    
}

