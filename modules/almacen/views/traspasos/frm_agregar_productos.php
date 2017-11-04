<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 23/05/2017
 * Time: 09:38 AM
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
include "../../../../core/model_articulos.php";

$connect = new \core\model_articulos();
$connect->valida_session_id();

$idalmacen_origen = $_POST['idalmacen_origen'];
$idalmacen_destino = $_POST['idalmacen_destino'];
$idusuario_solicita = $_POST['idusuario_solicita'];

$idEmpresa = $_SESSION['data_home']['idempresa'];

$connect->_query = "
SELECT nombre_almacen as AlmacenOrigen FROM almacen where idempresa = $idEmpresa AND idalmacen = $idalmacen_origen UNION 
SELECT nombre_almacen as AlmacenDestino FROM almacen where idempresa = $idEmpresa AND idalmacen = $idalmacen_destino ;
";
$connect->get_result_query();

$AlmacenOrigen = $connect->_rows[0][0];
$AlmacenDestino = $connect->_rows[1][0];

?>
<script>
    setOpenModal("modal_buscar_producto");

    $("#nombre_producto").on('keyup', function (e) {
        if (e.keyCode == 13) {
            // Do something
            $("#btnBuscarProducto").click();
        }
    });
    //$(e).closest("tr").remove();

</script>
<div class="modal fade" id="modal_buscar_producto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-size: 14px">Buscar Productos</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                        <div class="col-md-8">
                            <input class="form-control" type="text" id="nombre_producto" placeholder="Buscar productos" />
                        </div>
                        <div class="col-md-2">
                            <select id="tipo_producto" class="form-control">
                                <option value="0">Todos</option>
                                <option value="1">Productos</option>
                                <option value="2">Materiales</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button id="btnBuscarProducto" class="btn btn-default btn-block" onclick="agregar_producto_traspaso(3,{'idalmacen_origen':<?=$idalmacen_origen?>,'idalmacen_destino':<?=$idalmacen_destino?>,'idusuario_solicita':<?=$idusuario_solicita?>})"><i class="fa fa-search"></i> Buscar</button>
                        </div>

                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <span class="pull-left"><b>Origen:</b> <?=$AlmacenOrigen?></span>
                        <span class="pull-right"><b>Destino:</b> <?=$AlmacenDestino?></span>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-12">
                        <table id="example" class="table table-condensed table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th class="bg-bareylev" width="5">No</th>
                                <th class="bg-bareylev">Nombre</th>
                                <th class="bg-bareylev">Existencias</th>
                                <th class="bg-bareylev" width="100">Cantidad</th>
                                <th class="bg-bareylev" width="100">Tipo</th>
                                <th class="bg-bareylev" width="5"></th>
                            </tr>
                            </thead>
                            <tbody id="list_producto_cart">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger pull-right btn-sm" id="modalbtnclose" onclick="$('#modal_buscar_producto').modal('toggle')"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
