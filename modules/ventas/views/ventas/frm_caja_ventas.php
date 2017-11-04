<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 30/05/2017
 * Time: 05:55 PM
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
include "../../controller/ClassControllerCarritoVentas.php";

$connect = new \core\seguridad();
$cardVenta = new ClassControllerCarritoVentas();
$connect->valida_session_id();

$lista_carrito = $cardVenta->imprime_carrito();

if(count($lista_carrito) <= 0  ){
    \core\core::MyAlert("No se encontraron productos para cobrar","error");
    exit();
}

$TotalInExistencias = 0;

for($i=0;$i <count($lista_carrito);$i++){

    $TipoDiseno =  $lista_carrito[$i]['TipoDiseno'];

    $Importe = $lista_carrito[$i]['precio_venta'] + $TipoDiseno;
    $subtotal = ($Importe *  $lista_carrito[$i]['cantidad']);
    if($lista_carrito[$i]['existencias'] <= 0){
        $TotalInExistencias = $TotalInExistencias + 1;
    }

    $Total = $Total + $subtotal;

}

if($TotalInExistencias  > 0){
    $HiddenMensaje = "";
}else{$HiddenMensaje = 'hidden';}

$PagoInicial = round(($Total *  $_SESSION['sys_config']['pago_inicial']) / 100);
?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/jsCalendario.js"></script>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/js_formato_moneda.js"></script>
<script>
    setOpenModal("dml_caja_ventas");
    $('.currency').numeric({prefix:'$ ', cents: true});
    $("input").focus(function(){
        this.select();
    });


    $("#idpago_efectivo").on('keyup', function (e) {
        if (e.keyCode == 13) {
            // Do something
            fnVentaCobrarVenta(2);
        }
    });
    $("#idpago_tarjeta").on('keyup', function (e) {
        if (e.keyCode == 13) {
            // Do something
            fnVentaCobrarVenta(2);
        }
    });

    $(".datepicker").datepicker({dateFormat:'yy-mm-dd'});


    if(gPagoEfectivo){
        $("#gpoPagoTarjeta").addClass("hidden");
    }

    setTimeout(function () {
        //$(".modal-body .callout").fadeOut( "slow" );
    },5000)


</script>

<div class="modal fade" id="dml_caja_ventas" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Caja - <?=$_SESSION['data_home']['nombre_empresa']?>
            </div>
            <div class="modal-body">

                <div class="callout-danger <?=$HiddenMensaje?> scroll-auto callout" style="max-height: 25vh;">
                    Los siguientes productos no cuentan con existencias<br>
                    <?php
                    $x=0;
                    for($i=0;$i <count($lista_carrito);$i++){


                        if($lista_carrito[$i]['existencias'] <= 0){
                            $x++;
                           echo $x."-".$lista_carrito[$i]['nombre'] ."<br>";
                        }


                    }
                    ?>
                </div>

                <div id="vta01">
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipo de Venta</label>
                                <select id="opcTipoVenta" onchange="fnVentaTipoVenta(this.value)" class="form-control input-lg text-bold text-center ">
                                    <option value="1">Contado</option>
                                    <option value="2">Credito</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipo de Pago</label>
                                <select class="form-control input-lg text-bold text-center" disabled onchange="fnVentaTipoPago(this.value)">
                                    <option value="1">Efectivo</option>
                                    <option value="2">Tarjerta</option>
                                    <option value="3">Combinado</option>
                                </select>
                            </div>
                        </div>



                        <div class="col-md-6">
                            <div class="form-group">
                                Fecha Entrega
                                <input readonly id="FechaEntrega" class="form-control text-center text-bold datepicker input-lg" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                Hora
                                <select id="HoraEntrega" style="padding: 3px" class="form-control input-lg">
                                    <option value="<?=date("h")?>"><?=date("h")?></option>
                                    <?php
                                    for($i=1;$i <= 12;$i++){
                                        if($i <= 9){$i = "0".$i ;}
                                        echo "<option>".$i."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 ">
                            <div class="form-group">
                                Minuto
                                <select id="MinutoEntrega" style="padding: 3px" class="form-control input-lg">
                                    <option value="<?=date("i")?>"><?=date("i")?></option>
                                    <?php
                                    for($i=1;$i < 60;$i++){
                                        if($i <= 9){$i = "0".$i ;}
                                        echo "<option>".$i."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                Hora
                                <select id="FormatoHora" style="padding: 3px" class="form-control input-lg">
                                    <option value="<?=date("A")?>"><?=date("A")?></option>
                                    <option value="am">AM</option>
                                    <option value="pm">PM</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                                <div class="form-group">
                                    <h3 id="txtPagoMinimo" class="text-center text-bold text-danger hidden">Pago inicial: <span id="idtotal_pago_inicial" class="currency"><?=$PagoInicial?></span></h3></label>
                                </div>
                                <div class="form-group has-warning">
                                    <label>Total a cobrar</label>
                                    <input class="form-control input-lg text-bold text-center  currency" id="idtotal_venta" value="<?=$Total?>" type="text" disabled />
                                </div>
                                <div id="gpoPagoEfectivo" class="form-group ">

                                    <label>Pago en efectico</label>
                                    <input class="form-control input-lg text-bold text-center currency " id="idpago_efectivo" type="text" />
                                </div>
                                <div id="gpoPagoTarjeta" class="form-group">
                                    <label>Pago en tarjeta</label>
                                    <input class="form-control input-lg text-bold text-center currency" id="idpago_tarjeta" type="text" />
                                </div>
                                <div class="form-group">
                                    <span id="btnRealizarCobro" class="btn btn-block  btn-sm btn-primary" onclick="fnVentaCobrarVenta(2)" ><i class="fa fa-dollar"></i> Aceptar Pago</span>
                                </div>
                        </div>
                    </div>

                </div>

                <div id="vta02" class="row hidden">
                    <div class="col-md-12">

                        <div class="row row-sm">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h3 class="text-bold text-center ">Folio Venta</h3>
                                    <input style="font-size: 32px;" class="form-control text-center text-bold input-lg" id="folio_venta" disabled />
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                        </div>

                        <div id="result_caja" class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h3 class="text-bold text-center ">Cambio</h3>
                                    <input style="font-size: 32px;" class="form-control text-center currency text-bold input-lg" id="total_cambio" disabled />
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn btn-block text-bold btn-default btn-sm" onclick="fnVentaImprimirTicket(1)"><i class="fa fa-print"></i> Imprimir Comprobante</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div id="modal_result"></div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
