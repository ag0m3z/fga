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

if(array_key_exists('idcategoria',$_POST)){

    $categorias->get_categoria($_POST['idcategoria'],$_SESSION['data_home']['idempresa']);
}

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);
?>
<div class="modal fade" id="modal_editar_categoria">
    <div class="modal-dialog modal-sm">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-size: 14px"> Edición de categoría: <?=$categorias->getNombreCategoria()?></h4>
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
                                Nombre de la categoria:
                                <input class="form-control " value="<?=$categorias->getNombreCategoria()?>" id="nombre_categoria" placeholder="Nombre de la categoria" />
                            </div>
                            <div class="form-group">
                                Descripción:
                                <textarea class="form-control  " id="descripcion_categoria" placeholder="Descripión"><?=$categorias->getDescripcionCategoria()?></textarea>
                            </div>
                            <div class="form-group">
                                Estado:
                                <select id="idestado_categoria" class="form-control input-sm">
                                    <?php
                                    if($categorias->getNoEstado() == 1){
                                        echo "<option value='1'>Activado</option><option value='0'>Desactivado</option>";
                                    }else{
                                        echo "<option value='0'>Desactivado</option><option value='1'>Activado</option>";
                                    }
                                    ?>

                                </select>
                            </div>

                        </div>
                        <div class="tab-pane" id="tab_2">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        Usuario Alta:
                                        <input class="form-control input-sm" disabled value="<?=$categorias->getUsuarioAlta()?>" />
                                    </div>
                                    <div class="form-group">
                                        Fecha Alta:
                                        <input class="form-control" disabled value="<?=$categorias->getFechaAlta()?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        Usuario UM:
                                        <input class="form-control input-sm" disabled value="<?=$categorias->getUsuarioUM()?>"  />
                                    </div>
                                    <div class="form-group">
                                        Fecha UM:
                                        <input class="form-control" disabled value="<?=$categorias->getFechaUM()?>"  />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="response_modal"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-sm" id="btnSave" onclick="editar_categoria(2,<?=$_POST['idcategoria']?>)" ><i id="spinner" class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-danger btn-sm" id="modalbtnclose" onclick="$('#modal_editar_categoria').modal('toggle')"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#modal_editar_categoria').focus();
        $('#modal_editar_categoria').modal('toggle');
        $("#modal_editar_categoria").draggable({
            handle: ".modal-header"
        });
    });
</script>
