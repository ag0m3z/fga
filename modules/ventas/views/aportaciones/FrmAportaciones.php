<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 06/10/2017
 * Time: 07:00 PM
 */
include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();

$Tipo = $_POST['TipoAportacion'];

if($Tipo == 1){
    $Titulo = "Aportacion";
}else{
    $Titulo = "Retiro";
}

?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/js_formato_moneda.js"></script>
<script>

    setOpenModal("mdlAportaciones");
    $(".currency").numeric({prefix:'$ ',cents:true});
    $("input").focus(function () {
        $(this).select();
    });

</script>
<div id="mdlAportaciones" class="modal fade" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-dollar"></i> <?=$Titulo?> de Dinero
            </div>
            <div class="modal-body">

                <div id="box1" class="row row-sm">
                    <div class="col-md-6">
                        <div class="form-group">
                            Sucursal Origen
                            <select id="sucursal_origen" class="form-control">
                                <option value="0">Seleccione un Concepto</option>
                                <option value="1">Sucursal 1</option>
                                <option value="2">Sucursal 2</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            Sucursal Destino
                            <select id="sucursal_destino" class="form-control">
                                <option value="0">Seleccione una Sucursal</option>
                                <option value="1">Sucursal 1</option>
                                <option value="2">Sucursal 2</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            Importe
                            <input id="importe_aportacion" class="form-control currency text-right" />
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea id="observaciones" placeholder="Observaciónes" class="form-control"></textarea>
                        </div>
                    </div>

                </div>
                <div id="box2" class="row hidden row-sm">
                    <div class="col-md-12">
                        <div class="form-group">
                            Folio de <?=$Titulo?>
                            <input id="FolioAportacion" readonly class="form-control text-bold text-center" />
                        </div>
                        <div class="form-group">
                            <button class="btn btn-block btn-default btn-sm" onclick="WindowsOpenReport(2,{idAportacion:$('#FolioAportacion').val()})" ><i class="fa fa-print"></i> Imprimir</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm" id="mdlBtnGuardar" onclick="getAportaciones(2,<?=$Tipo?>)" ><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-danger btn-sm" id="mdlBtnClose" data-dismiss="modal"><i class="fa fa-close"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
