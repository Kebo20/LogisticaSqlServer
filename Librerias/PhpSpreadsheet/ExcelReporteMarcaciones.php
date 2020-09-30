<?php require_once('vendor/autoload.php');require_once('../../cado/ClaseReporte.php'); 
   use PhpOffice\PhpSpreadsheet\Spreadsheet;
   use PhpOffice\PhpSpreadsheet\Writer\Xlsx;  
   
$oreporte=  new Reportes();

$reader = new PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spread = $reader->load("ReporteHorasMarcacion.xlsx");

$idarea=$_GET['ar'];
$idpersonal=$_GET['per'];
$inicio=$_GET['ini'];
$fin=$_GET['fin'];

	  
 $sheet = $spread->getActiveSheet();
 $lis_marcas=$oreporte->ListarHoras($idarea,$idpersonal,$inicio,$fin);
  
     
$fec_ini = date("d/m/Y", strtotime($inicio));
$fec_fin = date("d/m/Y", strtotime($fin));

$sheet->setCellValue("E5", $fec_ini);
$sheet->setCellValue("G5", $fec_fin);
      
  $i=10; 
  
$almacenado=0;$total_horas=0;$total_minutos=0;
while ($fila=$lis_marcas->fetch()){$i++;
	 //$sheet ->getStyle("B".$i.":N".$i)->applyFromArray($styleArray);
	 $horas=(int)($fila[5]/60);
	 $minutos=$fila[5]%60;
	 $total_min=$total_min+$fila[5];
	 //$sheet->setCellValue("B".$i, $fila[1]);
	 if($fila[4]!=$almacenado){$almacenado=$fila[4];$sheet->setCellValue("B".$i, $fila[0]);$i++;}
	 $sheet->setCellValue("C".$i, $fila[1]);
	 $sheet->setCellValue("D".$i, $fila[2]);
	 $sheet->setCellValue("E".$i, $fila[3]);
	 $sheet->setCellValue("F".$i,$horas.' h  '.$minutos.' min');
	 
 }



$writer = new Xlsx($spread);


//$writer->save('reporte.xlsx');

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=ReporteHoras.xlsx');
header('Cache-Control: max-age=0');
 
//$writer = IOFactory::createWriter($spread, 'Xlsx');
$writer->save('php://output');
exit;

?>
