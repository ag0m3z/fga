<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 15/04/2017
 * Time: 11:42 AM
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
include "../../../../core/seguridad.class.php";

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

$connect = new \core\seguridad();
$connect->valida_session_id();


/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);
?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/jsCatalogos.js"></script>
<script>
    $('.btn-app').click(
        function () {
            $(".btn-app").removeClass("active bg-light-blue");
            $(this).addClass("active bg-light-blue");
        }
    );
</script>
<div class="row animated zoomIn">
    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-body table-responsive">

                <table class="no-border">
                    <tr>
                        <td>
                            <a class="btn btn-default   btn-app" onclick="menu_catalogos(1,1)">
                                <i class="fa fa-list"></i>Productos
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-default btn-app" onclick="menu_catalogos(8,8)">
                                <i class="fa fa-list"></i>Materiales
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-default btn-app" onclick="menu_catalogos(2,2)">
                                <i class="fa fa-list"></i>Categoías
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-default btn-app" onclick="menu_catalogos(3,3)">
                                <i class="fa fa-list"></i>Sub categoías
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-default btn-app" onclick="menu_catalogos(4,4)">
                                <i class="fa fa-list"></i>Tallas y Medidas
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-default btn-app" onclick="menu_catalogos(5,5)">
                                <i class="fa fa-eyedropper"></i>Colores
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-default btn-app" onclick="menu_catalogos(6,6)">
                                <i class="fa fa-list"></i>Almacenes
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-default btn-app" onclick="menu_catalogos(9,9)">
                                <i class="fa fa-list"></i>Clientes
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-default btn-app" onclick="menu_catalogos(7,7)">
                                <i class="fa fa-list"></i>Provedores
                            </a>
                        </td>

                        <td>
                            <a class="btn btn-default btn-app" onclick="menu_catalogos(10,10)">
                                <i class="fa fa-list"></i>Departamentos
                            </a>
                        </td>

                        <td>
                            <a class="btn btn-default btn-app" onclick="menu_catalogos(11,11)">
                                <i class="fa fa-users"></i>Usuarios
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-default btn-app" onclick="menu_catalogos(12,12)">
                                <i class="fa fa-list"></i>Perfiles
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-default btn-app" onclick="menu_catalogos(13,13)">
                                <i class="fa fa-list"></i>Combos
                            </a>
                        </td>

                    </tr>

                </table>

            </div>
        </div>
    </div>
</div>

<div class="row animated fadeInLeft">
    <div id="contenedor_catalogos" class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
            </div>
        </div>
    </div>
</div>