<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 15/06/2017
 * Time: 06:13 PM
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
?>
<script>
    $(".list-group-item").click(function () {
        $("button").removeClass("active");
        $(this).addClass("active");
    });
</script>

<div class="row">

    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

        <div class="box box-success">
            <div class="list-group">
                <button type="button" class="list-group-item ">Tablero <i class="fa pull-right fa-dashboard"></i></button>
                <button type="button" class="list-group-item active">Recargas <i class="fa pull-right fa-arrow-circle-right"></i> </button>
                <button type="button" class="list-group-item">Servicios <i class="fa pull-right fa-arrow-circle-right"></i> </button>
                <button type="button" class="list-group-item">Reportes <i class="fa pull-right fa-area-chart"></i> </button>
                <button type="button" class="list-group-item">Recargar <i class="fa pull-right fa-dollar"></i> </button>
                <button type="button" class="list-group-item">Configuración <i class="fa pull-right fa-gears"></i> </button>
            </div>
        </div>

    </div>

    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
        <div class="box box-warning">
            <div class="box-body">

                <div class="row">
                    <div class="col-md-8">

                        <div class="row margin-bottom">
                            <div class="col-md-4">
                                <button class="btn btn-info btn-block" onclick="$('#list-tipo').removeClass('hidden')" ><i class="fa fa-flash"></i> Recargas</button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-default btn-block"><i class="fa fa-flash"></i> Paquetes</button>
                            </div>
                        </div>

                        <div id="list-tipo" class="row hidden">

                            <div class="col-md-3">
                                <button onclick="$('#idproducto').val('20');$('#list-tipo').addClass('hidden');$('#box-cash').removeClass('hidden')" class="btn btn-default margin-bottom btn-block text-bold" style="font-size: 27px">20</button>
                            </div>

                            <div class="col-md-3">
                                <button class="btn btn-default margin-bottom btn-block text-bold" style="font-size: 27px">50</button>
                            </div>

                            <div class="col-md-3">
                                <button class="btn btn-default btn-block margin-bottom text-bold" style="font-size: 27px">100</button>
                            </div>

                            <div class="col-md-3">
                                <button class="btn btn-default margin-bottom btn-block text-bold" style="font-size: 27px">200</button>
                            </div>

                            <div class="col-md-3">
                                <button class="btn btn-default margin-bottom btn-block text-bold" style="font-size: 27px">500</button>
                            </div>
                        </div>

                        <div id="box-cash"  class="row hidden">
                            <div class="col-md-12">

                                <div class="form-group hidden">
                                    Producto
                                    <input disabled class="form-control input-lg" >
                                </div>

                                <div class="form-group">
                                    Recarga
                                    <input id="idproducto" disabled class="form-control input-lg" >
                                </div>

                                <div class="form-group">
                                    Numero
                                    <input type="number" class="form-control input-lg" >
                                </div>

                                <div class="form-group">
                                    Confirmar
                                    <input type="number" class="form-control input-lg" >
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-lg btn-success" onclick="fnVentaServicios()" ><i class="fa fa-calculator"></i> Cobrar</button>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="row">

                            <div class="col-sm-12 col-xs-12">
                                <div class="info-box hover-zoom-effect">
                                    <div class="icon bg-green">
                                        <i class="fa fa-money"></i>
                                    </div>
                                    <div class="text-left padding-x3">
                                        <p style="font-size: 19px;">Total Servicios</p>
                                        <h3 class="modal-title">$3,50.00</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-xs-12">
                                <div class="info-box hover-zoom-effect">
                                    <div class="icon bg-aqua-gradient ">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <div class="content">
                                        <p class="text-bold">Total Recargas</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="info-box hover-zoom-effect">
                                    <div class="icon bg-orange ">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <div class="content">
                                        <p class="text-bold">Total Recargas</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
