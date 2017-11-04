<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 09/10/2017
 * Time: 09:48 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();

?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/jsCalendario.js"></script>
<script>
    setOpenModal("mdlMovimientosDiario");
    $( ".datepicker" ).datepicker();
</script>
<div id="mdlMovimientosDiario" class="modal fade" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-search"></i> Reporte de Movimientos
            </div>
            <div class="modal-body">

                <div class="row row-sm">
                    <div class="col-md-12">
                        <div class="form-group">
                            Departamentos
                            <select class="form-control " disabled>
                                <option value="0">Todos</option>
                                <?php

                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                          Fecha Inicial
                          <input readonly value="<?=date("Y-m-d")?>" disabled class="form-control  datepicker" />
                      </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            Fecha Final
                            <input readonly value="<?=date("Y-m-d")?>" disabled class="form-control  datepicker" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            Usuario
                            <select class="form-control" disabled>
                                <option value="0">Todos</option>
                                <?php

                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            Estatus
                            <select class="form-control" disabled>
                                <option value="0">Todos</option>
                                <?php

                                ?>
                            </select>
                        </div>
                    </div>

                </div>


            </div>
            <div class="modal-footer">
                <button class="btn btn-default btn-sm" onclick="getReorteMovimientosDiario(2)"><i class="fa fa-search"></i> Buscar</button>
                <button class="btn btn-danger btn-sm" id="mdlMovimientos" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
