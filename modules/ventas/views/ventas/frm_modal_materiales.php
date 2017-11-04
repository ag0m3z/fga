<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 29/05/2017
 * Time: 12:30 PM
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
include "../../../../core/model_categorias.php";
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


$connect = new \core\model_categorias();
$connect->valida_session_id();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);

$idEmpresa = $_SESSION['data_home']['idempresa'];
$idAlmacen = $_SESSION['data_home']['almacen'];
?>
<script>
    setOpenModal("mdl_materiales");
    $("th").addClass("bg-bareylev");
    $("input").focus(function(){
        $(this).select();
    });


    $("#mat_todo").click(function () {

        if($(this).hasClass('btn-success')){
            $(this).removeClass('btn-success').addClass('btn-default');
            $('#txtCantidad').val(0);
        }else{
            $(this).removeClass('btn-default').addClass('btn-success');
            $('#txtCantidad').val(100);

        }

        $('.mat').removeClass('btn-success').addClass('btn-default');
        $('#mat_mitad').removeClass('btn-success').addClass('btn-default');

    });

    $("#mat_mitad").click(function () {

        if($(this).hasClass('btn-success')){
            $(this).removeClass('btn-success').addClass('btn-default');
            $('#txtCantidad').val(0);
        }else{
            $(this).removeClass('btn-default').addClass('btn-success');
            $('#txtCantidad').val(50);

        }

        $('#mat_todo').removeClass('btn-success').addClass('btn-default');
        $('.mat').removeClass('btn-success').addClass('btn-default');
    });

    $('.mat').click(function () {

        var Canditad = $('#txtCantidad');


        if($(this).hasClass('btn-success')){

            $(this).removeClass('btn-success').addClass('btn-default');
            Canditad.val(parseFloat(Canditad.val()) - 5);
        }else{


            $(this).removeClass('btn-default').addClass('btn-success');

            if( $("#mat_mitad").hasClass('btn-success')){
                $("#mat_mitad").removeClass('btn-success').addClass('btn-default');
                Canditad.val(0);
            }
            if( $("#mat_todo").hasClass('btn-success')){
                $("#mat_todo").removeClass('btn-success').addClass('btn-default');
                Canditad.val(0);
            }

            Canditad.val(parseFloat(Canditad.val()) + 5);



        }



    });

</script>
<div class="modal fade" data-backdrop="static" id="mdl_materiales">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Seleccione el Material
            </div>
            <div class="modal-body">

                <div id="content01">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                Nombre de Material
                                <input class="form-control" autofocus onkeyup="fnVentaOpenModal({'opc':4})" id="txtNombreMaterial" placeholder="Buscar Material" type="text" />
                            </div>
                        </div>
                    </div>

                    <div class="row" id="lista_materiales">

                    </div>
                </div>

                <div class="row hidden" id="content02">

                    <div class="col-md-12">
                        <div class="form-group">
                            <h4 class="title">Material: </h4>
                            <input class="form-control " disabled id="material">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <button class="btn mat btn-default">0.5</button><button class="btn mat btn-default">0.5</button><button class="btn mat btn-default">0.5</button><button class="btn mat btn-default">0.5</button><br>
                        <button class="btn mat btn-default">0.5</button><button class="btn mat btn-default">0.5</button><button class="btn mat btn-default">0.5</button><button class="btn mat btn-default">0.5</button><br>
                        <button class="btn mat btn-default">0.5</button><button class="btn mat btn-default">0.5</button><button class="btn mat btn-default">0.5</button><button class="btn mat btn-default">0.5</button><br>
                        <button class="btn mat btn-default">0.5</button><button class="btn mat btn-default">0.5</button><button class="btn mat btn-default">0.5</button><button class="btn mat btn-default">0.5</button><br>
                        <button class="btn mat btn-default">0.5</button><button class="btn mat btn-default">0.5</button><button class="btn mat btn-default">0.5</button><button class="btn mat btn-default">0.5</button><br><br>
                    </div>
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-6">
                                <button id="mat_todo" class="btn btn-block  btn-success"><i></i> Todo</button>
                            </div>
                            <div class="col-md-6 margin-bottom">
                                <button id="mat_mitad" class="btn btn-default btn-block"><i></i> Mitad</button>
                            </div>
                            <div class="col-md-12 margin-bottom">
                                <div class="input-group">
                                    <input disabled class="form-control  input-lg text-center" id="txtCantidad" value="100" type="text">
                                    <span class="input-group-addon text-bold" id="basic-addon2">%</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-lg btn-block btn-primary" onclick="$('#txtCantidad').val(1);$('#content02').addClass('hidden');$('#content01').removeClass('hidden');"><i class="fa fa-arrow-left"></i> Regresar</button>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-default btn-lg btn-block" onclick="fnVentaAddCartMateriales(1);$('#mdlBtnClose').click();" ><i class="fa fa-plus"></i> Agregar</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-danger" id="mdlBtnClose" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>

</div>
