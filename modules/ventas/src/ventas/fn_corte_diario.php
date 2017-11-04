<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 08/06/2017
 * Time: 10:01 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../controller/ClassControllerReports.php";

$connect = new ClassControllerReports();
$connect->valida_session_id();

/**
 * EL corte diario
 * Reporte de todas las ventas del dia actual
 * Perfil administrador puede ver por todas las sucursales, los
 * demas usuario solo veran lo de su sucursal
 */

?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/js_formato_moneda.js"></script>
<script>
    $('.currency').numeric({prefix:'$ ', cents: true});
</script>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">

        <div class="box box-warning">
            <div class="box-header padding-x3">
                <button class="btn btn-xs btn-default"><i class="fa fa-print"></i> Imprimir</button>
                <div class="btn-group">
                    <button class="btn btn-default btn-xs dropdown-toggle"
                            type="button" data-toggle="dropdown">
                        <i class="fa fa-home"></i> Otro departamentos <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#" onclick="fnVentaCorteDiario(1)" >Plaza Sendero</a></li>
                        <li><a href="#" onclick="fnVentaCorteDiario(2)" >Sendero Escobedo</a></li>
                    </ul>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">

                        <table class="table table-condensed small table-striped">
                            <thead>
                            <tr>
                                <th class="bg-blue-active" colspan="2">Movimientos ventas</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Saldo apertura</td>
                                <td>$0.00</td>
                            </tr>
                            <tr>
                                <td>Ventas contado</td>
                                <td>$0.00</td>
                            </tr>
                            <tr>
                                <td>Ventas credito</td>
                                <td>$0.00</td>
                            </tr>
                            <tr>
                                <td>Pagos</td>
                                <td>$0.00</td>
                            </tr>
                            <tr>
                                <td>Pagos pendientes</td>
                                <td>$0.00</td>
                            </tr>
                            <tr>
                                <td>Cancelaciones</td>
                                <td>$0.00</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="col-md-6">

                        <table class="table table-condensed small table-striped">
                            <thead>
                            <tr>
                                <th class="bg-green-gradient" colspan="2">Total caja</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Total</td>
                                <td>$0.00</td>
                            </tr>
                            </tbody>
                        </table>

                        <table class="table table-condensed small table-striped">
                            <thead>
                            <tr>
                                <th class="bg-aqua-gradient" colspan="2">Movimientos servicios</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Total venta</td>
                                <td>$0.00</td>
                            </tr>
                            <tr>
                                <td>Cancelaciones</td>
                                <td>$0.00</td>
                            </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">

                        <table class="table table-condensed small table-striped">
                            <thead>
                            <tr>
                                <th class="bg-blue-active" colspan="2">Movimientos Aportaciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Aportaciones</td>
                                <td>$0.00</td>
                            </tr>
                            <tr>
                                <td>Retiros</td>
                                <td>$0.00</td>
                            </tr>
                            <tr>
                                <td>Cancelaciones</td>
                                <td>$0.00</td>
                            </tr>
                            </tbody>
                        </table>


                    </div>
                    <div class="col-md-6">

                        <table class="table table-condensed small table-striped">
                            <thead>
                            <tr>
                                <th class="bg-blue-active" colspan="2">Movimientos Entradas</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Entradas</td>
                                <td>$0.00</td>
                            </tr>
                            <tr>
                                <td>Salidas</td>
                                <td>$0.00</td>
                            </tr>
                            <tr>
                                <td>Cancelaciones</td>
                                <td>$0.00</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6"></div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-2"></div>
</div>