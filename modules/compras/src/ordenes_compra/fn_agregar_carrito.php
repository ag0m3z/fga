<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 03/05/2017
 * Time: 06:51 PM
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

include "../../controllers/ControllerCart.php";

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

$carrito = new ControllerCart();

if($_POST['opc'] == 1){
    $carrito->introduce_producto($_POST['idarticulo'],$_POST['tipo_articulo'],$_POST['nombre_articulo'],$_POST['precio_compra'],$_POST['cantidad'],$_POST['precio_venta']);
}
$data =  $carrito->imprime_carrito();
$total_neto = 0;

for($i=0; $i < count($data);$i++){
    $total_neto = $total_neto + $data[$i]['total'];
    echo
    "<tr>
        <td>".$data[$i]['idarticulo']."</td>
        <td>".$data[$i]['cantidad']."</td>
        <td>".$data[$i]['nombre']."</td>
        <td>".$data[$i]['tipo_producto']."</td>
        <td class='text-right currency'>".$data[$i]['precio_compra']."</td>
        <td class='text-right currency'>".$data[$i]['total']."</td>
        <td><a href='#' onclick='fnCompraEliminarProducto(".$i.")' ><span class='fa fa-trash' ></span></a></td>
    </tr>";
}
$tota_iva = ($total_neto * 0);
$total = $total_neto + $tota_iva ;
?>

<script src="<?=\core\core::ROOT_APP()?>site_design/js/js_formato_moneda.js"></script>
<script>
    $('.currency').numeric({prefix:'$ ', cents: true});
</script>
<tr>
                <td colspan="4"></td>
                <td class="text-right text-bold" >Neto:</td>
                <td class="text-right currency"><?=$total_neto?></td>
            </tr>
            <tr class="hidden">
                <td colspan="4"></td>
                <td class="text-right text-bold">Iva 0:</td>
                <td class="text-right currency">0</td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td class="text-right text-bold">Total:</td>
                <td class="text-right currency"><?=$total?></td>
            </tr>