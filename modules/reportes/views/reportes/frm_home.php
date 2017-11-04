<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 17/04/2017
 * Time: 12:30 PM
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

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);
?>
<div class="box box-success animated fadeInDown">
    <div class="box-header">
        <i class="fa fa-area-chart"></i> Reportes
    </div>
    <div class="toolbars">

        <button class="btn btn-sm btn-primary"> <i class="fa fa-refresh"></i> Reportes e Indicadores </button>

        <div class="btn-group">
            <button class="btn btn-default btn-sm dropdown-toggle"
                    type="button" data-toggle="dropdown">
                Ingresos <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#">Acción #1</a></li>
                <li><a href="#">Acción #2</a></li>
                <li><a href="#">Acción #3</a></li>
                <li class="divider"></li>
                <li><a href="#">Acción #4</a></li>
            </ul>
        </div>

        <button class="btn btn-sm btn-default"> Productos </button>

        <div class="btn-group">
            <button class="btn btn-default btn-sm dropdown-toggle"
                    type="button" data-toggle="dropdown">
                Egresos <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#">Acción #1</a></li>
                <li><a href="#">Acción #2</a></li>
                <li><a href="#">Acción #3</a></li>
                <li class="divider"></li>
                <li><a href="#">Acción #4</a></li>
            </ul>
        </div>



        <div class="btn-group">
            <button class="btn btn-default btn-sm dropdown-toggle"
                    type="button" data-toggle="dropdown">
                Reportes <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#">Acción #1</a></li>
                <li><a href="#">Acción #2</a></li>
                <li><a href="#">Acción #3</a></li>
                <li class="divider"></li>
                <li><a href="#">Acción #4</a></li>
            </ul>
        </div>


    </div>
    <div class="box-body">

    </div>
</div>
