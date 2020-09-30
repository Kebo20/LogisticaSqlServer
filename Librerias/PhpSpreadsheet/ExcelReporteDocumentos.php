<?php require_once('vendor/autoload.php'); require_once('../../cado/ClaseReporte.php');
   use PhpOffice\PhpSpreadsheet\Spreadsheet;
   use PhpOffice\PhpSpreadsheet\Writer\Xlsx;  
   
$oreporte= new Reportes();

$reader = new PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spread = $reader->load("ReporteDocumentos.xlsx");

      $inicio=$_GET['ini'];
	  $fin=$_GET['fin'];
	  
 $sheet = $spread->getActiveSheet();
 $listar=$oreporte->ReporteDocumentosDeclarado($inicio,$fin);
      
  $i=8; 
$serie='';$correlativo='';
 while($f=$listar->fetch()){$i++;
     if($f[2]=='07'){
		 $serie=substr($f[13],0,4);$correlativo=substr($f[13],4,8);
		 if(substr($f['nrodoc_relacionado'],0,2)=='BV'){$tipo='03';}else{$tipo='01';}
		 $tipo='';}
	 $sheet->setCellValue("A".$i, $f[0]);
	 $sheet->setCellValue("B".$i, $f[1]);
	 $sheet->setCellValue("C".$i, $f[2]);
	 $sheet->setCellValue("D".$i, $f[3]);
	 $sheet->setCellValue("E".$i, $f[4]);
	 $sheet->setCellValue("F".$i, $f[5]);
	 $sheet->setCellValue("G".$i, $f[6]);
	 $sheet->setCellValue("H".$i, $f[7]);
	 $sheet->setCellValue("I".$i, $f[8]);
	 $sheet->setCellValue("J".$i, $f[9]);
	 $sheet->setCellValue("K".$i, $f[10]);
	 $sheet->setCellValue("L".$i, $f[11]);
	 $sheet->setCellValue("M".$i, $f[12]);
	 $sheet->setCellValue("N".$i, $tipo);	 	 
	 $sheet->setCellValue("O".$i, $serie);
	 $sheet->setCellValue("P".$i, $correlativo);
 }



$writer = new Xlsx($spread);


//$writer->save('reporte.xlsx');

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=ReporteDeclaracion.xlsx');
header('Cache-Control: max-age=0');
 
//$writer = IOFactory::createWriter($spread, 'Xlsx');
$writer->save('php://output');
exit;

?>
