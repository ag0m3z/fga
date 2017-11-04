<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 26/09/2017
 * Time: 10:17 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../controller/model_almacen.php";

$connect = new model_almacen();

$idEmpresa = $_SESSION['data_home']['idempresa'];
$idAlmacen = $_POST['idalmacen'];

$BtnPrint = "hidden";
$BtnEdit = "hidden";
$BtnConfirmar = "hidden";
$BtnAutorizar = "hidden";
$BtnCancelar = "hidden";

switch ($_POST['opc']){
    //Traspasos por almacen seleccionado
    case 1:
        $Titulo = 'Lista de Traspasos <br>'.$_POST['nombre_almacen'];
        $Where = " WHERE a.idempresa = $idEmpresa AND a.idestado = 3 AND a.idalmacen_destino = $idAlmacen ";
        $BtnPrint = "";
        break;
    case 2:
        //Todos los traspass realizados
        $Titulo = 'Todos los Traspasos';
        $Where = " WHERE a.idempresa = $idEmpresa AND a.idestado = 3 ";
        $BtnPrint = "";
        break;
    // Opcion para mostrar los traspasos por autorizar
    case 3:
        $BtnPrint = "";
        $BtnAutorizar = "";
        $BtnCancelar = "";
        $Titulo = "Traspasos por Autorizar";
        $Where = " WHERE a.idempresa = $idEmpresa AND a.idestado = 1 ";
        break;
    //Opcion para mostrar los traspass por confirmar
    case 4:
        $BtnPrint = "";
        $BtnConfirmar = "";
        $BtnCancelar = "";
        $Titulo = "Traspasos por Confirmar";
        $Where = " WHERE a.idempresa = $idEmpresa AND a.idestado = 2 ";
        break;
    default:
        break;
}

$connect->_query = "
SELECT 
  lpad(a.idtraspaso,6,'0'),a.idtraspaso,b.nombre_almacen,c.nombre_almacen,d.nick_name,a.fecha_alta 
FROM traspasos as a 
left join almacen as b 
on a.idalmacen_destino = b.idalmacen 
left join almacen as c 
on a.idalmacen_origen = c.idalmacen 
left join perfil_usuarios as d 
on a.idusuario_solicita = d.idusuario $Where ORDER BY a.fecha_alta DESC
";
$connect->get_result_query();
?>
<script>

    $("th").addClass("bg-bareylev");
    $("#ttindicador").text('<?=$connect->getFormatFolio(count($connect->_rows),4)?>');
</script>
<h4 class="text-center"><?=$Titulo?></h4>
<table class="table table-condensed table-striper table-hover">
    <thead>
    <tr>
        <th>Folio</th>
        <th>Almacen Destino</th>
        <th>Almacen Origen</th>
        <th>Usuario Solicitante</th>
        <th colspan="2">Fecha <span id="ttindicador" class="badge pull-right bg-red">0000</span></th>
    </tr>
    </thead>
    <tbody>
    <?php
    for($i=0;$i<count($connect->_rows);$i++){

        $idTraspaso = $connect->_rows[$i][1];

        echo "<tr>
        <td>".$connect->_rows[$i][0]."</td>
        <td>".$connect->_rows[$i][2]."</td>
        <td>".$connect->_rows[$i][3]."</td>
        <td>".$connect->_rows[$i][4]."</td>
        <td>".$connect->_rows[$i][5]."</td>
        <td style='width: 30%' class='text-right'>
            <button class='btn btn-xs btn-default ".$BtnPrint."' ' onclick='fnImprimirTraspaso(".$connect->_rows[$i][1].")'><i class='fa fa-print'></i> Imprimir</button>
            <button class='btn btn-xs btn-default ".$BtnEdit."' '  onclick='fnEditarTraspaso(1,$idTraspaso)'><i class='fa fa-edit'></i> Editar</button>
            <button class='btn btn-xs btn-default ".$BtnAutorizar." ' onclick='fnAutorizarTraspaso(1,$idTraspaso)' ><i class='fa fa-check'></i> Autorizar</button>
            <button class='btn btn-xs btn-default ".$BtnConfirmar." ' onclick='fnAutorizarTraspaso(2,$idTraspaso)' ><i class='fa fa-check'></i> Confirmar</button>
            <button class='btn btn-xs btn-default ".$BtnCancelar." ' onclick='fnCancelarTraspaso($idTraspaso)' ><i class='fa fa-close'></i> Cancelar</button>
        </td>
        </tr>";
    }
    ?>
    </tbody>
</table>
