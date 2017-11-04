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

include "../../controller/ControllerCartTraspasos.php";

$carrito = new ControllerCartTraspasos();
$lista_carrito = $carrito->imprime_carrito();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);



$NombreProducto = $_POST['nombre_producto'];
$idalmacen_origen = $_POST['datos']['idalmacen_origen'];
$idalmacen_destino = $_POST['datos']['idalmacen_destino'];
$idusuario_solicita = $_POST['datos']['idusuario_solicita'];
$TipoProducto = $_POST['tipo_producto'];

if($_POST['tipo_producto'] == 0){

    $articulos->_query = "SELECT 
	a.idalmacen,a.idarticulo,b.nombre_articulo,a.tipo_articulo,a.existencias,b.stock_minimo 
    FROM 
        almacen_articulos as a 
    LEFT JOIN articulos as b 
    ON a.idarticulo = b.idarticulo
    WHERE 
        a.idempresa = 1 AND
        a.existencias > 0 AND
        a.idalmacen = $idalmacen_origen AND 
        b.nombre_articulo LIKE '%$NombreProducto%'";


}else{

    $articulos->_query = "SELECT 
	a.idalmacen,a.idarticulo,b.nombre_articulo,a.tipo_articulo,a.existencias,b.stock_minimo 
    FROM 
        almacen_articulos as a 
    LEFT JOIN articulos as b 
    ON a.idarticulo = b.idarticulo
    WHERE 
        a.idempresa = 1 AND
        a.existencias > 0 AND
        a.tipo_articulo = $TipoProducto AND 
        a.idalmacen = $idalmacen_origen AND 
        b.nombre_articulo LIKE '%$NombreProducto%'";
}

$articulos->get_result_query();
$lista_articulos = $articulos->_rows;

for($i=0; $i < count($lista_articulos); $i++){

    $idarticulo = $lista_articulos[$i][1];
    $nombre = $lista_articulos[$i][2];
    $existencias = $lista_articulos[$i][4];
    $tipo_articulo = $lista_articulos[$i][3];

    $data = json_encode(array(
       "idalmacen_origen"=>$idalmacen_origen,
        "idalmacen_destino"=>$idalmacen_destino,
        'idusuario_solicita'=>$idusuario_solicita,
    ));

    echo "<tr>
            <td>".$articulos->getFormatFolio($idarticulo,4)."</td>
            <td>".$nombre."</td>
            <td class='text-center'>$existencias</td>
            <td>
                <input class='form-control text-center' id='cantidad-$idarticulo' value='0' />
            </td>
            <td  class='text-center'>$tipo_articulo</td>
            <td><button class='btn btn-success' onclick='agregar_carrito_traspasos($idarticulo,\"".$nombre."\",\"".$tipo_articulo."\",$(\"#cantidad-".$idarticulo."\").val(),$existencias,$data,this)'><i class='fa fa-plus'></i></button></td>
    </tr>";
}
?>

<script>
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