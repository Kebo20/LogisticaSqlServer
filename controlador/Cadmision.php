<?php   require_once('../cado/ClaseAdmision.php'); 
	    date_default_timezone_set('America/Lima');
	    session_start();
	
	

   controlador($_POST['accion']);
   
    function controlador($accion){
	
	   $oadmision=new Admision();
	  
	  if($accion=="LLENAR_CAJA"){
		$tbl="";
		$tbl="<option value='0'></option>";
		$listar=$oadmision->ListarNoActivas();
		while($fila=$listar->fetch()){
		   $tbl.="<option value='$fila[0]' > $fila[1] </option>";  
		}
		echo $tbl;
	  }
		 
	  if($accion=="MED_ESP"){
		  $tbl="";
		  $id=$_POST['id'];
		  $tbl="<option value='0'></option>";
		  $listar=$oadmision->MedicosXEsp($id);
		  while($fila=$listar->fetch()){
		    $tbl.="<option value='$fila[0]' > $fila[1] </option>";  
		  }
		  echo $tbl;
	    }
	  if($accion=="MED"){
		  $tbl="";
		  $tbl="<option value='0'></option>";
		  $listar=$oadmision->LisMedicos();
		  while($fila=$listar->fetch()){
		    $tbl.="<option value='$fila[0]' > $fila[1] </option>";  
		  }
		  echo $tbl;
	    }
	  if($accion=="BUS_PER"){
		  $tbl="";
		  $dni=$_POST['dni'];
		  $listar=$oadmision->BuscarPer($dni)->fetch();
		  $id=$listar[0];$pac=$listar[2];
		  echo $id.'**'.$pac;
	    }
	   if($accion=="BUS_NOM"){
		  $tbl="";
		  $nom=$_POST['nom'];
		  $listar=$oadmision->BuscarPerNom($nom);$i=0;
		  while($fila=$listar->fetch()){$i++;
			  $id='TblBusPac_'.$i; $idbtn='BtnBusPac_'.$i;								
			  if($i%2==0){$color=" background-color:#f5f5f5 !important; height:25px; ";}
			   else{$color="background-color:#ffffff !important; height:25px; ";}
				$tbl.="<tr id='$id' style='$color' onclick=\"javascript:PintarFilaBusPer('$id')\" 
				dni='$fila[1]' pac='$fila[2]' >
							<td align='center'>
			<button id='$idbtn' type='button' class='btn btn-light square btn-min-width mr-1 mb-1' 
			style='margin:0 !important; background-color: transparent !important; color:#000 !important; border:0 !important ' >
			$fila[1]</button>
			</td>
							<td  >&nbsp;&nbsp;$fila[2]</td>
				       </tr>";
		  }
		  echo $tbl.'**'.$i;
	    }
		
		if($accion=='CONSULTA_RUC'){
        require_once('../sunat/src/autoload.php');
		$company = new \Sunat\Sunat( false, false );
        $ruc = $_POST['ruc'];
		$search1 = $company->search( $ruc );
	    $info = json_decode($search1->json(),true);
		if($info['success']==false){echo 0;exit;}

		$datos = array(
	        0 => $info['result']['ruc'], 
	        1 => $info['result']['razon_social'],
	        2 => $info['result']['direccion'],
           );
		echo json_encode($datos);
		}
		
		if($accion=='LIS_SERIE'){
			$tbl="";
		    $listar=$oadmision->ListarSerie();
			$tbl.="<option value='0'></option>";
			while($col=$listar->fetch() ){
		      $tbl.="<option value='$col[0]'>$col[1]</option>";
			}
			echo $tbl;
		 }
		 if($accion=='AUTOCIE'){
			 //$pac=$_POST['pac'];   
			 $listar=$oadmision->ListarCie(); 
			 echo json_encode($listar->fetchAll()); 	
		 }
		 if($accion=='LLE_SERV'){
			$tbl="";
			$id=$_POST['id'];
		    $listar=$oadmision->LisServicioXTipoServ($id);
			$tbl.="<option value='0'></option>";
			while($col=$listar->fetch() ){
		      $tbl.="<option value='$col[0]' precio='$col[2]' >$col[1]</option>";
			}
			echo $tbl;
		 }
		 
		 if($accion=='GRABAR_AM'){
			 //$pac=$_POST['pac'];   
			$dni=$_POST['dni'];
			$idtiposerv=$_POST['idtiposerv'];
			$idturno=$_POST['idturno'];
			$idesp=$_POST['idesp'];
			$idmed=$_POST['idmed'];
			$cod_tipo=$_POST['cod_tipo'];
			$carrito=$_POST['carrito'];
			$cod_ingreso=$_SESSION['S_cod_ingreso'];
			$user=$_SESSION['S_user'];
			$grabar=$oadmision->GrabarAM($dni,$idtiposerv,$idturno,$idesp,$idmed,$cod_tipo,$carrito,$user,$cod_ingreso);	
			echo $grabar;	
		 }
		 
		 if($accion=='VAL_USER'){		
			$user=$_POST['user'];
			$val_user=$oadmision->ValidarUserActivo($user);
			while($fila=$val_user->fetch()){$can=$fila[0];}
			echo $can;
		 }
		 if($accion=='APERTURAR'){
			$idcaja=$_POST['idcaja'];
			$fecha=date('dmYhis');
			$fondo=$_POST['fondo'];
			$codigo=$idcaja.$fecha;
			$user=$_POST['user'];
			$nom_caja=trim($_POST['nom_caja']);
			$val_user=$oadmision->ValidarUserActivo($user);
			$fila=$val_user->fetch();$can=$fila[0];
			if($can==0){
		       $insertar=$oadmision->AperturarCaja($idcaja,$nom_caja,$codigo,$fondo,$user);
			   echo $insertar;
			}else{echo 2;}
		 }
		 if($accion=='CERRAR'){
			$idcaja=$_SESSION['S_idcaja'];
			$cod_ingreso=$_SESSION['S_cod_ingreso'];
			$iduser=$_SESSION['S_iduser'];
			$efectivo=$_POST['efectivo'];
			$tarjeta=$_POST['tarjeta'];
			$egresos=$_POST['egresos'];
			$total=$_POST['total'];
			/*$bi200=$_POST['bi200'];$bi100=$_POST['bi100'];$bi50=$_POST['bi50'];$bi20=$_POST['bi20'];$bi10=$_POST['bi10'];
			$mo5=$_POST['mo5'];$mo2=$_POST['mo2'];$mo1=$_POST['mo1'];$mo050=$_POST['mo050'];$mo020=$_POST['mo020'];$mo010=$_POST['mo010'];*/
			$insert=$oadmision->CerrarCaja($idcaja,$cod_ingreso,$iduser,$efectivo,$tarjeta,$egresos,$total);
			echo $insert;
		}
			
	}
?>