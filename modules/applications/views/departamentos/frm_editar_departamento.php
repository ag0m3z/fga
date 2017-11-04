<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 17/04/2017
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
include "../../controllers/departamentos/ControllerDepartamentos.php";

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

$connect = new ControllerDepartamentos();
$connect->valida_session_id();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);

if(array_key_exists('iddepartamento',$_POST)){

    $connect->get_departamentos($_POST['iddepartamento'],$_SESSION['data_home']['idempresa']);

}else{
    \core\core::MyAlert("Error no se encontro el id del departamento","aler");
    exit();
}

?>
<script>

    $("input").focus(function(){
        this.select();
    });

    validar_cierre = true;

    if($('#DataList').hasClass('no-padding')){
        $('#DataList').removeClass('no-padding');
    }
    $('.select2').select2();
    $('#nombre_departamento').focus();
    $('.btn-app').addClass('disabled');

</script>

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Datos Generales</a></li>
        <li><a href="#tab_2" data-toggle="tab">Bitácora</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">

            <div class="row">

                <div class="col-md-10">

                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label>Nombre del departamento:</label>
                                <input id="nombre_departamento" value="<?=$connect->getNombreDepartamento()?>" class="form-control" placeholder="Nombre del departamento" />
                                <input id="iddepartamento" class="hidden" disabled value="<?=$_POST['iddepartamento']?>" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Almacen: </label>
                                <select id="idalmacen" class="form-control" >
                                    <option value="<?=$connect->getIDAlmacen()?>"><?=$connect->getNombreAlmacen()?></option>
                                    <?php
                                    $IDAlmacen= $connect->getIDAlmacen();
                                    $connect->_query = "SELECT idalmacen,nombre_almacen FROM almacen where idempresa = ".$_SESSION['data_home']['idempresa']." AND idalmacen <> '$IDAlmacen' ORDER BY nombre_almacen ASC ";
                                    $connect->get_result_query();
                                    for($i=0; $i < count($connect->_rows); $i++){
                                        echo "<option value='".$connect->_rows[$i][0]."' >".$connect->_rows[$i][1]."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Total Cajas: </label>
                                <input id="total_cajas" class="form-control" value="<?=$connect->getTotalCajas()?>" type="number" placeholder="Total cajas" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Domicilio: </label>
                                <input id="domicilio" class="form-control" value="<?=$connect->getDomicilio()?>" placeholder="Domicilio" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Correo: </label>
                                <input id="correo" type="email" value="<?=$connect->getCorreo()?>" class="form-control" placeholder="Correo" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Teléfono:</label>
                                <input id="telefono01" placeholder="Teléfono" value="<?=$connect->getTelefono01()?>" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Teléfono 2:</label>
                                <input id="telefono02" placeholder="Otro teléfono" value="<?=$connect->getTelefono02()?>" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Celular: </label>
                                <input id="celular" placeholder="celular" value="<?=$connect->getCelular()?>" class="form-control" />
                            </div>
                        </div>

                        <!-- Horarios-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Horarios de Lunes a Viernes</label>
                                <input class="form-control" id="horario_semanal" value="<?=$connect->getHorarioSemanal()?>" placeholder="Horario semanal" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Horario fin de semanas: </label>
                                <input class="form-control" value="<?=$connect->getHorarioFindeSemana()?>" id="horario_findesemana" placeholder="Horario fin de semanas" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Estado: </label>
                                <select id="idestado" class="form-control">
                                    <?php
                                    if($connect->getIDEstado() == 1){
                                        echo "<option value='1'>Activado</option><option value='0'>Desactivado</option>";
                                    }else{
                                        echo "<option value='0'>Desactivado</option><option value='1'>Activado</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane " id="tab_2">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        Usuario Alta:
                        <input class="form-control input-sm" disabled value="<?=$connect->getUsuarioAlta()?>" />
                    </div>
                    <div class="form-group">
                        Fecha Alta:
                        <input class="form-control" disabled value="<?=$connect->getFechaAlta()?>" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        Usuario UM:
                        <input class="form-control input-sm" disabled value="<?=$connect->getUsuarioUM()?>"  />
                    </div>
                    <div class="form-group">
                        Fecha UM:
                        <input class="form-control" disabled value="<?=$connect->getFechaUM()?>" />
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
