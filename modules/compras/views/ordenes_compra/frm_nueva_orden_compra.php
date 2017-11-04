<?php
/**
 * Created by PhpStorm.
 * User: USUARIO
 * Date: 02/05/2017
 * Time: 08:55 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();
unset($_SESSION['cart']);
$idEmpresa = $_SESSION['data_home']['idempresa'];

$connect->_query = "SELECT MAX(idcompra)as UltimoIdCompra FROM compra WHERE idempresa = $idEmpresa ";
$connect->get_result_query(true);
$UltimoIdCompra = $connect->_rows[0]['UltimoIdCompra'];

?>
<script>
    //Script parar recorrer una tabla y sacar los valores de los tr
    $("#btnRecorrer").click(function () {
        $("#tabla tbody tr").each(function (index) {
            var campo1, campo2, campo3;
            $(this).children("td").each(function (index2) {
                switch (index2) {
                    case 0:
                        campo1 = $(this).text();
                        break;
                    case 1:
                        campo2 = $(this).text();
                        break;
                    case 2:
                        campo3 = $(this).text();
                        break;
                }
                $(this).css("background-color", "#ECF8E0");
            })
            alert(campo1 + ' - ' + campo2 + ' - ' + campo3);
        })
    })
    $(".select2").select2();
</script>
<div class="row row-sm">
    <div class="col-md-4">
        <div class="form-group">
            <label>Proveedor</label>
            <select id="idproveedor" class="form-control select2" style="width: 100%">
                <option value="0">-- --</option>
                <?php

                $connect->_query = "SELECT idproveedor,nombre_proveedor FROM proveedores WHERE idestado = 1 AND idempresa = '$idEmpresa' ";
                $connect->get_result_query();

                for($i=0;$i <count($connect->_rows);$i++){
                    echo "<option value='".$connect->_rows[$i][0]."'>".$connect->_rows[$i][1]."</option>";
                }

                ?>
            </select>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label>Almace Entrega</label>
            <select id="iddepartamento" class="form-control select2" style="width: 100%">
                <option value="0">-- Seleccione una Opción --</option>
                <?php
                $connect->_query = "SELECT idalmacen,nombre_almacen FROM almacen WHERE idestado = 1 AND idempresa = 1";
                $connect->get_result_query();
                if(count($connect->_rows) > 0){
                    for($i=0;$i<count($connect->_rows);$i++){
                        echo "<option value='".$connect->_rows[$i][0]."'>".$connect->_rows[$i][1]."</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label>Fecha</label>
            <input class="form-control text-right" disabled value="<?=date("d/m/Y")?>" />
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Orde de Compra Nº</label>
            <input class="form-control text-center" disabled value="<?=$connect->getFormatFolio(($UltimoIdCompra + 1),4)?>" />
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Agregar Productos</label>
            <button class="btn btn-info btn-block" onclick="nueva_orden_compra(2,0)" ><i class="fa fa-search"></i> Buscar Productos</button>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-hover table-striped table-bordered ">
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Cant.</th>
                    <th>Descripcion</th>
                    <th>Tipo</th>
                    <th width="300" class="text-right">Precio Unitario</th>
                    <th width="300" class="text-right">Precio Total</th>
                </tr>
            </thead>
            <tbody id="lista_productos">
            <tr>
                <td colspan="4"></td>
                <td class="text-right" >Neto $</td>
                <td class="text-right"> $0.00</td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td class="text-right">Neto $</td>
                <td class="text-right"> $0.00</td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td class="text-right">Neto $</td>
                <td class="text-right"> $0.00</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-12 text-right ">
        <button class="btn btn-danger " onclick="nueva_orden_compra(1,2)" ><i class="fa fa-trash"></i> Cancelar</button>
        <button class="btn btn-success " onclick="nueva_orden_compra(4,0)" ><i class="fa fa-save"></i> Guardar</button>
    </div>
</div>
