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

$connect = new \core\seguridad();
$connect->valida_session_id();



/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['cart_venta']);
unset($_SESSION['cart_costo_trabajo']);

if($_SESSION['myPrint'] ==""){
 $valPrint = 0;
}
$idEmpresa = $_SESSION['data_home']['iddepartamento'];

?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/jsVentas.js"></script>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/jsCatalogos.js"></script>

<div class="box box-primary animated fadeInDown">

    <div class="box-header">
        <i class="fa fa-calculator"></i>

        <button class="btn btn-sm btn-success" onclick="gn_menu_principal(9,9)" ><i class="fa fa-home"></i> Nueva venta </button>

        <button class="btn btn-sm btn-default" > Trabajos Pendientes</button>

        <button class="btn btn-sm btn-info hidden" onclick="gn_menu_principal(15,15)" ><i class="fa fa-dollar"></i> Servicios </button>

        <button class="btn btn-sm btn-default" onclick="setVentaPagos({'opc':1,'folio':0})"><i class="fa fa-dollar"></i> Pagos </button>

        <div class="btn-group">
            <button class="btn btn-warning btn-sm dropdown-toggle"
                    type="button" data-toggle="dropdown">
                Caja <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#"  onclick="fnVentaOpenModal({'opc':5})">Apertura</a></li>
                <li><a href="#"  onclick="fnVentaOpenModal({'opc':7})">Arqueo</a></li>
                <li><a href="#"  onclick="fnVentaOpenModal({'opc':6})">Cierre</a></li>
            </ul>
        </div>

        <button class="btn btn-sm btn-primary" onclick="fnVentaHistorialCliente({'opc':1})" ><i class="fa fa-list"></i> Historial Cliente </button>

        <div class="btn-group">
            <button class="btn btn-default btn-sm dropdown-toggle"
                    type="button" data-toggle="dropdown">
                Re Impresiones <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#" onclick="setVentaPagos({'opc':3,'folio':0})">Folio de Venta</a></li>
                <li class="hidden"><a href="#">Folio de Pago</a></li>
                <li class="hidden"><a href="#">Cancelaciones</a></li>
                <li class="hidden dropdown-submenu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li class="dropdown-submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">One more separated link</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="divider"></li>
                <li><a href="#">Entrada y Salidas</a></li>
                <li><a href="#">Aportaciones y Retiros</a></li>
            </ul>
        </div>

        <div class="btn-group">
            <button class="btn btn-danger btn-sm dropdown-toggle"
                    type="button" data-toggle="dropdown">
                Cancelaciones <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#" onclick="setVentaPagos({'opc':5,'folio':0})" >Folio de Venta</a></li>
                <li class="divider"></li>
                <li><a href="#">Entradas</a></li>
                <li><a href="#">Salidas</a></li>
                <li><a href="#">Aportaciones</a></li>
                <li><a href="#">Retiros</a></li>
            </ul>
        </div>

        <div class="btn-group">
            <button class="btn btn-default btn-sm dropdown-toggle"
                    type="button" data-toggle="dropdown">
                Reportes <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#" onclick="fnVentaCorteDiario(1)" >Movimientos Diario</a></li>
                <li><a href="#" onclick="fnVentaCorteDiario(2)" >Corto Diario</a></li>
                <li><a href="#" onclick="fnVentaCorteDiario(1)" >Notas Terminadas</a></li>
                <li><a href="#" onclick="fnVentaCorteDiario(1)" >Notas Pendientes</a></li>
                <li><a href="#">Entradas y salidas</a></li>
                <li><a href="#">Aportaciones y Retiros</a></li>
                <li class="divider"></li>
                <li><a href="#">Detallado</a></li>
            </ul>
        </div>
    </div>

    <div id="form_caja" class="box-body">

        <div class="row">

            <div class="col-md-12">

                <div class="row row-sm">

                    <div class="col-md-1 text-center">

                        <div class="box box-info">
                            <div class="box-header">
                                <span class="text-bold">Tools</span>
                            </div>
                            <div class="box-body no-padding">
                                <div class="form-group">
                                    <button class="btn-circle btn-lg btn-default"><i class="fa fa-home"></i> </button>
                                </div>
                                <div class="form-group">
                                    <button class="btn-circle btn-lg btn-default"><i class="fa fa-home"></i> </button>
                                </div>
                                <div class="form-group">
                                    <button class="btn-circle btn-lg btn-default"><i class="fa fa-home"></i> </button>
                                </div>
                                <div class="form-group">
                                    <button class="btn-circle btn-lg btn-default"><i class="fa fa-home"></i> </button>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="col-md-11">

                        <div class="row row-sm">
                            <div class="col-md-8">

                                <div class="box box-info">
                                    <div class="box-header">
                                        <span class="text-bold">Diseñador</span>
                                    </div>
                                    <div class="box-body no-padding">

                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <span class="text-bold">Listado</span>
                                    </div>
                                    <div class="box-body no-padding">

                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>

                </div>

            </div>

            <div class="col-md-12">

            </div>

        </div>

    </div>

</div>
