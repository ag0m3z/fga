<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 05/06/2017
 * Time: 10:44 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect  = new \core\seguridad();
$connect->valida_session_id();


?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/js_formato_moneda.js"></script>
<script>
    setOpenModal("mdl_apertura_caja");
    $('.currency').numeric({prefix:'$ ', cents: true});
    $("input").focus(function(){$(this).select();});
</script>
<div class="modal fade" id="mdl_apertura_caja" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                Apertura
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            Fecha Apertura
                            <input id="FechaApertura" value="<?=$_POST['FechaApertura']?>" class="form-control text-center text-bold input-lg" placeholder="Fecha Apertura" disabled />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            Saldo Inicial
                            <input id="SaldoApertura" class="form-control text-center text-bold currency input-lg" placeholder="Saldo Inicial de la caja" />
                        </div>
                        <div class="form-group">
                            <button class="btn btn-block btn-sm btn-primary" id="btnApertura" onclick="setApertura(2,0,0)" ><i class="fa fa-money"></i> Realizar apertura</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>