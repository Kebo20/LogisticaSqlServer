<?php require_once('vendor/autoload.php'); require_once('../../cado/ClaseCaja.php');
   use PhpOffice\PhpSpreadsheet\Spreadsheet;
   use PhpOffice\PhpSpreadsheet\Writer\Xlsx;  
   
$ocaja= new Cajas();

      $reader = new PhpOffice\PhpSpreadsheet\Reader\Xlsx();
      $spread = $reader->load("LiquidacionCajaChica.xlsx");

      $cod_ingreso=$_GET['co'];

      $listar=$ocaja->ListarDetalleCajaChica($cod_ingreso);
      $listar_innova=$ocaja->ListarDetalleCajaInnova($cod_ingreso);
	  $lis_dinero=$ocaja->ListarDinero($cod_ingreso);
	  $col=$lis_dinero->fetch();
	  $bi200=$col['billete_200'];$bi100=$col['billete_100'];$bi50=$col['billete_50'];$bi20=$col['billete_20'];$bi10=$col['billete_10'];
	  $mo5=$col['moneda_5'];$mo2=$col['moneda_2'];$mo1=$col['moneda_1'];$mo050=$col['moneda_050'];$mo020=$col['moneda_020'];
	  $mo010=$col['moneda_010'];$user=$col['nom_user'];$nom_caja=$_GET['nom_caja'];$fec_aper=$col['fec_ingreso'];
	  $fec_cierra=$col['fec_cierra'];$turno=$col['turno'];$fondo_inicial=$col['fondo_inicial'];


      $ingresos=$ocaja->IngresosCajaDia($cod_ingreso);
	  $data_ing=$ingresos->fetch();$ing_p=$data_ing[0];$ing_i=$data_ing[1];$pagos_credito=$data_ing[2];
	  

/*$fec_ini=implode('/',array_reverse('-',explode($_GET['ini'])));
$fec_fin=implode('/',array_reverse('-',explode($_GET['fin'])));*/

$fec_ini = date("d/m/Y h:i:s A", strtotime($fec_aper));
$fec_fin = date("d/m/Y h:i:s A", strtotime($fec_cierra));

//$spread = new Spreadsheet();

$sheet = $spread->setActiveSheetIndex(0);
$sheet->setCellValue("F4", $fec_ini);
$sheet->setCellValue("F5", $fec_fin);
$sheet->setCellValue("F6", $user);


  $i=10; 
 $egreso=0.00;$ingreso=0.00;$total=0.00;
 while($f=$listar->fetch()){$i++;
     //$egreso=$egreso+$f[8];$total=$total+$f[9];
	 if($f['tipo_doc']=='EG'){$egreso=$egreso+$f['monto_egreso'];}
     if($f['tipo_doc']=='IG'){$ingreso=$ingreso+$f['monto_egreso'];}
	 $sheet->setCellValue("B".$i, $f[0]);
	 $sheet->setCellValue("C".$i, $f[1]);
	 $sheet->setCellValue("D".$i, utf8_decode($f[2]));
	 $sheet->setCellValue("E".$i, $f[3]);
	 $sheet->setCellValue("F".$i, $f[4]);
	 $sheet->setCellValue("G".$i, $f[8]); 	 
 }
 $i++;
 $total=$fondo_inicial+$ingreso-$egreso;
 $sheet->setCellValue("F".($i+1), "FONDO INICIAL : ");$sheet->setCellValue("G".($i+1),$fondo_inicial );
 $sheet->setCellValue("F".($i+2), "INGRESOS : ");$sheet->setCellValue("G".($i+2),$ingreso );
 $sheet->setCellValue("F".($i+3), "EGRESOS");$sheet->setCellValue("G".($i+3),$egreso );
 $sheet->setCellValue("f".($i+4), "TOTAL");$sheet->setCellValue("G".($i+4),$total );
 
//$sheet->setCellValueByColumnAndRow(11, 1, "Valor en la posición 1, 1");


$writer = new Xlsx($spread);


//$writer->save('reporte.xlsx');

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=LiquidacionCaja.xlsx');
header('Cache-Control: max-age=0');
 
//$writer = IOFactory::createWriter($spread, 'Xlsx');
$writer->save('php://output');
exit;

?>
