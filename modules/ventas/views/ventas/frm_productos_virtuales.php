<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 06/06/2017
 * Time: 05:24 PM
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
<script>
    setOpenModal("mdl_paquetes_virtuales");
</script>
<div class="modal fade" data-backdrop="static" id="mdl_paquetes_virtuales">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                 Buscar Combos
            </div>
            <div class="modal-body">

                <div id="content_busqueda">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                Buscar Combo
                                <input class="form-control input-sm" onkeyup="fnVentaOpenModal({'opc':9})" placeholder="Buscar combo" id="textSearchCombo" />
                            </div>
                        </div>
                    </div>
                    <div id="lista_combos" class="row">

                    </div>
                </div>
                <div class="hidden" id="content_cantidad">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                Combo Seleccionado
                                <input class="form-control text-bold" disabled id="idcombo">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                Descripción
                                <textarea class="form-control text-bold" id="descripcion_combo"></textarea>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                &nbsp;
                                <button class="btn btn-primary btn-block" onclick="$('#content_cantidad').addClass('hidden');$('#content_busqueda').removeClass('hidden');" ><i class="fa fa-arrow-left"></i> Regresar</button>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                &nbsp;
                                <button class="btn btn-default btn-block" onclick="fnVentaAgregarCombo(1)" ><i class="fa fa-plus"></i> Agregar</button>
                            </div>
                        </div>

                    </div>


                </div>


            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-cloese"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
