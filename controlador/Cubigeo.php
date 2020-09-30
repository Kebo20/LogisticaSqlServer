<?php  session_start();
    require_once('../cado/ClaseUbigeo.php'); 
	
	
	   $oubigeo=new Ubigeo();
	   
	  $accion = $_POST['accion'];
	   if($accion=='provincias'){
	       
	       $departamento = $_POST['departamento'];
	       $provincias=$oubigeo->Listar_provincia($departamento);
	       $resultado="<option value=''>Seleccione una provincia</option>";
	       foreach($provincias as $provincia){
	           
	            $resultado.="<option value='$provincia[0]'>$provincia[1]</option>";
	       }
	       
	       echo $resultado;
	   }
	   
	   
	    if($accion=='distritos'){
	      
	       $provincia = $_POST['provincia'];
	       $distritos=$oubigeo->Listar_distrito($provincia);
	       $resultado="<option value=''>Seleccione un distrito</option>";
	       foreach($distritos as $distrito){
	           
	            $resultado.="<option value='$distrito[0]'>$distrito[1]</option>";
	       }
	       
	       echo $resultado;
	   }
	       
	   
	       
	   
	   
    