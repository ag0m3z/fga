<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 03/06/2017
 * Time: 09:25 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();
$idEmpresa = $_SESSION['data_home']['idempresa'];

?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/js_formato_moneda.js"></script>
<script>
    $('.currency').numeric({prefix:'$ ', cents: true});
    $("input").focus(function(){
        this.select();
    });

    $("#defaultTheme").on('change',function (e) {

        var theme = e.currentTarget.value;
        console.log(e.currentTarget.value);

        /**$("#defaultTheme option").each(function(){

            //Remover Thema Actual
            $("body").removeClass($(this).text());

            //alert('opcion '+$(this).text()+' valor '+ $(this).attr('value'));

        });**/
        $("body").removeClass();
        $("body").addClass('fixed sidebar-collapse sidebar-mini '+theme);
    });

    $('#imagen_producto').change(function(e) {
        addImage(e);
        fnreadURL(e);
    });
    function addImage(e){
        var file = e.target.files[0],
            imageType = /image.*/;

        if (!file.type.match(imageType))
            return;

        var reader = new FileReader();
        reader.onload = fileOnload;
        reader.readAsDataURL(file);
    }

    function fileOnload(e) {
        var result=e.target.result;
        $('#imgSalida').attr("src",result);
    }

    fnGnListarCostoTrabajo(1);
    fnGnListarImpresoras(1);

</script>
<div class="box box-warning animated fadeIn">
    <div class="box-header">
        <i class="fa fa-gears fa-spin"></i>Configuración del Sistema
    </div>
    <div class="toolbars">
        <button class="btn btn-sm btn-default" onclick="GuardarParametros()" ><i class="fa fa-save"></i> Guardar</button>
    </div>
    <div class="box-body">

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Datos Generales</a></li>
                <li class="disabled"><a href="#tab_2" >Servicios</a></li>
                <li><a href="#tab_3" data-toggle="tab">Credito y Costos</a></li>
                <li class="disabled"><a href="#tab_9" >Impresoras</a></li>
                <li class="hidden"><a href="#tab_5" data-toggle="tab">Notificaciones</a></li>
                <li class="hidden"><a href="#tab_6" data-toggle="tab">Alertas</a></li>
                <li ><a href="#tab_7" data-toggle="tab">Correos</a></li>
                <li class="pull-right"><a href="#" onclick="gn_menu_principal(14,14)"><i class="fa fa-refresh"></i></a></li>
            </ul>
            <div class="tab-content">

                <!-- Impresoras -->
                <div class="tab-pane " id="tab_9">
                    <div class="row">

                        <form id="formImpresoras">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Localidad</label>
                                    <select id="idsucursal" class="form-control input-sm">
                                        <option value="0">Seleccione una Localidad</option>
                                        <?php
                                        $connect->_query = "SELECT iddepartamento,nombre_departamento FROM departamentos where idestado = 1 AND tipo = 'S' AND idempresa = $idEmpresa order by nombre_departamento asc";
                                        $connect->get_result_query();
                                        for($i=0;$i < count($connect->_rows);$i++){
                                            echo "<option value='".$connect->_rows[$i][0]."'>".$connect->_rows[$i][1]."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Alias de la Impresora</label>
                                    <input id="aliasImpresora" placeholder="Alias de Impresora" class="form-control input-sm" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nombre de la Impresora</label>
                                    <input id="nombreImpresora" placeholder="Nombre de la impresora" class="form-control input-sm" />
                                </div>
                            </div>
                        </form>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Agregar</label><br>
                                <button class="btn btn-block btn-primary btn-sm" onclick="fnGnAgregarImpresora(1)"><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover table-condensed">
                                <thead>
                                <tr>
                                    <th>Sucursal</th>
                                    <th>Alias</th>
                                    <th>Nombre</th>
                                    <th>Funciones</th>
                                </tr>
                                </thead>
                                <tbody id="listarImpresoras">
                                <tr>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Datos Generales -->
                <div class="tab-pane active" id="tab_1">

                    <div class="row row-sm">

                        <div class="col-md-3">

                            <div id="vista_previa_producto" style="max-height: 25vh">
                                <img onclick="$('#imagen_producto').click();" id="imgSalida" src="site_design/img/logos/<?=$_SESSION['data_home']['logotipo']?>" style="max-height: 25vh" class="img-responsive" alt="Cinque Terre">
                            </div>
                            <input class="hidden" type="file"  accept="file_extension| ,.gif, .jpg, .png," name="imagen_producto" id="imagen_producto" />
                            <button onclick="$('#imagen_producto').click();"  type="button" class="btn btn-default btn-block">Cambiar imagen</button>

                        </div>
                        <div class="col-md-9">

                            <div class="row row-sm">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        Nombre Empresa
                                        <input id="nombreEmpresa" value="<?=$_SESSION['data_home']['nombre_empresa']?>" class="form-control input-sm" placeholder="Nombre de la empresa">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        Descripción
                                        <input id="descripcionEmpresa" value="<?=$_SESSION['data_home']['descripcion_empresa']?>" class="form-control input-sm" placeholder="Nombre de la empresa">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        Color de Tema
                                        <select id="defaultTheme" class="form-control input-sm">
                                            <option value="skin-vino">Tema Vino</option>
                                            <option value="skin-blue-gray">Tema Blue Gray</option>
                                            <option value="skin-cyan">Tema Cyan</option>
                                            <option value="skin-blue">Tema Blue</option>
                                            <option value="skin-blue-light">Tema Blue Light</option>
                                            <option value="skin-black">Tema Black</option>
                                            <option value="skin-black-light">Tema Black Light</option>
                                            <option value="skin-green"><span class="bg-red">&nbsp;</span>Tema Green</option>

                                            <option value="skin-green-light ">Tema Green Light</option>
                                            <option value="skin-red">Tema Red</option>
                                            <option value="skin-red-light">Tema Red Light</option>
                                            <option value="skin-yellow">Tema Yellow</option>
                                            <option value="skin-yellow-light">Tema Yellow Light</option>
                                            <option value="skin-purple">Tema Purple</option>
                                            <option value="skin-purple-light">Tema Purple Light</option>


                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row row-sm">

                                <div class="col-md-6">
                                    <div class="title-parametros">Horarios de Acceso</div>

                                    <div class="form-group">
                                        Hora inicial
                                        <input disabled class="form-control input-sm"/>
                                    </div>
                                    <div class="form-group">
                                        Hora Final
                                        <input disabled class="form-control input-sm"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="title-parametros">Horarios de Venta</div>

                                    <div class="form-group">
                                        Hora inicial
                                        <input disabled class="form-control input-sm"/>
                                    </div>
                                    <div class="form-group">
                                        Hora Final
                                        <input disabled class="form-control input-sm"/>
                                    </div>
                                </div>

                            </div>


                        </div>

                    </div>

                </div>

                <div class="tab-pane" id="tab_2">
                    <h3>Servicio no contratado</h3>
                </div>

                <!-- Creditos y Costos -->
                <div class="tab-pane" id="tab_3">
                    <div class="row">
                        <!-- PORCENTAJES IVA % -->
                        <div class="col-md-4">
                            <ul class="list-group">
                                <li class="list-group-item text-bold">% Agregar IVA</li>
                                <li class="list-group-item"><input id="ivaCompra" class="hidden" value="0"> Activar IVA en Compras <button class="btn btn-default pull-right btn-toggle" onc><i class="fa fa-toggle-on fa-2x text-green"></i></button></li>
                                <li class="list-group-item"><input id="ivaVenta" class="hidden" value="0"> Activar IVA en Ventas <button class="btn btn-default pull-right btn-toggle"><i class="fa fa-toggle-off fa-2x" ></i></button></li>
                                <li class="list-group-item text-bold"><i class="fa fa-cc-visa"></i> Medios de Pago</li>
                                <li class="list-group-item"><input id="medioPagoEfectivo" class="hidden" value="0"> Pago en Efectivo <button class="btn btn-default pull-right btn-toggle" onc><i class="fa fa-toggle-on fa-2x text-green"></i></button></li>
                                <li class="list-group-item"><input id="medioPagoTarjeta" class="hidden" value="0"> Pago con Tarjeta <button class="btn btn-default pull-right btn-toggle"><i class="fa fa-toggle-off fa-2x" ></i></button></li>
                            </ul>
                            <div class="title-parametros">Credito</div>
                            <div class="form-group">
                                % Pago inicial:
                                <div class="input-group">
                                    <span class="input-group-addon">%</span>
                                    <input type="number" id="pago_minimo_credito" value="<?=$_SESSION['sys_config']['pago_inicial']?>" class="form-control input-sm">
                                </div>
                            </div>

                            <div class="title-parametros">Medios de pagos</div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="1" checked disabled value="">
                                    Pagos en efectivo
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="2" > Pago con tarjeta
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="3"> Pago Combinado
                                </label>
                            </div>

                        </div>

                        <div class="col-md-8">


                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table no-border table-hover table-condensed">
                                        <thead>
                                        <tr>
                                            <th colspan="3" class="text-center">Costos de Trabajos</th>
                                        </tr>
                                        <tr style="border-bottom:1px solid #383838">
                                            <th>
                                                Nombre
                                            </th>
                                            <th colspan="2">
                                                Precio
                                            </th>
                                        </tr>
                                        <tr>
                                            <th><input id="nombreCostoTrabajo" class="form-control input-sm" placeholder="Nombre"/> </th>
                                            <th width="160"><input id="precioCostoTrabajo" class="form-control currency text-right input-sm" placeholder="Precio"/> </th>
                                            <th width="100"><button class="btn btn-sm btn-success" onclick="fnGnGuardarCostoTRabajo(1)"><i class="fa fa-plus"></i> Argegar</button></th>
                                        </tr>
                                        </thead>
                                        <tbody id="listaCostoTrabajos"></tbody>
                                    </table>
                                </div>
                            </div>


                        </div>

                    </div>

                </div>

                <div class="tab-pane" id="tab_5"></div>
                <div class="tab-pane" id="tab_6"></div>

                <!-- Correos de Alerta -->
                <div class="tab-pane" id="tab_7">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                Correo Notificacion
                                <input id="correoNotify" class="form-control" value="<?=$_SESSION['data_home']['correoEmpresa']?>" required placeholder="Corre de Notificaciones" type="email" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>