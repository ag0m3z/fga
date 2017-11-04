<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 29/09/2017
 * Time: 10:47 PM
 */


include "../../../core/core.class.php";
include "../../../core/sesiones.class.php";
include "../../../core/seguridad.class.php";

$connect = new \core\seguridad();

/** Incluir la libreria PHPExcel */
require_once '../../../plugins/PHPExcel.php';

// Crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()
    ->setCreator("Alejandro Gomez")
    ->setLastModifiedBy("AGB")
    ->setTitle("Catalogo de Productos")
    ->setSubject("Catalogo de Productos")
    ->setDescription("Catalogo de Productos")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Report");

// create style
$default_border = array(
    'style' => PHPExcel_Style_Border::BORDER_THIN,
    'color' => array('rgb'=>'FFFFFF')
);

$style_title = array(
    'font' => array(
        'bold' => true,
        'size' => 11,
        'color'=>array('rgb'=>'793240')
    )
);

$style_header = array(
    'borders' => array(
        'bottom' => $default_border,
        'left' => $default_border,
        'top' => $default_border,
        'right' => $default_border,
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb'=>'793240'),
    ),
    'font' => array(
        'bold' => false,
        'size' => 12,
        'color'=>array('rgb'=>'FFFFFF')
    )
);
$style_content = array(
    'borders' => array(
        'bottom' => $default_border,
        'left' => $default_border,
        'top' => $default_border,
        'right' => $default_border,
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb'=>'eeeeee'),
    ),
    'font' => array(
        'size' => 12,
    )
);


// Create Header
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A2', 'Reporte Catalogo de Productos') // El contenido de una cadena
    ->setCellValue('A4','Producto')
    ->setCellValue('B4','Descripción')
    ->setCellValue('C4','Categoria')
    ->setCellValue('D4','Tipo Producto')
    ->setCellValue('E4','Marca')
    ->setCellValue('F4','Precio Venta')
    ->setCellValue('G4','Clasificación')
    ->setCellValue('H4','C Empeño')
    ->setCellValue('I4','C Excelecte Compra')
    ->setCellValue('J4','C Buena Compra')

    ->setCellValue('K4','C Maxima Compra')
    ->setCellValue('L4','B Empeño')
    ->setCellValue('M4','B Exelente Compra')
    ->setCellValue('N4','B Buena Compra ')
    ->setCellValue('O4','B Maxima Compra')
    ->setCellValue('P4','A Empeño')

    ->setCellValue('Q4','A Buena Compra')
    ->setCellValue('R4','A Maxima Compra')
    ->setCellValue('S4','A Excelente Compra')
    ->setCellValue('T4','Fecha Alta')
    ->setCellValue('U4','Fecha UM');

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:U2');


$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray( $style_title ); // give style to header
$objPHPExcel->getActiveSheet()->getStyle('A4:U4')->applyFromArray( $style_header ); // give style to header

$objPHPExcel->getActiveSheet()
    ->getStyle('A2:O2')
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//Establecer la anchura

$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("J")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("L")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("M")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("O")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("P")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("Q")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("R")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("S")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("T")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("U")->setAutoSize(true);

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Inventario Articulos');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=" ReporteInventario'.date("YmdHiS").'.xls"'); // file name of excel
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
