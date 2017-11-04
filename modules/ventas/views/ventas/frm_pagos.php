<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 09/06/2017
 * Time: 01:27 PM
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
include "../../controller/ClassControllerVentas.php";

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

$connect = new ClassControllerVentas();
$connect->valida_session_id();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);


?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/js_formato_moneda.js"></script>
<script>
    setOpenModal("mdl_programaciones");

    setVentaPagos({'opc':2,'folio':<?=$_POST['folio']?>});

    $("input").focus(function(){
        $(this).select();
    });

    $("#folio_venta").on('keyup', function (e) {
        if (e.keyCode == 13) {
            // Do something
            setVentaPagos({'opc':2,'folio':this.value});
        }
    })
</script>
<div class="modal fade" id="mdl_programaciones" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Realizar Pago
            </div>
            <div id="form_pagos" class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label># de Folio</label>
                            <input id="folio_venta" style="font-size: 27px;" type="text" value="<?=$_POST['folio']?>" class="form-control text-bold input-lg text-center" />
                        </div>
                    </div>
                </div>

                <div id="detalle_pago" class="row">


                </div>

                <div id="result_pago" class="row hidden">
                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h3 class="text-bold text-center ">Folio Pago</h3>
                                    <input style="font-size: 34px;" class="form-control text-center text-bold input-lg" id="folio_pago" disabled />
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                        </div>

                        <div id="row_cambio" class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h3 class="text-bold text-center ">Cambio</h3>
                                    <input style="font-size: 34px;" class="form-control text-center  text-bold input-lg" id="total_cambio" disabled />
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn btn-block text-bold btn-default btn-sm" onclick="fnVentaImprimirTicket(1)"><i class="fa fa-print"></i> Imprimir Comprobante</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-danger  btn-sm " data-dismiss="modal" id="mdlBtnClosePagos"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
