<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 03/05/2017
 * Time: 04:42 PM
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
<script>
    setOpenModal("modal_buscar_producto");
    $('#tbexample').DataTable({
        "bRetrieve":true,
        "paging": true,
        "lengthChange": true,
        "searching": false,
        "order": [],
        "language": {
            "lengthMenu": "Mostrar  _MENU_ registros",
            "zeroRecords": "Nothing found - sorry",
            "info": " Página _PAGE_ de _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "sSearch":        "Buscar:",
            "paginate": {
                "next":       "Siguiente",
                "previous":   "Anterior"
            }
        },
        "autoWidth": true
    });

</script>
<div class="modal fade" id="modal_buscar_producto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-size: 14px">Buscar Productos</h4>
            </div>
            <div class="modal-body" >

                <div class="row">
                    <form action="#" onsubmit="nueva_orden_compra(3,0); return false;">
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
                            <button class="btn btn-default btn-block" onclick="nueva_orden_compra(3,0)"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </form>
                </div>
                <br/>
                <div class="row row-sm scroll-auto" style="max-height: 55vh;">
                    <div class="col-md-12">
                        <button class="pull-right hidden btn btn-warning btn-sm"><i class="fa fa-check"></i> Agregar Todo</button>
                        <table id="tbexample" class="table table-condensed table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th class="bg-bareylev" width="5">No</th>
                                <th class="bg-bareylev">Nombre del articulo</th>
                                <th class="bg-bareylev">Tipo</th>
                                <th class="bg-bareylev" >Cantidad</th>
                                <th class="bg-bareylev" >Precio de venta</th>
                                <th class="bg-bareylev" >Precio de compra</th>
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