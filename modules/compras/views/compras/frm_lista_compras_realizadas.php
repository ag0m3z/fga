<?php
/**
 * Created by PhpStorm.
 * User: USUARIO
 * Date: 11/05/2017
 * Time: 12:00 AM
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

$connect = new \core\seguridad();
$connect->valida_session_id();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
switch ($_POST['opc']){
    case 1:
        $Titulo = "Compras por Autorizar";
        break;
    case 2:
        $Titulo = "Compras Realizadas";
        break;
    case 3:
        $Titulo = "Compras Canceladas";
        break;
}
unset($_SESSION['EXPORT']);
?>
<script>
    $("th").addClass("bg-bareylev");

    var lista = function(){

        var table = $('#example').DataTable({

            "ajax":{
                "url":"modules/compras/src/compras/fn_listar_compras.php",
                "method":"post",
                "data":{
                    "opc":"<?=$_POST['opc']?>"
                }
            },
            "dom": 'T<"clear">lfrtip',
            "tableTools": {
                "aButtons": [ "xls", "pdf" ]
            },
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
            "columns":[
                {"data":"FolioOrden"},
                {"data":"proveedor"},
                {"data":"usuario"},
                {"data":"total"},
                {"data":"fecha"},
                {"data":"funciones"}
            ],
            "autoWidth": true
        });
    }
    lista();

</script>

<div class="row">
    <div class="col-md-12">
        <h3 class="text-center"><?=$Titulo?></h3>
        <table id="example" style="margin-top: -10px" class="table table-condensed table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th>Folio</th>
                <th>Proveedor</th>
                <th>Usuario</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Funciones</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    </div>
</div>