<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 04/09/2017
 * Time: 04:03 PM
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

$idEmpresa = $_SESSION['data_home']['idempresa'];

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);

if( array_key_exists('idcompra',$_POST) &&  empty($_POST['idcompra'])){
    \core\core::MyAlert("No existe la orden de compra","alert");
    exit;
}else{

    $idCompra = $_POST['idcompra'];

    $connect->_query = "
    select 
      a.idcompra,
      a.idproveedor,
      b.nombre_proveedor as Proveedor,
      a.iddepartamento_entrega,
      f.nombre_almacen,
      concat_ws(' ',c.nombre,c.apaterno,c.amaterno)as UsuarioAlta,
      a.fecha_alta
    from compra as a
    left join proveedores as b 
    on a.idproveedor = b.idproveedor
    left join perfil_usuarios as c 
    on a.idusuario_alta = c.idusuario 
    left join almacen as f 
    on a.iddepartamento_entrega = f.idalmacen 
    where a.idcompra = $idCompra ";

    $connect->get_result_query();
    $DataCompra = $connect->_rows;
    $idProveedor = $DataCompra[0][1];
    $idAlmacenEntrega = $DataCompra[0][3];

}
?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/js_formato_moneda.js"></script>
<script>
    $('.currency').numeric({prefix:'$ ', cents: true});
    setEditarFacturaCompra(3,<?=$idCompra?>);

</script>
<h3>Edición de Compra: <?=$_POST['idcompra']?></h3>
<div class="row row-sm">
    <div class="col-md-4">
        <div class="form-group">
            <label>Proveedor</label>
            <select id="idproveedor" class="form-control select2" style="width: 100%">
                <option value="<?=$idProveedor?>"><?=$DataCompra[0][2]?></option>
                <?php

                $connect->_query = "SELECT idproveedor,nombre_proveedor FROM proveedores WHERE idestado = 1 AND idproveedor <> $idProveedor AND idempresa = '$idEmpresa' ";
                $connect->get_result_query();

                for($i=0;$i <count($connect->_rows);$i++){
                    echo "<option value='".$connect->_rows[$i][0]."'>".$connect->_rows[$i][1]."</option>";
                }

                ?>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Almace Entrega</label>
            <select id="iddepartamento" class="form-control select2" style="width: 100%">
                <option value="<?=$DataCompra[0][3]?>"><?=$DataCompra[0][4]?></option>
                <?php
                $connect->_query = "SELECT idalmacen,nombre_almacen FROM almacen WHERE idestado = 1 AND idalmacen <> $idAlmacenEntrega AND idempresa = 1";
                $connect->get_result_query();
                if(count($connect->_rows) > 0){
                    for($i=0;$i<count($connect->_rows);$i++){
                        echo "<option value='".$connect->_rows[$i][0]."'>".$connect->_rows[$i][1]."</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Fecha</label>
            <input class="form-control text-right" disabled value="<?=$DataCompra[0][6]?>" />
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Orde de Compra Nº</label>
            <input class="form-control text-center" disabled value="<?=$connect->getFormatFolio(($idCompra),4)?>" />
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Agregar Productos</label>
            <button disabled class="btn  btn-info btn-block" onclick="nueva_orden_compra(2,0)" ><i class="fa fa-search"></i> Buscar Productos</button>
        </div>
    </div>

</div>
<div class="row row-sm">
    <div class="col-md-12">
        <table class="table table-hover table-striped table-bordered ">
            <thead>
            <tr>
                <th>Codigo</th>
                <th>Cant.</th>
                <th>Descripcion</th>
                <th>Tipo</th>
                <th width="300" class="text-right">Precio Unitario</th>
                <th width="300" class="text-right">Precio Total</th>
            </tr>
            </thead>
            <tbody id="lista_productos">
            <?php

            for($i=0;$i<count($DataCompra);$i++){

                $Subtotal = ( $DataCompra[$i][13] * $DataCompra[$i][11] );
                $Total = $Total + $Subtotal;
                $idArticulo = $DataCompra[$i][0];

                echo "<tr>
                    <td>".$DataCompra[$i][8]."</td>
                    <td>".$DataCompra[$i][11]."</td>
                    <td>".$DataCompra[$i][12]."</td>
                    <td>".$DataCompra[$i][9]."</td>
                    <td class='currency text-right'>".$DataCompra[$i][13]."</td>
                    <td class='text-right'><span class='currency '>".$Subtotal."</span> <a href='#' onclick='setEditarFacturaCompra(2,{idcompra:".$idCompra.",idarticulo:".$idArticulo."})'><i  class='fa fa-trash'></i></a> </td>
                </tr>";
            }

            ?>
            <tr>
                <td colspan="4"></td>
                <td class="text-right text-bold">Neto $</td>
                <td class="text-right currency"> <?=$Total?></td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td class="text-right text-bold">Neto $</td>
                <td class="text-right currency"> <?=$Total?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>