<?php require_once('vendor/autoload.php'); require_once('../../cado/ClaseCaja.php');
   use PhpOffice\PhpSpreadsheet\Spreadsheet;
   use PhpOffice\PhpSpreadsheet\Writer\Xlsx;  
   
$ocaja= new Cajas();

$reader = new PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spread = $reader->load("ReporteCierreCaja.xlsx");

$inicio=$_GET['ini'];
$fin=$_GET['fin'];

/*$fec_ini=implode('/',array_reverse('-',explode($_GET['ini'])));
$fec_fin=implode('/',array_reverse('-',explode($_GET['fin'])));*/

$fec_ini = date("d/m/Y", strtotime($inicio));
$fec_fin = date("d/m/Y", strtotime($fin));

//$spread = new Spreadsheet();

$sheet = $spread->getActiveSheet();
$sheet->setTitle("CIERRES");
$sheet->setCellValue("G5", $fec_ini);
$sheet->setCellValue("I5", $fec_fin);

/*$styleArray = array(
    'borders' => array(
        'outline' => array(
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => array('argb' => '000000'),
        ),
    ),
)*/;


$cabecera=$ocaja->CabeceraCierreCaja($inicio,$fin);$i=10;
$to_efec_pre=0.00;$to_efec_inno=0.00;$pre_efectivo=0.00;$pre_tarjeta=0.00;$pre_egresos=0.00;
$to_tar_pre=0.00;$to_tar_inno=0.00;$inno_efectivo=0.00;$inno_tarjeta=0.00;$inno_egresos=0.00;
$to_egreso_pre=0.00;$to_egreso_inno=0.00;
$total_efectivo=0.00;$total_tarjeta=0.00;
$total_egreso=0.00;$total_cierre=0.00;
 while($fila=$cabecera->fetch()){$i++;
     $detalle=$ocaja->DetalleCierreCaja($fila[0],'P');
	 $detalle_in=$ocaja->DetalleCierreCaja($fila[0],'I');
	 $data_precisa=$detalle->fetch();$pre_efectivo=$data_precisa[0];$pre_tarjeta=$data_precisa[1];$pre_egresos=$data_precisa[2];
	 $data_innova=$detalle_in->fetch();$inno_efectivo=$data_innova[0];$inno_tarjeta=$data_innova[1];$inno_egresos=$data_innova[2];
	
	 $to_efec_pre=$to_efec_pre+$pre_efectivo;$to_efec_inno=$to_efec_inno+$inno_efectivo;
	 $to_tar_pre=$to_tar_pre+$pre_tarjeta;$to_tar_inno=$to_tar_inno+$inno_tarjeta;
	 $to_egreso_pre=$to_egreso_pre+$pre_egresos;$to_egreso_inno=$to_egreso_inno+$inno_egresos;
	 $total_efectivo=$total_efectivo+$fila[4];$total_tarjeta=$total_tarjeta+$fila[5];
	 $total_egreso=$total_egreso+$fila[6];$total_cierre=$total_cierre+$fila[7];
	 //$sheet ->getStyle("B".$i.":N".$i)->applyFromArray($styleArray);
	 $sheet->setCellValue("B".$i, $fila[1]);
	 $sheet->setCellValue("C".$i, $fila[2]);
	 $sheet->setCellValue("D".$i, $fila[3]);
	 $sheet->setCellValue("E".$i, $pre_efectivo);
	 $sheet->setCellValue("F".$i, $pre_tarjeta);
	 $sheet->setCellValue("G".$i, $pre_egresos);
	 $sheet->setCellValue("H".$i, $inno_efectivo);
	 $sheet->setCellValue("I".$i, $inno_tarjeta);
	 $sheet->setCellValue("J".$i, $inno_egresos);
	 $sheet->setCellValue("K".$i, $fila[4]);
	 $sheet->setCellValue("L".$i, $fila[5]);
	 $sheet->setCellValue("M".$i, $fila[6]);
	 $sheet->setCellValue("N".$i, $fila[7]);	 
 }
 $i++;
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
 $sheet->setCellValue("N".$i, $total_cierre);
//$sheet->setCellValueByColumnAndRow(11, 1, "Valor en la posición 1, 1");

$writer = new Xlsx($spread);


//$writer->save('reporte.xlsx');

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=ReporteCaja.xlsx');
header('Cache-Control: max-age=0');
 
//$writer = IOFactory::createWriter($spread, 'Xlsx');
$writer->save('php://output');
exit;

?>
