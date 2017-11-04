<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 22/05/2017
 * Time: 12:19 PM
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
include "../../controller/model_almacen.php";

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

$almacen = new model_almacen();

?>
<script>
    $("th").addClass("bg-bareylev");

    $("#btnProductos").click(function(){

        $("#btnMateriales").removeClass('btn-success  btn-default').addClass('btn-default');

        $(this).removeClass('btn-success  btn-default').addClass('btn-success');

    });
    $("#btnMateriales").click(function(){

        $("#btnProductos").removeClass('btn-success btn-default').addClass('btn-default');
        $(this).removeClass('btn-success  btn-default').addClass('btn-success');

    });

    $("#btnProductos").click();

</script>

<div class="row">
    <div class="col-md-12">

        <form class="form-inline">
            <div class="btn-group" role="group" aria-label="...">
                <button id="btnProductos" onclick="listar_inventario3('ART',<?=$_POST['idalmacen']?>,<?=$_SESSION['data_home']['idempresa']?>)" type="button" class="btn btn-sm btn-default"> Productos</button>
                <button id="btnMateriales" onclick="listar_inventario3('MAT',<?=$_POST['idalmacen']?>,<?=$_SESSION['data_home']['idempresa']?>)" type="button" class="btn btn-sm btn-default" > Materiales</button>
                <button class="btn btn-sm btn-default" type="button"><i class="fa fa-file-excel-o"></i></button>
                <h4 class="pull-right" id="titulo_lista_almacenes"> </h4>
            </div>
            <div class="form-group">
                <label class="sr-only" for="exampleInputEmail3">Email address</label>
                <input type="email" class="form-control hidden text-right input-sm" id="fecha_inicial" placeholder="Fecha Inicial">
            </div>
            <div class="form-group">
                <label class="sr-only" for="exampleInputPassword3">Password</label>
                <input type="password" class="form-control hidden text-right input-sm" id="fecha_final" placeholder="Fecha Final">
            </div>
        </form>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <h3 class="text-center"><?=$_POST['str']?></h3>
        <table id="tabla_inventarios" style="margin-top: -10px" class="table table-condensed table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Almacen</th>
                <th>Existencios</th>
            </tr>
            </thead>
            <tbody id="tabla_lista_inventarios">

            </tbody>
        </table>
    </div>
</div>

