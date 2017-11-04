<header class="main-header">
    <!-- Logo -->
    <a href="#" onclick="location.reload()" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b> <?=substr($_SESSION['data_home']['nombre_empresa'],0,3)?></b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b><i class="fa fa-shopping-basket"></i> <?=$_SESSION['data_home']['nombre_empresa']?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o animated flip  "></i>
                        <span class="label label-success">0</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li class="hidden"><!-- start message -->
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="site_design/img/faces/avatars/default.png" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            Support Team
                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <!-- end message -->

                            </ul>
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
                    </ul>
                </li>

                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o animated flip "></i>
                        <span class="label label-warning">0</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li class="hidden"><!-- start message -->
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="site_design/img/faces/avatars/default.png" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            Support Team
                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <!-- end message -->

                            </ul>
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
                    </ul>
                </li>
                <!-- Notifications: style can be found in dropdown.less -->
                <!-- Tasks: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o animated flip  "></i>
                        <span id="alert_bell" class="label label-danger">0</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header text-bold">Existencias Bajas</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul id="list_bell" class="menu">

                            </ul>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>
                <li>
                    <div class="navbar-form navbar-right" method="post" >
                        <div class="form-group">
                            <input type="text" id="head_buscar_cliente" style="border-radius: 15px " class="form-control" placeholder=" Buscar Folio, clientes">
                        </div>
                    </div>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i> <?=$_SESSION['data_login']['nick_name']?>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="site_design/img/faces/avatars/default.png" class="img-circle" alt="User Image">
                            <p>
                                <?=$_SESSION['data_login']['nick_name']?>
                                <small><?=$_SESSION['data_home']['nombre_departamento']?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body hidden">
                            <div class="col-xs-4 text-center">
                                <a href="#"></a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#"></a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#"></a>
                            </div>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" disabled="" class="btn btn-default btn-flat">Perfil</a>
                            </div>
                            <div class="pull-right">
                                <a href="#" class="btn btn-default btn-flat" onclick="gnlogin_out()">Salir</a>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" onclick="requestFullScreen()"><i class="fa fa-arrows-alt" aria-hidden="true"></i></a>
                </li>
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>