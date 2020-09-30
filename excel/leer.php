<?php
	
	require 'Classes/PHPExcel/IOFactory.php';
	require 'conexion.php';
	
	$nombreArchivo = 'ejemplo.xlsx';
	
	$objPHPExcel = PHPEXCEL_IOFactory::load($nombreArchivo);
	
	$objPHPExcel->setActiveSheetIndex(0);
	
	$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
	
	echo '<table border=1><tr><td>Producto</td><td>Precio</td><td>Existencia</td></tr>';
	
	for($i = 2; $i <= $numRows; $i++){
		
		$nombre = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$precio = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$existencia = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		
		echo '<tr>';
		echo '<td>'.$nombre.'</td>';
		echo '<td>'.$precio.'</td>';
		echo '<td>'.$existencia.'</td>';
		echo '</tr>';
		
		$sql = "INSERT INTO productos (nombre, precio, existencia) VALUE('$nombre','$precio','$existencia')";
		$result = $mysqli->query($sql);
		
	}
	
	echo '</table>';
	
?>