<?php require_once('cado/ClaseAdmision.php');
$oadmision=new Admision();
date_default_timezone_set('America/Lima');$user=$_POST['user'];
$cod_ingreso=$_POST['cod_ingreso'];
$listar=$oadmision->ListarCajaFondo($cod_ingreso);
$col=$listar->fetch();
$fondo_inicial=$col[1];$efectivo=$col[2];$tarjeta=0.00;$egreso=0.00;
$total=$fondo_inicial+$efectivo+$tarjeta-$egreso;
//$billetes_monedas=$efectivo-$egreso;
?>
<!--<div class="page-header"  style="background-color:#EFF3F8; margin-bottom:0">
		<h1><i class="menu-icon"><img id="IdImgEdificacion" src="imagenes/abrir_caja.png" style="border:0;"  height="25" width="25" ></i>
			<span id="Titulo" style="font-size:13px; font-weight:bold">ABRIR CAJA</span>
        </h1> 								
</div>-->
<br />
<div class="row">
 <div class="col-1"></div>
   <div class="col-10 topi">
		
    <div id="IdAbrir"   >
    <div class="modal-dialog topi" style="box-shadow:5px 5px 20px #000">
      <div class="modal-content">
      <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
      <h4 class="modal-title" style="color:#2679B5;">  <img src="img/candado.png" height="30" width="30"  /> 
       <b> &nbsp;CIERRE DE CAJA </b> </h4>
        
      </div>
    <div class="modal-body" style="margin:0px !important">
      <table  width="100%">
        <tbody>
           <tr>
             <td ><b>FONDO INICIAL</b>
   <input type="text" id="TxtIdFondoInicial" class="form-control" style="width:100%;font-size:16px;" readonly="readonly" 
   value='<?=$fondo_inicial?>' ></td>
   </tr>
            <tr> <td ><b>Total Efectivo</b>
                 <input type="text" id="TxtIdEfectivo" class="form-control"  style="width:100%;font-size:16px;" readonly="readonly" 
                 value="<?=$efectivo?>" ></td> </tr>
            <tr> <td ><b>Total Tarjeta</b>
                  <input type="text" id="TxtIdTarjeta"  class="form-control" style="width:100%;font-size:16px;" readonly="readonly"
                   value="<?=$tarjeta?>"></td></tr>
             <tr><td ><b>Total Egresos</b>
                  <input type="text" id="TxtIdEgresos"  class="form-control" style="width:100%; font-size:16px;" readonly="readonly" 
                  value="<?=$egreso?>" ></td></tr>
             <tr><td ><b>Total Cierre</b>
                  <input type="text" id="TxtIdTotal" class="form-control" style="width:100%; font-size:16px; font-weight:bold"
                   readonly="readonly" value="<?=$total?>"></td> 
             </tr>
           <tr><td>&nbsp;</td></tr>
        </tbody>
     </table>
    
    </div>
    
    <div class="modal-footer" style="margin-top:-25px;">
        <table width="100%">
           <tr>
             <td align="left">
                <button class="btn bg-vino cambio-color mr-1 mb-1"  id="id_grabar" onclick="CerrarCajaLiquidacion()" >
                Cerrar Caja</button>
             </td>
           </tr>
        </table>
       										
								
      </div>
     </div>
   </div>
  </div>
        
	</div>
  <div class="col-1"></div>   
</div>
<script> 
    function abrirEnPestana(url) {
		var a = document.createElement("a");
		a.target = "_blank";
		a.href = url;
		a.click();
	}     
   function CerrarCajaLiquidacion(){
	 var $fon_incial=$("#TxtIdFondoInicial").val()
	/* var $bille_mone=$("#TxtIdBilletesMonedas").val()*/
	 var $efectivo=$("#TxtIdEfectivo").val()
	 var $tarjeta=$("#TxtIdTarjeta").val()
	 var $egresos=$("#TxtIdEgresos").val()
	 var $total=parseFloat($("#TxtIdTotal").val()).toFixed(2)
	 /*var $bi200=$("#TxtId200").val();var $bi100=$("#TxtId100").val();var $bi50=$("#TxtId50").val();var $bi20=$("#TxtId20").val();var $bi10=$("#TxtId10").val()
	 var $mo5=$("#TxtId5").val();var $mo2=$("#TxtId2").val();var $mo1=$("#TxtId1").val();var $mo050=$("#TxtId050").val();var $mo020=$("#TxtId020").val()
	 var $mo010=$("#TxtId010").val()*/
	 if($efectivo==''){$efectivo=0}if($tarjeta==''){$tarjeta=0}if($egresos==''){$egresos=0}if($total==''){$total=0}
	 /*if($bi200==''){$bi200=0;}if($bi100==''){$bi100=0;}if($bi50==''){$bi50=0;}if($bi20==''){$bi20=0;}if($bi10==''){$bi10=0;}
	 if($mo5==''){$mo5=0;}if($mo2==''){$mo2=0;}if($mo1==''){$mo1=0;}if($mo050==''){$mo050=0;}if($mo020==''){$mo020=0;}if($mo010==''){$mo010=0;}
	 var $suma_total=($bi200*200)+($bi100*100)+($bi50*50)+($bi20*20)+($bi10*10)+($mo5*5)+($mo2*2)+($mo1*1)+($mo050*0.5)+($mo020*0.2)+($mo010*0.1);
	 //var $suma_total=$suma_total;
	 //$total=$total.toFixed(2)
	  //alert($bille_mone);alert($suma_total)
	 if($bille_mone>$suma_total){swal("El Total Efectivo es diferente a los billetes y monedas ingresadas", "Verifique", "error");return false;}
	 if($bille_mone<$suma_total){swal("El Total Efectivo es diferente a los billetes y monedas ingresadas", "Verifique", "error");return false;}*/
	swal({
  title: "Confirmacion",
  text: "Está seguro de Cerrar Caja",
  icon: "warning",
  buttons: true,
  dangerMode: true}).then((willDelete) => {
  if (willDelete) { 
     $.post('controlador/Cadmision.php',{accion:"CERRAR",efectivo:$efectivo,tarjeta:$tarjeta,egresos:$egresos,total:$total},function(data){ 
	   if(data==1){$("#LiAdmTab2").attr("style", "display: none !important");$("#AdmTab2").html('')
		   swal("Se Cerro caja Correctamente", "Felicitaciones", "success");return false;}  
	   if(data==0){swal("Error en Cierre de caja", "Error", "error");return false;}
	 })
    } 
  });
}
 
 function ReporteLiquidacion(){
   var $url="Pdf_Liquidacion.php"
	 abrirEnPestana($url)
 }  


 </script>
            
  <input type="hidden" id="IdHiResulVen" value="0"  /> 
  <input type="hidden" id="IdHiPac" value=0 /> 
  <input type="hidden" id="IdHiTi" value="<?=$_POST['Tipo']?>"  /> 
  <input type="hidden" id="idvalor"  />

  
 
 
  
  
  
<style>
.topi{
  margin-top:0!important;
  width:80%;
 }
.bodycontainer { max-height: 220px; width: 100%; margin: 0; overflow-y: auto; height:220px; }
.table-scrollable { margin: 0; padding: 0; }

</style>
  
  
  
  
  
    
   