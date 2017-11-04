<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 09/06/2017
 * Time: 03:45 PM
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

include "../../controller/ClassControllerVentas.php";
/**
 * 1.- Instanciar la Clase seguridad y pasar como valor la BD del Usuario
 * 2.- Llamar al metodo @@valida_session_id($NoUsuario), para validar que el usuario este conectado y con una sesión valida
 *
 * Ejemplo:
 * Si se requiere cambiar de servidor de base de datos
 * $data_server = array(
 *   'bdHost'=>'192.168.2.5',
 *   'bdUser'=>'sa',
 *   'bdPass'=>'pasword',
 *   'port'=>'3306',
 *   'bdData'=>'dataBase'
 *);
 *
 * Si no es requerdio se puede dejar en null
 *
 * con @data_server
 * @@$seguridad = new \core\seguridad($_SESSION['data_login']['BDDatos'],$data_server);
 *
 * Sin @data_server
 * @@$seguridad = new \core\seguridad($_SESSION['data_login']['BDDatos']);
 *
 * @@$seguridad->valida_session_id($_SESSION['data_login']['NoUsuario']);
 */

$connect = new ClassControllerVentas();
$connect->valida_session_id();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);

if($_POST['folio'] == 0 ){
    exit();
}

$_POST = $connect->get_sanatiza($_POST);

$connect->putRealizarPago($_POST['folio']);
$importe_venta = 0;
$importe_pagado = 0;
$importe_pendiente= 0;

if($connect->_confirm){

    for($i=0;$i<count($connect->_rows);$i++){

        $importe_venta = $connect->_rows[0][4];
        if($connect->_rows[$i]['idestatus'] == "A"){

            $importe_pagado = ($importe_pagado + $connect->_rows[$i][5]);
        }


    }

    $TipoVenta = $connect->_rows[0][1];
    $importe_pendiente = ($importe_venta - $importe_pagado);

    if($importe_pagado >= $importe_venta){
        \core\core::MyAlert("El cliente ya saldo la cuenta","alert");
        $Hide= "hide";
        $activetab = "active";
    }else{
        $Hide="";
        $activetab = "";
    }

}else{


    \core\core::MyAlert($connect->_message,"error");
    exit();

}
?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/js_formato_moneda.js"></script>
<script>
    $(".currency").numeric({prefix:'$ ', cents: true});
    $("input").focus(function(){
        $(this).select();
    });
</script>
<div class="col-md-12">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active <?=$Hide?>"><a href="#tab_1" data-toggle="tab">Datos Generales</a></li>
            <li class="hide"><a href="#tab_2" data-toggle="tab">Detalle de venta</a></li>
            <li class="<?=$activetab?>" ><a href="#tab_3" data-toggle="tab">Pagos</a></li>
        </ul>
        <div class="tab-content">

            <div class="tab-pane active <?=$Hide?>" id="tab_1">
                <div class="row">
                    <div class="col-md-12 hidden">
                        <div class="form-group">
                            <label>Importe Total</label>
                            <input id="textTipoVenta" class="form-control text-bold text-center input-lg" value="<?=$TipoVenta?>" disabled type="text" />
                            <input id="textImporteTotal" class="form-control text-bold text-center   currency input-lg" value="<?=$importe_venta?>" disabled type="text" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Saldo Pendiente</label>
                            <input id="textSaldoPendiente" class="form-control text-bold text-center   currency input-lg" value="<?=$importe_pendiente?>" disabled type="text" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Pago</label>
                            <input id="textPago" class="form-control text-bold text-center  currency input-lg" type="text" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <button id="btnAceptarPago" onclick="fnVentaAceptarPago()" class="btn btn-primary btn-block">Aceptar</button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="tab-pane" id="tab_2">

            </div>

            <div class="tab-pane <?=$activetab?> no-padding" id="tab_3">

                <table class="table table-hover table-condensed">
                    <thead>
                    <tr>
                        <th>Num. Pago</th>
                        <th>Importe</th>
                        <th>Pago</th>
                        <th>Estatus</th>
                        <th>Fecha</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    for($i=0;$i<count($connect->_rows);$i++){

                        $importe_venta = $connect->_rows[0][4];
                        if($connect->_rows[$i]['idestatus'] == "A"){

                            $importe_pagado = ($importe_pagado + $connect->_rows[$i][5]);



                        }
                        echo "<tr>
                                <td>".$connect->getFormatFolio($connect->_rows[$i][3],4)."</td>
                                <td class='currency' >".$connect->_rows[$i][4]."</td>
                                <td class='currency' >".$connect->_rows[$i][5]."</td>
                                <td>".$connect->_rows[$i]['idestatus']."</td>
                                <td>".$connect->_rows[$i][11]."</td>
                             </tr>";

                    }

                    ?>
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</div>

