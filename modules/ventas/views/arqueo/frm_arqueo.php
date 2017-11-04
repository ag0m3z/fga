<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 05/06/2017
 * Time: 10:44 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect  = new \core\seguridad();
$connect->valida_session_id();
$idEmpresa = $_SESSION['data_home']['idempresa'];
$idDepartamento = $_SESSION['data_home']['iddepartamento'];

$DateTIME = date("Y-m-d H:i:s");
$connect->_query = "SELECT fecha_cierre FROM cierre WHERE idempresa = $idEmpresa AND iddepartamento = $idDepartamento AND date(fecha_cierre) = date('".$DateTIME."') ";
$connect->get_result_query();

if(count($connect->_rows) > 0){
    \core\core::MyAlert("El cierre ya se realizo","alert");
    exit();
}
?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/js_formato_moneda.js"></script>
<script>
    setOpenModal("mdl_arqueo_caja");
    $('.currency').numeric({prefix:'$ ', cents: true});
</script>
<div class="modal fade" id="mdl_arqueo_caja" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Arqueo
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-condensed table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Concepto</th><th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            sleep(1);
                            $TotalEntradas = 0;
                            $Total = 0;

                            $connect->_query = "SELECT SaldoInicial FROM apertura where idempresa = $idEmpresa AND iddepartamento = $idDepartamento AND date(fecha_apertura) = curdate()";
                            $connect->get_result_query();
                            $SaldoInicial = $connect->_rows[0][0];

                            //TOTAL VENTAS HOY
                            $connect->_query = "SELECT 
                            a.idventa,a.iddepartamento,a.costo_trabajo_cp,a.fecha_venta,b.importe_venta,sum(b.importe_pagado)
                            FROM venta as a 
                            LEFT JOIN movimientos_caja as b 
                            ON a.idventa = b.idventa AND b.idestatus = 'A' 
                            WHERE a.iddepartamento = $idDepartamento AND date(b.fecha_movimiento) = date(now()) group by a.idventa";
                            $connect->get_result_query();

                            for($i=0;$i < count($connect->_rows);$i++){
                                $TotalVentasHoy = $TotalVentasHoy +$connect->_rows[$i][5];
                            }



                            //Aportaciones y Retiros
                            $connect->_query = "SELECT tipo_movimiento,sum(importe),count(tipo_movimiento) FROM aportaciones  where idempresa = $idEmpresa AND iddepartamento = $idDepartamento AND date(fecha_movimiento) = curdate() GROUP BY tipo_movimiento ";
                            $connect->get_result_query();
                            $Aportaciones = $connect->_rows;

                            //Entradas y Salidas
                            $connect->_query = "SELECT tipogasto,sum(importe_gasto),count(tipogasto) FROM gastos_caja  where idempresa = $idEmpresa AND iddepartamento = $idDepartamento AND date(fecha_gasto) = curdate() GROUP BY tipogasto ";
                            $connect->get_result_query();
                            $Entradas = $connect->_rows;

                            echo "<tr><td>Saldo de Apertura</td><td><b>+ &nbsp;</b><span class='currency text-success'>$SaldoInicial</span></td>";
                            echo "<tr><td>Aportaciones</td><td><b>+ &nbsp;</b><span class='currency text-success'>".$Aportaciones[0][1]."</span></td>";
                            echo "<tr><td>Retiros</td><td><b>- &nbsp;</b><span class='currency text-danger'>".$Aportaciones[1][1]."</span></td>";
                            echo "<tr><td>Entradas</td><td><b>+ &nbsp;</b><span class='currency text-success'>".$Entradas[0][1]."</span></td>";
                            echo "<tr><td>Salidas</td><td><b>- &nbsp;</b><span class='currency text-danger'>".$Entradas[1][1]."</span></td>";
                            echo "<tr><td>Total Ventas</td><td><b>+ &nbsp;</b><span class='currency text-success'>".$TotalVentasHoy."</span></td>";
                            echo "<tr><td>Servicios</td><td><b>+ &nbsp;</b><span class='currency text-success'>0</span></td>";
                            echo "<tr><td>Cancelaciones</td><td><b>- &nbsp;</b><span class='currency text-danger'>0</span></td>";

                            $Total = $Total + $SaldoInicial + $Aportaciones[0][1] + $Entradas[0][1] ;
                            $TOtal = $Total - $Aportaciones[1][1] - $Entradas[1][1] ;
                            echo "<tr><td class='text-right'>Total</td><td><span class='currency text-bold'>$Total</span></td>";

                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>