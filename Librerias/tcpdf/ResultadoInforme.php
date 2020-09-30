<?php
require_once('tcpdf_include.php'); 
require_once('../../cado/ClaseReceta.php');

$oreceta=new Recetas();
$idexa=$_GET['idexa'];
$idreceta=$_GET['r'];

$datos=$oreceta->ListarPaciente1($idreceta);
	   while($fi=$datos->fetch()){
		   $pac=utf8_decode($fi[1]);
		   if($fi['sexo']=='M'){$sexo='Masculino';}else{$sexo='Femenino';}
		   $dni=$fi[2];  
		   $edad=$fi['edad'].' años';
		   $date = date_create($fi[6]);
		   $fecha=date_format($date, 'd/m/Y');$medico=$fi['medico'];
		}

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->setPrintHeader(false);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


$listar=$oreceta->ResultadoInforme($idreceta,$idexa);

 while($fila=$listar->fetch()){

$pdf->AddPage();

// para la cabecera
$pdf->SetFillColor(255);
$style6 = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => '4,3', 'color' => array(0, 0, 0));
$pdf->SetFont('helvetica','',8);
$pdf->Text(155,5,"Fec. Imp. :  ".date("d/m/Y h:i:s a"));
$pdf->SetFont('helvetica','BIU',11.5);

$pdf->Text(75,42,"INFORME DE ECOGRAFIAS"); 

$pdf->RoundedRect(14, 49, 184, 22.5, 5, '0101', 'DF',$style6);
$pdf->SetFont('helvetica','B',9);
$pdf->Text(17,51,"Paciente    :  ");
$pdf->Text(17,56,"Sexo          :  ");
$pdf->Text(17,61,"Indicacion :  ");
$pdf->Text(17,66,"Exámen     :  ");


$pdf->Text(150,51,"Fec. Examen    :  ");
$pdf->Text(150,56,"Edad                 :  ");
$pdf->Text(150,61,"DNI                    :  ");
$pdf->Text(150,66,"N° Orden          :");

$pdf->SetFont('helvetica','I',9);
$pdf->Text(36,51,$pac);
$pdf->Text(36,56,$sexo);
$pdf->Text(36,61,"Dr(a). ".$medico);
$pdf->Text(36,66,$fila[1]);

$pdf->Text(177,51,$fecha);
$pdf->Text(177,56,$edad);
$pdf->Text(177,61,$dni);
$pdf->Text(177,66,$orden);

$pdf->Ln(10);
   $pdf->SetX(14);
   $pdf->SetFont('','');
   $html="<b style='font-size:18px;' > <u>$fila[3] </u>: </b> ".$fila[4];

   $pdf->writeHTML($html, true, false, true, false, '');
    
 }


// output the HTML content



// set some language-dependent strings (optional)
/*if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}*/





$pdf->Output('FormatoInforme.pdf', 'I');


?>
