<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 29/05/2017
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
include "../../../../core/model_categorias.php";
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


$connect = new \core\model_categorias();
$connect->valida_session_id();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);

$idEmpresa = $_SESSION['data_home']['idempresa'];
$idAlmacen = $_SESSION['data_home']['almacen'];
$idCategoria = $_POST['idcategoria'];
$idSubCategoria = $_POST['idsubcategoria'];

$connect->_query = "
SELECT a.idarticulo,idalmacen,b.nombre_articulo,a.existencias,b.idtalla,d.nombre_catalogo,b.idtalla,b.idcolor 
FROM almacen_articulos as a 
LEFT JOIN articulos as b 
ON a.idarticulo = b.idarticulo 
LEFT JOIN catalogo_general as c 
ON c.idcatalogo = 2 AND c.opc_catalogo = b.idsubcategoria AND c.idempresa = $idEmpresa 
LEFT JOIN catalogo_general as d
ON d.idcatalogo = 3 AND d.opc_catalogo = b.idtalla AND c.idempresa = $idEmpresa 
WHERE a.existencias > 0 AND a.idalmacen = $idAlmacen AND b.idcategoria = $idCategoria AND b.idsubcategoria = $idSubCategoria AND b.idempresa = $idEmpresa GROUP BY b.idtalla
";

$connect->get_result_query();

$lista = $connect->_rows;

?>
<script>
    setOpenModal("mdl_categorias");
</script>
<div class="modal fade" id="mdl_categorias">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Seleccione la Talla
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12" style="max-height: 500px;overflow-y: scroll;" >
                        <?php



                        for($i=0; $i < count($lista); $i++){

                            $valor = $lista[$i][4]."-".$lista[$i][5];

                            echo "<button class='btn btn-app text-bold' onclick='$(\"#talla\").val(\"".$valor."\");$(\"#mdl_categorias\").modal(\"toggle\")' >".$lista[$i][5]."</button>";

                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
