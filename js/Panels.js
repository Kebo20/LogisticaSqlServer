jQuery(function($) {
	$("#IdModalApartado").on('shown.bs.modal', function(){
        $(this).find('#IdMensaje').focus();
    });
			   $('#sidebar2').insertBefore('.page-content');
			   $('#navbar').addClass('h-navbar');
			   $('.footer').insertAfter('.page-content');
			   
			   $('.page-content').addClass('main-content');
			   
			   $('.menu-toggler[data-target="#sidebar2"]').insertBefore('.navbar-brand');
			   $('[data-rel=tooltip]').tooltip();
			   
			   $(document).on('settings.ace.two_menu', function(e, event_name, event_val) {
				 if(event_name == 'sidebar_fixed') {
					 if( $('#sidebar').hasClass('sidebar-fixed') ) $('#sidebar2').addClass('sidebar-fixed')
					 else $('#sidebar2').removeClass('sidebar-fixed')
				 }
			   }).triggerHandler('settings.ace.two_menu', ['sidebar_fixed' ,$('#sidebar').hasClass('sidebar-fixed')]);
			   
			   $('#sidebar2[data-sidebar-hover=true]').ace_sidebar_hover('reset');
			   $('#sidebar2[data-sidebar-scroll=true]').ace_sidebar_scroll('reset', true);			   
})
            
			function abrirEnPestanaInicio(url) {
		      var a = document.createElement("a");
		      a.target = "_blank";
		      a.href = url;
		      a.click();
	        }
            function Backup(){location.href="backup.php";$("#IdCuerpo").html("")} 
			function Activar($id){
			   
			   $activo=$("#IdActivo").val()
			   $("#"+$activo).removeClass("active")
			   $("#"+$id).addClass("active")
			   $("#IdActivo").val($id)
			 }
			 function GrupoUsuarios(){$.post('Adm_GrupoUsuario.php',{},function(datitos){$("#IdCuerpo").html(datitos)}) }
			 function Usuarios(){$.post('Adm_Usuario.php',{},function(datitos){$("#IdCuerpo").html(datitos);}) }
			 function Series(){$.post('Adm_AsignarSerie.php',{},function(datitos){$("#IdCuerpo").html(datitos); })  }
			 function Cajas(){  $.post('Adm_Caja.php',{},function(datitos){$("#IdCuerpo").html(datitos); })  } 
			 
			 function AbrirCajaUsuario(){
				 $user=$("#User").val();
				 $.post('controlador/Ccaja.php',{accion:'VAL_USER',user:$user},function(datitos){
					   if(datitos==0){$.post('Adm_AbrirCaja.php',{user:$user},function(datitos){$("#IdCuerpo").html(datitos); 
					    })}else{
						  Activar(0);$("#IdCuerpo").html("");swal("Usuario ya tiene Caja Inicializada", "Error", "warning");
						}  
				  })
			 } 
			 function CerrarCaja(){
				 $user=$("#User").val();
				 $cod_ingreso=$("#HiCodIngreso").val();
				 $.post('controlador/Ccaja.php',{accion:'VAL_USER',user:$user},function(datitos){
					   if(datitos==0){swal("Usuario No tiene Caja Inicializada", "Error", "warning"); Activar(0);$("#IdCuerpo").html("");}
					   else{ 
						  $.post('Adm_CerrarCaja.php',{user:$user,cod_ingreso:$cod_ingreso},function(datitos){$("#IdCuerpo").html(datitos); })
						}  
				  })
			 } 
			 function GrupoExamenes(){  $.post('Lab_Grupo.php',{},function(datitos){$("#IdCuerpo").html(datitos); })  } 
			 function Examenes(){ 
			  $grupo=$("#HiNombreGrupo").val();
			  $.post('Lab_Examen.php',{grupo:$grupo},function(datitos){$("#IdCuerpo").html(datitos); })  } 
			 function Muestras(){  $.post('Lab_Muestra.php',{},function(datitos){$("#IdCuerpo").html(datitos); })  } 
			 function Convenios(){
				 $grupo=$("#HiNombreGrupo").val();
				   $.post('Lab_Convenios.php',{grupo:$grupo},function(datitos){$("#IdCuerpo").html(datitos); })  }
			 function Medicos(){
				$grupo=$("#HiNombreGrupo").val();
				
				$.post('Adm_Medico.php',{grupo:$grupo},function(datitos){$("#IdCuerpo").html(datitos); })  } 
			 function GenerarOrden(){ 
			 $user=$("#User").val();
			 $.post('controlador/Ccaja.php',{accion:'VAL_USER',user:$user},function(datitos){
					   if(datitos==0){swal("Usuario No tiene Caja Inicializada", "Error", "warning"); Activar(0);$("#IdCuerpo").html("");}
					   else{
						 $.post('Lab_GenerarOrden.php',{},function(datos){$("#IdCuerpo").html(datos); }) 
						}  
				  })
			  } 
			  function GenerarOrdenMuestra(){  $.post('Lab_GenerarOrdenMuestra.php',{},function(datitos){$("#IdCuerpo").html(datitos); })  } 
			 function ReporCierreCaja(){ 
			   $grupo=$("#HiNombreGrupo").val(); 
			  $.post('ReporteCierresCaja.php',{grupo:$grupo},function(datitos){$("#IdCuerpo").html(datitos); }) 
			  } 
			 function ReporteOrdenes(){  $.post('ReporteOrdenes.php',{},function(datitos){$("#IdCuerpo").html(datitos); })  } 
			 function ReporteOrdenesInnova(){  $.post('ReporteOrdenesInnova.php',{},function(datitos){$("#IdCuerpo").html(datitos); })  } 
			 function Resultado(){  
			 $grupo=$("#HiNombreGrupo").val();
			 $.post('Lab_Resultado.php',{grupo:$grupo},function(datitos){$("#IdCuerpo").html(datitos); })  } 
			 function Pacientes(){  $.post('Adm_Paciente.php',{},function(datitos){$("#IdCuerpo").html(datitos); })  }	
			 function DocElectronico(){ $.post('DocumentoElectronico.php',{},function(datitos){$("#IdCuerpo").html(datitos); })  } 
			 function DocInnova(){ $.post('DocumentoInnova.php',{},function(datitos){$("#IdCuerpo").html(datitos); })  } 
			 function PagoMedico(){ $.post('PagoMedico.php',{},function(datitos){$("#IdCuerpo").html(datitos); })  }
			 function AsignarPaquetes(){ $.post('Lab_AsignarPaquetes.php',{},function(datitos){$("#IdCuerpo").html(datitos); })  }
			 function Egresos(){
				 $.post('Caja_Egresos.php',{},function(datitos){$("#IdCuerpo").html(datitos); }) 
				 /* $user=$("#User").val();
				 $cod_ingreso=$("#HiCodIngreso").val();
				 $.post('controlador/Ccaja.php',{accion:'VAL_USER',user:$user},function(datitos){
					   if(datitos==0){swal("Usuario No tiene Caja Inicializada", "Error", "warning"); Activar(0);$("#IdCuerpo").html("");}
					   else{ 
						  $.post('Caja_Egresos.php',{user:$user,cod_ingreso:$cod_ingreso},function(datitos){$("#IdCuerpo").html(datitos); })
						}  
				  })*/
			  }
			 function FacturarConvenios(){ $.post('FacturarConvenios.php',{},function(datitos){$("#IdCuerpo").html(datitos); })  }
			 function PagoFacturas(){ $.post('PagoFactura.php',{},function(datitos){$("#IdCuerpo").html(datitos); })  }
			 function Dashboard(){
				 $anio=$("#IdAnio").val()
				 $mes=$("#IdMes").val()
				 $.post('GraficoVentas.php',{anio:$anio,mes:$mes},function(datitos){$("#IdCuerpo").html(datitos);
				 $("#IdModalDashboard").modal('hide')}) }
			 /*function AnularDocumento(){ $.post('AnularDocumento.php',{},function(datitos){$("#IdCuerpo").html(datitos); })  }*/
			 
			 function ProduccionXMedico(){
			    $("#IdModalProMed").modal('show') 
			  } 
			 function ReporteProMed(){
				 $ini=$("#TxtIni").val()
				 $fin=$("#TxtFin").val()
				 $emp=$("#IdSucu").val()
				 $ordenar=$("#IdOrdenar").val()
				 
			    url="Pdf_ReporteProduccionMedico.php?ini="+$ini+"&fin="+$fin+"&e="+$emp+'&ord='+$ordenar
		        abrirEnPestanaInicio(url)
			  }
			  
			  function ComisionXMedico(){
			    $("#IdModalComMed").modal('show') 
			  }
			  
			  function ReporteComMed(){
				 $ini=$("#TxtIni1").val()
				 $fin=$("#TxtFin1").val()
				 $emp=$("#IdSucu1").val()
				 $ordenar=$("#IdOrdenar1").val()
				 
			    url="Pdf_ReporteComisionMedico.php?ini="+$ini+"&fin="+$fin+"&e="+$emp+'&ord='+$ordenar
		        abrirEnPestanaInicio(url)
			  }
			  
			   function ProduccionExmanes(){
			    $("#IdModalProExa").modal('show') 
			  }
			  
			   function DashboardModal(){
			    $("#IdModalDashboard").modal('show') 
			  }
			  
			  function ReporteProExa(){
				 $ini=$("#TxtIni2").val()
				 $fin=$("#TxtFin2").val()
				 $emp=$("#IdSucu2").val()
				 $ordenar=$("#IdOrdenar2").val()
				 
			    url="Pdf_ReporteProduccionExamenes.php?ini="+$ini+"&fin="+$fin+"&e="+$emp+'&ord='+$ordenar
		        abrirEnPestanaInicio(url)
			  }
			  function ReporteProExaExcel(){
				 $ini=$("#TxtIni2").val()
				 $fin=$("#TxtFin2").val()
				 $emp=$("#IdSucu2").val()
				 $ordenar=$("#IdOrdenar2").val()
				 
			    url="Librerias/PhpSpreadsheet/ExcelReporteProduccionExamen.php?ini="+$ini+"&fin="+$fin+"&e="+$emp+'&ord='+$ordenar
		        abrirEnPestanaInicio(url)
			  }
			  
			  function ExcelComisionMed(){
				 $ini=$("#TxtIni1").val()
				 $fin=$("#TxtFin1").val()
				 $emp=$("#IdSucu1").val()
				 $ordenar=$("#IdOrdenar1").val()
	             location.href="Librerias/PhpSpreadsheet/ExcelComisionMedico.php?ini="+$ini+"&fin="+$fin+"&e="+$emp+'&ord='+$ordenar
	          }
			  
			  function Informe(){ 
			  $grupo=$("#HiNombreGrupo").val();
			  $.post('Img_Resultado.php',{grupo:$grupo},function(datitos){$("#IdCuerpo").html(datitos); })  }
			  
			 function Mostrar($id){
			   Activar($id)
	           $("#"+$id).show()
              }
			  
			  function Apartados(){ $.post('Adm_Apartado.php',{},function(datitos){$("#IdCuerpo").html(datitos); })  }
			  function CajaDia(){ $.post('AdmCajaDia.php',{},function(datitos){$("#IdCuerpo").html(datitos); })  }
			  
			  function AbrirApartado(){ $("#IdModalApartado").modal('show')  }
			  
			 
			  
			  function Personal(){  $.post('PlanillaPersonal.php',{},function(datitos){$("#IdCuerpo").html(datitos); })  } 
              function Area(){  $.post('PlanillaArea.php',{},function(datitos){$("#IdCuerpo").html(datitos); })  } 
              function Horario(){  $.post('PlanillaHorario.php',{},function(datitos){$("#IdCuerpo").html(datitos); })  }
              function Marcaciones(){  $.post('PlanillaReporteMarcaciones.php',{},function(datitos){$("#IdCuerpo").html(datitos); })  } 
              function Horas(){  $.post('PlanillaReporteHoras.php',{},function(datitos){$("#IdCuerpo").html(datitos); })  }
			  
			  
			 
		function ListarMensajes(){
          $.post('controlador/Cpaciente.php',{accion:"LIS_APAR"},function(data){
             $data=data.split('$$**')
			 $("#IdCuMen").html($data[0]);$("#CantMensajes,#CantMensajes2").text($data[1])
			 $("#IdApar").html($data[2]);
           })
         }
		 
		  setInterval(ListarMensajes, 3000);	 
		
		 function GrabarApartado(){ 
			    $mensaje=$("#IdMensaje").val()
				swal({
  title: "Confirmacion",
  text: "Está seguro de Crear Apartado",
  icon: "warning",
  buttons: true,
  dangerMode: true}).then((willDelete) => {
  if (willDelete) {
				$.post('controlador/Cpaciente.php',{accion:'APARTADO',mensaje:$mensaje},function(datitos){
				  if(datitos==0){swal("No se Crear Apartado",'Error','error');return false;}
		          if(datitos==1){$("#IdModalApartado").modal('hide');swal("Apartado Creado Correctamente ..",'Felicidades','success');return false;}	
				 })
	              
				} 
      });
				
			   }	   
			  
			  
			 