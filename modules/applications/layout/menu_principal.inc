<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 06/01/2017
 * Time: 01:07 PM
 */
?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- sidebar menu: : style can be found in sidebar.less -->

        <ul class="sidebar-menu">

            <li class="active"><a href="#"onclick="location.reload()"><i class="fa fa-home  "></i> <span>Inicio</span></a></li>

            <?php
            $OptionView = 0;
            for($i=0;$i<count($_SESSION['data_menu']);$i++){

                $NombreModulo = $_SESSION['data_menu'][$i]['nombre'];
                $FaIcon = $_SESSION['data_menu'][$i]['icon'];
                $ScriptEventOnClick = $_SESSION['data_menu'][$i]['onclick'];

                $OptionView = ($_SESSION['data_menu'][$i]['consultar'] + $_SESSION['data_menu'][$i]['agregar'] + $_SESSION['data_menu'][$i]['editar'] + $_SESSION['data_menu'][$i]['eliminar']);

                if($OptionView > 0){
                    echo '<li><a href="#" '.$ScriptEventOnClick.' ><i class="fa '.$FaIcon.'"></i> <span>'.$NombreModulo.'</span> <i class="fa fa-caret-right pull-right"></i></a> </li>';
                }

            }


            ?>
            <li><a href="#" onclick="gn_menu_principal(14,14)"><i class="fa fa-gears  "></i> <span>Configuración</span><i class="fa fa-caret-right pull-right"></i> </a></li>
            <!--<li><a href="#" onclick="gn_menu_principal(5,5)"><i class="fa fa-database  "></i> <span>Almacen</span><i class="fa fa-caret-right pull-right"></i></a></li>
            <li><a href="#" onclick="gn_menu_principal(6,6)"><i class="fa fa-truck  "></i> <span>Compras</span><i class="fa fa-caret-right pull-right"></i></a></li>
            <li><a href="#" onclick="gn_menu_principal(9,9)"><i class="fa fa-calculator  "></i> <span>Ventas</span><i class="fa fa-caret-right pull-right"></i></a></li>
            <li><a href="#" onclick="gn_menu_principal(10,10)"><i class="fa fa-pie-chart  "></i> <span>Reportes</span><i class="fa fa-caret-right pull-right"></i></a></li>
            <li><a href="#" onclick="gn_menu_principal(8,8)"><i class="fa fa-dollar  "></i> <span>Contabilidad</span><i class="fa fa-caret-right pull-right"></i> </a></li>
            <li><a href="#" onclick="gn_menu_principal(7,7)"><i class="fa fa-list-alt  "></i> <span>Catálogos</span><i class="fa fa-caret-right pull-right"></i> </a></li>
            <li><a href="#" onclick="gn_menu_principal(14,14)"><i class="fa fa-gears  "></i> <span>Configuración</span><i class="fa fa-caret-right pull-right"></i> </a></li>
            <li><a href="#" onclick="gn_menu_principal(14,14)"><i class="fa fa-gears  "></i> <span>Configuración</span><i class="fa fa-caret-right pull-right"></i> </a></li>-->


            <li><a href="#" onclick="gnlogin_out()"><i class="fa fa-sign-out text-red"></i>  <span>Salir</span><i class="fa fa-close text-red pull-right"></i></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
