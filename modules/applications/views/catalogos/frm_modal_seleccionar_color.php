<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 15/04/2017
 * Time: 02:35 PM
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
?>

<div class="modal fade" id="modal_seleccionar_color">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-size: 14px"> Seleccionar Color</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        $connect->_query = "SELECT opc_catalogo,nombre_catalogo,descripcion_catalogo FROM catalogo_general where idcatalogo = 4 AND idestado = 1 ";
                        $connect->get_result_query();
                        for($i=0;$i < count($connect->_rows);$i++){
                            echo "<a class='btn margin-bottom' style='border:1px solid #000;background: ".$connect->_rows[$i][1].";' onclick='fn_seleccionar_color(2,".$connect->_rows[$i][0].",\"".$connect->_rows[$i][1]."\")'>".$connect->_rows[$i][2]."</a> &nbsp;";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-sm" id="modalbtnclose" onclick="$('#modal_seleccionar_color').modal('toggle')"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        setOpenModal('modal_seleccionar_color');
    });
</script>