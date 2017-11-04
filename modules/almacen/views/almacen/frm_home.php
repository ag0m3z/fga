<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 17/04/2017
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
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();

$idEmpresa = $_SESSION['data_home']['idempresa'];
$idAlmacen = $_SESSION['data_home']['almacen'];

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);
?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/jsAlmacen.js"></script>
<script>
    $(".info-box").css('box-shadow','3px 4px 4px #a3a3a3');
    CargarTableroAlmacen(1,<?=$idEmpresa?>,<?=$idAlmacen?>);
    setTimeout(function () {
        $(".box ").addClass("animated bounceIn");
        $(".info-box ").addClass("animated flipInY");
    },500)
</script>
<div class="box box-success animated  fadeInDown">
    <div class="box-header">
        <i class="fa fa-database"></i> Almacen y Suministros
    </div>
    <div class="toolbars">

        <button class="btn btn-sm btn-primary" onclick="gn_menu_principal(5,5)"> <i class="fa fa-home"></i> Inicio</button>

        <div class="btn-group">
            <button class="btn btn-default btn-sm dropdown-toggle"
                    type="button" data-toggle="dropdown">
                <i class="fa fa-list-ol"></i> Inventario <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#" onclick="listar_inventarios(1,'ART',1,'Almacen General')"><i class="fa fa-list-alt"></i> Almacen General</a></li>
                <?php
                $connect->_query = "SELECT idalmacen,nombre_almacen from almacen WHERE idalmacen <> ".$_SESSION['sys_config']['almacen']." AND idempresa = ".$_SESSION['data_home']['idempresa']." ";
                $connect->get_result_query();
                for($i=0;$i < count($connect->_rows);$i++){
                    echo "<li><a href='#' onclick='listar_inventarios(1,\"ART\",".$connect->_rows[$i][0].",\"".$connect->_rows[$i][1]. "\")' ><i class='fa fa-list-alt'></i> ".$connect->_rows[$i][1]."</a></li>";
                }
                ?>
                <li class="divider"></li>
                <li><a href="#" onclick="listar_inventarios(1,'ART',999,'Todos los Almacenes')"><i class="fa fa-list-alt"></i> Todos</a></li>
            </ul>
        </div>

        <div class="btn-group">
            <button class="btn btn-default btn-sm dropdown-toggle"
                    type="button" data-toggle="dropdown">
                <i class="fa fa-truck"></i> Traspasos <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li class="dropdown-submenu">
                    <a href="#" class="dropdown-toggle" style="box-shadow: none !important;color: #000 !important;background: #fff !important;border: none !important;border-radius: 0px !important;" data-toggle="dropdown"><i class="fa fa-list-alt"></i> Listar traspasos de</a>
                    <ul class="dropdown-menu">
                        <?php
                        $connect->_query = "SELECT idalmacen,nombre_almacen FROM almacen WHERE idestado = 1 AND idempresa = '$idEmpresa'";
                        $connect->get_result_query();
                        for($i=0;$i<count($connect->_rows);$i++){
                            echo '<li><a href="#" onclick="fnListarTraspasos(1,'.$connect->_rows[$i][0].',\''.$connect->_rows[$i][1].'\')"><i class="fa fa-list-alt"></i> '.$connect->_rows[$i][1].'</a></li>';
                        }
                        ?>
                        <li><a href="#" onclick="fnListarTraspasos(2,0)"><i class="fa fa-list-alt"></i> Todos</a></li>
                    </ul>
                </li>
                <li class="divider"></li>
                <li><a href="#" onclick="fnListarTraspasos(3,0)"><i class="fa fa-check"></i> Traspasos por autorizar</a></li>
                <li><a href="#" onclick="fnListarTraspasos(4,0)"><i class=" text-green fa fa-check"></i> Traspasos por Confirmar</a></li>
                <li><a href="#" onclick="compras_nuevo_traspaso(2)" ><i class="fa fa-edit"></i> Solicitar Traspaso</a></li>
                <li><a href="#" onclick="compras_nuevo_traspaso(1)" ><i class="fa fa-file"></i> Nuevo Traspaso</a></li>
            </ul>
        </div>

        <div class="btn-group">
            <button class="btn btn-default btn-sm dropdown-toggle"
                    type="button" data-toggle="dropdown">
                <i class="fa fa-print"></i> Reportes <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#" onclick="fnReporteInventario(1)"><i class="fa fa-list"></i> Inventario</a></li>
                <li><a href="#"><i class="fa fa-truck"></i> Traspasos</a></li>
            </ul>
        </div>

    </div>

    <div id="lista_traspasos" class="box-body">

        <div class="row row-sm">

            <div class="col-md-6">

                <div class="box  box-warning">
                    <div class="box-header">
                        <h3 class="box-title"> Traspasos Por Autorizar</h3>
                        <span class="pull-right hidden"><span class="badge">00</span></span>
                    </div>
                    <div class="box-body table-responsive" >
                        <table class="table table-condensed table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Almacen Origen</th>
                                <th>Almacen Destino</th>
                                <th>Fecha</th>
                                <th></th>
                            </tr>
                            </thead>
                            <thead id="listaTraspasosAutorizar">
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"> Traspasos Por Confirmar</h3>
                        <span class="pull-right hidden"><span class="badge">00</span></span>
                    </div>
                    <div class="box-body table-responsive" >
                        <table class="table table-condensed table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Almacen Origen</th>
                                <th>Almacen Destino</th>
                                <th>Fecha</th>
                            </tr>
                            </thead>
                            <thead id="listaTraspasosConfirmar">
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">Ultimos 10 Traspasos</h3>
                        <span class="pull-right hidden"><span class="badge">00</span></span>
                    </div>
                    <div class="box-body table-responsive" >
                        <table class="table table-condensed table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Almacen Origen</th>
                                <th>Almacen Destino</th>
                                <th>Fecha</th>
                            </tr>
                            </thead>
                            <thead id="listaTraspasos">
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">

                <div class="row row-sm">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-green"><i class="fa fa-list-ol"></i></span>
                            <div class="info-box-content" id="IndicadorInventario">
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div><!-- /.col -->

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box shadow" >
                            <span class="info-box-icon bg-aqua"><i class="fa fa-truck"></i></span>
                            <div class="info-box-content" id="IndicadorTraspasos">
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div><!-- /.col -->

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-orange"><i class="fa fa-minus"></i></span>
                            <div class="info-box-content" id="IndicadorExisBajas">
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div><!-- /.col -->

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-red"><i class="fa fa-angle-double-left"></i></span>
                            <div class="info-box-content" id="IndicadorSinExistencias">
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div><!-- /.col -->
                </div>

                <div class="row row-sm">
                    <div class="col-md-12">
                        <div class="box box-warning">
                            <div class="box-header">
                                <h3 class="box-title">Productos con stock minimo</h3>
                            </div>
                            <div class="box-body no-padding table-responsive">
                                <table class="table table-bordered table-condensed table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>Articulos</th>
                                        <th>Almacen</th>
                                        <th>Cantidad</th>
                                    </tr>
                                    </thead>
                                    <tbody id="listaStockMinimo">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>


    </div>


</div>
