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

$lista = $connect->get_lista_categorias(1,$_SESSION['data_home']['idempresa']);

?>
<script>
    setOpenModal("mdl_categorias");
</script>
<div class="modal fade" id="mdl_categorias">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Categorías
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12" style="max-height: 500px;overflow-y: scroll;" >
                        <?php
                        for($i=0; $i < count($lista); $i++){

                            $valor = $lista[$i][0]."-".$lista[$i][2];

                            echo "<button class='btn btn-app text-bold' onclick='$(\"#categoria\").val(\"".$valor."\");$(\"#mdl_categorias\").modal(\"toggle\")' >".$lista[$i][2]."</button>";


                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
