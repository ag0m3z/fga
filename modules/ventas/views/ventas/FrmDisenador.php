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

    setOpenModal("mdl_categorias");

    $("input").focus(function(){
        $(this).select();
    });
    
    $("th").addClass("bg-bareylev");
    
    $("#mat_todo").click(function () {

        if($(this).hasClass('btn-success')){
            $(this).removeClass('btn-success').addClass('btn-default');
            $('#txtCantidadMat').val(0);
        }else{
            $(this).removeClass('btn-default').addClass('btn-success');
            $('#txtCantidadMat').val(100);

        }

        $('.mat').removeClass('btn-success').addClass('btn-default');
        $('#mat_mitad').removeClass('btn-success').addClass('btn-default');

    });

    $("#mat_mitad").click(function () {

        if($(this).hasClass('btn-success')){
            $(this).removeClass('btn-success').addClass('btn-default');
            $('#txtCantidadMat').val(0);
        }else{
            $(this).removeClass('btn-default').addClass('btn-success');
            $('#txtCantidadMat').val(50);

        }

        $('#mat_todo').removeClass('btn-success').addClass('btn-default');
        $('.mat').removeClass('btn-success').addClass('btn-default');
    });

    $('.mat').click(function () {

        var Canditad = $('#txtCantidadMat');


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
<div class="modal fade" data-backdrop="static" id="mdl_categorias">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                Diseñador
            </div>
            <div class="modal-body scroll-auto table-responsive" style="min-height: 50vh;max-height: 50vh">

                <!-- Caja para buscar el Producto -->
                <div class="row" id="content01">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Buscar Producto:</label>
                            <input id="textSearch" placeholder="Ingrese más de 3 Caracteres" type="text" autofocus onkeyup="fnVentaOpenModal({'opc':2})" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-12 table-responsive"  style="max-height: 30vh;overflow-y: scroll;" >
                        <table class="table table-condensed table-hover">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th class='text-center'>Existencias</th>
                                <th width="70">Precio</th>
                                <th>Agregar</th>
                            </tr>
                            </thead>
                            <tbody id="lista_busqueda_producto">

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Caja para Agregar la descripcion y cantidad del producto Seleccionado -->
                <div class="row  hidden" id="content02">

                    <div class="col-md-12">
                        <div class="form-group ">
                            Producto:
                            <input class="form-control input-lg" id="producto" disabled placeholder="id del Producto" />
                        </div>
                        <div class="col-md-12 hidden">
                            <h3>Producto: <span class="text-success" id="txtNameProduc">Nombre</span></h3>
                        </div>
                        <div class="col-md-12">
                            <label>Agregar descripción</label>
                            <textarea rows="4" id="descripcion_por_producto" class="form-control input-lg"></textarea>
                        </div>
                        <div class="col-md-4">
                            &nbsp;
                            <button id="btnregresar" class="btn btn-lg btn-block btn-primary" onclick="getCrearTrabajo(2,{opc:1})"><i class="fa fa-arrow-left"></i> Regresar</button>
                        </div>
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-4">
                            &nbsp;
                            <button class="btn btn-default btn-lg btn-block" onclick="getCrearTrabajo(3,{})" ><i class="fa fa-plus"></i> Agregar</button>
                        </div>
                    </div>

                </div>

                <!-- Caja para agregar el material del producto -->
                <div class="row hidden" id="content03">

                    <div class="col-md-12">



                        <div id="tipoMaterial" class="form-group">
                            <div class="form-group ">
                                <h4>Seleccione el Tipo de Material</h4>
                            </div>
                            <button onclick="$('#content01MAT').removeClass('hidden');$('#tipoMaterial').addClass('hidden')" class="btn btn-default btn-app"><i class="fa fa-file"></i>Carta</button>
                            <button disabled class="btn btn-default btn-app"><i class="fa fa-file-photo-o"></i> Vinil</button>
                        </div>

                        <div class="hidden" id="content01MAT">
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

                        <div class="row hidden" id="content02MAT">

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
                                            <input disabled class="form-control  input-lg text-center" id="txtCantidadMat" value="100" type="text">
                                            <span class="input-group-addon text-bold" id="basic-addon2">%</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-lg btn-block btn-primary" onclick="$('#btnregresar2').removeClass('hidden');$('#txtCantidadMat').val(100);$('#content02MAT').addClass('hidden');$('#content01MAT').removeClass('hidden');"><i class="fa fa-arrow-left"></i> Regresar</button>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-default btn-lg btn-block" onclick="fnVentaAddCartMateriales(1)" ><i class="fa fa-plus"></i> Agregar</button>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-primary btn-lg btn-block" onclick="$('#txtCantidad').val(0);$('#content03MAT').removeClass('hidden');$('#content02MAT').addClass('hidden')" ><i class="fa fa-arrow-right"></i> Finalizar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row hidden" id="content03MAT">
                        <div class="col-md-12">
                            <div class="form-group padding-x5">
                                <label>Seleccione el Tipo de Diseño</label>
                                <select id="costotrabajo" class="form-control select2" style="width: 100%">
                                    <option value="sin">-- Tipo Diseño --</option>
                                    <?php
                                    $connect->_query = "SELECT moneda1,nombre_catalogo FROM catalogo_general where idestado = 1 AND idcatalogo = 7 ORDER BY nombre_catalogo ASC";
                                    $connect->get_result_query();
                                    for($i=0;$i <count($connect->_rows);$i++){
                                        echo "<option value='".$connect->_rows[$i][0]."'>".$connect->_rows[$i][1]." - ".$connect->setFormatoMoneda($connect->_rows[$i][0],'pesos')."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4">
                                &nbsp;
                                <button id="btnregresar3" class="btn btn-lg btn-block btn-primary" onclick="$('#txtCantidad').val(0);$('#content02MAT').removeClass('hidden');$('#content03MAT').addClass('hidden')"><i class="fa fa-arrow-left"></i> Regresar</button>
                            </div>
                            <div class="col-md-4">

                                <div class="input-group">
                                    Cantidad de Producto
                                    <input class="form-control input-lg text-center" id="txtCantidad" value="0" />
                                </div>

                            </div>
                            <div class="col-md-4">
                                &nbsp;
                                <button class="btn btn-default btn-lg btn-block" onclick="getCrearTrabajo(5,{});" ><i class="fa fa-plus"></i> Agregar</button>
                            </div>
                        </div>
                    </div>



                    <div id="btnregresar2" class="col-md-4">

                        <div class="col-md-6">
                            <button  class="btn btn-block btn-primary" onclick="getCrearTrabajo(2,{opc:2})"><i class="fa fa-arrow-left"></i> Regresar</button>
                        </div>
                        <div class="col-md-6">
                            <button  class="btn btn-block btn-default" onclick="$('#btnregresar2').addClass('hidden');$('#content03MAT').removeClass('hidden');$('#content01MAT').addClass('hidden');$('#tipoMaterial').addClass('hidden')"><i class="fa fa-arrow-right"></i> Sin Material</button>
                        </div>

                    </div>


                </div>

            </div>
            <div class="modal-footer">
                <button id="btnModalClose" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>

</div>
