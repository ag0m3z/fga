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

    setOpenModal("mdlReimpresionAportaciones");
    $(".currency").numeric({prefix:'$ ',cents:true});
    $("input").focus(function () {
        $(this).select();
    });

    $("#FolioAportacion").on('keyup',function () {
        $("#box2").addClass('hidden');
    });

    $("#FolioAportacion").on("keyup",function (e) {

        if(e.keyCode == 13){
            getAportaciones(6);
        }
    })

</script>
<div id="mdlReimpresionAportaciones" class="modal fade" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-dollar"></i> Reimprimir Ticket de <?=$Titulo?>
            </div>
            <div class="modal-body">

                <div id="box1" class="row row-sm">

                    <div class="col-md-12">
                        <div class="input-group">
                            <input id="FolioAportacion" class="form-control text-bold text-center" placeholder="Buscar Folio"/>
                            <span class="input-group-btn">
                                    <button class="btn btn-default" onclick="getAportaciones(6)"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>

                </div>
                <div id="box2" class="row hidden row-sm">

                    <div class="col-md-12">
                        <h4 class="text-center" id="tituloMovimiento"></h4>
                        <hr/>
                    </div>

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
                    <div class="col-md-12">
                        <div class="form-group">
                            <button onclick="WindowsOpenReport(2,{'idAportacion':$('#FolioAportacion').val()})" class="btn btn-block btn-default btn-sm"><i class="fa fa-print"></i> Imprimir</button>
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
