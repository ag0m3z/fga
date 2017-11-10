<?php
include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";
?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/js_formato_moneda.js"></script>
<script>
    $('.currency').numeric({prefix:'$ ', cents: true});
    $(".datepicker").datepicker({dateFormat:'yy-mm-dd'});
    getCorteDiario(2,0);
</script>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">

        <div class="box box-warning">
            <div class="box-header padding-x3">
                <div class="col-md-5 col-sm-4 col-lg-4 no-padding no-margin">
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
                <div class="col-md-3 no-padding no-margin">
                    <input class="form-control hidden datepicker input-sm">
                </div>

            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">

                        <table class="table table-condensed  table-hover table-striped">
                            <tr>
                                <td colspan="2" class="bg-blue-active text-bold">Pagos y Notas</td>
                            </tr>
                            <tr>
                                <td>Caja Inicial</td>
                                <td id="caja_inicial" class="currency">0</td>
                            </tr>
                            <tr>
                                <td>Notas <span class="pull-right text-bold text-black">+</span></td>
                                <td id="nnotasventa" class="currency">0</td>
                            </tr>
                            <tr>
                                <td>Pagos <span class="pull-right text-bold text-black">+</span></td>
                                <td id="npagos" class="currency">0</td>
                            </tr>
                            <tr>
                                <td>Cancelaciones <span class="pull-right text-bold text-red">-</span></td>
                                <td id="ncancelaciones" class="currency">0</td>
                            </tr>
                            <tr>
                                <td class="text-right text-bold">Total</td>
                                <td id="TotalMovimientos" class="currency">0</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="bg-blue-active text-bold">Aportaciones y Retiros</td>
                            </tr>
                            <tr>
                                <td>Aportaciones <span class="pull-right text-bold text-black">+</span></td>
                                <td id="aportacion" class="currency">0</td>
                            </tr>
                            <tr>
                                <td>Retiros <span class="pull-right text-bold text-red">-</span></td>
                                <td id="retiro" class="currency">0</td>
                            </tr>
                            <tr>
                                <td>Cancelaciones <span class="pull-right text-bold text-red">-</span></td>
                                <td id="cancelacion_aportaciones" class="currency">0</td>
                            </tr>
                            <tr>
                                <td class="text-right text-bold">Total</td>
                                <td id="total_aportaciones" class="currency">0</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="bg-blue-active text-bold">Entradas y Salidas</td>
                            </tr>
                            <tr>
                                <td>Entradas <span class="pull-right text-bold text-black">+</span></td>
                                <td id="entrada" class="currency">0</td>
                            </tr>
                            <tr>
                                <td>Salidas <span class="pull-right text-bold text-red">-</span></td>
                                <td id="salida" class="currency">0</td>
                            </tr>
                            <tr>
                                <td>Cancelaciones <span class="pull-right text-bold text-red">-</span></td>
                                <td id="cancelacion_entrada" class="currency">0</td>
                            </tr>
                            <tr>
                                <td class="text-right text-bold">Total</td>
                                <td id="total_entrada" class="currency">0</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="bg-green-active text-bold">Totales</td>
                            </tr>
                            <tr>
                                <td class="text-right text-bold">SubTotal</td>
                                <td id="subtotal" class="currency">0</td>
                            </tr>
                            <tr>
                                <td class="text-right text-bold">Caja Inicial</td>
                                <td id="caja_inicial" class="currency">0</td>
                            </tr>
                            <tr>
                                <td class="text-right text-bold">Total</td>
                                <td id="total" class="currency">0</td>
                            </tr>
                        </table>

                    </div>

                </div>
            </div>
        </div>

    </div>
    <div class="col-md-2"></div>
</div>