<?php require_once('vendor/autoload.php'); require_once('../../cado/ClaseCuentasCorrientes.php');
   use PhpOffice\PhpSpreadsheet\Spreadsheet;
   use PhpOffice\PhpSpreadsheet\Writer\Xlsx;  
   
$occ= new CC();

//$reader = new PhpOffice\PhpSpreadsheet\Reader\Xlsx();
//$spread = $reader->load("ReportePagoDocumentos.xlsx");

$spread = new Spreadsheet();

      $ini=$_GET['ini'];
	  $fin=$_GET['fin'];
	  $emp=$_GET['emp'];
	  $est=$_GET['est'];


	 
 //$sheet = $spread->getActiveSheet();
 $empresa=$occ->LisDocEmp($emp,$ini,$fin,$est);$hoja=0;
 while($row=$empresa->fetch()){
   $idconv=$row[0];
   $nom_empresa=substr($row[1],0, 20);
 $spread->createSheet();
 $spread->setActiveSheetIndex($hoja);$hoja++;
 $sheet = $spread->getActiveSheet()->setTitle($nom_empresa); 
 $sheet->mergeCells("B5:G5"); 
 $sheet->getStyle("B5:G5")->getFont()->setBold( true );
 $sheet->setCellValue('B5',$row[1]) ;
 /*$img = imagecreatefromjpeg('logo.jpg');
 $sheet->setImageResource($img);*/
 $sheet->setCellValue('B8', 'NRO');$sheet->setCellValue('C8', 'FECHA');$sheet->setCellValue('D8', 'EMPRESA');
 $sheet->setCellValue('E8', 'DOCUMENTO');$sheet->setCellValue('F8', 'MONTO');$sheet->setCellValue('G8', 'ESTADO');
 
 $listar=$occ->LisDocumentos($idconv,$ini,$fin,$est);
      
  $i=8; $y=0;

   while($f=$listar->fetch()){$i++;$y++;
     if($f[4]==0){$pagado='PENDIENTE';}else{$pagado='CANCELADO';}
	 $sheet->setCellValue("B".$i, $y);
	 $sheet->setCellValue("C".$i, $f[5]);
	 $sheet->setCellValue("D".$i, $f[1]);
	 $sheet->setCellValue("E".$i, $f[2]);
	 $sheet->setCellValue("F".$i, $f[3]);
	 $sheet->setCellValue("G".$i, $pagado);
   }

}

$writer = new Xlsx($spread);


//$writer->save('reporte.xlsx');

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=ReportePagoFacturas.xlsx');
header('Cache-Control: max-age=0');
 
//$writer = IOFactory::createWriter($spread, 'Xlsx');
$writer->save('php://output');
exit;

?>
