<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 16/04/2017
 * Time: 11:34 AM
 */
/**
 * Incluir las Librerias Principales del Sistema
 * En el Siguiente Orden ruta de libreias: @@/SistemaIntegral/core/
 *
 * 1.- core.php;
 * 2.- sesiones.php
 * 3.- seguridad.php o modelo ( ej: model_aparatos.php)
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/model_categorias.php";

/**
 * 1.- Instanciar la Clase seguridad y pasar como valor la BD del Usuario
 * 2.- Llamar al metodo @@valida_session_id($NoUsuario), para validar que el usuario este conectado y con una sesión valida
 *
 * Ejemplo:
 * Si se requiere cambiar de servidor de base de datos
 * $data_server = array(
 *   'bdHost'=>'192.168.2.5',
 *   'bdUser'=>'sa',
 *   'bdPass'=>'pasword',
 *   'port'=>'3306',
 *   'bdData'=>'dataBase'
 *);
 *
 * Si no es requerdio se puede dejar en null
 *
 * con @data_server
 * @@$seguridad = new \core\seguridad($_SESSION['data_login']['BDDatos'],$data_server);
 *
 * Sin @data_server
 * @@$seguridad = new \core\seguridad($_SESSION['data_login']['BDDatos']);
 *
 * @@$seguridad->valida_session_id($_SESSION['data_login']['NoUsuario']);
 */

$categorias = new \core\model_categorias();
$categorias->valida_session_id();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);

if(array_key_exists('idcategoria',$_POST)||array_key_exists('nombre_categoria',$_POST)){

    //Sanatizar datos
    $NombreCategoria = $categorias->get_sanatiza($_POST['nombre_categoria']);
    $DescripcionCategoria = $categorias->get_sanatiza($_POST['descripcion_categoria']);

    $categorias->edit_categoria(array(
        "idempresa"=>$_SESSION['data_home']['idempresa'],
        "idcategoria"=>$_POST['idcategoria'],
        "idestado"=>$_POST['idestado_categoria'],
        "nombre_categoria"=>$NombreCategoria,
        "descripcion_categoria"=>$DescripcionCategoria,
        "idusuario_um"=>$_SESSION['data_login']['idusuario']
    ));

   if($categorias->_confirm){
       echo '<script>getMessage("Categoría editada correctamente");menu_catalogos(2,2);$("#modalbtnclose").click()</script>';
   }else{
       \core\core::MyAlert($categorias->_message,"error");
   }


}else{
    \core\core::MyAlert("Error al editar la categoía","alert");
}
