<?php  
$sucu=$_POST['sucu'];
$tipo=$_POST['tipo'];

date_default_timezone_set('America/Lima');
 ?>
  
<table id="IdTblEgresos" border="1" bordercolor="#cccccc" >
	<thead>
	   <tr style="font-size:14px">
		  <Th>Nro Egreso</Th>
		  <Th>Persona</Th>
		  <Th>Monto</Th>
		  <Th>Descripci&oacute;n</Th>
		  <Th>Empresa</Th> 
	   </tr>
	</thead>
	<tbody id="IdCuerpoCaja" style="font-size:12px;"></tbody>  
</table>
<br>
<div class="row">
	<div class="col-lg-4 col-md-12">
		<div class="form-group">
		<!-- Simple Icon Button -->
	<button type="button" class="btn bg-vino cambio-color mr-1 mb-1" onClick="AbrirModalEgreso()"><i class="ft-plus"></i> Nuevo</button>
		</div>
	</div>	
</div>



 <div id="IdModalEgreso" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-header" >
         <div class="row">
		   <div class="col-12"><img src="img/egresos.png" height="30" width="30"  />&nbsp; REGISTRAR EGRESO</div> 
		   
		 </div>
        
        
      </div>
    <div class="modal-body">  
       <table width="100%">
          <tr>
             <td><b>Empresa</b>
                <select id="CboEmpresa" class="chosen-select form-control" style="width:100%;"> 
                   <option value="P" selected="selected">BMCLINICA</option>
                   <option value="I">CLINICA DE OJOS</option>
                </select>
             </td>
          </tr>
          <tr><td>&nbsp;</td></tr>
          <tr>
             <td><b>Persona</b>
                <input type="text" id="TxtPersona" class='form-control'  />
             </td>
          </tr>
          <tr><td>&nbsp;</td></tr>
          <tr>
             <td><b>Monto</b>
                <input type="number" id="TxtMonto" class='form-control'  />
             </td>
          </tr>
          <tr><td>&nbsp;</td></tr>
          <tr>
             <td><b>Descripci&oacute;n</b>
                <input type="text" id="TxtDescripcion" class='form-control'  />
             </td>
          </tr>
     </table>
 </div>
    
    <div class="modal-footer">
        <button type="button" id="BtnGrabarSerie" class="btn bg-vino mr-1 mb-1" onClick="GrabarEgreso()"> Grabar</button>
		<button type="button" class="btn bg-vino mr-1 mb-1" data-dismiss="modal"> Cancelar</button>	
    </div>
     </div>
   </div>
  </div>   
     

 <script>            
		
  $(document).ready(function() {
	  $("#IdModalEgreso").on('shown.bs.modal', function(){
        $(this).find('#TxtPersona').focus();
      });
	  $('#IdTblEgresos').fixheadertable({
		//caption	: 'Lista de Areas', 
		colratio : [10,50,20,20,20], 
		height : 500, 
		width :'100%', 
		zebra : true, 
		sortable : false, 
		sortedColId : 3, 
		pager : false,
		rowsPerPage	 : 10,
		resizeCol : false,
	});
  })
	 function PintarFila($id,$estado){
	 var $idfilaanterior=$("#IdHiRepor").val()  
	 var $par=$idfilaanterior.split('_')
	 var $par_int=parseInt($par[1])
	// alert($par_int)
		 if($par_int%2==0){
		   // alert("hola")
		  $("#"+$idfilaanterior).css({ 
			   "background-color":"#f5f5f5",
			   "color": "#000000"
			})
		}else{
		   $("#"+$idfilaanterior).css({
			   "background-color":"#FFFFFF",
			   "color": "#000000"
			})					   
		}
		$("#"+$id).css({
		   "background-color": "#438EB9",
		   "color": "#FFFFFF"
		 })
		 /*if($estado=='ANULADO'){$("#BtnAnul").hide()}else{$("#BtnAnul").show()}*/
		$("#IdHiRepor").val($id)	
  } 
     function Seleccionar(){
	     var $tipo= $('input:radio[name=Egresos]:checked').val()
		 if($tipo=='P'){$("#TdMed,#TdBoton,#TblTicket,#TblCuerpoTicket,#IdPagoM").show();$("#TdFinta,#IdOtrosP").hide() }
		 if($tipo=='O'){$("#TdMed,#TdBoton,#TblTicket,#TblCuerpoTicket,#IdPagoM").hide();$("#TdFinta,#IdOtrosP").show(); $("#TxtPago").focus()}
	  }
     function ListarMedicos(){
	   $.post('controlador/Creporte.php',{accion:"LIS_ME_CAJA"},function(data){
	      $("#Med1").html(data);$("#Med1").trigger("chosen:updated")
		});
	  }
	  function ListarPago(){
		 var $tipo=2
		 var $idmed=$("#Med1").val()
	   $.post('controlador/Creporte.php',{accion:"LIS_PAGO_CAJA",t:$tipo,idmed:$idmed},function(data){
			$("#IdCuTicket").html(data);
		})
	  }
   
	// function ValidarFechas(){$fin=$("#FecFin").val();$("#FecInicio").val($fin).attr("max",$fin)}
	
	function abrirEnPestana(url) {
		var a = document.createElement("a");
		a.target = "_blank";
		a.href = url;
		a.click();
	}
	
	function AbrirModalEgreso(){
	 limpiar_campos();$("#IdModalEgreso").modal()
    }
	function CerrarModal(){$("#IdModalEgreso").modal("hide")} 			 	 	
    function limpiar_campos(){
	  $("#TxtMonto,#TxtDescripcion,#TxtPersona").val("");
	}	
	/*function VerDetalle($idmed,$medico,$ini,$fin){
	    url="Pdf_DetallePagoMedico.php?id="+$idmed+"&ini="+$ini+"&fin="+$fin+"&med="+$medico
		abrirEnPestana(url)
	 }*/
	function VerDetalleTicket($medico,$idreceta){
	    url="Pdf_DetalleTicket.php?med="+$medico+"&r="+$idreceta
		abrirEnPestana(url)
	 }
	
	function ListarEgresos(){
	   $.post('controlador/Ccaja.php',{accion:"LIS_EGRESOS"},function(data){
	        $("#IdCueroEgreso").html(data)
		});
	  }
	 
  function AnularEgreso($id){
	swal({
  title: "Confirmacion",
  text: "Desea Anular Egreso",
  icon: "warning",
  buttons: true,
  dangerMode: true}).then((willDelete) => {
  if (willDelete) {
      $.post('controlador/Ccaja.php',{accion:"ANU_EGRESOS",id:$id},function(data){
	        if(data==1){ListarEgresos();swal("Egreso Anulado ..", "Felicitaciones", "success");}
			if(data==0){swal("Datos no registrados ..", "Error", "error");}
		 });
	   } 
    });
  }
	
	function GrabarEgreso(){
	   var $empresa=$("#CboEmpresa").val()
	   var $persona=$("#TxtPersona").val()
	   var $monto=$("#TxtMonto").val()
	   var $descripcion=$("#TxtDescripcion").val()
	   if($persona==''){swal("Ingrese Persona ..", "Campo Obligatorio", "warning");return false;}
	   if($monto=='' || $monto<=0){swal("Ingrese Monto ..", "Campo Obligatorio", "warning");return false;}
	   if($descripcion==''){swal("Ingrese Descripcion ..", "Campo Obligatorio", "warning");return false;}
	  
	  swal({
  title: "Confirmacion",
  text: "Está seguro de Generar Egreso",
  icon: "warning",
  buttons: true,
  dangerMode: true}).then((willDelete) => {
  if (willDelete) {
	  
	   $.post('controlador/Ccaja.php',{accion:"REG_EGRESO",empresa:$empresa,persona:$persona,monto:$monto,des:$descripcion},function(data){
			if(data==1){ListarEgresos();CerrarModal();swal("Egreso Generado ..", "Felicitaciones", "success");}
			if(data==0){swal("Datos no registrados ..", "Error", "error");}
			if(data=='NO'){location.href='index.php'}
		})
     } 
   });
} 


	function CalcularRetencion($idcheck,$monto,$idcaja,$idcaja2){
	   var retencion=(($monto*8)/100).toFixed(2)
	   var pago=($monto-retencion).toFixed(2)
	    if ($('#'+$idcheck).is(':checked')){$("#"+$idcaja).val(retencion);$("#"+$idcaja2).val(pago);}	
		else{$("#"+$idcaja).val(0.00);$("#"+$idcaja2).val($monto)}
	 }

  //ValidarFechas()
  ListarMedicos()
  Seleccionar()
  
   /*function AnularTicket(){
		$ident = $("#IdHiRepor").val()
		$orden=$("#"+$ident).attr('orden');
		$tip=$("#"+$ident).attr('tipo');
		if($ident == ''){swal("Debe seleccionar un Registro", "Seleccione Registro", "warning");return false;}
	    if($orden==''){swal("Seleccione Orden ..", "Alerta", "warning"); return false;}  
swal({
  title: "Confirmacion",
  text: "Está seguro de Anular Orden",
  icon: "warning",
  buttons: true,
  dangerMode: true}).then((willDelete) => {
  if (willDelete) {
    $.post("controlador/Creceta.php",{accion:'GEN_TICKET',orden:$orden,t:$tip},function(data){
		   if(data==1){ListarPago();swal("Ticket Generado",'Felicitaciones','success');return false;}
		   if(data==0){swal("No se Generar Ticket",'Error','error');return false;}
	     })
        } 
      });
	 }*/
  
    function PagarTicket($id_ticket,$nro_ticket,$monto,$idretencion,$idpago){
		var $monto_retencion=$("#"+$idretencion).val()
		var $pago_medico=$("#"+$idpago).val()
	    swal({
  title: "Está seguro de Realizar Pago",
  text: "Recuerde Imprimir Detalle",
  icon: "warning",
  buttons: true,
  dangerMode: true}).then((willDelete) => {
  if (willDelete) {
     $.post("controlador/Creporte.php",{accion:'PAGO_TICKET',id:$id_ticket,nro_ticket:$nro_ticket,monto:$monto,monto_retencion:$monto_retencion,pago:$pago_medico},function(data){
		   if(data==1){ListarMedicos();ListarPago();swal("Pago Generado",'Felicitaciones','success');return false;}
		   if(data==0){swal("No se pudo Generar pago",'Error','error');return false;}
	     })
        } 
      });
	}
   
 </script>
  
  <input type="hidden" id="IdHiRepor"  />         
  <input type="hidden" id="IdHiPac"  />
  <input type="hidden" id="IdHiFecha" value="<?=date('Y-m-d')?>"  />

<style>
.bodycontainer { max-height: 340px; width: 100%; margin: 0; overflow-y: auto; height:340px; }
.table-scrollable { margin: 0; padding: 0; }
.ui-autocomplete { height: 200px; overflow-y: scroll; overflow-x: hidden;}
</style>
          