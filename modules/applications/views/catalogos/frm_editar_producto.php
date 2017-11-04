<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 27/04/2017
 * Time: 03:43 PM
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

$connect = new \core\model_articulos();
$connect->valida_session_id();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);

$connect->get_articulos($_POST['idproducto'],$_SESSION['data_home']['idempresa']);
//var_dump($_POST);

?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/js_formato_moneda.js"></script>
<script>

    $('.currency').numeric({prefix:'$ ', cents: true});

    $("input").focus(function(){
        this.select();
    });

    validar_cierre = true;

    if($('#DataList').hasClass('no-padding')){
        $('#DataList').removeClass('no-padding');
    }
    $('.select2').select2();
    $('#btnNuevo_producto').hide();

    $('#imagen_producto').change(function(e) {
        addImage(e);
    });
    function addImage(e){
        var file = e.target.files[0],
            imageType = /image.*/;

        if (!file.type.match(imageType))
            return;

        var reader = new FileReader();
        reader.onload = fileOnload;
        reader.readAsDataURL(file);
    }

    function fileOnload(e) {
        var result=e.target.result;
        $('#imgSalida').attr("src",result);
    }

    $('.btn-app').addClass('disabled');

</script>
<div class="row">

    <form method="post" enctype="multipart/form-data" id="frm_imagen_producto">

        <div class="col-md-9">

            <div class="row margin-bottom">
                <div class="col-md-4">
                    <label>Codigo Producto</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                        <input type="text" id="codigo_producto" value="<?=$connect->getCodigo()?>" class="form-control" placeholder="Codigo o Clave de Producto">
                    </div>
                </div>
                <div class="col-md-8">
                    <label>Nombre producto</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-file"></i></span>
                        <input type="text" id="nombre_producto" value="<?=$connect->getNombreArticulo()?>" class="form-control" placeholder="Nombre del producto">
                        <input id="idarticulo" value="<?=$connect->getIDArticulo()?>" class="form-control hidden" />
                    </div>
                </div>
            </div>

            <div class="row margin-bottom">
                <div class="col-md-12">
                    <textarea id="descripcion_producto" class="form-control btn-block" placeholder="Descripcion"><?=$connect->getDescripcion()?></textarea>

                </div>
            </div>

            <div class="row margin-bottom">
                <div class="col-md-6">
                    <select class="form-control select2" style="width: 100%;" id="categoria_producto">
                        <option value="<?=$connect->getIDCategoria()?>"><?=$connect->getNombreCategoria()?></option>
                        <?php
                        $idCategoria = $connect->getIDCategoria();
                        $connect->_query = "SELECT opc_catalogo,nombre_catalogo FROM bdpvt.catalogo_general where idcatalogo = 1 AND opc_catalogo <> '$idCategoria'  and idestado = 1 AND idempresa = ".$_SESSION['data_home']['idempresa']." ORDER BY nombre_catalogo ASC";
                        $connect->get_result_query();
                        for($i = 0 ; $i < count($connect->_rows);$i++){
                            echo "<option value='".$connect->_rows[$i][0]."'>".$connect->_rows[$i][1]."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <select class="form-control select2" style="width: 100%;" id="subcategoria_producto">
                        <option value="<?=$connect->getIDSubcategoria()?>"><?=$connect->getNombreSubcategoria()?></option>
                        <?php
                        $idSubcategoria = $connect->getIDSubcategoria();
                        $connect->_query = "SELECT opc_catalogo,nombre_catalogo FROM bdpvt.catalogo_general where idcatalogo = 2 and idestado = 1 AND opc_catalogo <> '$idSubcategoria' AND idempresa = ".$_SESSION['data_home']['idempresa']." ORDER BY nombre_catalogo ASC";
                        $connect->get_result_query();
                        for($i = 0 ; $i < count($connect->_rows);$i++){
                            echo "<option value='".$connect->_rows[$i][0]."'>".$connect->_rows[$i][1]."</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row margin-bottom">
                <div class="col-md-6">
                    <select class="form-control select2" style="width: 100%;"  id="talla_producto">
                        <option value="<?=$connect->getIDTalla()?>"><?=$connect->getNombreTalla()?></option>
                        <?php
                        $idTalla = $connect->getIDTalla();
                        $connect->_query = "SELECT opc_catalogo,nombre_catalogo FROM bdpvt.catalogo_general where idcatalogo = 3 and opc_catalogo <> '$idTalla' and idestado = 1 AND idempresa = ".$_SESSION['data_home']['idempresa']." ORDER BY nombre_catalogo ASC";
                        $connect->get_result_query();
                        for($i = 0 ; $i < count($connect->_rows);$i++){
                            echo "<option value='".$connect->_rows[$i][0]."'>".$connect->_rows[$i][1]."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-eyedropper"></i></span>
                        <input type="text" id="idcolor" style="background: <?=$connect->getCodigoColor()?>" readonly onclick="fn_seleccionar_color(1,0,0)" value="<?=$connect->getIDColor()?>-<?=$connect->getCodigoColor()?>" class="form-control" placeholder="Color del producto ">
                    </div>
                </div>
            </div>

            <div class="row margin-bottom">
                <div class="col-md-3">
                    <label>Precio compra</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                        <input type="text" id="precio_compra" value="<?=$connect->getPrecioCompra()?>" onkeyup="setGeneraUtilidad(1,this.value,$('#porcentaje').val())" onblur="setGeneraUtilidad(1,this.value,$('#porcentaje').val())" class="form-control currency text-right" placeholder="Precio Compra">
                    </div>
                </div>
                <div class="col-md-2">
                    <label>% utilidad</label>
                    <div class="input-group">
                        <span class="input-group-addon">%</span>
                        <input type="number" value="<?=$connect->getUtilidad()?>" onkeyup="setGeneraUtilidad(1,$('#precio_compra').val(),this.value)" onblur="setGeneraUtilidad(1,$('#precio_compra').val(),this.value)" id="porcentaje" class="form-control" placeholder="Utilidad">
                    </div>
                </div>
                <div class="col-md-3">
                    <label>Precio venta</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                        <input type="text" id="precio_venta" value="<?=$connect->getPrecioVenta()?>" class="form-control currency text-right" placeholder="Precio Unitario">
                    </div>
                </div>
                <div class="col-md-2">
                    <label>Precio mayoreo</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                        <input type="text" id="precio_mayoreo" value="<?=$connect->getPrecioMayoreo()?>" class="form-control currency text-right" placeholder="Precio Mayore">
                    </div>
                </div>
                <div class="col-md-2">
                    <label>Cantidad mayoreo</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                        <input type="number" id="cantidad_mayoreo" value="<?=$connect->getCantidadMayoreo()?>" class="form-control" placeholder="Cantidad Mayoreo">
                    </div>
                </div>
            </div>

            <div class="row margin-bottom">
                <div class="col-md-3">
                    <label>Inventario minimo</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-minus"></i></span>
                        <input type="text" value="<?=$connect->getStockMinimo()?>" id="inventario_minimo_producto" class="form-control" placeholder="Inventario Minimo">
                    </div>
                </div>
                <div class="col-md-3">
                    <label>Inventario maximo</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-plus"></i></span>
                        <input type="text" id="inventario_maximo_producto" value="<?=$connect->getStockMaximo()?>" class="form-control" placeholder="Inventario Maximo">
                    </div>
                </div>
                <div class="col-md-3">
                    <label>Inventario inicial</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-list-ol"></i></span>
                        <input type="text" id="inventario_inicial_producto" value="0" class="form-control" disabled placeholder="Inventario Inicial">
                    </div>
                </div>
                <div class="col-md-3">
                    <label>Estado</label>
                    <select class="form-control" id="idestado_producto">
                        <?php
                        if($connect->getIDEstado() == 1){
                            echo '<option value="1">Activado</option><option value="0">Desactivado</option>';
                        }else{
                            echo '<option value="0">Desactivado</option><option value="1">Activado</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-3 hidden ">
            <div id="vista_previa_producto" style="max-height: 25vh">
                <img onclick="$('#imagen_producto').click();" id="imgSalida" src="site_design/img/wallpapers/wallpaper03.jpg" style="max-height: 25vh" class="img-responsive" alt="Cinque Terre">
            </div>
            <input class="hidden" type="file"  accept="file_extension| ,.gif, .jpg, .png," name="imagen_producto" id="imagen_producto" />
            <button onclick="$('#imagen_producto').click();"  type="button" class="btn btn-default btn-block">Cambiar imagen</button>
        </div>

    </form>

</div>


