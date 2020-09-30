<?php require_once('vendor/autoload.php'); require_once('../../cado/ClaseCaja.php');
   use PhpOffice\PhpSpreadsheet\Spreadsheet;
   use PhpOffice\PhpSpreadsheet\Writer\Xlsx;  
   
$ocaja= new Cajas();

$reader = new PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spread = $reader->load("ReporteCajaSemanal.xlsx");
      //echo $_GET['co'];exit;
      $arreglo=explode(',',$_GET['co']);
	 
	  
$efectivo=0.00;$tarjeta=0.00;$egreso=0.00;$total=0.00;$i=10;$x=10; 
	  
for($aut=0;$aut<count($arreglo);$aut++){
	  if($aut==0){$cel_inicio=4;}else{$cel_inicio=$cel_inicio+15;}
	  $cod_ingreso=$arreglo[$aut];

      $listar=$ocaja->ListarDetalleCajaSemanal($cod_ingreso);
      $listar_innova=$ocaja->ListarDetalleCajaInnovaSemanal($cod_ingreso);
	  $lis_dinero=$ocaja->ListarDinero($cod_ingreso);
	  $col=$lis_dinero->fetch();
	 $bi200=$col['billete_200'];$bi100=$col['billete_100'];$bi50=$col['billete_50'];$bi20=$col['billete_20'];$bi10=$col['billete_10'];
	  $mo5=$col['moneda_5'];$mo2=$col['moneda_2'];$mo1=$col['moneda_1'];$mo050=$col['moneda_050'];$mo020=$col['moneda_020'];
	  $mo010=$col['moneda_010'];$user=$col['nom_user'];$nom_caja=$_GET['nom_caja'];$fec_aper=$col['fec_ingreso'];
	  $fec_cierra=$col['fec_cierra'];$turno=$col['turno'];$pos=$col['monto_tarjeta'];


      $ingresos=$ocaja->IngresosCajaDia($cod_ingreso);
	  $data_ing=$ingresos->fetch();$ing_p=$data_ing[0];$ing_i=$data_ing[1];$pagos_credito=$data_ing[2];
	  

/*$fec_ini=implode('/',array_reverse('-',explode($_GET['ini'])));
$fec_fin=implode('/',array_reverse('-',explode($_GET['fin'])));*/

$fec_ini = date("d/m/Y h:i:s A", strtotime($fec_aper));
$fec_fin = date("d/m/Y h:i:s A", strtotime($fec_cierra));

//$spread = new Spreadsheet();

$sheet = $spread->setActiveSheetIndex(0);
$sheet->setCellValue("F4", $fec_ini);$sheet->setCellValue("I4", $turno);
$sheet->setCellValue("F5", $fec_fin);$sheet->setCellValue("I5", $user);

/*$styleArray = array(
    'borders' => array(
        'outline' => array(
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => array('argb' => '000000'),
        ),
    ),
)*/;

 while($f=$listar->fetch()){$i++;
     $efectivo=$efectivo+$f[6];$tarjeta=$tarjeta+$f[7];$egreso=$egreso+$f[8];$total=$total+$f[9];
	 if($f[3]=='FA' or $f[3]=='BV'){$serie=substr($f[4],0,4);$correlativo=substr($f[4],4,8);}else{$serie='';$correlativo=$f[4];}
	 $sheet->setCellValue("A".$i, $f['turno']);
	 $sheet->setCellValue("B".$i, $f[0]);
	 $sheet->setCellValue("C".$i, $f[1]);
	 $sheet->setCellValue("D".$i, $f[2]);
	 $sheet->setCellValue("E".$i, $f[3]);
	 $sheet->setCellValue("F".$i, $serie);
	 $sheet->setCellValue("G".$i, $correlativo);
	 $sheet->setCellValue("H".$i, $f['fecha']);
	 $sheet->setCellValue("I".$i, $f['pago']);
	 $sheet->setCellValue("J".$i, $f['total_venta']); 
 }
 

$sheet = $spread->setActiveSheetIndex(1);
/*$sheet->setCellValue("F4", $fec_ini);$sheet->setCellValue("I4", $turno);
$sheet->setCellValue("F5", $fec_fin);$sheet->setCellValue("I5", $user);*/

 while($f=$listar_innova->fetch()){$x++; 
	 $sheet->setCellValue("B".$x, $f[0]);
	 $sheet->setCellValue("C".$x, $f[1]);
	 $sheet->setCellValue("D".$x, $f[2]);
	 $sheet->setCellValue("E".$x, $f[3]);
	 $sheet->setCellValue("F".$x, $f[4]);
	 $sheet->setCellValue("G".$x, $f[5]);
	 $sheet->setCellValue("H".$x, $f[6]);
	 $sheet->setCellValue("I".$x, $f[7]);
	 $sheet->setCellValue("J".$x, '');
	 	 
 }
 
$sheet = $spread->setActiveSheetIndex(2);
/*
$bi200=$col['billete_200'];$bi100=$col['billete_100'];$bi50=$col['billete_50'];$bi20=$col['billete_20'];$bi10=$col['billete_10'];
	  $mo5=$col['moneda_5'];$mo2=$col['moneda_2'];$mo1=$col['moneda_1'];$mo050=$col['moneda_050'];$mo020=$col['moneda_020'];
	  $mo010=$col['moneda_010'];
*/
$sheet->setCellValue("I".$cel_inicio, $bi200);
$sheet->setCellValue("I".($cel_inicio+1), $bi100);
$sheet->setCellValue("I".($cel_inicio+2), $bi50);
$sheet->setCellValue("I".($cel_inicio+3), $bi20);
$sheet->setCellValue("I".($cel_inicio+4), $bi10);

$sheet->setCellValue("M".$cel_inicio, $mo5);
$sheet->setCellValue("M".($cel_inicio+1), $mo2);
$sheet->setCellValue("M".($cel_inicio+2), $mo1);
$sheet->setCellValue("M".($cel_inicio+3), $mo050);
$sheet->setCellValue("M".($cel_inicio+4), $mo020);
$sheet->setCellValue("M".($cel_inicio+5), $mo010);

$sheet->setCellValue("A".($cel_inicio-2), date("d/m/Y", strtotime($fec_aper)));
$sheet->setCellValue("A".($cel_inicio-1), $turno);

$sheet->setCellValue("D".$cel_inicio, $ing_p);$sheet->setCellValue("D".($cel_inicio+1), $ing_i);
$sheet->setCellValue("D".($cel_inicio+2),$pos);
$sheet->setCellValue("D".($cel_inicio+6), $pagos_credito);
$sheet->setCellValue("K".($cel_inicio+5), $pos);

$gastos=$ocaja->GastosCajaDia($cod_ingreso);
$m=$cel_inicio-1;
while($row_gastos=$gastos->fetch()){$m++;
  $sheet->setCellValue("F".$m,$row_gastos[1]);$sheet->setCellValue("G".$m,$row_gastos[0]);
}


$writer = new Xlsx($spread);


// FIN DEL FOR
}

//$writer->save('reporte.xlsx');

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=ReporteCajaSemanal.xlsx');
header('Cache-Control: max-age=0');
 
//$writer = IOFactory::createWriter($spread, 'Xlsx');
$writer->save('php://output');
exit;

?>
