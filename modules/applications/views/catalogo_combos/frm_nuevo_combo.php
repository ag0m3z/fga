<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 11/06/2017
 * Time: 02:18 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";

include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();

unset($_SESSION['cart_combos']);

?>
<script>
    $(".select2").select2();
    $("#codigo_combo").focus();

</script>
<div class="row">
    <div class="col-md-5">

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    Codigo
                    <input id="codigo_combo" placeholder="Codigo del combo" class="form-control input-sm">
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    Nombre
                    <input id="nombre_combo" placeholder="Nombre del combo" class="form-control input-sm">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    Descripción
                    <textarea placeholder="Descripción del combo" id="descripcion" class="form-control"></textarea>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-7">

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    Tipo de Producto
                    <select id="tipo_producto" onchange="nuevo_combo(4)" style="width: 100%" class="form-control select2 input-sm">
                        <option value="0">-- Seleccione el tipo de producto --</option>
                        <option value="ART">Productos</option>
                        <option value="MAT">Materiales</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    Producto
                    <select id="idproducto" style="width: 100%" class="form-control select2 input-sm">
                        <option value="0">-- Seleccione el tipo de producto --</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                &nbsp;
                <button class="btn btn-sm btn-success btn-block" onclick="nuevo_combo(2)"><i class="fa fa-plus"></i></button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Tip Produto</th>
                        <th>Nombre Producto</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="lista_productos_combo">

                    </tbody>
                </table>
            </div>
        </div>


    </div>
</div>
