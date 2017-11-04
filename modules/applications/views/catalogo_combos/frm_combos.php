<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 11/06/2017
 * Time: 02:11 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";

include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();


?>
<div class="box box-success">
    <div class="box-header">
        <i class="fa fa-list-alt" ></i> Catalogo de combos
    </div>
    <div class="toolbars">
        <button class="btn btn-xs btn-primary" onclick="menu_catalogos(13,13)"><i class="fa fa-list-alt"></i> Lista combos</button>
        <button class="btn btn-xs btn-default" onclick="nuevo_combo(1)"><i class="fa fa-file"></i> Nuevo</button>
        <button class="btn btn-xs btn-success" onclick="nuevo_combo(3)"><i class="fa fa-save"></i> Guardar</button>

    </div>
    <div id="listCombos" class="box-body">


    </div>
</div>
