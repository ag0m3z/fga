<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 15/04/2017
 * Time: 02:35 PM
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
<?=\core\core::includeCSS('plugins/colorpicker/bootstrap-colorpicker.css',false)?>
<?=\core\core::includeJS('plugins/colorpicker/bootstrap-colorpicker.js',false)?>
<script>
    $(document).ready(function(){
        $('#codigo_color').focus();
        $('#modal_nuevo_color').modal('toggle');
        $("#modal_nuevo_color").draggable({
            handle: ".modal-header"
        });
        $(".my-colorpicker1").colorpicker();

    });
</script>
<div class="modal fade" id="modal_nuevo_color">
    <div class="modal-dialog modal-sm">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-size: 14px"> Alta de Color</h4>
            </div>
            <div class="modal-body">

                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab">Datos Generales</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Bitácora</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-5">
                                        <input class="form-control my-colorpicker1" onfocus="$(this).css('background',this.val())" id="codigo_color" placeholder="Codigo" />
                                    </div>
                                    <div class="col-md-7">
                                        <input class="form-control " onfocus="$('#codigo_color').css('background',$('#codigo_color').val())" id="nombre_color" placeholder="Nombre Color"/>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane" id="tab_2">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        Usuario Alta:
                                        <input class="form-control input-sm" disabled value="<?=$_SESSION['data_login']['nick_name']?>" />
                                    </div>
                                    <div class="form-group">
                                        Fecha Alta:
                                        <input class="form-control" disabled value="<?=date("d/m/Y")?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        Usuario UM:
                                        <input class="form-control input-sm" disabled value="<?=$_SESSION['data_login']['nick_name']?>"  />
                                    </div>
                                    <div class="form-group">
                                        Fecha UM:
                                        <input class="form-control" disabled value="<?=date("d/m/Y")?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="response_modal"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-sm" id="btnSave" onclick="nuevo_color(2,2)" ><i id="spinner" class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-danger btn-sm" id="modalbtnclose" onclick="$('#modal_nuevo_color').modal('toggle')"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
