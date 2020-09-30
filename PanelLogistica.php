<?php session_start();
//require_once('CADO/ClaseCaja.php');
/*if (!isset($_SESSION['S_user'])) {
	header("location:index.php");
	exit;
}
$tipouser = $_SESSION['S_tipouser'];
$caja = $_SESSION['S_caja'];
$cod_ingreso = $_SESSION['S_cod_ingreso'];
$grupo_nombre = $_SESSION['S_grupo_nombre'];
date_default_timezone_set('America/Lima');
//$ocaja=new Cajas();*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title>LABORATORIO</title>

	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

	<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<!-- page specific plugin styles -->
	<link rel="stylesheet" href="assets/css/jquery-ui.min.css" />
	<link rel="stylesheet" href="assets/css/chosen.min.css" />

	<!-- text fonts -->
	<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

	<!-- ace styles -->
	<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

	<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
	<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
	<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
	<!--<link rel="stylesheet" href="assets/css/jquery.gritter.min.css" />-->

	<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

	<!-- inline styles related to this page -->

	<!-- ace settings handler -->
	<script src="assets/js/ace-extra.min.js"></script>
	<script src="js/ValidarLetrasNumeros.js"></script>
	<link rel="stylesheet" type="text/css" href="css/input.css">
	<link rel="stylesheet" type="text/css" href="assets/css/select2.min.css">
	<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

	<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
</head>

<body class="no-skin">

	<div id="navbar" class="navbar navbar-default   navbar-collapse       h-navbar ace-save-state">
		<div class="navbar-container ace-save-state" id="navbar-container">
			<div class="navbar-header pull-left"> <br>
				<b style="color:#FFF">Bienvenido : <span id="LblIdUser"></span></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<b style="color:#FFF"><span id="LblIdCaja"></span></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<b style="color:#FFF">Fecha : <?= date('d/m/Y') ?></b>
				<a href="Panel.php" class="navbar-brand">
					<!--<img src="imagenes/logo.png" height="20" width="150">-->
				</a>
				<button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

			</div>

			<div class="navbar-buttons navbar-header pull-right  collapse navbar-collapse" role="navigation">
				<ul class="nav ace-nav">
					<!-- Apartado icono -->
					<li class="purple dropdown-modal">
						<a data-toggle="dropdown" class="dropdown-toggle" href="#">
							<i class="ace-icon fa fa-envelope icon-animated-vertical"></i>
							<span class="badge badge-important" id='CantMensajes'></span>
						</a>

						<ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
							<li class="dropdown-header">
								<i class="ace-icon fa fa-envelope-o"></i>
								<span id='CantMensajes2'>0</span> Apartados nuevos
							</li>

							<li class="dropdown-content">
								<ul id='IdCuMen' class="dropdown-menu dropdown-navbar navbar-pink"> </ul>
							</li>

							<li class="dropdown-footer">
								<a href="#" onClick='Apartados()'>
									Ver 10 &Uacute;ltimos Apartados
									<i class="ace-icon fa fa-arrow-right"></i>
								</a>
							</li>
						</ul>
					</li>
					<!-- Fin Apartado icono-->
					<li class="light-blue dropdown-modal user-min">
						<a data-toggle="dropdown" href="#" class="dropdown-toggle">
							<img class="nav-user-photo" src="assets/images/avatars/user.jpg" alt="Usuario" />
							<span class="user-info">
								<small>Bienvenido,</small>
								<?= $_SESSION['S_user']; ?>
							</span>

							<i class="ace-icon fa fa-caret-down"></i>
						</a>

						<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
							<!--<li>
									<a href="#">
										<i class="ace-icon fa fa-cog"></i>
										Settings
									</a>
								</li>-->

							<!--<li>
									<a href="profile.html">
										<i class="ace-icon fa fa-user"></i>
										Perfil
									</a>
								</li>-->

							<!--<li class="divider"></li>-->

							<li>
								<a href="index.php">
									<i class="ace-icon fa fa-power-off"></i>
									Salir
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>

		</div><!-- /.navbar-container -->
	</div>

	<div class="main-container ace-save-state" id="main-container">
		<script type="text/javascript">
			try {
				ace.settings.loadState('main-container')
			} catch (e) {}
		</script>

		<div id="sidebar" class="sidebar      h-sidebar                navbar-collapse collapse          ace-save-state">
			<script type="text/javascript">
				try {
					ace.settings.loadState('sidebar')
				} catch (e) {}
			</script>

			<div class="sidebar-shortcuts" id="sidebar-shortcuts">

				<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
					<span class="btn btn-success" onClick="DashboardModal()"></span>

					<span class="btn btn-info" onClick="DashboardModalAnual()"></span>

					<span class="btn btn-warning"></span>

					<span class="btn btn-danger"></span>
				</div>
			</div><!-- /.sidebar-shortcuts -->


			<ul class="nav nav-list" id="IdMenu" style="margin:0; padding:0">
				<li class="hover" id="1" onClick="Activar('1');">

					<a href="#" class="dropdown-toggle">
						<i class="menu-icon"><img src="imagenes/productos.png" style="border:0" height="25" width="25"></i>
						<span class="menu-text" style="font-size:10px; font-weight:bold"> PRODUCTOS </span>
					</a>

					<b class="arrow"></b>
					<ul class="submenu">
						<li class="hover" id="2" onClick="Activar('1');Productos()">
							<a href="#">
								<i style="margin:0; padding:0" class="menu-icon fa fa-caret-right"></i>
								<span class="menu-text" style="font-size:10px; margin:0; padding:0; font-weight:bold"> PRODUCTOS </span>
							</a>

							<b class="arrow"></b>
						</li>
						<li class="hover" id="3" onClick="Activar('1');CategoriasProducto()">
							<a href="#">
								<i class="menu-icon fa fa-caret-right" style="margin:0; padding:0"></i>
								<span class="menu-text" style="font-size:10px; margin:0; padding:0; font-weight:bold"> CATEGORIAS </span>
							</a>

							<b class="arrow"></b>
						</li>


					</ul>
				</li>
				<li class="hover" id="8" onClick="Activar('8');Proveedores();">
					<a href="#">
						<i class="menu-icon" style="margin:0; padding:0">
							<img src="imagenes/proveedor.png" style="border:0" height="30" width="30"></i>
						<span class="menu-text" style="font-size:10px; margin:0; padding:0; font-weight:bold">PROVEEDORES </span>
					</a>
					<b class="arrow"></b>
				</li>
				<li class="hover" id="9" onClick="Activar('9');">
					<a href="#" class="dropdown-toggle">
						<i class="menu-icon"><img src="imagenes/almacen.png" style="border:0" height="25" width="25"></i>
						<span class="menu-text" style="font-size:10px; font-weight:bold"> ALMACÉN </span>
					</a>

					<b class="arrow"></b>
					<ul class="submenu">
						<li class="hover" id="31" onClick="Activar('9');Almacenes()">
							<a href="#">
								<i style="margin:0; padding:0" class="menu-icon fa fa-caret-right"></i>
								<span class="menu-text" style="font-size:10px; margin:0; padding:0; font-weight:bold">ALMACENES </span>
							</a>

							<b class="arrow"></b>
						</li>
						<li class="hover" id="" onClick="Activar('9');TransferirAlmacen()">
							<a href="#">
								<i style="margin:0; padding:0" class="menu-icon fa fa-caret-right"></i>
								<span class="menu-text" style="font-size:10px; margin:0; padding:0; font-weight:bold">TRANSFERIR </span>
							</a>

							<b class="arrow"></b>
						</li>
						<li class="hover" id="" onClick="Activar('9');Lotes()">
							<a href="#">
								<i class="menu-icon fa fa-caret-right" style="margin:0; padding:0"></i>
								<span class="menu-text" style="font-size:10px; margin:0; padding:0; font-weight:bold">LOTES </span>
							</a>
							<b class="arrow"></b>
						</li>
						<li class="hover" id="" onClick="Activar('9');FraccionarLote()">
							<a href="#">
								<i class="menu-icon fa fa-caret-right" style="margin:0; padding:0"></i>
								<span class="menu-text" style="font-size:10px; margin:0; padding:0; font-weight:bold">FRACCIONAR LOTES </span>
							</a>

							<b class="arrow"></b>
						</li>

					</ul>

				</li>


				<li class="hover" id="13" onClick="Activar('13');Kardex();">
					<a href="#">
						<i class="menu-icon" style="margin:0; padding:0">
							<img src="imagenes/kardex.png" style="border:0" height="30" width="30"></i>
						<span class="menu-text" style="font-size:10px; margin:0; padding:0; font-weight:bold">KARDEX </span>
					</a>
					<b class="arrow"></b>
				</li>

				<li class="hover" id="14" onClick="Activar('14');OrdenCompra();">
					<a href="#">
						<i class="menu-icon" style="margin:0; padding:0">
							<img src="imagenes/orden_compra.png" style="border:0" height="30" width="30"></i>
						<span class="menu-text" style="font-size:10px; margin:0; padding:0; font-weight:bold">ORDEN DE COMPRA</span>
					</a>
					<b class="arrow"></b>
				</li>
				<li class="hover" id="15" onClick="Activar('15');RealizarCompra();">
					<a href="#">
						<i class="menu-icon" style="margin:0; padding:0">
							<img src="imagenes/realizar_compra.png" style="border:0" height="30" width="30"></i>
						<span class="menu-text" style="font-size:10px; margin:0; padding:0; font-weight:bold">REALIZAR COMPRA</span>
					</a>
					<b class="arrow"></b>
				</li>
				<li class="hover" id="16" onClick="Activar('16');Compras();">
					<a href="#">
						<i class="menu-icon" style="margin:0; padding:0">
							<img src="imagenes/compras.png" style="border:0" height="30" width="30"></i>
						<span class="menu-text" style="font-size:10px; margin:0; padding:0; font-weight:bold">COMPRAS </span>
					</a>
					<b class="arrow"></b>
				</li>
				<li class="hover" id="17" onClick="Activar('17');OrdenDocumento();">
					<a href="#">
						<i class="menu-icon" style="margin:0; padding:0">
							<img src="imagenes/orden_documento.png" style="border:0" height="30" width="30"></i>
						<span class="menu-text" style="font-size:10px; margin:0; padding:0; font-weight:bold">Orden documento </span>
					</a>
					<b class="arrow"></b>
				</li>
				<li class="hover" id="18" onClick="Activar('18');">

					<a href="#" class="dropdown-toggle">
						<i class="menu-icon"><img src="imagenes/reactivos.png" style="border:0" height="25" width="25"></i>
						<span class="menu-text" style="font-size:10px; font-weight:bold"> CONTROL DE REACTIVOS </span>
					</a>

					<b class="arrow"></b>
					<ul class="submenu">
						<li class="hover" id="" onClick="Activar('18');ReporteReactivo()">
							<a href="#">
								<i style="margin:0; padding:0" class="menu-icon fa fa-caret-right"></i>
								<span class="menu-text" style="font-size:10px; margin:0; padding:0; font-weight:bold"> REPORTE </span>
							</a>

							<b class="arrow"></b>
						</li>
						<li class="hover" id="" onClick="Activar('18');ReactivosExamen()">
							<a href="#">
								<i style="margin:0; padding:0" class="menu-icon fa fa-caret-right"></i>
								<span class="menu-text" style="font-size:10px; margin:0; padding:0; font-weight:bold"> REACTIVOS POR EXÁMEN </span>
							</a>

							<b class="arrow"></b>
						</li>
						<li class="hover" id="" onClick="Activar('18');ExamenesClientes()">
							<a href="#">
								<i style="margin:0; padding:0" class="menu-icon fa fa-caret-right"></i>
								<span class="menu-text" style="font-size:10px; margin:0; padding:0; font-weight:bold"> EXAMENES X CLIENTES </span>
							</a>

							<b class="arrow"></b>
						</li>
						<li class="hover" id="" onClick="Activar('18');Maquinas()">
							<a href="#">
								<i style="margin:0; padding:0" class="menu-icon fa fa-caret-right"></i>
								<span class="menu-text" style="font-size:10px; margin:0; padding:0; font-weight:bold"> MÁQUINAS </span>
							</a>

							<b class="arrow"></b>
						</li>
						<li class="hover" id="" onClick="Activar('18');Calibraciones()">
							<a href="#">
								<i class="menu-icon fa fa-caret-right" style="margin:0; padding:0"></i>
								<span class="menu-text" style="font-size:10px; margin:0; padding:0; font-weight:bold"> CALIBRACIONES </span>
							</a>

							<b class="arrow"></b>
						</li>


					</ul>
				</li>


			</ul>
		</div>

		<div class="main-content">
			<div class="main-content-inner">
				<div class="page-content">
					<!-- /.page-header -->

					<div class="row">
						<div class="col-xs-12">


							<!-- INICIO CUERPO -->
							<div id="IdCuerpo"> </div> <!-- FIN CUERPO-->
							<!-- INICIO APARTADO -->
							<div id="IdApar">

							</div> <!-- FIN APARTADO-->




							<!-- PAGE CONTENT ENDS -->
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.page-content -->
			</div>
		</div><!-- /.main-content -->

	</div><!-- /.main-container -->



	<!-- basic scripts -->

	<!--[if !IE]> -->
	<script src="assets/js/jquery-2.1.4.min.js"></script>

	<!-- <![endif]-->

	<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
	<script type="text/javascript">
		if ('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
	</script>
	<script src="assets/js/bootstrap.min.js"></script>

	<!-- page specific plugin scripts -->
	<script src="assets/js/jquery-ui.min.js"></script>
	<script src="assets/js/chosen.jquery.min.js"></script>
	<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
	<script src="assets/js/jquery.sparkline.index.min.js"></script>
	<script src="assets/js/jquery.flot.min.js"></script>
	<script src="assets/js/jquery.flot.pie.min.js"></script>
	<script src="assets/js/jquery.flot.resize.min.js"></script>

	<!-- ace scripts -->
	<script src="assets/js/ace-elements.min.js"></script>
	<script src="assets/js/ace.min.js"></script>
	<script src="js/sweetalert.min.js"></script>
	<script src="js/PanelLog.js"></script>
	<!--<script src="assets/js/jquery.gritter.min.js"></script>-->

	<input type="hidden" id="IdActivo">
	<input type="hidden" id="User" value="<?= $_SESSION['S_user'] ?>">
	<input type="hidden" id="HiCaja" value="<?= $_SESSION['S_caja'] ?>">
	<input type="hidden" id="HiCodIngreso" value="<?= $_SESSION['S_cod_ingreso'] ?>">
	<input type="hidden" id="HiNombreGrupo" value="<?= $grupo_nombre ?>">
	<div id="IdCargando" class="overlay" style="display:none">
		<div id="loader">
			<div class="dot"></div>
			<div class="dot"></div>
			<div class="dot"></div>
			<div class="dot"></div>
			<div class="dot"></div>
			<div class="dot"></div>
			<div class="dot"></div>
			<div class="dot"></div>
			<div class="lading"></div>
		</div>
	</div>

	<script src="assets/js/select2.min.js"></script>


	<!-- Fin Apartado -->