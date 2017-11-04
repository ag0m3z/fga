<?php
/**
 * Created by PhpStorm.
 * User: USUARIO
 * Date: 27/04/2017
 * Time: 12:00 AM
 */
namespace core;
include "seguridad.class.php";


class model_articulos extends seguridad {

    protected $idarticulo ;
    protected $nombre_articulo;
    protected $descripcion;
    protected $codigo ;
    protected $idcategoria;
    protected $NombreCategoria;
    protected $idsubcategoria;
    protected $NombreSubcategoria;
    protected $idtalla;
    protected $NombreTalla;
    protected $idcolor;
    protected $CodigoColor;
    protected $NombreColor;
    protected $nick_name;
    protected $fecha_alta;
    protected $precio_venta;
    protected $precio_compra;
    protected $precio_mayoreo;
    protected $cantidad_mayoreo;
    protected $stock_minimo;
    protected $stock_maximo;
    protected $Utilidad;
    protected $idestado;

    public function getIDArticulo(){return $this->idarticulo ;}
    public function getNombreArticulo(){return $this->nombre_articulo;}
    public function getDescripcion(){return $this->descripcion ; }
    public function getCodigo(){return $this->codigo;}
    public function getIDCategoria(){return $this->idcategoria;}
    public function getNombreCategoria(){return $this->NombreCategoria;}
    public function getIDSubcategoria(){return $this->idsubcategoria;}
    public function getNombreSubcategoria(){return $this->NombreSubcategoria;}
    public function getIDTalla(){return $this->idtalla;}
    public function getNombreTalla(){return $this->NombreTalla;}
    public function getIDColor(){return $this->idcolor; }
    public function getCodigoColor(){return $this->CodigoColor; }
    public function getNombreColor(){return $this->NombreColor; }
    public function getUsuarioAlta(){return $this->nick_name; }
    public function getFechaAlta(){return $this->fecha_alta; }
    public function getPrecioVenta(){return $this->precio_venta; }
    public function getPrecioCompra(){return $this->precio_compra; }
    public function getPrecioMayoreo(){return $this->precio_mayoreo; }
    public function getCantidadMayoreo(){return $this->cantidad_mayoreo; }
    public function getStockMinimo(){return $this->stock_minimo; }
    public function getStockMaximo(){return $this->stock_maximo; }
    public function getUtilidad(){return $this->Utilidad; }
    public function getIDEstado(){return $this->idestado ;}

    public function set_articulos($data_array = array()){

        if(
            array_key_exists('nombre_producto',$data_array) &&
            array_key_exists('descripcion',$data_array) &&
            array_key_exists('codigo',$data_array) &&
            array_key_exists('idcategoria',$data_array) &&
            array_key_exists('idsubcategoria',$data_array) &&
            array_key_exists('idtalla',$data_array) &&
            array_key_exists('idcolor',$data_array) &&
            array_key_exists('precio_venta',$data_array) &&
            array_key_exists('stock_minimo',$data_array) &&
            array_key_exists('idempresa',$data_array) &&
            array_key_exists('idusuario_alta',$data_array) &&
            array_key_exists('fecha_alta',$data_array)
        ){
            // Validar que el nombre ya exista registrado
            $this->_query = "SELECT nombre_articulo FROM articulos where nombre_articulo = '$data_array[nombre_producto]' AND idempresa = '$data_array[idempresa]' ";
            $this->get_result_query();

            if(count($this->_rows) > 0){
                //Si existe el producto
                $this->_confirm = false;$this->_message = "El producto <b>".$data_array['nombre_producto']."</b> ya existe registrado";
            }else{
                //No existe producto
                $this->_query = "call sp_registra_articulo
                (
                '1',
                '0',
                '$data_array[idempresa]',
                '$data_array[nombre_producto]',
                '$data_array[descripcion]',
                '$data_array[codigo]',
                '$data_array[idcategoria]',
                '$data_array[idsubcategoria]',
                '$data_array[idtalla]',
                '$data_array[idcolor]',
                '$data_array[unidad_medida]',
                '$data_array[precio_compra]',
                '$data_array[precio_venta]',
                '$data_array[precio_mayoreo]',
                '$data_array[cantidad_mayoreo]',
                '$data_array[stock_minimo]',
                '$data_array[stock_maximo]',
                '$data_array[idestado]',
                '$data_array[idusuario_alta]',
                '$data_array[fecha_alta]'
                )";

                $this->execute_query();
                $this->_confirm = true;
                $this->_message = "Producto registrado correctamente";
            }



        }else{
                $this->_confirm = false;
                $this->_message = "Error no se encontraron los parametros para el registro del producto: model_productos";
        }
    }
    public function get_articulos($idArticulo,$idempresa){

        if($idArticulo != ''){
            $this->_query = "
                SELECT 
                a.idarticulo,a.nombre_articulo,a.descripcion,a.codigo,a.idcategoria,
                b.nombre_catalogo as NombreCategoria,
                a.idsubcategoria,c.nombre_catalogo as NombreSubcategoria ,
                a.idtalla,d.nombre_catalogo as NombreTalla,
                a.idcolor,e.nombre_catalogo as CodigoColor,e.descripcion_catalogo as NombreColor,
                a.idusuario_alta,f.nick_name,a.fecha_alta,a.precio_venta,a.precio_compra,a.precio_mayoreo,
                a.cantidad_mayoreo,a.stock_minimo,a.stock_maximo,
                ((a.precio_venta - a.precio_compra) / a.precio_compra) * 100 as Utilidad,a.idestado
            FROM articulos as a 
            LEFT JOIN catalogo_general as b 
            ON a.idcategoria = b.opc_catalogo AND b.idcatalogo =1 
            LEFT JOIN catalogo_general as c 
            ON a.idsubcategoria = c.opc_catalogo AND c.idcatalogo =2 
            LEFT JOIN catalogo_general as d 
            ON a.idtalla = d.opc_catalogo AND d.idcatalogo =3 
            LEFT JOIN catalogo_general as e 
            ON a.idcolor = e.opc_catalogo AND e.idcatalogo =4 
            LEFT JOIN perfil_usuarios as f 
            ON a.idusuario_alta = f.idusuario
             WHERE a.idempresa = '$idempresa' AND a.idarticulo = '$idArticulo' ORDER BY a.fecha_alta DESC
            ";

            $this->get_result_query();

        }

        if(count($this->_rows) == 1){

            foreach ($this->_rows[0] as $campo => $valor){
                $this->$campo = $valor ;
            }
            $this->_confirm = true ;
            $this->_message = "Se encontro el almacen";

        }else{
            $this->_confirm = false ;
            $this->_message = "No se encontro el almacen" ;
        }

    }
    public function edit_articulos($data_array = array()){

        if(
            array_key_exists('idarticulo',$data_array) &&
            array_key_exists('nombre_producto',$data_array) &&
            array_key_exists('descripcion',$data_array) &&
            array_key_exists('codigo',$data_array) &&
            array_key_exists('idcategoria',$data_array) &&
            array_key_exists('idsubcategoria',$data_array) &&
            array_key_exists('idtalla',$data_array) &&
            array_key_exists('idcolor',$data_array) &&
            array_key_exists('precio_venta',$data_array) &&
            array_key_exists('stock_minimo',$data_array) &&
            array_key_exists('idempresa',$data_array) &&
            array_key_exists('idusuario_alta',$data_array) &&
            array_key_exists('fecha_alta',$data_array)
        ){

            //validar que no exita ya el producto
            $this->_query = "SELECT nombre_articulo FROM articulos where nombre_articulo = '$data_array[nombre_producto]' AND idempresa = '$data_array[idempresa]' AND idarticulo != '$data_array[idarticulo]'  ";
            $this->get_result_query();

            if(count($this->_rows) >= 1 ){

                $this->_confirm = false ;
                $this->_message = "El producto ya existe";

            }else{
                //editar el producto
                $this->_query = "call sp_registra_articulo
                (
                '2',
                '$data_array[idarticulo]',
                '$data_array[idempresa]',
                '$data_array[nombre_producto]',
                '$data_array[descripcion]',
                '$data_array[codigo]',
                '$data_array[idcategoria]',
                '$data_array[idsubcategoria]',
                '$data_array[idtalla]',
                '$data_array[idcolor]',
                '$data_array[unidad_medida]',
                '$data_array[precio_compra]',
                '$data_array[precio_venta]',
                '$data_array[precio_mayoreo]',
                '$data_array[cantidad_mayoreo]',
                '$data_array[stock_minimo]',
                '$data_array[stock_maximo]',
                '$data_array[idestado]',
                '$data_array[idusuario_alta]',
                '$data_array[fecha_alta]'
                )";

                $this->execute_query();
                $this->_confirm = true;
                $this->_message = "Producto editada correctamente";
            }
        }else{
            $this->_confirm = false ;
            $this->_message = "No se encontraron los datos para editar el producto";
        }
    }

    public function get_list($opcion,$idempresa,$cadena = "",$tipo_producto = 1){

        switch ($opcion){
            case 1:
                $this->_query =
                    "SELECT 
                a.idarticulo,a.nombre_articulo,a.descripcion,a.codigo,a.idcategoria,
                b.nombre_catalogo as NombreCategoria,
                a.idsubcategoria,c.nombre_catalogo as NombreSubcategoria ,
                a.idtalla,d.nombre_catalogo as NombreTalla,
                a.idcolor,e.nombre_catalogo as CodigoColor,e.descripcion_catalogo as NombreColor,
                a.idusuario_alta,f.nick_name,
                a.fecha_alta
            FROM articulos as a 
            LEFT JOIN catalogo_general as b 
            ON a.idcategoria = b.opc_catalogo AND b.idcatalogo =1 
            LEFT JOIN catalogo_general as c 
            ON a.idsubcategoria = c.opc_catalogo AND c.idcatalogo =2 
            LEFT JOIN catalogo_general as d 
            ON a.idtalla = d.opc_catalogo AND d.idcatalogo =3 
            LEFT JOIN catalogo_general as e 
            ON a.idcolor = e.opc_catalogo AND e.idcatalogo =4 
            LEFT JOIN perfil_usuarios as f 
            ON a.idusuario_alta = f.idusuario
             WHERE a.idempresa = '$idempresa' AND tipo = 1 ORDER BY a.fecha_alta DESC";

                $this->get_result_query();
                return $this->_rows ;
                break;
            case 2:
                //Agregar productos para la compra
                if($tipo_producto == 0){

                    $this->_query =
                        "SELECT 
                    a.idarticulo,a.nombre_articulo,a.descripcion,a.precio_venta,a.fecha_alta,a.precio_compra,case a.tipo WHEN 1 THEN 'ART' WHEN 2 THEN 'MAT' end
                    FROM articulos as a 
                     WHERE a.idempresa = '$idempresa' AND a.nombre_articulo LIKE '%$cadena%' OR a.idarticulo like '%$cadena%' ORDER BY a.fecha_alta DESC";


                }else{

                    $this->_query =
                        "SELECT 
                    a.idarticulo,a.nombre_articulo,a.descripcion,a.precio_venta,a.fecha_alta,a.precio_compra,case a.tipo WHEN 1 THEN 'ART' WHEN 2 THEN 'MAT' end
                    FROM articulos as a 
                     WHERE a.idempresa = '$idempresa' AND a.tipo = $tipo_producto AND a.nombre_articulo LIKE '%$cadena%' OR a.idarticulo like '%$cadena%' ORDER BY a.fecha_alta DESC";

                }


                $this->get_result_query();
                return $this->_rows ;

                break;
            case 3:
                //Agregar productos para los traspasos

                if($tipo_producto == 'ART'){
                    $this->_query =
                        "SELECT 
                        a.idarticulo,a.nombre_articulo,a.precio_venta,'ART'
                        FROM articulos as a 
                        WHERE a.idempresa = '$idempresa' AND a.nombre_articulo LIKE '%$cadena%' OR a.idarticulo like '%$cadena%' ORDER BY a.fecha_alta DESC";
                }else if($tipo_producto == 'MAT'){
                    $this->_query =
                        "SELECT 
                        a.idmateriales,a.nombre_material,a.precio_venta,'MAT'
                        FROM materiales as a 
                        WHERE a.idempresa = '$idempresa' AND a.nombre_material LIKE '%$cadena%' OR a.idmateriales like '%$cadena%' ORDER BY a.fecha_alta DESC";

                }


                $this->get_result_query();
                return $this->_rows ;
                break;
        }

    }

}