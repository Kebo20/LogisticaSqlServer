<?php date_default_timezone_set('America/Lima');$user=1
//$user=$_POST['user'];?>
<br />
<div class="row">
 <div class="col-2"></div>
   <div class="col-8 topi">
		
    <div id="IdAbrir"   >
    <div class="modal-dialog xl" style="box-shadow:5px 5px 20px #000">
      <div class="modal-content">
      <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
      <h4 class="modal-title" style="color:#2679B5;">  <img src="imagenes/candado.png" height="30" width="30"  /> 
       <b> &nbsp;CONFIGURACION DE INGRESO </b><span id="Titu"></span> </h4>
        
      </div>
    <div class="modal-body">
     
     <table width="100%">
        <tr>
           <td colspan="5">
               <b>CAJA</b>
               <select class="form-control" id="IdCa" style="height:35px"  ></select>
           </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
           <td colspan="5">
               <b>FONDO INICIAL</b>
               <input type="number" min="0" value="0.00" step=".01" id="TxtFondoIncial" style="text-transform:uppercase" class="form-control">
           </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
           <td >
               <b>USER</b>
               <input type="text" id="TxtUser" style="text-transform:uppercase" readonly="readonly" class="form-control" value="<?=$user?>">
           </td>
           <td width="8%">&nbsp;</td>
           <td >
               <b>FECHA</b>
               <input type="text" id="TxtFecha" style="text-transform:uppercase" readonly="readonly" class="form-control" value="<?=date('d/m/Y')?>">
           </td>
           <td width="8%">&nbsp;</td>
           <!--<td>
               <b>HORA</b>
               <input type="text" id="TxtHora" style="text-transform:uppercase" class="form-control" readonly="readonly" value="">
           </td>-->
        </tr>   
     </table>
    
    </div>
    
    <div class="modal-footer">
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Grabar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>-->
        <table width="100%">
           <tr>
             <td align="left">
                 <button class="btn bg-vino cambio-color mr-1 mb-1"  id="id_grabar" onclick="GrabarAperturarCaja()" >
                 Aperturar Caja</button>
             </td>
           </tr>
        </table>
       										
								
      </div>
     </div>
   </div>
  </div>
        
	</div>
  <div class="col-2"></div>   
</div>

<script> 
  function LLenarCaja(){
	  $.post('controlador/Cadmision.php',{accion:"LLENAR_CAJA"},function(data){
		  $("#IdCa").html(data);console.log(data)
     })
   }
  
   
   function GrabarAperturarCaja(){
	 var $caja=$("#IdCa").val()
	 
	 
     //var $codigo=$caja+dia+mes+anio+hora+minu+seg
	 if($("#TxtFondoIncial").val()==''){$fondo=0.00;}else{$fondo=$("#TxtFondoIncial").val()}
	 var $fondo=parseFloat($fondo).toFixed(2) 
	 var $user=$("#TxtUser").val()
	 var $nom_caja=$('#IdCa option:selected').text()
	 if($caja==0){swal("Seleccionar Caja a Aperturar", "Campo Obligatorio", "warning"); return false;}

	 swal({
  title: "Confirmacion",
  text: "Está seguro de Aperturar Caja",
  icon: "warning",
  buttons: true,
  dangerMode: true}).then((willDelete) => {
  if (willDelete) {
	   $.post('controlador/Cadmision.php',{accion:"APERTURAR",idcaja:$caja,fondo:$fondo,user:$user,nom_caja:$nom_caja},function(data){
		 //alert(data)
		 if(data==2){swal("Usuario Ya tiene Caja Inicializada", "Error", "error"); return false;}
		 if(data==1){LLenarCaja(); swal("Se Aperturo caja Correctamente", "Felicitaciones", "success");
		  $("#LiAdmTab1").attr("style", "display: none !important");$("#AdmTab1").html('')}	 
		 if(data==0){swal("No se aperturo Caja", "Verifique", "error"); return false;}
        })
	 } 
   });
  }
   
LLenarCaja()

 </script>
            
  <input type="hidden" id="IdHiResulVen" value="0"  /> 
  <input type="hidden" id="IdHiPac" value=0 /> 
  <input type="hidden" id="IdHiTi" value="<?=$_POST['Tipo']?>"  /> 
  <input type="hidden" id="idvalor"  />

  
 
 
  
  
  
<style>
.topi{
  margin-top:0!important;
 }
.bodycontainer { max-height: 220px; width: 100%; margin: 0; overflow-y: auto; height:220px; }
.table-scrollable { margin: 0; padding: 0; }
</style>

