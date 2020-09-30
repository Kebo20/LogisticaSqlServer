<?php
require('fpdf.php'); 

class Pdf_Table extends FPDF 
{ 
var $widths; 
var $aligns;

function SetWidths($w) 
{ 
    //Set the array of column widths 
    $this->widths=$w; 
}


function SetAligns($a) 
{ 
    //Set the array of column alignments 
    $this->aligns=$a; 
} 

function RowCabecera($data) 
{ 
    //Calculate the height of the row
	
    $nb=0; 
    for($i=0;$i<count($data);$i++) 
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i])); 
    $h=8*$nb; 
    //Issue a page break first if needed 
    $this->CheckPageBreak($h); 
    //Draw the cells of the row 
    for($i=0;$i<count($data);$i++) 
    { 
        $w=$this->widths[$i]; 
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; 
        //Save the current position 
        $x=$this->GetX(); 
        $y=$this->GetY(); 
        //Draw the border 
        $this->Rect($x,$y,$w,$h,''); 
        //Print the text 
		
        $this->MultiCell($w,6.5,$data[$i],0,'C'); 
        //Put the position to the right of the cell 
        $this->SetXY($x+$w,$y); 
    } 
    //Go to the next line 
    $this->Ln($h); 
	return $h;
} 


function Row2($data) 
{ 
    //Calculate the height of the row
	
    $nb=0;
	 
    for($i=0;$i<count($data);$i++) 
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i])); 
    $h=8*$nb; 
    //Issue a page break first if needed 
    $this->CheckPageBreak($h); 
    //Draw the cells of the row 
    for($i=0;$i<count($data);$i++) 
    { 
        $w=$this->widths[$i]; 
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; 
        //Save the current position 
        $x=$this->GetX(); 
        $y=$this->GetY(); 
        //Draw the border 
		 //Letra color blanco 
        $this->Rect($x,$y,$w,$h,'F');
		
        //Print the text 
		//$this->SetFillColor(220,200,150);
        $this->MultiCell($w,8,$data[$i],0,$a); 
        //Put the position to the right of the cell 
        $this->SetXY($x+$w,$y); 
    } 
    //Go to the next line 
    $this->Ln($h);
	return $h; 
}

function RowCabecera1($data) 
{ 
    //Calculate the height of the row
	
    $nb=0; 
    for($i=0;$i<count($data);$i++) 
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i])); 
    $h=(3.2)*$nb; 
    //Issue a page break first if needed 
    $this->CheckPageBreak($h); 
    //Draw the cells of the row 
    for($i=0;$i<count($data);$i++) 
    { 
        $w=$this->widths[$i]; 
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; 
        //Save the current position 
        $x=$this->GetX(); 
        $y=$this->GetY(); 
        //Draw the border 
        $this->Rect($x,$y,$w,$h); 
        //Print the text 
		
        $this->MultiCell($w,3,$data[$i],0,'C'); 
        //Put the position to the right of the cell 
        $this->SetXY($x+$w,$y); 
    } 
    //Go to the next line 
    $this->Ln($h); 
	return $h;
}

function Row($data) 
{ 
    //Calculate the height of the row
	
    $nb=0; 
    for($i=0;$i<count($data);$i++) 
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i])); 
    $h=7*$nb; 
    //Issue a page break first if needed 
    $this->CheckPageBreak($h); 
    //Draw the cells of the row 
    for($i=0;$i<count($data);$i++) 
    { 
        $w=$this->widths[$i]; 
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; 
        //Save the current position 
        $x=$this->GetX(); 
        $y=$this->GetY(); 
        //Draw the border 
        $this->Rect($x,$y,$w,$h,'F'); 
        //Print the text 
		//$this->SetFillColor(220,200,150);
        $this->MultiCell($w,6,$data[$i],0,$a); 
        //Put the position to the right of the cell 
        $this->SetXY($x+$w,$y); 
    } 
    //Go to the next line 
    $this->Ln($h);
	return $h; 
}

function RowSinBorder($data) 
{ 
    //Calculate the height of the row
	
    $nb=0; 
    for($i=0;$i<count($data);$i++) 
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i])); 
    $h=2*$nb; 
    //Issue a page break first if needed 
    $this->CheckPageBreak($h); 
    //Draw the cells of the row 
    for($i=0;$i<count($data);$i++) 
    { 
        $w=$this->widths[$i]; 
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; 
        //Save the current position 
        $x=$this->GetX(); 
        $y=$this->GetY(); 
        //Draw the border 
        $this->Rect(0,0,0,0); 
        //Print the text 
		
        $this->MultiCell($w,2,$data[$i],0,$a); 
        //Put the position to the right of the cell 
        $this->SetXY($x+$w,$y); 
    } 
    //Go to the next line 
    $this->Ln($h);
	return $h; 
} 
function RowSinBorderHistorico($data) 
{ 
    //Calculate the height of the row
	
    $nb=0; 
    for($i=0;$i<count($data);$i++) 
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i])); 
    $h=3*$nb; 
    //Issue a page break first if needed 
    $this->CheckPageBreak($h); 
    //Draw the cells of the row 
    for($i=0;$i<count($data);$i++) 
    { 
        $w=$this->widths[$i]; 
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; 
        //Save the current position 
        $x=$this->GetX(); 
        $y=$this->GetY(); 
        //Draw the border 
        $this->Rect(0,0,0,0); 
        //Print the text 
		
        $this->MultiCell($w,3,$data[$i],0,$a); 
        //Put the position to the right of the cell 
        $this->SetXY($x+$w,$y); 
    } 
    //Go to the next line 
    $this->Ln($h);
	return $h; 
} 
function RowSinBorderPerfilEna($data) 
{ 
    //Calculate the height of the row
	
    $nb=0; 
    for($i=0;$i<count($data);$i++) 
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i])); 
    $h=5*$nb; 
    //Issue a page break first if needed 
    $this->CheckPageBreak($h); 
    //Draw the cells of the row 
    for($i=0;$i<count($data);$i++) 
    { 
        $w=$this->widths[$i]; 
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; 
        //Save the current position 
        $x=$this->GetX(); 
        $y=$this->GetY(); 
        //Draw the border 
        $this->Rect(0,0,0,0); 
        //Print the text 
		
        $this->MultiCell($w,5,$data[$i],0,$a); 
        //Put the position to the right of the cell 
        $this->SetXY($x+$w,$y); 
    } 
    //Go to the next line 
    $this->Ln($h);
	return $h; 
} 

function RowSinBorderReporte($data) 
{ 
    //Calculate the height of the row
	
    $nb=0; 
    for($i=0;$i<count($data);$i++) 
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i])); 
    $h=4*$nb; 
    //Issue a page break first if needed 
    $this->CheckPageBreak($h); 
    //Draw the cells of the row 
    for($i=0;$i<count($data);$i++) 
    { 
        $w=$this->widths[$i]; 
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; 
        //Save the current position 
        $x=$this->GetX(); 
        $y=$this->GetY(); 
        //Draw the border 
        $this->Rect($x,$y,$w,$h,'F'); 
        //Print the text 
		
        $this->MultiCell($w,3,$data[$i],0,$a); 
        //Put the position to the right of the cell 
        $this->SetXY($x+$w,$y); 
    } 
    //Go to the next line 
    $this->Ln($h);
	return $h; 
} 

function RowSinBorderRep($data) 
{ 
    //Calculate the height of the row
	
    $nb=0; 
    for($i=0;$i<count($data);$i++) 
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i])); 
    $h=5*$nb; 
    //Issue a page break first if needed 
    $this->CheckPageBreak($h); 
    //Draw the cells of the row 
    for($i=0;$i<count($data);$i++) 
    { 
        $w=$this->widths[$i]; 
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; 
        //Save the current position 
        $x=$this->GetX(); 
        $y=$this->GetY(); 
        //Draw the border 
       $this->Rect($x,$y,$w,$h,'F');
        //Print the text 
		
        $this->MultiCell($w,5,$data[$i],0,$a); 
        //Put the position to the right of the cell 
        $this->SetXY($x+$w,$y); 
    } 
    //Go to the next line 
    $this->Ln($h);
	return $h; 
} 
function RowSinBorderAlergias($data) 
{ 
    //Calculate the height of the row
	
    $nb=0; 
    for($i=0;$i<count($data);$i++) 
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i])); 
    $h=1.5*$nb; 
    //Issue a page break first if needed 
    $this->CheckPageBreak($h); 
    //Draw the cells of the row 
    for($i=0;$i<count($data);$i++) 
    { 
        $w=$this->widths[$i]; 
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; 
        //Save the current position 
        $x=$this->GetX(); 
        $y=$this->GetY(); 
        //Draw the border 
        $this->Rect(0,0,0,0); 
        //Print the text 
		
        $this->MultiCell($w,1.5,$data[$i],0,$a); 
        //Put the position to the right of the cell 
        $this->SetXY($x+$w,$y); 
    } 
    //Go to the next line 
    $this->Ln($h);
	return $h; 
} 
function RowSinBorderCultivo($data) 
{ 
    //Calculate the height of the row
	
    $nb=0; 
    for($i=0;$i<count($data);$i++) 
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i])); 
    $h=4*$nb; 
    //Issue a page break first if needed 
    $this->CheckPageBreak($h); 
    //Draw the cells of the row 
    for($i=0;$i<count($data);$i++) 
    { 
        $w=$this->widths[$i]; 
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; 
        //Save the current position 
        $x=$this->GetX(); 
        $y=$this->GetY(); 
        //Draw the border 
        $this->Rect(0,0,0,0); 
        //Print the text 
		
        $this->MultiCell($w,4,$data[$i],0,'J'); 
        //Put the position to the right of the cell 
        $this->SetXY($x+$w,$y); 
    } 
    //Go to the next line 
    $this->Ln($h);
	return $h; 
} 

function RowSinBorderProtocolo($data) 
{ 
    //Calculate the height of the row
	
    $nb=0; 
    for($i=0;$i<count($data);$i++) 
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i])); 
    $h=4*$nb; 
    //Issue a page break first if needed 
    $this->CheckPageBreak($h); 
    //Draw the cells of the row 
    for($i=0;$i<count($data);$i++) 
    { 
        $w=$this->widths[$i]; 
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; 
        //Save the current position 
        $x=$this->GetX(); 
        $y=$this->GetY(); 
        //Draw the border 
        $this->Rect(0,0,0,0); 
        //Print the text 
		
        $this->MultiCell($w,4,$data[$i],0,$a); 
        //Put the position to the right of the cell 
        $this->SetXY($x+$w,$y); 
    } 
    //Go to the next line 
    $this->Ln($h); 
}

function CheckPageBreak($h) 
{ 
    //If the height h would cause an overflow, add a new page immediately 
    if($this->GetY()+$h>$this->PageBreakTrigger) 
        $this->AddPage($this->CurOrientation); 
} 

function RowDoc($data) 
{ 
    //Calculate the height of the row
	
    $nb=0; 
    for($i=0;$i<count($data);$i++) 
        $nb=max($nb,$this->NbLines1($this->widths[$i],$data[$i])); 
    $h=7*$nb; 
    //Issue a page break first if needed 
    $this->CheckPageBreak($h); 
    //Draw the cells of the row 
    for($i=0;$i<count($data);$i++) 
    { 
        $w=$this->widths[$i]; 
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; 
        //Save the current position 
        $x=$this->GetX(); 
        $y=$this->GetY(); 
        //Draw the border 
        $this->Rect($x,$y,$w,$h,'F'); 
        //Print the text 
		//$this->SetFillColor(220,200,150);
        $this->MultiCell($w,6,$data[$i],0,$a); 
        //Put the position to the right of the cell 
        $this->SetXY($x+$w,$y); 
    } 
    //Go to the next line 
    $this->Ln($h);
	return $h; 
}

function NbLines($w,$txt) 
{ 
    //Computes the number of lines a MultiCell of width w will take 
    $cw=&$this->CurrentFont['cw']; 
    $this->SetDrawColor(0, 0,0);  
    $this->SetLineWidth(.5);   
    if($w==0) 
        $w=$this->w-$this->rMargin-$this->x; 
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize; 
    $s=str_replace("\r",'',$txt); 
    $nb=strlen($s); 
    if($nb>0 and $s[$nb-1]=="\n") 
        $nb--; 
    $sep=-1; 
    $i=0; 
    $j=0; 
    $l=0; 
    $nl=1; 
    while($i<$nb) 
    { 
        $c=$s[$i]; 
        if($c=="\n") 
        { 
            $i++; 
            $sep=-1; 
            $j=$i; 
            $l=0; 
            $nl++; 
            continue; 
        } 
        if($c==' ') 
            $sep=$i; 
        $l+=$cw[$c]; 
        if($l>$wmax) 
        { 
            if($sep==-1) 
            { 
                if($i==$j) 
                    $i++; 
            } 
            else 
                $i=$sep+1; 
            $sep=-1; 
            $j=$i; 
            $l=0; 
            $nl++; 
        } 
        else 
            $i++; 
    } 
    return $nl; 
} 

function NbLines1($w,$txt) 
{ 
    //Computes the number of lines a MultiCell of width w will take 
    $cw=&$this->CurrentFont['cw']; 
    $this->SetDrawColor(0, 0,0);  
    $this->SetLineWidth(.5);   
    if($w==0) 
        $w=$this->w-$this->rMargin-$this->x; 
    $wmax=($w-2*$this->cMargin)*1000/7; 
    $s=str_replace("\r",'',$txt); 
    $nb=strlen($s); 
    if($nb>0 and $s[$nb-1]=="\n") 
        $nb--; 
    $sep=-1; 
    $i=0; 
    $j=0; 
    $l=0; 
    $nl=1; 
    while($i<$nb) 
    { 
        $c=$s[$i]; 
        if($c=="\n") 
        { 
            $i++; 
            $sep=-1; 
            $j=$i; 
            $l=0; 
            $nl++; 
            continue; 
        } 
        if($c==' ') 
            $sep=$i; 
        $l+=$cw[$c]; 
        if($l>$wmax) 
        { 
            if($sep==-1) 
            { 
                if($i==$j) 
                    $i++; 
            } 
            else 
                $i=$sep+1; 
            $sep=-1; 
            $j=$i; 
            $l=0; 
            $nl++; 
        } 
        else 
            $i++; 
    } 
    return $nl; 
} 


	function LoadData($file)
	{
	//Leer las líneas del fichero
		$lines=file($file);
		$data=array();
		foreach($lines as $line)
			$data[]=explode(';',chop($line));
			return $data;
	}

	//Tabla simple
	function BasicTable($header,$data)
	{
		//Cabecera
		foreach($header as $col)
			$this->Cell(40,7,$col,1);
			$this->Ln();
		//Datos
		foreach($data as $row)
		{
			foreach($row as $col)
				$this->Cell(40,6,$col,1);
			$this->Ln();
		}
	}
	//Una tabla más completa
	function ImprovedTable($header,$data)
	{
		//Anchuras de las columnas
		$w=array(40,35,40,45);
		//Cabeceras
		for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C');
		$this->Ln();
		//Datos
		foreach($data as $row)
		{
			$this->Cell($w[0],6,$row[0],'LR');
			$this->Cell($w[1],6,$row[1],'LR');
			$this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
			$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
			$this->Ln();
		}
		//Línea de cierre
		$this->Cell(array_sum($w),0,'','T');
	}

	//Tabla coloreada
	function FancyTable($header,$data)
	{
		//Colores, ancho de línea y fuente en negrita
		$this->SetFillColor(0,0,0);  //color de fondo de la celda
		$this->SetTextColor(255);    //color usado por el texto
		$this->SetDrawColor(0,0,0);  //color usado para las operaciones de graficación (lineas, rectangulos, y bordes de celdas )
		$this->SetLineWidth(0.3);     //Define el ancho de la línea. Por defecto, el valor es igual a 0.2 mm.
		$this->SetFont('Arial','B',10);
		//Cabecera
		$w=array(40,35,120);
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
		$this->Ln();
		//Restauración de colores y fuentes
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		//Datos
		$fill=false;
		foreach($data as $row)
		{
			$this->Cell($w[0],6,$row[0],'LR','','L',$fill);
			$this->Cell($w[1],6,$row[1],'LR','','L',$fill);
			$this->Cell($w[2],6,number_format($row[2]),'LR','','R',$fill);
			$this->Ln();
			$fill=!$fill;
		}
		$this->Cell(array_sum($w),0,'','T');
	}

//------------------------------------------------

  function Footer_x($direccion){
   $this->SetFont('Arial','BI',8);
   $this->Text(250,29,'Pagina : '.$this->PageNo()."/{nb}",0,0,'C');
   } 
  function Footer_y(){
   $this->SetFont('Arial','I',8);
   $this->Text(185,275,'Pagina : '.$this->PageNo()."/{nb}",0,0,'C');
   }
 function FooterResultado() 
    { 
        // Position at 1.5 cm from bottom 
        $this->SetY(-15); 
          
        // Set font-family and font-size of footer. 
        $this->SetFont('Arial', 'I', 8); 
          
        // set page number 
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . 
              '/{nb}', 0, 0, 'C'); 
    } 
 function footer1($direccion)
 {
	 	  $this->SetFont('Arial','I',8);
   $this->Text(10,265,'______________________________________________________________________________________________________________________________');
   $direccion=utf8_decode($direccion);
   //$this->Text(70,271,$direccion);
   $this->Text(85,271,'CAJARURO - AMAZONAS - PERU');
   $this->Text(190,271,'Pagina : '.$this->PageNo()."/{nb}",0,0,'C');
 //$this->SetFont('Arial','I',12);
   
	 }
	 
	  function footer2()
 {
	 	  $this->SetFont('Arial','I',10);
   
   $this->Text(55,274,'Calle Francisco Cabrera 130 - Teléfono: (074) 207084');
   //$this->Text(90,278,'CHICLAYO - PERU');
   $this->Text(180,274,'Pagina : '.$this->PageNo()."/{nb}",0,0,'C');
 //$this->SetFont('Arial','I',12);
   
	 }
	 
 function Header_x($pac,$sexo,$medico,$orden,$fecha,$edad,$dni)
  {
$this->SetFont('Arial','BIU',12);
$this->SetY(15);
 
$this->Text(65,46,"LABORATORIO DE ANALISIS CLINICO"); 
$this->SetFont('Arial','B',10);
$this->Text(85,77,"REPORTE DE RESULTADOS"); 
$this->Ln(5);
$this->SetFillColor(255);
$this->RoundedRect(10, 49, 196, 22.5, 5, '13', 'DF');
$this->SetFont('Arial','B',9);
$this->Text(15,54,"Paciente    :  ");
$this->Text(15,59,"Sexo          :  ");
$this->Text(15,64,"Indicacion :  ");
$this->Text(15,69,"Fec. Imp.   :  ");


$this->Text(150,54,"Fec. Examen    :  ");
$this->Text(150,59,"Edad                 :  ");
$this->Text(150,64,"DNI                    :  ");
$this->Text(150,69,"N° Orden          :");
//$this->Text(130,62,"Fec. Impresion :  " );
//$this->SetFont('Arial','BIU',10);
//$this->Text(82,82,"INFORME DE RESULTADOS"); 
$this->SetFont('Arial','B',9);
$this->Text(78,88,"Resultados");$this->Text(114.5,88,"Unidades"); $this->Text(144,88,"Rango Referencial");$this->Text(186,88,"Metodo");
$this->SetFont('Arial','I',9);
$this->Text(38,54,$pac);
$this->Text(38,59,$sexo);
$this->Text(38,64,"Dr(a). ".$medico);
$this->Text(38,69,date("d/m/Y h:i:s a"));

$this->Text(180,54,$fecha);
$this->Text(180,59,$edad);
$this->Text(180,64,$dni);
$this->Text(180,69,$orden);
	   }
function Header_Especiales($pac,$sexo,$medico,$orden,$fecha,$edad,$dni)
  {
	$this->SetFont('Arial','BIU',12);
$this->SetY(15);
 
 $this->Text(65,46,"LABORATORIO DE ANALISIS CLINICO"); 
 $this->SetFont('Arial','B',10);
 $this->Text(85,77,"REPORTE DE RESULTADOS"); 
$this->Ln(5);
$this->SetFillColor(255);
$this->RoundedRect(10, 49, 196, 22.5, 5, '13', 'DF');
$this->SetFont('Arial','B',9);
$this->Text(15,54,"Paciente    :  ");
$this->Text(15,59,"Sexo          :  ");
$this->Text(15,64,"Indicacion :  ");
$this->Text(15,69,"Fec. Imp.   :  ");


$this->Text(150,54,"Fec. Examen    :  ");
$this->Text(150,59,"Edad                 :  ");
$this->Text(150,64,"DNI                    :  ");
$this->Text(150,69,"N° Orden          :");
//$this->Text(130,62,"Fec. Impresion :  " );
//$this->SetFont('Arial','BIU',10);
//$this->Text(82,82,"INFORME DE RESULTADOS"); 
/*$this->SetFont('Arial','B',9);
$this->Text(78,88,"Resultados");$this->Text(114.5,88,"Unidades"); $this->Text(144,88,"Rango Referencial");$this->Text(186,88,"Metodo");*/
$this->SetFont('Arial','I',9);
$this->Text(38,54,$pac);
$this->Text(38,59,$sexo);
$this->Text(38,64,"Dr(a). ".$medico);
$this->Text(38,69,date("d/m/Y h:i:s a"));

$this->Text(180,54,$fecha);
$this->Text(180,59,$edad);
$this->Text(180,64,$dni);
$this->Text(180,69,$orden);
	   }
function Header_Historicos($pac,$sexo,$medico,$orden,$fecha,$edad,$dni,$examen)
  {
	$this->SetFont('Arial','BIU',12);
$this->SetY(15);
 
 $this->Text(65,46,"LABORATORIO DE ANALISIS CLINICO"); 
 $this->SetFont('Arial','BIU',9);
 $this->Text(12,80,"HISTORIAL DE EXAMEN :  ".$examen); 
$this->Ln(5);
$this->SetFillColor(255);
$this->RoundedRect(10, 49, 196, 22.5, 5, '13', 'DF');
$this->SetFont('Arial','B',9);
$this->Text(15,54,"Paciente    :  ");
$this->Text(15,59,"Sexo          :  ");
$this->Text(15,64,"Indicacion :  ");
$this->Text(15,69,"Fec. Imp.   :  ");


$this->Text(150,54,"Fec. Examen    :  ");
$this->Text(150,59,"Edad                 :  ");
$this->Text(150,64,"DNI                    :  ");
$this->Text(150,69,"N° Orden          :");
//$this->Text(130,62,"Fec. Impresion :  " );
//$this->SetFont('Arial','BIU',10);
//$this->Text(82,82,"INFORME DE RESULTADOS"); 
/*$this->SetFont('Arial','B',9);
$this->Text(78,88,"Resultados");$this->Text(114.5,88,"Unidades"); $this->Text(144,88,"Rango Referencial");$this->Text(186,88,"Metodo");*/
$this->SetFont('Arial','I',9);
$this->Text(38,54,$pac);
$this->Text(38,59,$sexo);
$this->Text(38,64,"Dr(a). ".$medico);
$this->Text(38,69,date("d/m/Y h:i:s a"));

$this->Text(180,54,$fecha);
$this->Text(180,59,$edad);
$this->Text(180,64,$dni);
$this->Text(180,69,$orden);
	   }
  function Header_Alergias($pac,$sexo,$medico,$orden,$fecha,$edad,$dni)
  {
	$this->SetFont('Arial','BIU',11);
$this->SetY(15);
 
 $this->Text(65,46,"LABORATORIO DE ANALISIS CLINICO"); 
 $this->SetFont('Arial','B',10);
$this->Ln(5);
$this->SetFillColor(255);
$this->RoundedRect(10, 49, 196, 22.5, 5, '13', 'DF');
$this->SetFont('Arial','B',9);
$this->Text(15,54,"Paciente    :  ");
$this->Text(15,59,"Sexo          :  ");
$this->Text(15,64,"Indicacion :  ");
$this->Text(15,69,"Fec. Imp.   :  ");


$this->Text(150,54,"Fec. Examen    :  ");
$this->Text(150,59,"Edad                 :  ");
$this->Text(150,64,"DNI                    :  ");
$this->Text(150,69,"N° Orden          :");
//$this->Text(130,62,"Fec. Impresion :  " );
//$this->SetFont('Arial','BIU',10);
//$this->Text(82,82,"INFORME DE RESULTADOS"); 

$this->SetFont('Arial','I',9);
$this->Text(38,54,$pac);
$this->Text(38,59,$sexo);
$this->Text(38,64,"Dr(a). ".$medico);
$this->Text(38,69,date("d/m/Y h:i:s a"));

$this->Text(180,54,$fecha);
$this->Text(180,59,$edad);
$this->Text(180,64,$dni);
$this->Text(180,69,$orden);
	   }
 function Cabecera($user,$nom_caja,$cod_ingreso,$empresa){
 $this->Image("imagenes/cab_liquidacion.jpg", -15, 0,  235, 40, $type='', $link='');
$this->Image('imagenes/pie_liquidacion.jpg',-5,266,235,20);
$this->SetFont('Arial','B',9);
$this->setTextColor(255,255,255);
$this->Text(155,8,"RUC               : 20561370096");
$this->Text(155,13,"Fec. Imp.       : ".date('d/m/Y h:i a'));
$this->Text(155,18,"Cod. Ingreso : ".$cod_ingreso);
//$pdf->Text(57,22,"CAJA 1");// $pdf->Text(7,35,"USUARIO : MELIAS");
$this->SetXY(50,18);
$this->Cell(30,7,$nom_caja,0,0,'C');
$this->SetXY(2,30);
$this->Cell(52,7,"USUARIO : ".$user,0,0,'C');
$this->SetFont('Arial','BIU',11);
$this->setTextColor(0,0,0);
$this->Text(72,37,"REPORTE DE CIERRE DE CAJA - ".$empresa);
 }
function CabeceraCierre($user,$nom_caja,$cod_ingreso,$fec_apertura,$fec_cierra,$empresa){
 $this->Image("imagenes/cab_liquidacion.jpg", -15, 0,  235, 40, $type='', $link='');
$this->Image('imagenes/pie_liquidacion.jpg',-5,266,235,20);
$this->SetFont('Arial','B',9);
$this->setTextColor(255,255,255);
$this->Text(155,8,"RUC               : 20561370096");
$this->Text(155,13,"Fec. Imp.       : ".date('d/m/Y h:i a'));
$this->Text(155,18,"Cod. Ingreso : ".$cod_ingreso);
//$pdf->Text(57,22,"CAJA 1");// $pdf->Text(7,35,"USUARIO : MELIAS");
$this->SetXY(50,18);
$this->Cell(30,7,$nom_caja,0,0,'C');
$this->SetXY(2,30);
$this->Cell(52,7,"USUARIO : ".$user,0,0,'C');
$this->SetFont('Arial','BIU',11);
$this->setTextColor(0,0,0);
$this->Text(80,33,"REPORTE DE CIERRE DE CAJA - ".$empresa);
$this->SetFont('Arial','B',8);
$this->Text(65,38,"Fec. Apertura : ".$fec_apertura);
$this->Text(130,38,"Fec. Cierre : ".$fec_cierra);
 }
 function CabeceraPrecios($user){
 $this->Image("imagenes/logoprecisa.jpg", 0, 5	,  200, 23, $type='', $link='');
$this->Image('imagenes/pie_liquidacion.jpg',-5,266,235,20);
$this->SetFont('Arial','B',9);
$this->setTextColor(255,255,255);
$this->Text(155,8,"RUC               : 20561370096");
$this->Text(155,14,"Fec. Imp.       : ".date('d/m/Y h:i a'));

//$pdf->Text(57,22,"CAJA 1");// $pdf->Text(7,35,"USUARIO : MELIAS");
$this->SetXY(50,18);
$this->Cell(30,7,$nom_caja,0,0,'C');
$this->SetXY(2,30);
$this->Cell(52,7,"USUARIO : ".$user,0,0,'C');
$this->SetFont('Arial','BIU',12);
$this->setTextColor(0,0,0);
$this->Text(90,37,"TARIFARIO DE PRECIOS");
 }

function CabeceraResumen($user,$nom_caja,$cod_ingreso){
 $this->Image("imagenes/cab_liquidacion.jpg", -15, 0,  235, 40, $type='', $link='');
$this->Image('imagenes/pie_liquidacion.jpg',-5,266,235,20);
$this->SetFont('Arial','B',9);
$this->setTextColor(255,255,255);
$this->Text(155,8,"RUC               : 20561370096");
$this->Text(155,13,"Fec. Imp.       : ".date('d/m/Y h:i a'));
$this->Text(155,18,"Cod. Ingreso : ".$cod_ingreso);
//$pdf->Text(57,22,"CAJA 1");// $pdf->Text(7,35,"USUARIO : MELIAS");
$this->SetXY(50,18);
$this->Cell(30,7,$nom_caja,0,0,'C');
$this->SetXY(2,30);
$this->Cell(52,7,"USUARIO : ".$user,0,0,'C');
$this->SetFont('Arial','BIU',12);
 }

 function Header_vista()
  {
	 $this->SetFont('Arial','BIU',12);
$this->SetY(15);
 
 $this->Text(65,45,"LABORATORIO DE ANALISIS CLINICO"); 
$this->Ln(5);
$this->SetFillColor(255);
$this->RoundedRect(10, 50, 196, 25, 5, '13', 'DF');
$this->SetFont('Arial','B',9);
$this->Text(15,57,"Paciente    :  ");
$this->Text(15,62,"Sexo          :  ");
$this->Text(15,67,"Indicacion :  ");
$this->Text(15,72,"Fec. Imp.   :  ");


$this->Text(130,57,"Fec. Examen    :  ");
$this->Text(130,62,"Edad                 :  ");
$this->Text(130,67,"DNI                    :  ");
$this->Text(130,72,"N° Orden          :");
//$this->Text(130,62,"Fec. Impresion :  " );
$this->SetFont('Arial','BIU',10);
$this->Text(82,82,"INFORME DE RESULTADOS"); 
$this->SetFont('Arial','B',9);
$this->Text(78,88,"Resultados"); 
$this->Text(114.5,88,"Unidades"); 
$this->Text(140,88,"Rango Referencial");
$this->Text(186,88,"Metodo");

/*$this->SetFont('Arial','I',10);
$this->Text(38,57,'');
$this->Text(38,62,$sexo);
$this->Text(38,67,"Dr(a). ".$medico);
$this->Text(38,72,date("d/m/Y h:i:s a"));

$this->Text(160,57,$fecha);
$this->Text(160,62,$edad);
$this->Text(160,67,$dni);*/
//$this->Text(160,62,date("d/m/Y h:i:s a"));
/*
$this->SetFont('Arial','B',10);*/
//creamos el tamaño de cada celda
//$pdf->Row(array('Nro',"",'Paciente','Monto'));
$this->Ln(4);
	   }

function Header_Protocolo($pac,$fecha,$turno,$hcl,$nro_hemo,$frec,$dni,$fua){
$this->SetFillColor(255);
$this->RoundedRect(10, 5, 196, 29, 5, '13', 'DF');
$this->SetFont('Arial','B',9);
$this->Text(103,11,"PROCEDIMIENTO DE HEMODIALISIS");

$this->Text(70,18,"Paciente     :");
$this->Text(165,18,"Fecha   :");
$this->Text(70,24,"Turno          :  ");
$this->Text(118,24,"HCL N° :  ");
$this->Text(165,24,"N° HD   :  ");
$this->Text(70,30,"Frecuencia :  ");
$this->Text(118,30,"N° SIS   :  ");
$this->Text(165,30,"N° FUA :  ");
$this->SetFont('Arial','I',8);
$this->Text(93,18,substr($pac,0,38));
$this->Text(183,18,$fecha);
$this->Text(93,24,$turno);
$this->Text(135,24,$hcl);
$this->Text(183,24,$nro_hemo);
$this->Text(93,30,$frec);
$this->Text(135,30,$dni);
$this->Text(183,30,$fua);	
}
	
function Header_Cultivos($pac,$sexo,$medico,$muestra,$fecha,$edad,$dni)
  {
	 $this->SetFont('Arial','BIU',14);
$this->SetY(15);
 
 $this->Text(65,45,"LABORATORIO DE ANALISIS CLINICO"); 
$this->Ln(5);
$this->SetFillColor(255);
$this->RoundedRect(10,50,196, 23, 5, '13', 'DF');
$this->SetFont('Arial','B',10);
$this->Text(15,55,"Paciente    :  ");
$this->Text(15,60,"Sexo          :  ");
$this->Text(15,65,"Indicacion :  ");
$this->Text(15,70,"Muestra     :  ");

$this->Text(130,55,"Fec. Examen    :  ");
$this->Text(130,60,"Edad                 :  ");
$this->Text(130,65,"DNI                    :  ");
$this->Text(130,70,"Fec. Impresion :  " );


$this->SetFont('Arial','I',10);
$this->Text(38,55,$pac);
$this->Text(38,60,$sexo);
$this->Text(38,65,"Dr(a). ".$medico);
$this->Text(38,70,$muestra);

$this->Text(160,55,$fecha);
$this->Text(160,60,$edad);
$this->Text(160,65,$dni);
$this->Text(160,70,date("d/m/Y h:i:s a"));

$this->SetFont('Arial','B',10);
//creamos el tamaño de cada celda
//$pdf->Row(array('Nro',"",'Paciente','Monto'));
$this->Ln(4);
	   }	   
	   
	   
function Header_conv($pac,$sexo,$dni,$nro_historia,$fecha,$cen_dia,$conv)
  {
	 $this->SetFont('Arial','BIU',14);
$this->SetY(15);
 
 $this->Text(62,35,"LABORATORIO DE ANALISIS CLINICO"); 
$this->Ln(5);
$this->SetFillColor(255);
$this->RoundedRect(10, 42, 196, 30, 5, '13', 'DF');
$this->SetFont('Arial','B',10);
$this->Text(15,49,"Paciente    :  ");
$this->Text(15,55,"Sexo          :  ");
$this->Text(15,61,"Centro de Dialisis :  ");
$this->Text(15,67,"Seguro      :  ");

$this->Text(140,49,"Fecha    :  ");
$this->Text(140,55,"HCL       :  ");
$this->Text(140,61,"DNI        :  ");
//$this->Text(130,62,"Fec. Impresion :  " );
$this->SetFont('Arial','BIU',11);
$this->Text(78,80,"INFORME DE RESULTADOS"); 
$this->SetFont('Arial','B',10);
$this->Text(80,87,"Resultados"); 
$this->Text(125,87,"Unidades"); 
$this->Text(155,87,"Rango de Referencia");

$this->SetFont('Arial','I',10);
$this->Text(38,49,$pac);
$this->Text(38,55,$sexo);
$this->Text(50,61,$cen_dia);
$this->Text(38,67,$conv);
$this->Text(160,49,$fecha);
$this->Text(160,55,$nro_historia);
$this->Text(160,61,$dni);
//$this->Text(160,62,date("d/m/Y h:i:s a"));

$this->SetFont('Arial','B',10);
//creamos el tamaño de cada celda
//$pdf->Row(array('Nro',"",'Paciente','Monto'));
$this->Ln(4);
	   }  


function SetDash($black=false, $white=false)
    {
        if($black and $white)
            $s=sprintf('[%.3f %.3f] 0 d', $black*$this->k, $white*$this->k);
        else
            $s='[] 0 d';
        $this->_out($s);
    }
 
}  
?>