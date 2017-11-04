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
include "../../../../core/model_proveedores.php";

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

$proveedores = new \core\model_proveedores();
$proveedores->valida_session_id();

if(array_key_exists('idproveedor',$_POST)){

    $proveedores->get_proveedor($_POST['idproveedor'],$_SESSION['data_home']['idempresa']);
}

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);
?>
<div class="modal fade" id="modal_editar_proveedor">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-size: 14px"> Edición de proveedor: <?=$proveedores->getNombreProveedor()?></h4>
            </div>
            <div class="modal-body">

                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab">Datos Generales</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Bitácora</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        Nombre proveedor:
                                        <input class="form-control" value="<?=$proveedores->getNombreProveedor()?>" id="nombre_proveedor" placeholder="Nombre Proveedor" />
                                    </div>
                                    <div class="form-group">
                                        Correo:
                                        <input class="form-control" value="<?=$proveedores->getCorreo()?>" id="correo_proveedor" placeholder="Correo" />
                                    </div>
                                    <div class="form-group">
                                        Dirección:
                                        <input class="form-control" value="<?=$proveedores->getDireccion()?>" id="direccion_proveedor" placeholder="Dirección" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        Teléfono:
                                        <input class="form-control" value="<?=$proveedores->getTelefono1()?>" id="telefono1_proveedor" placeholder="Teléfono" />
                                    </div>
                                    <div class="form-group">
                                        Teléfono 2:
                                        <input class="form-control" value="<?=$proveedores->getTelefono2()?>" id="telefono2_proveedor" placeholder="Teléfono" />
                                    </div>
                                    <div class="form-group">
                                        Celular:
                                        <input class="form-control" value="<?=$proveedores->getCelular()?>" id="celular_proveedor" placeholder="Celular" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        Descripcón:
                                        <textarea class="form-control" id="descripcion_proveedor" placeholder="Descripción"><?=$proveedores->getDescripcionProveedor()?></textarea>
                                    </div>
                                    <div class="form-group">
                                        Estado:
                                        <select id="idestado_proveedor" class="form-control input-sm">
                                            <?php
                                            if($proveedores->getNoEstado() == 1){
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
                                        <input class="form-control input-sm" disabled value="<?=$proveedores->getUsuarioAlta()?>" />
                                    </div>
                                    <div class="form-group">
                                        Fecha Alta:
                                        <input class="form-control" disabled value="<?=$proveedores->getFechaAlta()?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        Usuario UM:
                                        <input class="form-control input-sm" disabled value="<?=$proveedores->getUsuarioUM()?>"  />
                                    </div>
                                    <div class="form-group">
                                        Fecha UM:
                                        <input class="form-control" disabled value="<?=$proveedores->getFechaUM()?>"  />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="response_modal"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-sm" id="btnSave" onclick="editar_proveedor(2,<?=$_POST['idproveedor']?>)" ><i id="spinner" class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-danger btn-sm" id="modalbtnclose" onclick="$('#modal_editar_proveedor').modal('toggle')"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#nombre_proveedor').focus();
        $('#modal_editar_proveedor').modal('toggle');
        $("#modal_editar_proveedor").draggable({
            handle: ".modal-header"
        });
    });
</script>
