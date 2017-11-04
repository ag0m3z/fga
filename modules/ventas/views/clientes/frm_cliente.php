<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 09/06/2017
 * Time: 05:32 PM
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
include "../../controller/ClassControllerVentas.php";

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

$connect = new ClassControllerVentas();
$connect->valida_session_id();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);

?>

<script>
    $("th").addClass("bg-bareylev");



    $("#textSearch").select2({
        multiple: false,
        tokenSeparators: [',', ' '],
        minimumInputLength: 2,
        minimumResultsForSearch: 10,
        ajax: {
            url: "modules/ventas/src/clientes/fn_buscar_cliente.php",
            dataType: "json",
            type: "GET",
            data: function (params) {

                var queryParameters = {
                    term: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.tag_value,
                            id: item.tag_id
                        }
                    })
                };
            }
        }
    });

</script>

<div class="row row-sm">
    <div class="col-md-1">

        <div class="box box-info">

            <table class="table table-striped table-hover table-condensed">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Folios</th>
                </tr>
                </thead>
                <tbody id="lista_folios_cte">

                </tbody>
            </table>
        </div>

    </div>
    <div class="col-md-11">

        <div class="box box-success">

            <div class="box-body">

                <div class="row row-sm">
                    <div class="col-md-4">
                        <div class="form-group">
                            Nombre
                            <select id="textSearch" onchange="fnVentaHistorialCliente({'opc':2,'idcliente':this.value})" class="form-control select2 input-sm">

                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">

                        <div class="form-group">
                            Telefono
                            <input id="telefono_cliente" disabled class="form-control input-sm" placeholder="Telefono del cliente"/>
                        </div>


                    </div>

                    <div class="col-md-3">

                        <div class="form-group">
                            Celular
                            <input id="celular_cliente" disabled class="form-control input-sm" placeholder="Celular del cliente"/>
                        </div>

                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            Correo
                            <input id="correo_cliente" disabled class="form-control input-sm" placeholder="Correo del cliente"/>
                        </div>
                    </div>

                </div>


                <div id="detalle_venta" class="row row-sm"></div>

                <div class="row">
                    <div class="col-md-12">

                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
