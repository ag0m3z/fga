<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 28/09/2017
 * Time: 11:50 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../controller/model_almacen.php";

$connect = new model_almacen();

unset($_SESSION['EXPORT']);
unset($_SESSION['cart_traspasos']);
$idempresa = IDEMPRESA;

$connect->_query = "SELECT a.idusuario,b.nick_name FROM usuarios as a LEFT JOIN perfil_usuarios as b ON a.idusuario = b.idusuario WHERE a.idempresa = $idempresa AND a.idestado = 1  ";
$connect->get_result_query();
$ListaEmpleados = $connect->_rows;

$connect->_query = "SELECT idalmacen,nombre_almacen FROM almacen WHERE idempresa = $idempresa AND  idestado = 1 ";
$connect->get_result_query();
$ListaAlmacenes = $connect->_rows;
?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/jsAlmacen.js"></script>
<script>$(".select2").select2();</script>

<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">Editar Traspaso: <?=$connect->getFormatFolio($_POST['idTraspaso'],4)?></h3>
    </div>
    <div class="box-body">

        <div class="row">
            <div class="col-md-3">

                <div class="form-group">
                    <label>Usuario Solicititante</label>
                    <select class="form-control select2" id="idusuario_solicita">
                        <option value="0">-- --</option>
                        <?php

                        for($i=0;$i<count($ListaEmpleados);$i++){
                            echo "<option value='".$ListaEmpleados[$i][0]."'>".$ListaEmpleados[$i][1]."</option>";
                        }

                        ?>
                    </select>
                </div>

            </div>
            <div class="col-md-3">

                <div class="form-group">
                    <label>Almacen Origen</label>
                    <select class="form-control select2" id="idalmacen_origen">
                        <option value="0">-- --</option>
                        <?php

                        for($i=0;$i<count($ListaAlmacenes);$i++){
                            echo "<option value='".$ListaAlmacenes[$i][0]."'>".$ListaAlmacenes[$i][1]."</option>";
                        }

                        ?>
                    </select>
                </div>

            </div>
            <div class="col-md-3">

                <div class="form-group">
                    <label>Almacen Destino</label>
                    <select class="form-control select2" id="idalmacen_destino">
                        <option value="0">-- --</option>
                        <?php

                        for($i=0;$i<count($ListaAlmacenes);$i++){
                            echo "<option value='".$ListaAlmacenes[$i][0]."'>".$ListaAlmacenes[$i][1]."</option>";
                        }

                        ?>
                    </select>
                </div>

            </div>

            <div class="col-md-3">

                <div class="form-group">
                    <label>Agregar</label>
                    <button id="btnAgregarProductosTraspaso" onclick="buscar_producto_almacen()" class="btn btn-sm btn-info btn-block" ><i class="fa fa-search"></i> Agregar Productos o Material</button>
                </div>


            </div>
        </div>

        <div class="row">
            <div class="col-md-12 table-responsive">

                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Tipo Producto</th>
                        <th width="250">Cantidad</th>
                    </tr>
                    </thead>
                    <tbody id="list_cart_traspasos">

                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td class="text-right" width="300">
                            <button id="btnNuevoTraspaso02" onclick="compras_nuevo_traspaso(2)" class="btn  btn-danger btn-sm" > <i class="fa fa-trash"></i> Cancelar</button>
                            <button id="btnNuevoTraspaso01" class="btn  btn-success btn-sm" > <i class="fa fa-save"></i> Guardar  </button>
                        </td>
                    </tr>
                    </tfoot>
                </table>

            </div>
        </div>

    </div>
</div>
