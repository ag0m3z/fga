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

?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/js_formato_moneda.js"></script>
<script>

    setOpenModal("mdlEntradas");
    $(".currency").numeric({prefix:'$ ',cents:true});
    $("input").focus(function () {
        $(this).select();
    });

</script>
<div id="mdlEntradas" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-dollar"></i> Entrada de Dinero a Caja
            </div>
            <div class="modal-body">

                <div id="box1" class="row row-sm">
                    <div class="col-md-12">
                        <div class="form-group">
                            Concepto
                            <select id="idconcepto" class="form-control">
                                <option value="0">Seleccione un Concepto</option>
                                <option value="1">Sobrante</option>
                            </select>
                        </div>
                        <div class="form-group">
                            Importe
                            <input id="importe_entrada" class="form-control currency text-right"/>
                        </div>
                        <div class="form-group">
                            Observaciones
                            <textarea id="observaciones" class="form-control" placeholder="Observaciónes"></textarea>
                        </div>
                    </div>
                </div>
                <div id="box2" class="row hidden row-sm">
                    <div class="col-md-12">
                        <div class="form-group">
                            Folio De Entrada
                            <input id="FolioEntrada" readonly class="form-control text-bold text-center" />
                        </div>
                        <div class="form-group">
                            <button onclick="WindowsOpenReport(1,{'idEntrada':$('#FolioEntrada').val()})" class="btn btn-block btn-default btn-sm"><i class="fa fa-print"></i> Imprimir</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm" id="mdlBtnGuardar" onclick="getEntradas(2)" ><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-danger btn-sm" id="mdlBtnClose" data-dismiss="modal"><i class="fa fa-close"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
