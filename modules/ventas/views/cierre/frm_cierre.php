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
$idEmpresa = $_SESSION['data_home']['idempresa'];
$idDepartamento = $_SESSION['data_home']['iddepartamento'];

$DateTIME = date("Y-m-d");

$connect->_query = "
         SELECT 
        (
        SELECT ifnull( MAX(date(fecha_apertura)),'NO') FROM apertura where idempresa = 1 AND iddepartamento = 1 ORDER BY fecha_apertura DESC
        )as FechaUltimaApertura,
        ifnull( MAX(date(fecha_cierre)),'NO') as FechaUltimoCierre,date(now()) as FechaActual 
        FROM cierre WHERE idempresa = $idEmpresa AND iddepartamento = $idDepartamento ORDER BY fecha_cierre DESC
         ";
$connect->get_result_query();

if($connect->_rows[0][1] == $DateTIME){
    \core\core::MyAlert("El cierre ya se realizo","alert");
    exit();
}

?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/js_formato_moneda.js"></script>
<script>
    setOpenModal("mdl_cierre_caja");
    $('.currency').numeric({prefix:'$ ', cents: true});
    $("input").focus(function(){$(this).select();});
</script>
<div class="modal fade" id="mdl_cierre_caja" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                Cierre
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Fecha Cierre</label>
                            <input id="fecha_cierre" class="form-control text-center text-bold input-lg" value="<?=$connect->_rows[0][0]?>" disabled />
                        </div>
                        <div class="form-group">
                            <label>Saldo Final en Caja</label>
                            <input id="saldo_final_caja" class="form-control text-center text-bold currency input-lg" placeholder="Saldo Final en caja" />
                        </div>
                        <div class="form-group">
                            <button class="btn btn-block btn-sm btn-warning" id="btnApertura" onclick="fnVentaCierreCaja(2)" >Realizar Cierre</button>
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