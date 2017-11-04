<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 29/09/2017
 * Time: 12:09 AM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();

$idempresa = $_SESSION['data_home']['idempresa'];

$connect->_query = "SELECT idalmacen,nombre_almacen FROM almacen WHERE idempresa = $idempresa AND  idestado = 1 ORDER BY nombre_almacen";
$connect->get_result_query();
$ListaAlmacenes = $connect->_rows;

$connect->_query = "
	SELECT a.idarticulo,c.nombre_articulo,c.idcategoria,b.nombre_catalogo
	FROM almacen_articulos as a 
	LEFT JOIN articulos as c 
	ON a.idarticulo = c.idarticulo 
    LEFT JOIN catalogo_general as b 
	ON c.idcategoria = b.opc_catalogo AND b.idcatalogo = 1
    ORDER BY nombre_articulo
";
$connect->get_result_query();
$ListaArticulos = $connect->_rows;

//Eliminar Duplicados
$GrupoCategoria = array_unique($ListaArticulos);


?>
<script>
    setOpenModal("mdlReporteInventario");
</script>
<div class="modal fade" id="mdlReporteInventario" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" ><span aria-hidden="true">&times;</span></button>
                <i class="fa fa-search"></i> Reporte de Inventarios
            </div>
            <div class="modal-body">

                <div class="row row-sm">

                    <div class="col-md-6">
                        <div class="form-group">
                            Almacen
                            <select id="txtidAlmacen" class="form-control input-sm">
                                <option value="0">-- Todos los almacenes --</option>
                                <?php
                                for($i=0;$i<count($ListaAlmacenes);$i++){
                                    echo "<option value='".$ListaAlmacenes[$i][0]."'>".$ListaAlmacenes[$i][1]."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            Articulo
                            <select id="txtidArticulo" class="form-control input-sm">
                                <option value="0">-- Todos los articulo--</option>
                                <?php
                                for($i=0;$i<count($ListaArticulos);$i++){
                                    echo "<option value='".$ListaArticulos[$i][0]."'>".$ListaArticulos[$i][1]."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            Categoría
                            <select id="txtidCategoria" class="form-control input-sm">
                                <option value="0">-- Todas --</option>
                                <?php
                                for($i=0;$i<count($GrupoCategoria);$i++){
                                    echo "<option value='".$GrupoCategoria[$i][2]."'>".$GrupoCategoria[$i][3]."</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            Tipo de Articulo
                            <select id="txtidTipo" class="form-control input-sm">
                                <option value="0">-- Todos --</option>
                                <option value="1">ART</option>
                                <option value="2">MAT</option>
                            </select>
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary" onclick="fnReporteInventario(2)" ><i class="fa fa-search"></i> Buscar</button>
                <button class="btn btn-sm btn-danger" id="mdlBtnReporteInventario" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>

