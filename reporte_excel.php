<?php

require 'excel/Classes/PHPExcel.php';
include 'cado/ClaseLogistica.php';

$fila = 13;

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Kevin Alberca")->setDescription("Reporte de usuarios");

/*$gdImage = imagecreatefrompng('images/logoe.png'); //Logotipo
$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
$objDrawing->setName('Logotipo');
$objDrawing->setDescription('Logotipo');
$objDrawing->setImageResource($gdImage);
$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
$objDrawing->setHeight(100);
$objDrawing->setCoordinates('A1');
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
*/
$estiloTituloReporte = array(
    'font' => array(
        'name' => 'Arial',
        'bold' => true,
        'italic' => false,
        'strike' => false,
        'size' => 11
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE
        )
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);

$estiloTituloColumnas = array(
    'font' => array(
        'name' => 'Arial',
        'bold' => true,
        'size' => 10,
        'color' => array(
            'rgb' => 'FFFFFF'
        )
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'A5A7A9')
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);

$estiloCuerpo= array(
    'font' => array(
        'name' => 'Arial',
        'bold' => false,
        'size' => 10,
        
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);
$estiloSubtitulos= array(
    'font' => array(
        'name' => 'Arial',
        'bold' => true,
        'size' => 10,
        
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);

$estiloInformacion = new PHPExcel_Style();
$estiloInformacion->applyFromArray(array(
    'font' => array(
        'name' => 'Arial',
        'color' => array(
            'rgb' => '000000'
        )
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
));

$objPHPExcel->getActiveSheet()->getStyle('A1:H9')->applyFromArray($estiloTituloReporte);
$objPHPExcel->getActiveSheet()->getStyle('A11:M12')->applyFromArray($estiloTituloColumnas);
$objPHPExcel->getActiveSheet()->getStyle('A13:M13')->applyFromArray($estiloSubtitulos);



$olog = new Logistica();
$producto=$olog->ListarProductoLogxid($_GET['producto'])->fetch();
$unidad=$olog->ListarUnidadxid($producto['id_unidad'])->fetch();




$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle("KARDEX VALORIZADO");

//ANCHO DE COLUMNAS
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);

//VALOR DE COLUMNAS ENCABEZADO

$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Periodo');
$objPHPExcel->getActiveSheet()->setCellValue('B1', '');
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'RUC');
$objPHPExcel->getActiveSheet()->setCellValue('B2', '');
$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Denominación o Razón social');
$objPHPExcel->getActiveSheet()->setCellValue('B3', '');
$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Establecimiento');
$objPHPExcel->getActiveSheet()->setCellValue('B4', '');
$objPHPExcel->getActiveSheet()->setCellValue('A5', 'Código de la existencia');
$objPHPExcel->getActiveSheet()->setCellValue('B5', '');
$objPHPExcel->getActiveSheet()->setCellValue('A6', 'Tipo');
$objPHPExcel->getActiveSheet()->setCellValue('B6', '');
$objPHPExcel->getActiveSheet()->setCellValue('A7', 'Descripción');
$objPHPExcel->getActiveSheet()->setCellValue('B7', $producto['nombre']);
$objPHPExcel->getActiveSheet()->setCellValue('A8', 'Código de la unidad de medida');
$objPHPExcel->getActiveSheet()->setCellValue('B8', $unidad['codigo']);
$objPHPExcel->getActiveSheet()->setCellValue('A9', 'Método de evaluación');
$objPHPExcel->getActiveSheet()->setCellValue('B9', 'Promedio');

$objPHPExcel->getActiveSheet()->setCellValue('A11', 'DOCUMENTO DE TRASLADO, COMPROBANTE DE PAGO, DOCUMENTO INTERNO O SIMILAR');
$objPHPExcel->getActiveSheet()->mergeCells('A11:C11');

$objPHPExcel->getActiveSheet()->setCellValue('A12', 'Fecha');
$objPHPExcel->getActiveSheet()->setCellValue('B12', 'N° documento');
$objPHPExcel->getActiveSheet()->setCellValue('C12', 'Tipo de documento');

$objPHPExcel->getActiveSheet()->setCellValue('D12', 'Tipo de operación');


$objPHPExcel->getActiveSheet()->setCellValue('E11', 'ENTRADAS');
$objPHPExcel->getActiveSheet()->mergeCells('E11:G11');
$objPHPExcel->getActiveSheet()->setCellValue('E12', 'Cantidad');
$objPHPExcel->getActiveSheet()->setCellValue('F12', 'Costo unitario (S/.)');
$objPHPExcel->getActiveSheet()->setCellValue('G12', 'Costo total (S/.)');

$objPHPExcel->getActiveSheet()->setCellValue('H11', 'SALIDAS');
$objPHPExcel->getActiveSheet()->mergeCells('H11:J11');

$objPHPExcel->getActiveSheet()->setCellValue('H12', 'Cantidad');
$objPHPExcel->getActiveSheet()->setCellValue('I12', 'Costo unitario (S/.)');
$objPHPExcel->getActiveSheet()->setCellValue('J12', 'Costo total (S/.)');

$objPHPExcel->getActiveSheet()->setCellValue('K11', 'SALDOS');
$objPHPExcel->getActiveSheet()->mergeCells('K11:M11');

$objPHPExcel->getActiveSheet()->setCellValue('K12', 'Cantidad');
$objPHPExcel->getActiveSheet()->setCellValue('L12', 'Costo unitario (S/.)');
$objPHPExcel->getActiveSheet()->setCellValue('M12', 'Costo total (S/.)');







//CUERPO
$lista = $olog->ListarKardex($_GET['producto'],0,10000);
$i = 0;
$fin=$lista->rowCount()+12;
$objPHPExcel->getActiveSheet()->getStyle('A13:M'.$fin)->applyFromArray($estiloCuerpo);

foreach ($lista as $row) {
    $i++;
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $row[0]);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('B' . $fila, $row[1],PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $row[2]);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $row[3]);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $row[4]);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $row[5]);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('G' . $fila, $row[6],PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $row[7]);
    $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $row[8]);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('J' . $fila, $row[9],PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $row[10]);
    $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $row[11]);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('M' . $fila, $row[12],PHPExcel_Cell_DataType::TYPE_STRING);
    

    $fila++;
}

//header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
//header('Content-Disposition: attachment;filename="Productos.xlsx"');
//header('Cache-Control: max-age=0');
//
//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
//$objWriter->save('php://output');



header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Reporte Kardex.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>