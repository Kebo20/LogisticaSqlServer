<?php
	
	require 'Classes/PHPExcel.php';
	require 'conexion.php';
	
	$sql = "SELECT id, nombre, precio, existencia FROM productos";
	$resultado = $mysqli->query($sql);
	
	$fila = 2;
	
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("Codigos de Programacion")->setDescription("Reporte de Productos");
	
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle("Productos");
	
	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID');
	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'NOMBRE');
	$objPHPExcel->getActiveSheet()->setCellValue('C1', 'PRECIO');
	$objPHPExcel->getActiveSheet()->setCellValue('D1', 'EXISTENCIA');
	$objPHPExcel->getActiveSheet()->setCellValue('E1', 'TOTAL');
	
	while($row = $resultado->fetch_assoc())
	{
		
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['id']);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['nombre']);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['precio']);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['existencia']);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, '=C'.$fila.'*D'.$fila);
		
		$fila++;
		
	}
	
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Productos.xlsx"');
	header('Cache-Control: max-age=0');
	
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
	
?>