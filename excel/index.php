<?php
	
	//require 'Classes/PHPExcel.php';
	require 'Classes/PHPExcel/IOFactory.php';
	
	$objPHPExcel = new PHPExcel();
	
	$objPHPExcel->getProperties()
	->setCreator('Codigos de Programacion')
	->setTitle('Excel en PHP')
	->setDescription('Documento de prueba')
	->setKeywords('excel phpexcel php')
	->setCategory('Ejemplos');

	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
	
	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'PHPExcel');
	$objPHPExcel->getActiveSheet()->setCellValue('A2', 12345.6789);
	$objPHPExcel->getActiveSheet()->setCellValue('A3', TRUE);
	$objPHPExcel->getActiveSheet()->setCellValue('A4', '=CONCATENATE(A1," ",A2)');
	
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Excel.xlsx"');
	header('Cache-Control: max-age=0');
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');


?>