<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 17/04/2017
 * Time: 05:32 PM
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
include "../../../../core/seguridad.class.php";

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
$connect = new \core\seguridad();
$connect->valida_session_id();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);

//var_dump($_POST);
?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/js_formato_moneda.js"></script>
<script>
    if($('#DataList').hasClass('no-padding')){
        $('#DataList').removeClass('no-padding');
    }
    $('#nombre_material').focus();

    $("#btnNuevo_material").hide();
    $("#btnEditar_material").hide();

    $('.currency').numeric({prefix:'$ ', cents: true});
    $("input").focus(function(){
        this.select();
    });
    $('.btn-app').addClass('disabled');
</script>
<div class="row">

    <div class="col-md-9">

        <div class="row margin-bottom">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-file"></i></span>
                    <input type="text" id="nombre_material" class="form-control" placeholder="Nombre del material">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-eyedropper"></i></span>
                    <input type="text" id="idcolor" readonly onclick="fn_seleccionar_color(1)" class="form-control" placeholder="Color">
                </div>
            </div>
        </div>

        <div class="row margin-bottom">
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                    <input type="text" id="precio_compra" onkeypress="setGeneraUtilidad(1,this.value,$('#porcentaje').val())" onblur="setGeneraUtilidad(1,this.value,$('#porcentaje').val())" Compra" value="0" class="form-control text-right currency" placeholder="Precio Compra">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-addon">%</span>
                    <input type="number" id="porcentaje" onkeypress="setGeneraUtilidad(1,$('#precio_compra').val(),this.value )" onblur="setGeneraUtilidad(1,$('#precio_compra').val(),this.value )"  value="50" class="form-control" placeholder="Utilidad">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                    <input type="text" id="precio_venta" value="0" class="form-control text-right currency" placeholder="Precio Unitario">
                </div>
            </div>
        </div>

        <div class="row margin-bottom">
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-minus"></i></span>
                    <input type="number" id="stock_minimo" value="0" class="form-control" placeholder="Inventario Minimo">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-plus"></i></span>
                    <input type="number" id="stock_maximo" value="0" class="form-control" placeholder="Inventario Maximo">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-control" disabled>
                    <option value="1">Activo</option>
                </select>
            </div>
        </div>

    </div>

</div>
