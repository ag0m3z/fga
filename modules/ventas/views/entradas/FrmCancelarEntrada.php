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

$Titulo = "";

if($_POST['Tipo']==1){
    $Titulo="Entrada";
    $Tipo = "E";
}else{
    $Titulo = "Salida";
    $Tipo="S";
}

?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/js_formato_moneda.js"></script>
<script>

    setOpenModal("mdlCancelarEntradas");
    $(".currency").numeric({prefix:'$ ',cents:true});
    $("input").focus(function () {
        $(this).select();
    });

    $("#FolioEntrada").on('keyup',function () {
        $("#box2").addClass('hidden');
    });

    $("#FolioEntrada").on("keyup",function (e) {

        if(e.keyCode == 13){
            getEntradas(6,'<?=$Tipo?>');
        }
    })

</script>
<div id="mdlCancelarEntradas" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <i class="fa fa-dollar"></i> Cancelación de <?=$Titulo?>
            </div>

            <div class="modal-body">

                <div id="box1" class="row row-sm">
                    <div class="col-md-12">
                        <div class="input-group">
                            <input id="FolioEntrada" class="form-control text-bold text-center" placeholder="Buscar Folio"/>
                            <span class="input-group-btn">
                                    <button class="btn btn-default" onclick="getEntradas(6,'<?=$Tipo?>')"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>

                <div id="box2" class="row hidden row-sm">
                    <div class="col-md-12">
                        <br>
                        <h4 class="text-center" id="tituloMovimiento"></h4>
                        <hr/>

                        <div class="form-group ">
                            <a class="btn btn-link btn-sm" href="#collapseExample" ria-controls="collapseExample" data-toggle="collapse">Mostrar / Ocultar detalle</a>
                        </div>
                        <div class="collapse" id="collapseExample">
                            <div class="form-group">
                                <label>Importe</label>
                                <input id="importe" readonly class="form-control text-right currency " />
                            </div>
                            <div class="form-group">
                                <label>Descripción</label>
                                <textarea readonly class="form-control" id="observacion"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Motivo</label>
                            <textarea class="form-control" id="motivo"></textarea>
                        </div>
                        <div class="form-group">
                            <button onclick="getCancelarEntradaSalidas(2,'<?=$Tipo?>',$('#FolioEntrada').val())" class="btn btn-block btn-warning btn-sm"><i class="fa fa-save"></i> Realizar Cancelación</button>
                        </div>
                    </div>
                </div>

                <div id="box3" class="row hidden row-sm">
                    <div class="form-group">
                        <label>Folio de Cancelación</label>
                        <input id="FolioCancelacion" readonly class="form-control text-right currency " />
                    </div>
                    <div class="form-group">
                        <button onclick="WindowsOpenReport(3,{'idEntrada':$('#FolioCancelacion').val()})" class="btn btn-block btn-default btn-sm"><i class="fa fa-print"></i> Imprimir</button>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-sm" id="mdlBtnClose" data-dismiss="modal"><i class="fa fa-close"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
