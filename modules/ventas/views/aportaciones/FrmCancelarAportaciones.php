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

$Tipo = $_POST['Tipo'];

if($Tipo == 1){
    $Titulo = "Cancelación de Aportacion";
}else{
    $Titulo = "Cancelación de Retiro";
}

?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/js_formato_moneda.js"></script>
<script>

    setOpenModal("mdlCancelacionAportaciones");
    $(".currency").numeric({prefix:'$ ',cents:true});
    $("input").focus(function () {
        $(this).select();
    });

    $("#FolioAportacion").on('keyup',function () {
        $("#box2").addClass('hidden');
    });

    $("#FolioAportacion").on("keyup",function (e) {

        if(e.keyCode == 13){
            getAportaciones(6,<?=$Tipo?>);
        }
    });

</script>
<div id="mdlCancelacionAportaciones" class="modal fade" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-dollar"></i> <?=$Titulo?>
            </div>
            <div class="modal-body">

                <div id="box1" class="row row-sm">
                    <div class="col-md-12">
                        <div class="input-group">
                            <input id="FolioAportacion" class="form-control text-bold text-center" placeholder="Buscar Folio"/>
                            <span class="input-group-btn">
                                    <button class="btn btn-default"  onclick="getAportaciones(6,<?=$Tipo?>)"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>

                <div id="box2" class="row hidden row-sm">
                    <br>
                    <div class="form-group ">
                        <a class="btn btn-link btn-sm" href="#collapseExample2" data-toggle="collapse">Mostrar / Ocultar detalle</a>
                    </div>
                   <div class="collapse" id="collapseExample2">
                       <div class="col-md-6">
                           <div class="form-group">
                               <label>Sucursal Origen</label>
                               <input id="cajaorigen" class="form-control" readonly />
                           </div>
                       </div>

                       <div class="col-md-6">
                           <div class="form-group">
                               <label>Sucursal Destino</label>
                               <input id="cajadestino" class="form-control" readonly>
                           </div>
                       </div>

                       <div class="col-md-12">
                           <div class="form-group">
                               <label>Importe</label>
                               <input id="importe" readonly class="form-control text-right currency " />
                           </div>
                       </div>
                       <div class="col-md-12">
                           <div class="form-group">
                               <label>Descripción</label>
                               <textarea readonly class="form-control" id="observacion"></textarea>
                           </div>
                       </div>
                   </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Motivo Cancelación</label>
                            <textarea id="motivo" placeholder="Motivo Cancelación" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <button class="btn btn-block btn-warning btn-sm" onclick="getCancelarAportacionesRetiros(2,<?=$Tipo?>,0)"><i class="fa fa-ban"></i> Realizar Cancelación</button>
                        </div>
                    </div>

                </div>
                <div id="box3" class="row hidden row-sm">
                    <div class="col-md-12">
                        <div class="form-group">
                            Folio <?=$Titulo?>
                            <input id="FolioCancelacion" readonly class="form-control text-bold text-center" />
                        </div>
                        <div class="form-group">
                            <button class="btn btn-block btn-default btn-sm" onclick="WindowsOpenReport(4,{idAportacion:$('#FolioCancelacion').val()})" ><i class="fa fa-print"></i> Imprimir</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-sm" id="mdlBtnClose" data-dismiss="modal"><i class="fa fa-close"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
