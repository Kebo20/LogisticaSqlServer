<?php
	function mostrarFechaHora($fec){
		if(!empty($fec))
		{
			if($fec!='0000-00-00 00:00:00'){
				$fecha	=date('d-m-Y h:i:s a', strtotime($fec));
			}
			else
			{
				$fecha="";
			}
		}
		else
		{
			$fecha="";
		}
		
		return $fecha;
	}
	
	function mostrarFechaHoraH($fec){
		if(!empty($fec))
		{
			if($fec!='0000-00-00 00:00:00'){
				$fecha	=date('d-m-Y H:i:s', strtotime($fec));
			}
			else
			{
				$fecha="";
			}
		}
		else
		{
			$fecha="";
		}
		
		return $fecha;
	}
	
	function mostrarFecha2($fec){
		if(!empty($fec))
		{
			if($fec!='0000-00-00 00:00:00'){
				$fecha	=date('d-m-Y', strtotime($fec));
			}
			else
			{
				$fecha="";
			}
		}
		else
		{
			$fecha="";
		}
		
		return $fecha;
	}
	
	function mostrarFecha($fec){
		if(!empty($fec))
		{
			if($fec!='0000-00-00'){
				$fecha	=date('d-m-Y', strtotime($fec));
			}
			else
			{
				$fecha="";
			}
		}
		else
		{
			$fecha="";
		}
		$fecha = str_replace('-','/',$fecha);
		return $fecha;
	}
	
	function mostrarHora($hor){
		if(!empty($hor))
		{
			if($hor!='NULL'){
				$hora	=date('h:i a', strtotime($hor));
			}
			else
			{
				$hora="";
			}
		}
		else
		{
			$hora="";
		}
		
		return $hora;
	}
	
	function mostrarHora_fh($fec){
		if(!empty($fec))
		{
			if($fec!='0000-00-00 00:00:00'){
				$fecha	=date('H:i:s', strtotime($fec));
			}
			else
			{
				$fecha="";
			}
		}
		else
		{
			$fecha="";
		}
		
		return $fecha;
	}
	
	function formato_hora($hor){
		if(!empty($hor))
		{
			if($hor!='NULL'){
				$hora	=date('H:i', strtotime($hor));
			}
			else
			{
				$hora="";
			}
		}
		else
		{
			$hora="";
		}
		
		return $hora;
	}
	
	function hora_mysql($hor){
		if(!empty($hor) and $hor!="")
		{
			$hora=$hor;
		}
		else
		{
			$hora="NULL";
		}
		return $hora;
	}
	
	function fecha_mysql($fec){
		if(!empty($fec))
		{
			$fecha=date('Y-m-d', strtotime($fec));
		}
		else
		{
			$fecha="";
		}
		return $fecha;
	}
	
	function fechahora_mysql($fechor){
		
		if(!empty($fechor))
		{
			//$fec=substr($fechor,0,10);
			//$hora=substr($fechor,-8);
			
			$fechahora=date('Y-m-d H:i:s', strtotime($fechor));
			
			//$fechahora=$fecha.' '.$hora;
		}
		else
		{
			$fechahora="";
		}
		return $fechahora;
	}
	
	function formato_moneda($monto){
		$dato=number_format($monto, 2, '.', '');
		return $dato;
	}
	function formato_money($monto){
		$dato=number_format($monto, 2);
		return $dato;
	}
	function formato_money2($monto){
		$dato=number_format($monto, 4);
		return $dato;
	}
	function formato_decimal($monto,$decimales){
		$dato=number_format($monto, $decimales, '.', '');
		return $dato;
	}
	function formato_numero($monto,$decimales,$separador_miles){
		$dato=number_format($monto, $decimales, '.', "$separador_miles");
		return $dato;
	}

	function moneda_mysql($monto){
		if($monto!="")
		{
			$dato=str_replace(",","",$monto);
		}
		else
		{
			$dato="";
		}
		return $dato;
	}
	
	function mostrar_blanco($text){
		if($text!="") {
			$texto=$text;
		}
		else
		{
			$texto='&nbsp;';
		}
		return $texto;
	}
	function mostrar_siigual($texto_entrada,$condicion,$texto_salida){
		if($texto_entrada=="$condicion") {
			$ret=$texto_salida;
		}
		else
		{
			$ret='&nbsp;';
		}
		return $ret;
	}
	function limpia_espacios($cadena){
		$cadena=trim($cadena);
		$cadena = ereg_replace( "([  ]+)", " ", $cadena );
		$cadena = str_replace('  ', ' ', $cadena);

		return $cadena;
	}
	
function utilidad($precos, $preven,$decimales){
	$min = $precos;
	$max = $preven;	
	if($max!==0 && $min!==0){
	$util = (1-($min/$max))*100; 
	$util = intval($util*1000)/1000;	
	return $util.' %';
	}else{
			return "Error!";
		}

}
	/**
	* Le da formato a un número agregando la coma
	* y verificando la cantidad de decimales
	* 
	* @author Marlon
	* @param $num número a formatear
	* @param $dec cantidad de decimales
	* @return String numero formateado
	*/
	function autonumeric($num, $dec=null){

		if(!is_numeric($num)) return $num;
		$num = (string) $num;

		$puntopos = strpos($num, '.');

		if($puntopos>0){
			$partdec = substr($num, $puntopos);
			$partent = substr($num, 0, $puntopos);
		}else{
			$partdec = '.0';
			$partent = $num;
		}

		if(isset($dec) && is_int($dec)){
			$partdec .= '00000000000000000000000000000000000000000000000000000000000';
			$partdec = substr($partdec, 0, $dec+1);
		}

		if($dec===0) $partdec = '';

		if(strlen($partent)>3){
			$cente = substr($partent, strlen($partent)-3);
			$exede = substr($partent, 0, strlen($partent)-3);
			$partent = $exede.','.$cente;
		}
		return $partent.$partdec;

	}

	/**
	* Compila una vista a partir de la ruta de una vista inyectando variables
	* 
	* @author Marlon Montalvo Flores
	* @param $path ruta de la vista
	* @param $data array con las variables a inyectar
	* @return String vista compilada
	*/
	function compilar_vista($path, $data=array()){
		ob_start();
		extract($data);
		include $path;
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}


	/**
	* Completa un codigo con caracteres a las izquierda
	* 
	* @author Marlon Montalvo Flores
	* @param $codigo Codigo a completar
	* @param $largo largo del codigo deseado
	* @param $char caracter para completar por defecto es 0
	* @return String codigo generado
	*/
	function generar_serie($codigo, $largo, $char='0'){
		if(strlen($codigo) >= $largo) return $codigo;
		$count = $largo - strlen($codigo);
		for ($i=0; $i < $count; $i++) { 
			$codigo = $char.$codigo;
		}
		return $codigo;
	}
?>