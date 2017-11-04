<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 06/01/2017
 * Time: 10:38 AM
 */

include "core/core.class.php";
include "core/seguridad.class.php";
$core = new \core\core();
?>
    <!DOCTYPE html><html><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"><?php
    //framework Bootstrap
    $core::includeCSS("plugins/bootstrap/css/bootstrap.css",false);
    //frameworks fontawesome fonts
    $core::includeCSS("plugins/fonts/font-awesome/css/font-awesome.min.css",false);
    // estilo para select buscador
    $core::includeCSS("plugins/select2/select2.min.css",false);
    //tema de la aplicacion
    $core::includeCSS("site_design/css/AdminLTE.css",false);
    //themas
    $core::includeCSS("site_design/css/skins/_all-skins.css",false);

    $core::includeCSS("plugins/pnotify/pnotify.custom.min.css",false);

    $core::includeCSS("plugins/datatables/dataTables.bootstrap.css",false);
    $core::includeCSS("plugins/datatables/extensions/TableTools/css/dataTables.tableTools.css",false);

    // Nombre de la pagina
    ?><title>Sistema 12</title></head><body class="<?=\core\core::THEME_APP()?>   fixed sidebar-collapse sidebar-mini">
    <div class="wrapper">
        <?php include "modules/applications/layout/header.inc";
         include "modules/applications/layout/menu_principal.inc";?>
        <div class="content-wrapper">

        <div id="getBell"></div>
        <div id="show_modal"></div><div id="idgeneral"></div>
        <!-- Main content -->
        <section id="div_general" class="content ">

            <?php  //var_dump($_SESSION); ?>

            <div class="row animated fadeInLeft">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>00</h3>
                            <p>Compras</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-truck"></i>
                        </div>
                        <a href="#" data-toggle="tooltip" data-target="top" title="Prueba" class="small-box-footer">Mas Información <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>00</h3>
                            <p>Ventas</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-bar-chart"></i>
                        </div>
                        <a href="#" class="small-box-footer">Mas Información  <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>00</h3>
                            <p>Productos</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <a href="#" class="small-box-footer">Mas Información  <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>00</h3>
                            <p>Venta a Credito</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-minus-circle"></i>
                        </div>
                        <a href="#" data-toggle="modal" data-target="#mdl_nueva_categoria_producto" class="small-box-footer">Mas Información<i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->

            </div><!-- /.row -->

            <div class="row">
                <div class="col-md-6">

                    <div class="col-md-6">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-success ">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="box-header bg-success">
                                Top 5 Pendientes
                            </div>
                            <div class="box-footer no-padding">
                                <ul class="nav nav-stacked">
                                    <li><a href="#">Projects <span class="pull-right badge bg-blue">31</span></a></li>
                                    <li><a href="#">Tasks <span class="pull-right badge bg-aqua">05</span></a></li>
                                    <li><a href="#">Completed Projects <span class="pull-right badge bg-green">12</span></a></li>
                                    <li><a href="#">Followers <span class="pull-right badge bg-red">42</span></a></li>
                                </ul>
                            </div>
                        </div><!-- /.widget-user -->
                    </div><!-- /.col -->
                    <div class="col-md-6">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-danger ">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="box-header bg-danger">
                                Top 5 Pendientes
                            </div>
                            <div class="box-footer no-padding">
                                <ul class="nav nav-stacked">
                                    <li><a href="#">Projects <span class="pull-right badge bg-blue">31</span></a></li>
                                    <li><a href="#">Tasks <span class="pull-right badge bg-aqua">05</span></a></li>
                                    <li><a href="#">Completed Projects <span class="pull-right badge bg-green">12</span></a></li>
                                    <li><a href="#">Followers <span class="pull-right badge bg-red">42</span></a></li>
                                </ul>
                            </div>
                        </div><!-- /.widget-user -->
                    </div><!-- /.col -->
                    <div class="col-md-6">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-warning ">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="box-header bg-warning">
                                Top 5 Pendientes
                            </div>
                            <div class="box-footer no-padding">
                                <ul class="nav nav-stacked">
                                    <li><a href="#">Projects <span class="pull-right badge bg-blue">31</span></a></li>
                                    <li><a href="#">Tasks <span class="pull-right badge bg-aqua">05</span></a></li>
                                    <li><a href="#">Completed Projects <span class="pull-right badge bg-green">12</span></a></li>
                                    <li><a href="#">Followers <span class="pull-right badge bg-red">42</span></a></li>
                                </ul>
                            </div>
                        </div><!-- /.widget-user -->
                    </div><!-- /.col -->
                    <div class="col-md-6">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-info ">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="box-header bg-info">
                                Top 5 Pendientes
                            </div>
                            <div class="box-footer no-padding">
                                <ul class="nav nav-stacked">
                                    <li><a href="#">Projects <span class="pull-right badge bg-blue">31</span></a></li>
                                    <li><a href="#">Tasks <span class="pull-right badge bg-aqua">05</span></a></li>
                                    <li><a href="#">Completed Projects <span class="pull-right badge bg-green">12</span></a></li>
                                    <li><a href="#">Followers <span class="pull-right badge bg-red">42</span></a></li>
                                </ul>
                            </div>
                        </div><!-- /.widget-user -->
                    </div><!-- /.col -->

                </div>

                <div class="col-md-6">
                    <div id="grafica_sucursales"></div>
                </div>

            </div>

        </section>
        <!-- /.content -->

        </div>
        <?php include "modules/applications/layout/pie_de_pagina.inc"?>
        <?php include "modules/applications/layout/menu_right.inc"?>
    </div>
<?php
    $core::includeJS("plugins/jQuery/",true);
    $core::includeJS("site_design/js/app.js",false);
    $core::includeJS("plugins/jQueryUI/jQuery-ui.js",false);
    $core::includeJS("plugins/bootstrap/js/bootstrap.js",false);
    $core::includeJS("plugins/bootstrap/js/bootbox.min.js",false);
    //$core::includeJS("plugins/slimScroll/jquery.slimscroll.min.js",false);

    $core::includeJS("plugins/datatables/jquery.dataTables.js",false);
    $core::includeJS("plugins/datatables/dataTables.bootstrap.js",false);
    $core::includeJS("plugins/datatables/extensions/TableTools/js/dataTables.tableTools.js",false);

    $core::includeJS("plugins/Highcharts-5.0.10/code/highcharts.js",false);
    $core::includeJS("plugins/Highcharts-5.0.10/code/highcharts-3d.js",false);
    $core::includeJS("plugins/Highcharts-5.0.10/code/js/modules/exporting.js",false);

    $core::includeJS("plugins/select2/select2.full.min.js",false);
    $core::includeJS("plugins/pnotify/pnotify.custom.min.js",false);

    $core::includeJS("site_design/js/iKroAnimate.js",false);
    $core::includeJS("site_design/js/js_general.js",false);
    ?>
    <script language="JavaScript">
        $(document).ready(function(){

            $(".select2").select2();
            $("#head_buscar_cliente").focus();

            getBell(1);

            $("#head_buscar_cliente").on('keyup', function (e) {
                if (e.keyCode == 13) {
                    // Do something
                    setVentaPagos({'opc':1,'folio':this.value});
                }
            });

            $('.sidebar-menu li').click(
                function () {
                    $(".sidebar-menu li").removeClass("active");
                    $(this).addClass("active");
                }
            );

            var chart = new Highcharts.Chart({

                chart: {
                    renderTo:'grafica_sucursales',
                    type: 'column'
                },
                title: {
                    text: 'Ventas por sucursales'
                },
                subtitle: {
                    text: 'hockma.com'
                },
                xAxis: {
                    categories: [
                        'Ene',
                        'Feb',
                        'Mar',
                        'Abr',
                        'May',
                        'Jun',
                        'Jul',
                        'Ago',
                        'Sep',
                        'Oct',
                        'Nov',
                        'Dic'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Ventas'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y} </b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Sendero Escobedo',
                    data: [49, 71, 106, 129,0,0,0,0,0,0,0,0]

                }, {
                    name: 'Interplaza',
                    data: [83, 78, 98, 93,0,0,0,0,0,0,0,0]

                }]
            });

        });
    </script>
</body>
</html>
