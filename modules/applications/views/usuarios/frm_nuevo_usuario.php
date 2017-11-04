<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 12/06/2017
 * Time: 05:51 PM
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
unset($_SESSION['EXPORT']);

$connect->_query = "SELECT iddepartamento,nombre_departamento FROM departamentos where idestado = 1";
$connect->get_result_query();
$listaDepartamentos = $connect->_rows;

$connect->_query = "SELECT opc_catalogo,nombre_catalogo FROM catalogo_general where idcatalogo = 5 AND idestado = 1";
$connect->get_result_query();
$listaPerfiles = $connect->_rows;
?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/jsCatalogos.js"></script>
<script>
    if($('#DataList').hasClass('no-padding')){
        $('#DataList').removeClass('no-padding');
    }
    $("#btnGuardarNuevoUsaurio").removeClass("hidden");
    $("td").addClass('text-centar');

    $("#idperfil").on('change',function (e) {

        /**
         * 1 Administrador
         * 2 Vendedor y cajero
         * 3 Diseñador
         * 4 Supervisor
         * 5 Gerente
         */

        var perfil = $("#idperfil").val();



    });

</script>
<div class="row">
    <div class="col-md-4">

        <div class="box box-info">
            <div class="box-header">
                Datos Generales
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            Nombre
                            <input id="nombre" class="form-control input-sm" placeholder="Nombre ">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            Ap Paterno
                            <input id="apaterno" class="form-control input-sm" placeholder="Apellido Paterno ">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            Ap Materno
                            <input id="amaterno" class="form-control input-sm" placeholder="Apellido Materno ">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            Telefono
                            <input id="telefono" class="form-control input-sm" placeholder="Telefono 1">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            Celular
                            <input id="celular" class="form-control input-sm" placeholder="Celular">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            Sucursal
                            <select class="form-control input-sm" id="idsucursal">
                                <option value="0">-- Seleccione una Sucursal --</option>
                                <?php

                                for($i=0;$i<count($listaDepartamentos);$i++){
                                    echo "<option value='".$listaDepartamentos[$i][0]."'>".$listaDepartamentos[$i][1]."</option>";
                                }

                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="col-md-8">

        <div class="box box-warning">
            <div class="box-header">
                Datos de Acceso
            </div>
            <div class="box-body">

                <div class="row">
                    <div class="col-md-4">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    Nick Name
                                    <input id="nickname" class="form-control input-sm" placeholder="Nombre para mostrar">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    Usuario
                                    <input id="usuario_login" class="form-control input-sm" placeholder="Usuario de Acceso">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    Contraseña
                                    <input id="clave1" type="password" class="form-control input-sm" placeholder="Contraseña">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    Contraseña
                                    <input id="clave2" type="password" class="form-control input-sm" placeholder="Confirmar Contraseña">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    Perfil
                                    <select id="idperfil" class="form-control input-sm" >
                                        <option value="0">-- Seleccione un Perfil --</option>
                                        <?php

                                        for($i=0;$i<count($listaPerfiles);$i++){
                                            echo "<option value='".$listaPerfiles[$i][0]."'>".$listaPerfiles[$i][1]."</option>";
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-8 table-responsive">

                        <table class="table table-hover table-condensed">
                            <thead>
                            <tr>
                                <th>Modulo</th>
                                <th width="10">Consultar</th>
                                <th width="10" >Agregar</th>
                                <th width="10">Modificar</th>
                                <th width="10">Eliminar</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Almacen</td>
                                    <td class="text-center"> <input name="app[]" value="1-c" type="checkbox" ></td>
                                    <td class="text-center"> <input name="app[]" value="1-a" type="checkbox" ></td>
                                    <td class="text-center"> <input name="app[]" value="1-m" type="checkbox" ></td>
                                    <td class="text-center"> <input name="app[]" value="1-e" type="checkbox" ></td>
                                </tr>
                                <tr>
                                    <td>Compras</td>
                                    <td class="text-center"> <input name="app[]" value="2-c" type="checkbox" ></td>
                                    <td class="text-center"> <input name="app[]" value="2-a" type="checkbox" ></td>
                                    <td class="text-center"> <input name="app[]" value="2-m" type="checkbox" ></td>
                                    <td class="text-center"> <input name="app[]" value="2-e" type="checkbox" ></td>
                                </tr>
                                <tr>
                                    <td>Ventas</td>
                                    <td class="text-center"> <input name="app[]" value="3-c" type="checkbox" ></td>
                                    <td class="text-center"> <input name="app[]" value="3-a" type="checkbox" ></td>
                                    <td class="text-center"> <input name="app[]" value="3-m" type="checkbox" ></td>
                                    <td class="text-center"> <input name="app[]" value="3-e" type="checkbox" ></td>
                                </tr>
                                <tr>
                                    <td>Reportes</td>
                                    <td class="text-center"> <input name="app[]" value="4-c" type="checkbox" ></td>
                                    <td class="text-center"> <input name="app[]" value="4-a" type="checkbox" ></td>
                                    <td class="text-center"> <input name="app[]" value="4-m" type="checkbox" ></td>
                                    <td class="text-center"> <input name="app[]" value="4-e" type="checkbox" ></td>
                                </tr>
                                <tr>
                                    <td>Contabilidad</td>
                                    <td class="text-center"> <input name="app[]" value="5-c" type="checkbox" ></td>
                                    <td class="text-center"> <input name="app[]" value="5-a" type="checkbox" ></td>
                                    <td class="text-center"> <input name="app[]" value="5-m" type="checkbox" ></td>
                                    <td class="text-center"> <input name="app[]" value="5-e" type="checkbox" ></td>
                                </tr>
                                <tr>
                                    <td>Catalogos</td>
                                    <td class="text-center"> <input name="app[]" value="6-c" type="checkbox" ></td>
                                    <td class="text-center"> <input name="app[]" value="6-a" type="checkbox" ></td>
                                    <td class="text-center"> <input name="app[]" value="6-m" type="checkbox" ></td>
                                    <td class="text-center"> <input name="app[]" value="6-e" type="checkbox" ></td>
                                </tr>

                            </tbody>
                        </table>


                    </div>

                </div>



            </div>
        </div>

    </div>
</div>
