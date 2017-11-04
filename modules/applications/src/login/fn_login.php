<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 09/01/2017
 * Time: 04:18 PM
 */

include '../../../../core/sesiones.class.php';
include "../../../../core/seguridad.class.php";
include "../../../../core/core.class.php";

$seguridad = new \core\seguridad();
$sesiones = new \core\sesiones();

if(!trim($_POST['user']) == "" && !trim($_POST['pass']) == ""){

    $seguridad->loginIn($seguridad->get_sanatiza($_POST['user']),$seguridad->get_sanatiza($_POST['pass']));

    if($seguridad->_confirm){

        $dataLogin = $seguridad->_rows;

        $sesiones->set(
            'data_login',
            array(
                'idusuario'=>$dataLogin[0]['idusuario'],
                'nick_name'=>$dataLogin[0]['nick_name'],
                'idperfil'=>$dataLogin[0]['idtipo_usuario']
            )
        );

        $sesiones->set(
            'data_home',
            array(
                'idempresa'=>$dataLogin[0]['idempresa'],
                'nombre_empresa'=>$dataLogin[0]['nombre_empresa'],
                'iddepartamento'=>$dataLogin[0]['iddepartamento'],
                'nombre_departamento'=>$dataLogin[0]['nombre_departamento'],
                'almacen'=>$dataLogin[0]['AlmacenDepartamento'],
                'nombre_almacen'=>$dataLogin[0]['nombre_almacen'],
                'descripcion_empresa'=>$dataLogin[0]['descripcion_empresa'],
                'correoEmpresa'=>$dataLogin[0]['correoEmpresa'],
                'logotipo'=>$dataLogin[0]['logotipo']
            )
        );

        /**
         * PArametros del Sistema
         */

        $sesiones->set(
            'sys_config',
            array(
                'tema'=>$dataLogin[0]['tema'],
                'mayoreo_menudeo'=>$dataLogin[0]['mayoreo_menudeo'],
                'idservicio'=>$dataLogin[0]['idservicio'],
                'fecha_caducidad'=>$dataLogin[0]['fecha_caducidad'],
                'costo_trabajo_cp'=>$dataLogin[0]['costo_trabajo_cp'],
                'cantidad_mayoreo_cp'=>$dataLogin[0]['cantidad_mayoreo_cp'],
                'costo_trabajo_mayoreo_cp'=>$dataLogin[0]['costo_trabajo_mayoreo_cp'],
                'costo_trabajo_sp'=>$dataLogin[0]['costo_trabajo_sp'],
                'cantidad_mayoreo_sp'=>$dataLogin[0]['cantidad_mayoreo_sp'],
                'costo_trabajo_mayoreo_sp'=>$dataLogin[0]['costo_trabajo_mayoreo_sp'],
                'pago_inicial'=>$dataLogin[0]['pago_minimo_credito'],
                'almacen'=>1
            )
        );

        /**
         * Cargar Accesos del Menu y Opciones del Sistema
         */
        $NoUsuario = $dataLogin[0]['idusuario'];
        $permisos = new \core\seguridad();
        $permisos->_query = "
        SELECT 
            a.idmodulo,b.nombre,
            b.faIcon,b.OnClick,
            a.consultar,a.agregar,
            a.editar,a.eliminar 
        FROM modulos_acceso as a 
        LEFT JOIN modulos as b 
        ON a.idmodulo = b.idmodulo 
        WHERE a.idusuario = 1";

        $permisos->get_result_query();
        $Menu = $permisos->_rows;

        for($i=0;$i<count($permisos->_rows);$i++){

            $_SESSION['data_menu'][] = array(
                "idmodulo"=>$Menu[$i][0],
                "nombre"=>$Menu[$i][1],
                "icon"=>$Menu[$i][2],
                "onclick"=>$Menu[$i][3],
                "consultar"=>$Menu[$i][4],
                "agregar"=>$Menu[$i][5],
                "editar"=>$Menu[$i][6],
                "eliminar"=>$Menu[$i][7]
            );

        }

        echo '<script>location.reload()</script>';


    }else{
        \core\core::MyAlert($seguridad->_message,"error");
    }


}else{
    \core\core::MyAlert("El usuario o la contrasaña estan vacios","error");
}




