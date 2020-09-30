<?php session_start();
    require_once('vendor/autoload.php'); require_once('../../cado/ClaseReporte.php');
   use PhpOffice\PhpSpreadsheet\Spreadsheet;
   use PhpOffice\PhpSpreadsheet\Writer\Xlsx;  
   
$oreporte= new Reportes();

$reader = new PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spread = $reader->load("ReporteProduccionExamen.xlsx");


$user_imprime=$_SESSION['S_user'];
$ini=$_GET['ini'];
$fin=$_GET['fin'];
$ord=$_GET['ord'];
	  //$medico=utf8_decode($_GET['med']);
$emp=$_GET['e'];
$listar=$oreporte->ReporteProExa($ini,$fin,$emp,$ord);
/*$fec_ini=implode('/',array_reverse('-',explode($_GET['ini'])));
$fec_fin=implode('/',array_reverse('-',explode($_GET['fin'])));*/

$fec_ini = date("d/m/Y", strtotime($ini));
$fec_fin = date("d/m/Y", strtotime($fin));

//$spread = new Spreadsheet();

$sheet = $spread->getActiveSheet();
$sheet->setTitle("PRODUCCION EXAMENES");
$sheet->setCellValue("D5", $fec_ini);
$sheet->setCellValue("F5", $fec_fin);

/*$styleArray = array(
    'borders' => array(
        'outline' => array(
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => array('argb' => '000000'),
        ),
    ),
)*/;


 $i=8;
 while($fila=$listar->fetch()){$i++;
   
	 $sheet->setCellValue("B".$i, $fila[1]);
	 $sheet->setCellValue("C".$i, $fila[2]);
	 $sheet->setCellValue("D".$i, $fila[3]);
	
 }
 /*$i++;
 $sheet->setCellValue("D".$i, "TOTAL : ");
 $sheet->setCellValue("E".$i, $to_efec_pre);
 $sheet->setCellValue("F".$i, $to_tar_pre);
 $sheet->setCellValue("G".$i, $to_egreso_pre);
 $sheet->setCellValue("H".$i, $to_efec_inno);
 $sheet->setCellValue("I".$i, $to_tar_inno);
 $sheet->setCellValue("J".$i, $to_egreso_inno);
 $sheet->setCellValue("K".$i, $total_efectivo);
 $sheet->setCellValue("L".$i, $total_tarjeta);
 $sheet->setCellValue("M".$i, $total_egreso);
 $sheet->setCellValue("N".$i, $total_cierre);*/
//$sheet->setCellValueByColumnAndRow(11, 1, "Valor en la posición 1, 1");

$writer = new Xlsx($spread);


//$writer->save('reporte.xlsx');

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=ReporteProduccionExamen.xlsx');
header('Cache-Control: max-age=0');
 
//$writer = IOFactory::createWriter($spread, 'Xlsx');
$writer->save('php://output');
exit;

?>
