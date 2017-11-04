<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 03/05/2017
 * Time: 05:58 PM
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
include "../../../../core/model_articulos.php";

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

$articulos = new \core\model_articulos();
$articulos->valida_session_id();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);


//Validar que venta el tipo de producto y el nombre no este vacio

if(array_key_exists('tipo_producto',$_POST) && array_key_exists('nombre_producto',$_POST)){

    //Sanatizar Datos
    $_POST = $articulos->get_sanatiza($_POST);

    $lista_articulos = $articulos->get_list($_POST['parametro'],$_SESSION['data_home']['idempresa'],$_POST['nombre_producto'],$_POST['tipo_producto']);

    for($i=0; $i < count($lista_articulos); $i++){

        $idarticulo = $lista_articulos[$i][0];
        $tipo_articulo = $lista_articulos[$i][6];
        $nombre = $lista_articulos[$i][1];
        $PrecioVenta = $lista_articulos[$i][3];
        $PrecioCompra = $lista_articulos[$i][5];


        echo "<tr>
            <td>".$articulos->getFormatFolio($idarticulo,4)."</td>
            <td width='490'>".$lista_articulos[$i][1]."</td>
            <td>".$tipo_articulo."</td>
            <td >
                <input style='width:80px' class='form-control text-center' id='cantidad-$idarticulo' value='0' />
            </td>
            <td ><input style='width:80px' class='form-control text-right' id='precio_venta-$idarticulo' value='$PrecioVenta' /></td>
            <td ><input style='width:80px' class='form-control text-right' id='precio_compra-$idarticulo' value='$PrecioCompra' /></td>
            <td><button style='width:80px' class='btn btn-success' onclick='agregar_carrito_compras($idarticulo,\"".$tipo_articulo."\",\"".$nombre."\",$(\"#cantidad-".$idarticulo."\").val(),$(\"#precio_venta-".$idarticulo."\").val(),$(\"#precio_compra-".$idarticulo."\").val(),this);'><i class='fa fa-shopping-cart'></i></button></td>
    </tr>";


    }

}else{

    \core\core::MyAlert("Error no se encontraron el tipo de producto o el nombre del producto esta vacio","alert");

}





?>
<script>
    $("input").focus(function(){$(this).select();});
    $('#example').DataTable({
        "bRetrieve":true,
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "language": {
            "lengthMenu": "Mostrar  _MENU_ registros",
            "zeroRecords": "Nothing found - sorry",
            "info": " Página _PAGE_ de _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "sSearch":        "Buscar:",
            "paginate": {
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
        }
    });
</script>
