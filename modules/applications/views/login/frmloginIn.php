<?php
include 'core/core.class.php';
$core = new \core\core();
?>
<!DOCTYPE html><html ><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"><?php
    $core::includeCSS('plugins/bootstrap/css/bootstrap.css',false);
    $core::includeCSS('plugins/fonts/font-awesome/css/font-awesome.min.css',false);
    $core::includeCSS('site_design/css/css_login.css',false);
    $core::includeCSS('site_design/css/AdminLTE.css',false);
?><title><?=$core::NAMEAPP("FGA Servicios")?></title></head><body class="full">
<nav class="navbar navbar-default navbar-fixed-top" style="box-shadow:4px 4px 5px rgba(71,71,71,0.85)"  role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->

            <span>
                <img class="img-responsive" src="site_design/img/logos/logo_200px.jpg">
            </span>

        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<div class="contenedor">
    <div class="row">
        <div class="container animated zoomIn">
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">

                    <div class="row">
                        <div class="col-md-12 animated fadeInDownBig">
                            <h2 class="text-center text-bold " style=" text-shadow: 2px 1px rgba(0,186,61,0.56);">FGA Servicios</h2>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4 col-md-push-6 margin">
                            <h4 class="text-center text-primary">Iniciar session</h4><br>
                            <form name="formlogIn01" action="#" onsubmit="fn_login(); return false;" method="post">
                                <div class="form-group hidden" >
                                    <label class="text-left text-white">Codigo de la empresa</label>
                                    <input  type="text" placeholder="codigo de la empresa" class="input-login ">
                                </div>
                                <div class="form-group">
                                    <label class="text-left text-white">Correo</label>
                                    <input id="login_user" type="text" placeholder="Correo / usuario" class="input-login ">
                                </div>
                                <div class="form-group margin-bottom">
                                    <label class="text-left text-white">Contraseña</label>
                                    <input id="login_pass" type="password" placeholder="Contrsaeña" class="input-login ">
                                </div>
                                <div id="div_result"></div>
                                <div class="form-group col-md-6" >
                                    <button type="submit" data-loading-text="Loading..." autocomplete="off" id="btn_login" class="btn btn-block btn-instagram btn-sm bg-aqua-gradient text-bold text-white" value="Iniciar Sesion" ><i class="fa fa-sign-in"></i> Iniciar Sesi&oacute;n</button>
                                </div>
                            </form>

                        </div>

                        <div class="col-md-6 col-md-pull-4 text-center" style="border-right: 1px solid#ccc; ">
                            <img class="img-push animated flipInY"  style="max-height: 35vh" src="site_design/img/wallpapers/Abstract-PNG.png"/>
                            <h2 class="text-bold "> <b class="text-primary">H</b>SD Punto de venta</h2>
                        </div>

                        <div class="col-md-2"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <br><br/>
                            <p class="text-center">
                                <b>Hockma SD</b>
                                es una herramienta con mayor transparencia para con nuestros clientes, mejoramos los niveles de atención y tenemos mayor control de calidad en los servicios aplicados.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>


        </div>
    </div>

</div>


</body>
<?php
$core::includeJS('plugins/jQuery/jQuery-2.2.0.min.js',false);
$core::includeJS('plugins/bootstrap/js/bootstrap.js',false);
$core::includeJS('plugins/bootstrap/js/bootbox.min.js',false);
$core::includeJS('site_design/js/js_login.js',false);
?><script language="JavaScript">
</script>
</html>