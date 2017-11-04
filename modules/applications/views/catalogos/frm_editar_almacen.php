<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 16/04/2017
 * Time: 10:28 AM
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
include "../../../../core/model_almacen.php";

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

$almacenes = new \core\model_almacen();
$almacenes->valida_session_id();

if(array_key_exists('idalmacen',$_POST)){

    $almacenes->get_almacen($_POST['idalmacen'],$_SESSION['data_home']['idempresa']);
}

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);
?>
<div class="modal fade" id="modal_editar_almacen">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-size: 14px"> Edición del almacén: <?=$almacenes->getNombreAlmacen()?></h4>
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
                                Nombre del almacén:
                                <input class="form-control " value="<?=$almacenes->getNombreAlmacen()?>" id="nombre_almacen" placeholder="Nombre del almacén" />
                            </div>
                            <div class="form-group">
                                Descripción:
                                <input class="form-control  " id="descripcion_almacen" placeholder="Descripión" value="<?=$almacenes->getDescripcionAlmacen()?>"/>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        Opción traspaso:
                                        <select id="opcion_traspasos" class="form-control input-sm">
                                            <?php
                                            if($almacenes->getOpcionTraspaso() == 1){
                                                echo "<option value='1'>SI Permitido</option><option value='0'>NO Permitido</option>";
                                            }else{
                                                echo "<option value='0'>NO Permitido</option><option value='1'>SI Permitido</option>";
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        Estado:
                                        <select id="idestado_almacen" class="form-control input-sm">
                                            <?php
                                            if($almacenes->getNoEstado() == 1){
                                                echo "<option value='1'>Activado</option><option value='0'>Desactivado</option>";
                                            }else{
                                                echo "<option value='0'>Desactivado</option><option value='1'>Activado</option>";
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane" id="tab_2">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        Usuario Alta:
                                        <input class="form-control input-sm" disabled value="<?=$almacenes->getUsuarioAlta()?>" />
                                    </div>
                                    <div class="form-group">
                                        Fecha Alta:
                                        <input class="form-control" disabled value="<?=$almacenes->getFechaAlta()?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        Usuario UM:
                                        <input class="form-control input-sm" disabled value="<?=$almacenes->getUsuarioUM()?>"  />
                                    </div>
                                    <div class="form-group">
                                        Fecha UM:
                                        <input class="form-control" disabled value="<?=$almacenes->getFechaUM()?>"  />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="response_modal"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-sm" id="btnSave" onclick="editar_almacen(2,<?=$_POST['idalmacen']?>)" ><i id="spinner" class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-danger btn-sm" id="modalbtnclose" onclick="$('#modal_editar_almacen').modal('toggle')"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#nombre_almacen').focus();
        $('#modal_editar_almacen').modal('toggle');
        $("#modal_editar_almacen").draggable({
            handle: ".modal-header"
        });
    });
</script>
