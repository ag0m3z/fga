<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 22/05/2017
 * Time: 01:13 PM
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
include "../../controller/model_almacen.php";
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
/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/

$almacen = new model_almacen();
$almacen->valida_session_id();

$lista_existencias = $almacen->listar_inventario($_POST['tipo_articulo'],$_POST['idalmacen'],$_POST['idempresa'],1);

$a = 1;
$_SESSION['EXPORT'] = $lista_existencias;

for($i=0;$i < count($lista_existencias);$i++){

    if($_POST['tipo_articulo'] == "MAT"){
        $Existencias = $almacen->getFormatFolio($lista_existencias[$i][7],4);
    }else{
        $Existencias = $almacen->getFormatFolio(intval($lista_existencias[$i][7]),4);
    }
    echo "<tr>
        <td>".$a++."</td>
        <td>".$lista_existencias[$i][6]."</td>
        <td>".$lista_existencias[$i][3]."</td>
        <td class='text-center'><span class='badge bg-light-blue'>".$Existencias."</span></td>
    </tr>";
}
?>
<script>
    $('#tabla_inventarios').DataTable({
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "aButtons": [ "xls", "pdf" ]
        },
        "bRetrieve":true,
        "paging": true,
        "lengthChange": true,
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