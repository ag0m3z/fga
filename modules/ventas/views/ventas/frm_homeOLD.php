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
unset($_SESSION['cart_venta']);
unset($_SESSION['cart_costo_trabajo']);

if($_SESSION['myPrint'] ==""){
 $valPrint = 0;
}
$idEmpresa = $_SESSION['data_home']['iddepartamento'];

?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/jsVentas.js"></script>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/jsCatalogos.js"></script>

<script>




    $(".select2").select2();
    $("#idcliente").click(function(){
        $(this).focus();
    })
    $("th").addClass("bg-bareylev");

    shortcut.add("Ctrl+1",function () {
        fnVentaOpenModal({'opc':8})
    });

    shortcut.add("Ctrl+2",function () {
        //Buscar Producto
        fnVentaOpenModal({'opc':1});

    });

    shortcut.add("Ctrl+3",function () {
        //Agregar Material
        fnVentaOpenModal({'opc':3});
    });

    shortcut.add("Ctrl+4",function () {
        //Cobrar Caja
        fnVentaCobrarVenta(1);
    });
</script>
<div class="modal fade" id="mdlSeleccionarImpresora" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Seleccionar Impresora <?=$idEmpresa?>
            </div>
            <div class="modal-body">
                <table class="table">
                    <?php
                    $connect->_query = "select opc_catalogo,nombre_catalogo,descripcion_catalogo from catalogo_general WHERE idcatalogo = 8 and opc_catalogo2 = $idEmpresa and idestado = 1";
                    $connect->get_result_query();
                    for($i=0;$i<count($connect->_rows);$i++){
                        echo '<tr><td><a href="#" onclick="mdlSeleccionarImpresora(2,\''.$connect->_rows[$i][2].'\')">'.$connect->_rows[$i][2].'</a> </td></tr>';
                    }
                    ?>
                </table>
            </div>
            <div class="modal-footer">
                <button id="btnCloseModalChangePrinter" class="btn btn-danger btn-sm " data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>

</div>
<div class="box box-info animated fadeInDown">

    <div class="box-header">
        <i class="fa fa-calculator"></i>

        <button class="btn btn-sm btn-success" onclick="gn_menu_principal(9,9)" ><i class="fa fa-home"></i> Nueva venta </button>

        <button class="btn btn-sm btn-default" > Trabajos Pendientes</button>

        <button class="btn btn-sm btn-info hidden" onclick="gn_menu_principal(15,15)" ><i class="fa fa-dollar"></i> Servicios </button>

        <button class="btn btn-sm btn-default" onclick="setVentaPagos({'opc':1,'folio':0})"><i class="fa fa-dollar"></i> Pagos </button>

        <div class="btn-group">
            <button class="btn btn-warning btn-sm dropdown-toggle"
                    type="button" data-toggle="dropdown">
                Caja <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#"  onclick="fnVentaOpenModal({'opc':5})">Apertura</a></li>
                <li><a href="#"  onclick="fnVentaOpenModal({'opc':7})">Arqueo</a></li>
                <li><a href="#"  onclick="fnVentaOpenModal({'opc':6})">Cierre</a></li>
            </ul>
        </div>

        <button class="btn btn-sm btn-primary" onclick="fnVentaHistorialCliente({'opc':1})" ><i class="fa fa-list"></i> Historial Cliente </button>

        <div class="btn-group">
            <button class="btn btn-default btn-sm dropdown-toggle"
                    type="button" data-toggle="dropdown">
                Re Impresiones <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#" onclick="setVentaPagos({'opc':3,'folio':0})">Folio de Venta</a></li>
                <li class="hidden"><a href="#">Folio de Pago</a></li>
                <li class="hidden"><a href="#">Cancelaciones</a></li>
                <li class="hidden dropdown-submenu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li class="dropdown-submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">One more separated link</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="divider"></li>
                <li><a href="#">Entrada y Salidas</a></li>
                <li><a href="#">Aportaciones y Retiros</a></li>
            </ul>
        </div>

        <div class="btn-group">
            <button class="btn btn-danger btn-sm dropdown-toggle"
                    type="button" data-toggle="dropdown">
                Cancelaciones <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#" onclick="setVentaPagos({'opc':5,'folio':0})" >Folio de Venta</a></li>
                <li class="divider"></li>
                <li><a href="#">Entradas</a></li>
                <li><a href="#">Salidas</a></li>
                <li><a href="#">Aportaciones</a></li>
                <li><a href="#">Retiros</a></li>
            </ul>
        </div>

        <div class="btn-group">
            <button class="btn btn-default btn-sm dropdown-toggle"
                    type="button" data-toggle="dropdown">
                Reportes <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#" onclick="fnVentaCorteDiario(1)" >Movimientos Diario</a></li>
                <li><a href="#" onclick="fnVentaCorteDiario(2)" >Corto Diario</a></li>
                <li><a href="#" onclick="fnVentaCorteDiario(1)" >Notas Terminadas</a></li>
                <li><a href="#" onclick="fnVentaCorteDiario(1)" >Notas Pendientes</a></li>
                <li><a href="#">Entradas y salidas</a></li>
                <li><a href="#">Aportaciones y Retiros</a></li>
                <li class="divider"></li>
                <li><a href="#">Detallado</a></li>
            </ul>
        </div>
    </div>

    <div id="form_caja" class="box-body">

        <div id="cashOpen" class=" hidden">
            <div class="row row-sm">
                <div class="col-md-8">
                    <div class="box box-primary">
                        <div class="box-body">

                            <div class="row row-sm">

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-group">
                                          <span class="input-group-btn">
                                            <button class="btn btn-warning"  onclick="fnVentaOpenModal({'opc':1})"  type="button"><i class="fa fa-search"></i> Producto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                                          </span>
                                                <input type="text" readonly  ondblclick="fnVentaOpenModal({'opc':1})"   class="form-control" placeholder="Seleccione un producto">
                                                <div id="precio_producto" class="input-group-addon">$ 00</div>
                                            </div><!-- /input-group -->
                                        </div>
                                    </div><br>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-group">
                                          <span class="input-group-btn">
                                            <button class="btn btn-default" onclick="fnVentaOpenModal({'opc':3})" type="button">Selec. Material</button>
                                          </span>
                                                <input type="text" disabled class="form-control" placeholder="...">

                                            </div><!-- /input-group -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row row-sm">

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-group">
                                          <span class="input-group-btn">
                                            <button class="btn btn-default" onclick="nuevo_cliente(1,1)" disabled type="button"><i class="fa fa-file-photo-o"></i> Tipo Diseño</button>
                                          </span>
                                                <select id="costotrabajo" onchange="fnAgregarTipoDiseno(this.value)" class="form-control select2" style="width: 100%">
                                                    <option value="0">-- Tipo Diseño --</option>
                                                    <?php
                                                    $connect->_query = "SELECT opc_catalogo,nombre_catalogo FROM catalogo_general where idestado = 1 AND idcatalogo = 7 ORDER BY nombre_catalogo ASC";
                                                    $connect->get_result_query();
                                                    for($i=0;$i <count($connect->_rows);$i++){
                                                        echo "<option value='".$connect->_rows[$i][0]."'>".$connect->_rows[$i][1]."</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div><!-- /input-group -->
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-group">
                                          <span class="input-group-btn">
                                            <button class="btn btn-default" onclick="nuevo_cliente(1,1)" type="button"><i class="fa fa-user"></i> Clinte Nuevo</button>
                                          </span>
                                                <select id="idcliente" class="form-control select2" style="width: 100%">
                                                    <?php
                                                    $connect->_query = "SELECT idcliente,nombre_completo FROM clientes where idestado = 1 ORDER BY nombre_completo ASC";
                                                    $connect->get_result_query();
                                                    for($i=0;$i <count($connect->_rows);$i++){
                                                        echo "<option value='".$connect->_rows[$i][0]."'>".$connect->_rows[$i][1]."</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div><!-- /input-group -->
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <br>
                            <div class="row row-sm">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea id="descripcion_general" class="form-control input-sm" placeholder="Ingrese la descripción" ></textarea>
                                        </div>
                                    </div><br>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-success">
                        <div class="box-body">
                            <div class="bg-black currency text-center" id="ledcaja" style="padding: 6px;margin: 2px;height: 70px;font-size: 38px;"> $0.00</div>
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-condensed table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>producto</th>
                                            <th>precio</th>
                                            <th>cantidad</th>
                                            <th>total</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody class="small" id="list_cart_ventas">

                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-success" onclick="fnVentaCobrarVenta(1)"><i class="fa fa-dollar"></i> Cobrar</button>
                                    <button class="btn btn-danger" onclick="gn_menu_principal(9,9)"><i class="fa fa-close"></i> Cancelar Venta</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12">
                    <label class="text-blue"><a href="#" onclick="fnVentaOpenModal({'opc':8})"> << VENTA RAPIDA (ctrl + 1) >> &nbsp; </a></label>
                    <label class="text-red"> << BUSCAR PRODUCTO (ctrl + 2) >> &nbsp;</label>
                    <label class="text-green" > << AGREGAR (ctrl + 3) > >&nbsp;</label>
                    <label class="text-fuchsia" > << COBRAR (ctrl + 4) >>&nbsp;</label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="callout callout-danger">
                    <h4>No se ha realizado el cierre del dia anterior !</h4>
                    <p>Realize primeramente el cierre del día anterior, para hacer la apertura de la caja.</p>
                </div>
            </div>
        </div>

    </div>

</div>
