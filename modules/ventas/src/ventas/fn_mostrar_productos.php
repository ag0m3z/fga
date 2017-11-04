<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 30/05/2017
 * Time: 05:06 PM
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

include "../../controller/ClassControllerCarritoVentas.php";
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

$carrito = new ClassControllerCarritoVentas();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);

$lista_carrito = $carrito->imprime_carrito();



$a=1;
for($i=0;$i < count($lista_carrito); $i++){

    $num_array = $i;
    $TipoDiseno =  $lista_carrito[$i]['TipoDiseno'];
    $Descripcion = $lista_carrito[$i]['descripcion'];

    $Importe = $lista_carrito[$i]['precio_venta'] + $TipoDiseno;
    $subtotal = ($Importe *  $lista_carrito[$i]['cantidad']);


    echo "<tr title='$Descripcion'>
        <td class='' width='15'>".$a++."</td>
        <td class=''>".$lista_carrito[$i]['nombre']."</td>
        <td class=' currency'>".$Importe."</td>
        <td class=''>".$lista_carrito[$i]['cantidad']."</td>
        <td class=''><span class='currency'>".$subtotal."</span></td>
        <td><span onclick='fnVentaEliminarProducto(".$num_array.")' class='fa fa-trash btn btn-link btn-xs text-danger'></span> </td>
    </tr>";

    $Total = $Total + $subtotal;
}

?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/js_formato_moneda.js"></script>
<script>
    $("#ledcaja").text(<?=$Total?>);
    $('.currency').numeric({prefix:'$ ', cents: true});

</script>
