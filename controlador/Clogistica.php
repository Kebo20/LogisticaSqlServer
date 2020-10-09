<?php

require_once '../cado/ClaseLogistica.php';
date_default_timezone_set('America/Lima');
$paginacion = 7;

session_start();

$olog = new Logistica();

switch ($_GET["op"]) {
        //ALMACEN
    case "LIS_ALM":
        $datos = array();
        $pagina = $_GET["pagina"];
        $ultimo_pagina = $pagina * $paginacion;
        $primero_pagina = $ultimo_pagina - $paginacion;
        $lista = $olog->ListarAlmacen($_GET["q"], $primero_pagina, $paginacion);
        $cont = $primero_pagina;
        foreach ($lista as $alm) {
            $cont++;
            $subArray = array();
            $subArray[] = $cont;
            $subArray[] = $alm["nombre"];
            $subArray[] = $alm["responsable"];
            $subArray[] = $alm["correo"];
            $subArray[] = $alm["sucursal"];
            if ($alm["tipo"] == '0') {
                $subArray[] = "<span class='badge badge-pill badge-danger'>General</span>";
            }
            if ($alm["tipo"] == '1') {
                $subArray[] = "<span class='badge badge-pill badge-secondary'>Subalmacén</span>";
            }

            $subArray[] = "<div align='center'>
            <a  onclick=\"editar('" . $alm["id"] . "')\" ><i class=' fa fa-pencil green' ></i> </a>" .
                "&nbsp;&nbsp;&nbsp;<a  onclick=\"eliminar(" . $alm["id"] . " )\"  ><i class='fa fa-trash red'></i></a></div>";
            $datos[] = $subArray;
        }

        echo json_encode($datos);
        break;

    case "PAG_ALM":

        $cont = $olog->TotalAlmacen($_GET["q"])->fetch()[0];

        if ($cont == 0) {
            echo 0;
            break;
        }

        if ($cont < $paginacion) {
            echo "1";
        } else {
            echo ceil($cont / $paginacion);
        }
        break;


    case 'LLENAR_ALM':
        $id = $_POST['id'];
        $listar = $olog->ListarAlmacenxid($id);
        echo json_encode($listar->fetch());
        break;

    case 'LISTAR_ALMxSUC':
        $sucursal = $_POST['sucursal'];

        $listar = $olog->ListarAlmacenxSucursal($sucursal);
        $opt = "<option value=''>Seleccione</option>";
        foreach ($listar as $a) {

            if ($a["tipo"] == '0') {
                $tipo = "<span class='badge badge-pill badge-danger'>General</span>";
            }
            if ($a["tipo"] == '1') {
                $tipo = "<span class='badge badge-pill badge-secondary'>Subalmacén</span>";
            }



            $opt .= "<option value='$a[0]'>$a[1] ($tipo)</option>";
        }

        echo $opt;
        break;





    case 'LISTAR_ALM_GRALxSUC':
        $sucursal = $_POST['sucursal'];

        $listar = $olog->ListarAlmacenGeneralxSucursal($sucursal);
        $opt = "<option value=''>Seleccione</option>";
        foreach ($listar as $a) {

            $opt .= "<option value='$a[0]'>$a[1]</option>";
        }

        echo $opt;
        break;


    case 'LISTAR_ALM_GRAL':

        $listar = $olog->ListarAlmacenGeneral();
        $opt = "<option value=''>Seleccione</option>";
        foreach ($listar as $a) {

            $opt .= "<option value='$a[0]'>$a[1]</option>";
        }

        echo $opt;
        break;


    case 'LISTAR_ALM_SUBxSUC':
        $sucursal = $_POST['sucursal'];

        $listar = $olog->ListarAlmacenSubxSucursal($sucursal);
        $opt = "<option value=''>Seleccione</option>";
        foreach ($listar as $a) {

            $opt .= "<option value='$a[0]'>$a[1]</option>";
        }

        echo $opt;
        break;


    case 'ALMxORD_COMPRA':
        $id_orden = $_POST['id_orden'];

        $id_almacen = $olog->ListarOrdenCompraxId($id_orden)->fetch()['id_almacen'];

        echo $id_almacen;
        break;
    case 'NUEVO_ALM':
        $nombre = $_POST['nombre'];
        $responsable = $_POST['responsable'];
        $correo = $_POST['correo'];
        $sucursal = $_POST['sucursal'];
        $tipo = $_POST['tipo'];
        $valor = $_POST['valor'];
        $validar = $olog->ValidarAlmacen($nombre)->fetch();

        $can = $validar[0];
        // si el valor es igual a 1 insertamos
        if ($valor == 1) {
            if ($can == 0) {

                $insertar = $olog->RegistrarAlmacen($nombre, $responsable, $correo, $sucursal, $tipo);
                echo $insertar;
            } else
                echo 2;
            exit;
        }
        // si el valor es igual a 2 modificamos
        if ($valor == 2) {
            $id = $_POST["id"];

            $modificar = $olog->ModificarAlmacen($id, $nombre, $responsable, $correo, $sucursal, $tipo);
            echo $modificar;
        }
        break;
    case 'ELIMINAR_ALM':
        $id = $_POST['id'];

        $eliminar = $olog->EliminarAlmacen($id);
        echo $eliminar;
        break;
        //CATEGORIA
    case "LIS_CAT":

        $datos = array();
        $pagina = $_GET["pagina"];
        $ultimo_pagina = $pagina * $paginacion;
        $primero_pagina = $ultimo_pagina - $paginacion;
        $lista = $olog->ListarCategoriaProducto($_GET["q"], $primero_pagina, $paginacion);
        $cont = $primero_pagina;
        foreach ($lista as $cat) {
            $cont++;
            $subArray = array();
            $subArray[] = $cont;
            $subArray[] = $cat["nombre"];
            $subArray[] = "<div align='center'>
            <a  onclick=\"editar('" . $cat["id"] . "','" . $cat["nombre"] . "' )\" ><i class=' fa fa-pencil green' ></i> </a>" .
                "&nbsp;&nbsp;&nbsp;<a  onclick=\"eliminar(" . $cat["id"] . " )\"  ><i class='fa fa-trash red'></i></a></div>";
            $datos[] = $subArray;
        }

        echo json_encode($datos);
        break;

    case "PAG_CAT":

        $cont = $olog->TotalCategoria($_GET["q"])->fetch()[0];

        if ($cont == 0) {
            echo 0;
            break;
        }

        if ($cont < $paginacion) {
            echo "1";
        } else {
            echo ceil($cont / $paginacion);
        }
        break;

    case 'LLENAR_CAT':
        $id = $_POST['id'];
        $listar = $olog->ListarCategoriaProductoxid($id);
        echo json_encode($listar->fetch());
        break;
    case 'NUEVO_CAT':
        $nombre = $_POST['nombre'];

        $valor = $_POST['valor'];
        $validar = $olog->ValidarCategoriaProducto($nombre)->fetch();

        $can = $validar[0];
        // si el valor es igual a 1 insertamos
        if ($valor == 1) {
            if ($can == 0) {

                $insertar = $olog->RegistrarCategoriaProducto($nombre);
                echo $insertar;
            } else
                echo 2;
            exit;
        }
        // si el valor es igual a 2 modificamos
        if ($valor == 2) {
            $id = $_POST["id"];

            $modificar = $olog->ModificarCategoriaProducto($id, $nombre);
            echo $modificar;
        }
        break;
    case 'ELIMINAR_CAT':
        $id = $_POST['id'];

        $eliminar = $olog->EliminarCategoriaProducto($id);
        echo $eliminar;
        break;
        //PRODUCTO
    case "LIS_PRO":
        $datos = array();
        $pagina = $_GET["pagina"];
        $ultimo_pagina = $pagina * $paginacion;
        $primero_pagina = $ultimo_pagina - $paginacion;
        $lista = $olog->ListarProductoLog($_GET["q"], $primero_pagina, $paginacion);
        $cont = $primero_pagina;
        foreach ($lista as $alm) {
            $cont++;
            $subArray = array();
            $subArray[] = $cont;
            $subArray[] = $alm["nombre"];
            $subArray[] = $alm["categoria"];
            $subArray[] = $alm["codigo_unidad"] . " - " . $alm["descripcion_unidad"];
            $subArray[] = $alm["stock_min"];
            $subArray[] = $alm["stock_max"];
            if ($alm["tipo_producto"] == "0") {
                $subArray[] = "<span class='badge badge-danger badge-pill ml-50'>Producto";
            }
            if ($alm["tipo_producto"] == "1") {
                $subArray[] = "<span class='badge badge-secondary badge-pill ml-50'>Servicio";
            }


            if ($alm["nombre_producto_fraccion"] != null) {
                $subArray[] = $alm["nombre_producto_fraccion"];
            } else {
                $subArray[] = "";
            }

            $subArray[] = $alm["cantidad_fraccion"];

            $subArray[] = "<div align='center'>
            <a  onclick=\"editar('" . $alm["id"] . "')\" ><i class=' fa fa-pencil green' ></i> </a>" .
                "&nbsp;&nbsp;&nbsp;<a  onclick=\"eliminar(" . $alm["id"] . " )\"  ><i class='fa fa-trash red'></i></a></div>";
            $datos[] = $subArray;
        }

        echo json_encode($datos);
        break;



    case "PAG_PRO":

        $cont = $olog->TotalProducto($_GET["q"])->fetch()[0];

        if ($cont == 0) {
            echo 0;
            break;
        }

        if ($cont < $paginacion) {
            echo "1";
        } else {
            echo ceil($cont / $paginacion);
        }
        break;

    case "LISTAR_PRO_OC":
        $lista = $olog->ListarProductoTipo($_POST['tipo'], $_POST['categoria']);
        $tbl = "<option value=''>Seleccione</option>";
        $i = 0;
        foreach ($lista as $pro) {

            $tbl .= "<option id='OCpro_$pro[0]'  value='$pro[0]' nombre_producto='$pro[1]' tipo_producto='$pro[6]'>$pro[1]</option>";
        }

        echo $tbl;
        break;



    case "LISTAR_PRO_FRACCION":
        $lista = $olog->ListarSoloProductos();
        $tbl = "<option value=''>Seleccione</option>";
        $i = 0;
        foreach ($lista as $pro) {

            $tbl .= "<option   value='$pro[0]'>$pro[1]</option>";
        }

        echo $tbl;
        break;


    case 'LLENAR_PRO':
        $id = $_POST['id'];
        $listar = $olog->ListarProductoLogxid($id);
        echo json_encode($listar->fetch());
        break;
    case 'NUEVO_PRO':
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $unidad = $_POST['unidad'];
        $stock_min = $_POST['stock_min'];
        $stock_max = $_POST['stock_max'];
        $tipo_producto = $_POST['tipo_producto'];

        $cantidad_fraccion = $_POST['cantidad_fraccion'];


        //Si existe producto fraccion y tipo = producto
        if (isset($_POST['id_producto_fraccion']) && $_POST['id_producto_fraccion'] != '' && $tipo_producto == '0') {

            if ($_POST['cantidad_fraccion'] < 2) { //cantidad a fraccionar debe ser mínimo 2
                echo 0;
                break;
            }
            $id_producto_fraccion = $_POST['id_producto_fraccion'];
            $opro = $olog->ListarProductoLogxid($id_producto_fraccion)->fetch();
            if ($opro['id_producto_fraccion'] != '0') { //si producto fraccion ya esta fraccionado
                echo 5;
                break;
            }
        } else {
            $id_producto_fraccion = '0';
            $cantidad_fraccion = '0';
        }




        $valor = $_POST['valor'];
        $validar = $olog->ValidarProductoLog($nombre)->fetch();


        $can = $validar[0];
        // si el valor es igual a 1 insertamos
        if ($valor == 1) {
            if ($can == 0) { //Si no existe nombre 
                $validar3 = $olog->ValidarProductoFraccion($id_producto_fraccion)->fetch(); //producto fracción ya fue utilizado
                if ($validar3[0] > 0 && $id_producto_fraccion != '0') {
                    echo 6;
                    break;
                }
                $insertar = $olog->RegistrarProductoLog($nombre, $categoria, $unidad, $stock_min, $stock_max, $tipo_producto, $id_producto_fraccion, $cantidad_fraccion);
                echo $insertar;
            } else
                echo 2;
            exit;
        }


        // si el valor es igual a 2 modificamos
        if ($valor == 2) {
            $id = $_POST["id"];

            if ($id == $id_producto_fraccion) { //producto y producto fraccion iguales
                echo 4;
                break;
            }

            $validar2 = $olog->ValidarProductoFraccion($id)->fetch(); //Es fracción de otro producto
            if ($validar2[0] != 0 && ($id_producto_fraccion != '0')) {

                echo '3';
                break;
            }


            $modificar = $olog->ModificarProductoLog($id, $nombre, $categoria, $unidad, $stock_min, $stock_max, $tipo_producto, $id_producto_fraccion, $cantidad_fraccion);
            echo $modificar;
        }
        break;
    case 'ELIMINAR_PRO':
        $id = $_POST['id'];

        $eliminar = $olog->EliminarProductoLog($id);
        echo $eliminar;
        break;



        //Orden de Compra

    case "NUEVO_ORD_COM":

        $detalles_orden_compra = json_decode($_POST["orden_compra"], true);
        $fecha = $_POST['fecha'];
        $nro = $_POST['nro'];
        $sucursal = $_POST['sucursal'];

        $almacen = $_POST['almacen'];
        $referencia = $_POST['referencia'];
        $tipo = $_POST['tipo'];

        $valor = $_POST['valor'];
        $validar = $olog->ValidarOrdenCompra($nro)->fetch();

        $can = $validar[0];
        // si el valor es igual a 1 insertamos
        if ($valor == 1) {
            if ($can == 0) {

                $insertar = $olog->RegistrarOrdenCompra($detalles_orden_compra, $nro, $fecha, $sucursal,  $almacen, $referencia, $tipo);
                echo $insertar;
            } else
                echo 2;
            exit;
        }
        // si el valor es igual a 2 modificamos
        if ($valor == 2) {
            $id = $_POST["id"];
            $modificar = $olog->ModificarOrdenCompra($id, $detalles_orden_compra, $nro, $fecha, $sucursal, $almacen, $referencia, $tipo);
            echo $modificar;
        }
        break;

    case "LIS_ORD_COM":
        $nro = $_POST["nro"];
        $fecha = $_POST["fecha"];
        $estado = $_POST["estado"];
        $almacen = $_POST["almacen"];

        $where = array();
        $where2 = "";
        if ($nro != "" || $fecha != "" || $estado != "" || $almacen != "") {
            $where2 = " where ";
        }
        if ($nro != "") {
            $where[] = " o.numero='$nro' ";
        }
        if ($fecha != "") {
            $where[] = " o.fecha='$fecha'";
        }
        if ($estado != "") {
            $where[] = " o.estado='$estado'";
        }
        if ($almacen != "") {

            $where[] = " o.id_almacen='$almacen'";
        }



        $where2 .= implode(" and ", $where);

        $lista = $olog->ListarOrdenCompra($where2);
        $tbl = "";
        $i = 0;
        foreach ($lista as $o) {
            $i++;
            $id = 'TblOC_' . $i;
            if ($i % 2 == 0) {
                //$color = "style=' background-color:#f5f5f5; height:30px'";
                $color = "style='background-color:#ffffff; height:30px'";
            } else {
                $color = "style='background-color:#ffffff; height:30px'";
            }
            $estado = "$o[5]";
            if ($o[5] == "pendiente") {
                $estado = "<btn class='badge badge-success badge-pill ml-50' >$o[5] </btn>";
            }
            if ($o[5] == "anulada") {
                $estado = "<btn class='badge badge-danger  badge-pill ml-50' >$o[5]</btn>";
            }
            if ($o[5] == "finalizada") {
                $estado = "<btn class='badge badge-secondary badge-pill ml-50' >$o[5]</btn>";
            }

            if ($o[6] == "0") {
                $tipo = "<btn class='badge badge-danger badge-pill ml-50' >Producto</btn>";
            }
            if ($o[6] == "1") {
                $tipo = "<btn class='badge badge-secondary  badge-pill ml-50' >Servicio</btn>";
            }


            $tbl .= "<tr id='$id' idOC='$o[0]'  $color  onclick=\"PintarFilaOC('$id')\" ondblclick='OCLlenarDatos()'>"
                . "<td >$i</td>"
                . "<td >$o[3]</td>"
                . "<td >$o[2]</td>"
                . "<td >$o[1]</td>"


                . "<td >$o[4]</td>"
                . "<td align='center' >$tipo</td>"
                . "<td align='center' >$estado</td>"

                . "</tr>";
        }

        echo $tbl;
        break;


    case "LIS_ORD_COMxnro":
        $nro = $_POST["nro"];


        $where = array();
        $where2 = "";

        $where2 = " where ";

        if ($nro != "") {
            $where[] = " o.numero='$nro' ";
        }

        $where[] = " o.estado='pendiente'";

        $where2 .= implode(" and ", $where);

        $lista = $olog->ListarOrdenCompra($where2);
        $tbl = "";
        $i = 0;
        foreach ($lista as $o) {
            $i++;
            $id = 'TblECOC_' . $i;
            if ($i % 2 == 0) {
                $color = "style=' background-color:#f5f5f5; height:30px'";
            } else {
                $color = "style='background-color:#ffffff; height:30px'";
            }


            $tbl .= "<tr id='$id' idECOC='$o[0]' idalmacen='$o[7]'   $color onclick=\"PintarFilaECOC('$id')\">"
                . "<td >$i</td>"
                . "<td >$o[3]</td>"
                . "<td >$o[2]</td>"

                . "</tr>";
        }

        echo $tbl;
        break;


    case 'LLENAR_ORD_COM':
        $id = $_POST['id'];
        $listar = $olog->ListarOrdenCompraxId($id);
        echo json_encode($listar->fetch());
        break;
    case 'LLENAR_ORD_COM_DET':
        $id = $_POST['id'];

        //$orden_compra = $olog->ListarOrdenCompraxId($id)->fetch();

        $listar = $olog->ListarOrdenComprDetalles($id);

        echo json_encode($listar->fetchAll());
        break;
    case 'ESTADO_ORD_COM':
        $id = $_POST['id'];
        $estado = $_POST['estado'];
        $actualizar = $olog->EstadoOrdenCompra($id, $estado);
        echo $actualizar;
        break;





        //COMPRAS

    case "NUEVO_COM":

        $detalles_compra = json_decode($_POST["compra"], true);
        $fecha = $_POST['fecha'];
        $proveedor = $_POST['proveedor'];
        $tipo_documento = $_POST['tipo_documento'];
        $tipo_afectacion = $_POST['tipo_afectacion'];
        $monto_sin_igv = $_POST['monto_sin_igv'];
        $igv = $_POST['igv'];
        $monto_igv = $_POST['monto_igv'];
        $total = $_POST['total'];
        $nota_credito = $_POST['nota_credito'];
        $tipo_compra = $_POST['tipo_compra'];
        $nro_dias = $_POST['nro_dias'];
        $nro_documento = $_POST['nro_documento'];
        $id_orden = $_POST['id_orden'];
        $id_almacen = $_POST['id_almacen'];
        $insertar = $olog->RegistrarCompra(
            $detalles_compra,
            $fecha,
            $proveedor,
            $tipo_documento,
            $tipo_afectacion,
            $monto_sin_igv,
            $igv,
            $monto_igv,
            $total,
            $nota_credito,
            $tipo_compra,
            $nro_documento,
            $nro_dias,
            $id_orden,
            $id_almacen
        );

        echo $insertar;
        break;


    case "LIS_COM":

        $datos = array();
        $pagina = $_GET["pagina"];
        $ultimo_pagina = $pagina * $paginacion;
        $primero_pagina = $ultimo_pagina - $paginacion;
        $lista = $olog->ListarCompra($_GET["q"], $primero_pagina, $paginacion);
        $cont = $primero_pagina;
        foreach ($lista as $prov) {

            if ($prov[10] == "0") {
                $nota_credito = "<input disabled type='checkbox' >";
            } else if ($prov[10] == "1") {
                $nota_credito = "<input disabled type='checkbox' checked >";
            } else {
                $nota_credito = "";
            }
            $cont++;
            $subArray = array();
            $subArray[] = $cont;
            $subArray[] = $prov[3];
            $subArray[] = $prov[13];

            $subArray[] = $prov[0];
            $subArray[] = $prov[11];
            $subArray[] = $prov[1];
            $subArray[] = $prov[2];

            $subArray[] = $prov[4];
            $subArray[] = $prov[5];
            $subArray[] = $prov[6];
            $subArray[] = $prov[7];
            $subArray[] = $prov[8];
            $subArray[] = $prov[12];
            $subArray[] = $prov[14];
            $subArray[] = "<div align='center'>
                <a  onclick=\"detalles('" . $prov["id"] . "')\" ><i class=' fa fa-search-plus' ></i> </a>";


            $datos[] = $subArray;
        }

        echo json_encode($datos);
        break;

    case "PAG_COM":

        $cont = $olog->TotalCompra($_GET["q"])->fetch()[0];

        if ($cont == 0) {
            echo 0;
            break;
        }

        if ($cont < $paginacion) {
            echo "1";
        } else {
            echo ceil($cont / $paginacion);
        }
        break;
    case "LIS_COMPRA_DETALLE":
        $compra = $_POST["compra"];

        $lista = $olog->ListarCompraDetalles($compra);
        $tbl = "";
        $i = 0;
        foreach ($lista as $c) {
            $i++;
            $id = 'TblComD_' . $i;
            if ($i % 2 == 0) {
                $color = "style=' background-color:#f5f5f5; height:30px'";
            } else {
                $color = "style='background-color:#ffffff; height:30px'";
            }

            if ($c[4] == "0") {
                $bonificacion = "<input disabled type='checkbox' >";
            } else if ($c[4] == "1") {
                $bonificacion = "<input disabled type='checkbox' checked >";
            } else {
                $bonificacion = "";
            }
            $tbl .= "<tr id='$id' style='height:20px'  $color >"
                . "<td class='text-right' >$i</td>"
                . "<td >$c[14]</td>"
                . "<td >$c[0]</td>"
                . "<td align='center' >$bonificacion</td>"
                . "<td align='center'>$c[5] </td>"
                . "<td class='text-right'>$c[13]  </td>"
                . "<td class='text-right'>$c[7]  </td>"
                . "<td class='text-right'>S/." . $c[8] . "  </td>"
                . "<td class='text-right' >S/." . $c[9] . "  </td>"
                . "<td class='text-right'>S/." . $c[10] . "  </td>"
                . "<td class='text-right'>S/." . $c[11] . "  </td>"
                . "</tr>";
        }

        echo $tbl;

        break;

    case 'PRECIO_COMPRA_ULTIMO':
        $id = $_POST['id'];

        $listar = $olog->UltimaPrecioCompra($id);
        echo json_encode($listar->fetch());
        break;

        //PROVEEDOR
    case "LIS_PROV":
        $datos = array();
        $pagina = $_GET["pagina"];
        $ultimo_pagina = $pagina * $paginacion;
        $primero_pagina = $ultimo_pagina - $paginacion;
        $lista = $olog->ListarProveedor($_GET["q"], $primero_pagina, $paginacion);
        $cont = $primero_pagina;
        foreach ($lista as $prov) {
            $cont++;
            $subArray = array();
            $subArray[] = $cont;
            $subArray[] = $prov["nombre"];
            $subArray[] = $prov["documento"];
            $subArray[] = $prov["direccion"];
            $subArray[] = $prov["contacto"];
            $subArray[] = $prov["telefono"];
            $subArray[] = $prov["email"];

            $subArray[] = "<div align='center'>
                <a  onclick=\"editar('" . $prov["id"] . "')\" ><i class=' fa fa-pencil green' ></i> </a>" .
                "&nbsp;&nbsp;&nbsp;<a  onclick=\"eliminar(" . $prov["id"] . " )\"  ><i class='fa fa-trash red'></i></a></div>";
            $datos[] = $subArray;
        }

        echo json_encode($datos);
        break;



    case "PAG_PROV":

        $cont = $olog->TotalProveedor($_GET["q"])->fetch()[0];

        if ($cont == 0) {
            echo 0;
            break;
        }

        if ($cont < $paginacion) {
            echo "1";
        } else {
            echo ceil($cont / $paginacion);
        }
        break;
    case 'LLENAR_PROV':
        $id = $_POST['id'];
        $listar = $olog->ListarProveedorxid($id);
        echo json_encode($listar->fetch());
        break;
    case 'NUEVO_PROV':
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $contacto = $_POST['contacto'];
        $documento = $_POST['documento'];
        $email = $_POST['correo'];
        $valor = $_POST['valor'];
        $validar = $olog->Validarproveedor($nombre)->fetch();

        $can = $validar[0];
        // si el valor es igual a 1 insertamos
        if ($valor == 1) {
            if ($can == 0) {

                $insertar = $olog->Registrarproveedor($nombre, $documento, $direccion, $contacto, $telefono, $email);
                echo $insertar;
            } else
                echo 2;
            exit;
        }
        // si el valor es igual a 2 modificamos
        if ($valor == 2) {
            $id = $_POST["id"];

            $modificar = $olog->Modificarproveedor($id, $nombre, $documento, $direccion, $contacto, $telefono, $email);
            echo $modificar;
        }
        break;
    case 'ELIMINAR_PROV':
        $id = $_POST['id'];

        $eliminar = $olog->Eliminarproveedor($id);
        echo $eliminar;
        break;


    case 'LIS_LOTE':
        $datos = array();
        $pagina = $_GET["pagina"];
        $ultimo_pagina = $pagina * $paginacion;
        $primero_pagina = $ultimo_pagina - $paginacion;
        $lista = $olog->ListarLote($_GET["q"], $primero_pagina, $paginacion);
        $cont = $primero_pagina;
        foreach ($lista as $prov) {
            $cont++;
            $subArray = array();
            $subArray[] = $cont;
            $subArray[] = $prov["nro"];
            $subArray[] = $prov["nombre"];
            $subArray[] = $prov["cantidad"];
            $subArray[] = $prov["unidad"];
            $subArray[] = $prov["fecha_vencimiento"];
            $subArray[] = $prov["almacen"] . ' - ' . $prov["sucursal"];


            $datos[] = $subArray;
        }

        echo json_encode($datos);
        break;



    case "PAG_LOTE":

        $cont = $olog->TotalLote($_GET["q"])->fetch()[0];

        if ($cont == 0) {
            echo 0;
            break;
        }

        if ($cont < $paginacion) {
            echo "1";
        } else {
            echo ceil($cont / $paginacion);
        }
        break;


    case 'LISTAR_LOTExALM':
        $almacen = $_POST['almacen'];

        $listar = $olog->ListarLotexAlmacen($almacen);
        $opt = "<option value=''>Seleccione</option>";
        foreach ($listar as $a) {

            $opt .= "<option value='$a[0]'>$a[2] - Lote: $a[1]</option>";
        }

        echo $opt;
        break;



    case 'LIS_LOTE_FRACCIONxALM': //Lote de producto que se pueden fraccionar
        $almacen = $_POST['almacen'];

        $listar = $olog->ListarLoteFraccionxAlmacen($almacen);
        $opt = "<option value=''>Seleccione</option>";
        foreach ($listar as $a) {

            $opt .= "<option value='$a[0]'>$a[2] - Lote: $a[1]</option>";
        }

        echo $opt;
        break;


    case 'STOCKxLOTE':
        $lote = $_POST['lote'];

        $listar = $olog->ListarLotexid($lote)->fetch();

        $stock = $listar['cantidad'];

        echo $stock;
        break;




    case 'PRODUCTOxLOTE':
        $lote = $_POST['lote'];

        $listar = $olog->ProductoxLote($lote);

        echo json_encode($listar->fetch());
        break;

    case 'PRODUCTO_FRACCIONxLOTE':
        $lote = $_POST['lote'];

        $listar = $olog->ProductoFraccionxLote($lote);

        echo json_encode($listar->fetch());
        break;



    case 'LIS_ORD_DOC':
        $datos = array();
        $pagina = $_GET["pagina"];
        $ultimo_pagina = $pagina * $paginacion;
        $primero_pagina = $ultimo_pagina - $paginacion;
        $lista = $olog->ListarOrdDoc($_GET["q"], $primero_pagina, $paginacion);
        $cont = $primero_pagina;
        foreach ($lista as $prov) {
            $cont++;
            $subArray = array();
            $subArray[] = $cont;
            $subArray[] = $prov[0];
            $subArray[] = $prov[1];
            $subArray[] = $prov[2];
            $subArray[] = $prov[4];
            $subArray[] = $prov[5];


            $datos[] = $subArray;
        }

        echo json_encode($datos);
        break;



    case "PAG_ORD_DOC":

        $cont = $olog->TotalOrdDoc($_GET["q"])->fetch()[0];

        if ($cont == 0) {
            echo 0;
            break;
        }

        if ($cont < $paginacion) {
            echo "1";
        } else {
            echo ceil($cont / $paginacion);
        }
        break;


    case "TRANSEFERIR_ALM":
        if ($_POST['cantidad'] < 1) {
            echo 0;
            break;
        }

        $almacen_origen = $_POST['almacen_origen'];
        $almacen_destino = $_POST['almacen_destino'];
        $id_lote = $_POST['lote'];
        $cantidad = $_POST['cantidad'];
        $lote = $olog->ListarLotexid($id_lote)->fetch();
        $id_producto = $lote['id_producto'];
        $producto = $olog->ListarProductoLogxid($id_producto)->fetch();
        $unidad = $producto['unidad'];


        $insertar = $olog->TransferenciaAlmacen($almacen_origen, $almacen_destino, $cantidad, $unidad, $id_lote, $id_producto);
        echo $insertar;

        break;


    case "FRACCIONAR_LOTE":

        if ($_POST['cantidad'] < 1) {
            echo 0;
            break;
        }

        $almacen = $_POST['almacen'];
        $id_lote = $_POST['lote'];
        $cantidad_origen = $_POST['cantidad'];


        $producto = $olog->ProductoFraccionxLote($id_lote)->fetch();
        $id_producto_origen = $producto['id'];
        $id_producto_destino = $producto['id_producto_fraccion'];
        $unidad_origen = $producto['unidad'];
        $producto_fraccion = $olog->ListarProductoLogxId($producto['id_producto_fraccion'])->fetch();

        $unidad_destino = $producto_fraccion['id_unidad'];
        $cantidad_destino = $producto['cantidad_fraccion'] * $cantidad_origen;

        $insertar = $olog->FraccionarLote($almacen, $cantidad_origen, $cantidad_destino, $unidad_origen, $unidad_destino, $id_producto_origen, $id_producto_destino, $id_lote);
        echo $insertar;

        break;

        /* case 'LIS_KARDEX':
        $datos = array();
        $pagina = $_GET["pagina"];
        $ultimo_pagina = $pagina * $paginacion;
        $primero_pagina = $ultimo_pagina - $paginacion;
        $lista = $olog->ListarKardex($_GET["producto"], $primero_pagina, $paginacion);
        $cont = $primero_pagina;
        foreach ($lista as $kardex) {
            $cont++;
            $subArray = array();
            $subArray[] = $kardex[0];
            $subArray[] = $kardex[1];
            $subArray[] = $kardex[2];
            $subArray[] = $kardex[3];
            $subArray[] = $kardex[4];
            $subArray[] = $kardex[5];
            $subArray[] = $kardex[6];
            $subArray[] = $kardex[7];
            $subArray[] = $kardex[8];
            $subArray[] = $kardex[9];
            $subArray[] = $kardex[10];
            $subArray[] = $kardex[11];
            $subArray[] = $kardex[12];
           



            $datos[] = $subArray;
        }

        echo json_encode($datos);
        break;
*/
    case 'LIS_KARDEX':
        $datos = array();
        $pagina = $_GET["pagina"];
        $ultimo_pagina = $pagina * $paginacion;
        $primero_pagina = $ultimo_pagina - $paginacion;
        $lista = $olog->ListarKardex($_GET["producto"], $primero_pagina, $paginacion);
        $cont = $primero_pagina;

        $cantidad_final = 0;
        $costo_total_final = 0;
        foreach ($lista as $kardex) {
            $cont++;
            $subArray = array();
            $subArray[] = $kardex[0];
            $subArray[] = $kardex[1];
            $subArray[] = $kardex[2];
            $subArray[] = $kardex[3];
            $subArray[] = $kardex[4];
            $subArray[] = $kardex[5];
            $subArray[] = $kardex[6];
            $subArray[] = $kardex[7];
            $subArray[] = $kardex[8];
            $subArray[] = $kardex[9];
            if ($kardex['tipo_movimiento'] == 1) {
                $cantidad_final = $cantidad_final + $kardex['cantidad'];
                $costo_total_final = $costo_total_final + $kardex['costo_total'];
                $subArray[] = $cantidad_final;
                if ($cantidad_final == 0) {
                    $subArray[] = 0.00;
                } else {
                    $subArray[] = $costo_total_final / $cantidad_final;
                }
                $subArray[] =  $costo_total_final;
            } else {
                $cantidad_final = $cantidad_final - $kardex['cantidad'];
                $costo_total_final = $costo_total_final - $kardex['costo_total'];
                $subArray[] = $cantidad_final;
                if ($cantidad_final == 0) {
                    $subArray[] = 0.00;
                } else {
                    $subArray[] = $costo_total_final / $cantidad_final;
                }
                $subArray[] =  $costo_total_final;
            }


            $datos[] = $subArray;
        }

        echo json_encode($datos);
        break;


    case "PAG_KARDEX":

        $cont = $olog->TotalKardex($_GET["producto"])->fetch()[0];

        if ($cont == 0) {
            echo 0;
            break;
        }

        if ($cont < $paginacion) {
            echo "1";
        } else {
            echo ceil($cont / $paginacion);
        }
        break;


    case 'LIS_KARDEX_ALM':
        $datos = array();
        $pagina = $_GET["pagina"];
        $ultimo_pagina = $pagina * $paginacion;
        $primero_pagina = $ultimo_pagina - $paginacion;
        $lista = $olog->ListarKardexAlmacen($_GET["producto"], $_GET["almacen"], $primero_pagina, $paginacion);
        $cont = $primero_pagina;

        $cantidad_final = 0;
        $costo_total_final = 0;
        foreach ($lista as $kardex) {
            $cont++;
            $subArray = array();
            $subArray[] = $kardex[0];
            $subArray[] = $kardex[1];
            $subArray[] = $kardex[2];
            $subArray[] = $kardex[3];
            $subArray[] = $kardex[4];
            $subArray[] = $kardex[5];
            $subArray[] = $kardex[6];
            $subArray[] = $kardex[7];
            $subArray[] = $kardex[8];
            $subArray[] = $kardex[9];
     
            if ($kardex['tipo_movimiento'] == 1) {
                $cantidad_final = $cantidad_final + $kardex['cantidad'];
                $costo_total_final = $costo_total_final + $kardex['costo_total'];
                $subArray[] = $cantidad_final;
                if ($cantidad_final == 0) {
                    $subArray[] = 0.00;
                } else {
                    $subArray[] = $costo_total_final / $cantidad_final;
                }
                $subArray[] =  $costo_total_final;
            } else {
                $cantidad_final = $cantidad_final - $kardex['cantidad'];
                $costo_total_final = $costo_total_final - $kardex['costo_total'];
                $subArray[] = $cantidad_final;
                if ($cantidad_final == 0) {
                    $subArray[] = 0.00;
                } else {
                    $subArray[] = $costo_total_final / $cantidad_final;
                }
                $subArray[] =  $costo_total_final;
            }




            $datos[] = $subArray;
        }

        echo json_encode($datos);
        break;

    case "PAG_KARDEX_ALM":

        $cont = $olog->TotalKardexAlmacen($_GET["producto"], $_GET["almacen"])->fetch()[0];

        if ($cont == 0) {
            echo 0;
            break;
        }

        if ($cont < $paginacion) {
            echo "1";
        } else {
            echo ceil($cont / $paginacion);
        }
        break;



    case "NUEVO_MAQUINA":

        $nombre = $_POST['nombre'];
        $valor = $_POST['valor'];
        if ($valor == '1') {
            $insertar = $olog->RegistrarMaquina($nombre);
            echo $insertar;
        }
        if ($valor == '2') {
            $id = $_POST['id'];
            $modificar = $olog->ModificarMaquina($id, $nombre);
            echo $modificar;
        }

        break;

    case "ELIMINAR_MAQUINA":

        $id = $_POST['id'];

        $eliminar = $olog->EliminarMaquina($id);
        echo $eliminar;




        break;

    case 'LIS_MAQUINA':
        $datos = array();
        $pagina = $_GET["pagina"];
        $ultimo_pagina = $pagina * $paginacion;
        $primero_pagina = $ultimo_pagina - $paginacion;
        $lista = $olog->ListarMaquinas($_GET["q"], $primero_pagina, $paginacion);
        $cont = $primero_pagina;
        foreach ($lista as $reactivo) {
            $cont++;
            $subArray = array();
            $subArray[] = $cont;

            $subArray[] = $reactivo[1];
            $subArray[] = "<div align='center'>
                <a  onclick=\"editar('" . $reactivo[0] . "','" . $reactivo[1] . "')\" ><i class=' fa fa-pencil green' ></i> </a>" .
                "&nbsp;&nbsp;&nbsp;<a  onclick=\"eliminar(" . $reactivo[0] . " )\"  ><i class='fa fa-trash red'></i></a></div>";
            $datos[] = $subArray;
        }
        echo json_encode($datos);
        break;

    case "PAG_MAQUINA":

        $cont = $olog->TotalMaquina($_GET["q"])->fetch()[0];

        if ($cont == 0) {
            echo 0;
            break;
        }

        if ($cont < $paginacion) {
            echo "1";
        } else {
            echo ceil($cont / $paginacion);
        }
        break;





    case "NUEVO_CALIBRACION":

        $id_reactivo = $_POST['id_reactivo'];
        $id_maquina = $_POST['id_maquina'];
        $cantidad = $_POST['cantidad'];
        $fecha = $_POST['fecha'];
        $valor = $_POST['valor'];
        if ($valor == '1') {
            $insertar = $olog->RegistrarCalibracion($id_reactivo, $fecha, $cantidad, $id_maquina);
            echo $insertar;
        }
        if ($valor == '2') {
            $id = $_POST['id'];
            $modificar = $olog->ModificarCalibracion($id, $id_reactivo, $fecha, $cantidad, $id_maquina);
            echo $modificar;
        }

        break;

    case "ELIMINAR_CALIBRACION":

        $id = $_POST['id'];

        $eliminar = $olog->EliminarCalibracion($id);
        echo $eliminar;

        break;

    case 'LIS_CALIBRACION':
        $datos = array();
        $pagina = $_GET["pagina"];
        $ultimo_pagina = $pagina * $paginacion;
        $primero_pagina = $ultimo_pagina - $paginacion;
        $lista = $olog->ListarCalibraciones($_GET["fecha"], $primero_pagina, $paginacion);
        $cont = $primero_pagina;
        foreach ($lista as $calibracion) {
            $cont++;
            $subArray = array();
            $subArray[] = $cont;

            $subArray[] = $calibracion[1];
            $subArray[] = $calibracion[2];
            $subArray[] = $calibracion[3];
            $subArray[] = $calibracion[4];


            $subArray[] = "<div align='center'>
                <a  onclick=\"editar('" . $calibracion[0] . "','" . $calibracion[1] . "','" . $calibracion[3] . "','" . $calibracion[5] . "','" . $calibracion[6] . "')\" ><i class=' fa fa-pencil green' ></i> </a>" .
                "&nbsp;&nbsp;&nbsp;<a  onclick=\"eliminar(" . $calibracion[0] . " )\"  ><i class='fa fa-trash red'></i></a></div>";

            $datos[] = $subArray;
        }

        echo json_encode($datos);
        break;

    case "PAG_CALIBRACION":

        $cont = $olog->TotalCalibracion($_GET["fecha"])->fetch()[0];

        if ($cont == 0) {
            echo 0;
            break;
        }

        if ($cont < $paginacion) {
            echo "1";
        } else {
            echo ceil($cont / $paginacion);
        }
        break;



    case 'LIS_EXAMEN':
        $datos = array();
        $pagina = $_GET["pagina"];
        $ultimo_pagina = $pagina * $paginacion;
        $primero_pagina = $ultimo_pagina - $paginacion;
        $lista = $olog->ListarExamenes($_GET["q"], $primero_pagina, $paginacion);
        $cont = $primero_pagina;
        foreach ($lista as $reactivo) {
            $cont++;
            $subArray = array();
            $subArray[] = $cont;
            $subArray[] = ($reactivo[1]);

            $subArray[] = "<div align='center'> <a  onclick=\"detalles(" . $reactivo[0] . ",'" . ($reactivo[1]) . "' )\"  ><i class='fa fa-plus-circle  blue '></i></a></div>";
            $datos[] = $subArray;
        }
        echo json_encode($datos);
        break;

    case "PAG_EXAMEN":

        $cont = $olog->TotalExamen($_GET["q"])->fetch()[0];

        if ($cont == 0) {
            echo 0;
            break;
        }

        if ($cont < $paginacion) {
            echo "1";
        } else {
            echo ceil($cont / $paginacion);
        }
        break;

    case 'LIS_EXAMEN_REACTIVO':
        $datos = array();

        $lista = $olog->ListarExamenReactivo($_GET["id_examen"]);
        $cont = 0;
        foreach ($lista as $reactivo) {
            $cont++;
            $subArray = array();
            $subArray[] = $cont;

            $subArray[] = $reactivo[1];
            $subArray[] = $reactivo[2];

            $subArray[] = "<div align=''>
                <a  onclick=\"eliminar(" . $reactivo[0] . " )\"  ><i class='fa fa-trash red'></i></a>" .
                "</div>";
            $datos[] = $subArray;
        }
        echo json_encode($datos);
        break;

    case "NUEVO_EXAMEN_REACTIVO":

        $id_examen = $_POST['id_examen'];
        $id_reactivo = $_POST['id_reactivo'];
        $cantidad = $_POST['cantidad'];

        $insertar = $olog->RegistrarExamenReactivo($id_reactivo, $cantidad, $id_examen);
        echo $insertar;
        break;

    case "ELIMINAR_EXAMEN_REACTIVO":

        $id = $_POST['id'];

        $eliminar = $olog->EliminarExamenReactivo($id);
        echo $eliminar;

        break;



    case "NUEVO_CLIENTE_EXAMEN":

        $id_cliente = $_POST['id_cliente'];
        $id_examen = $_POST['id_examen'];
        $fecha = $_POST['fecha'];
        $valor = $_POST['valor'];
        if ($valor == '1') {
            $insertar = $olog->RegistrarClienteExamen($id_cliente, $id_examen, $fecha);
            echo $insertar;
        }
        if ($valor == '2') {
            $id = $_POST['id'];
            $modificar = $olog->ModificarClienteExamen($id, $id_cliente, $id_examen, $fecha);
            echo $modificar;
        }

        break;

    case "ELIMINAR_CLIENTE_EXAMEN":

        $id = $_POST['id'];

        $eliminar = $olog->EliminarClienteExamen($id);
        echo $eliminar;

        break;

    case 'LIS_CLIENTE_EXAMEN':
        $datos = array();
        $pagina = $_GET["pagina"];
        $ultimo_pagina = $pagina * $paginacion;
        $primero_pagina = $ultimo_pagina - $paginacion;
        $lista = $olog->ListarClienteExamen($_GET["q"], $primero_pagina, $paginacion);
        $cont = $primero_pagina;
        foreach ($lista as $ingreso) {
            $cont++;
            $subArray = array();
            $subArray[] = $cont;

            $subArray[] = $ingreso[1];
            $subArray[] = $ingreso[2];
            $subArray[] = $ingreso[3];

            $subArray[] = "<div align='center' ><a  onclick=\"editar('" . $ingreso[0] . "','" . $ingreso[1] . "','" . $ingreso[4] . "','" . $ingreso[5] . "')\" ><i class=' fa fa-pencil green' ></i> </a>" .
                "&nbsp;&nbsp;&nbsp;<a  onclick=\"eliminar(" . $ingreso[0] . " )\"  ><i class='fa fa-trash red'></i></a></div>";

            $datos[] = $subArray;
        }

        echo json_encode($datos);
        break;

    case "PAG_CLIENTE_EXAMEN":

        $cont = $olog->TotalClienteExamen($_GET["q"])->fetch()[0];

        if ($cont == 0) {
            echo 0;
            break;
        }

        if ($cont < $paginacion) {
            echo "1";
        } else {
            echo ceil($cont / $paginacion);
        }
        break;

    case 'LIS_INGRESOSxREACTIVO':
        $datos = array();
        $pagina = $_GET["pagina"];
        $ultimo_pagina = $pagina * $paginacion;
        $primero_pagina = $ultimo_pagina - $paginacion;

        $id_reactivo = $_GET["q"];
        $lista = $olog->ListarIngresosxReactivo($id_reactivo, $primero_pagina, $paginacion);
        $cont = $primero_pagina;
        foreach ($lista as $ingreso) {
            $cont++;
            $subArray = array();
            $subArray[] = $cont;

            $subArray[] = $ingreso[0];
            $subArray[] = $ingreso[1];

            /* $fecha1 = $olog->FechaAnteriorIngresoReactivo($ingreso[0], $id_reactivo)->fetch()[0];
            if ($fecha1 == '') {
                $fecha1 = '0001-01-01';
            }
            $total_usado_examenes = $olog->ReporteTotalReactivoxPeriodo($id_reactivo, $fecha1, $ingreso[0])->fetch()[0];
            $total_usado_calibraciones = $olog->TotalCalibracionesxPeriodo($id_reactivo, $fecha1, $ingreso[0])->fetch()[0];
            */

            $fecha1 = $olog->FechaPosteriorIngresoReactivo($ingreso[0], $id_reactivo)->fetch()[0];
            if ($fecha1 == '') {
                $fecha1 = '3000-01-01';
            }
            $total_usado_examenes = $olog->ReporteTotalReactivoxPeriodo($id_reactivo, $ingreso[0], $fecha1)->fetch()[0];
            $total_usado_calibraciones = $olog->TotalCalibracionesxPeriodo($id_reactivo, $ingreso[0], $fecha1)->fetch()[0];
            if ($total_usado_examenes == null) {
                $total_usado_examenes = '0.00';
            }
            if ($total_usado_calibraciones == null) {
                $total_usado_calibraciones = '0.00';
            }

            $total = $total_usado_examenes + $total_usado_calibraciones;
            $subArray[] = $total;
            $subArray[] = ($ingreso[1] - $total);
            $subArray[] = "<div align='center' ><a   onclick=\"Detalles('" . $id_reactivo . "','" . $ingreso[0] . "','" . $fecha1 . "')\" ><i class='fa fa-plus-circle secondary'></i></a></div>";




            $datos[] = $subArray;
        }

        echo json_encode($datos);
        break;

    case "PAG_INGRESOSxREACTIVO":

        $cont = $olog->TotalIngresosxReactivo($_GET["q"])->fetch()[0];

        if ($cont == 0) {
            echo 0;
            break;
        }

        if ($cont < $paginacion) {
            echo "1";
        } else {
            echo ceil($cont / $paginacion);
        }
        break;

    case 'LIS_REACTIVOxPERIODO':
        $datos = array();
        $id = $_GET['id'];
        $fecha1 = $_GET['fecha1'];
        $fecha2 = $_GET['fecha2'];

        $lista = $olog->ReporteReactivoxPeriodo($id, $fecha1, $fecha2);
        $cont = 0;
        foreach ($lista as $ingreso) {
            $cont++;
            $subArray = array();
            $subArray[] = $cont;
            $subArray[] = $ingreso[0];
            $subArray[] = $ingreso[1];
            $subArray[] = $ingreso[2];
            $datos[] = $subArray;
        }

        echo json_encode($datos);
        break;

    case 'LIS_CALIBRACIONESxPERIODO':
        $datos = array();
        $id = $_GET['id'];
        $fecha1 = $_GET['fecha1'];
        $fecha2 = $_GET['fecha2'];

        $lista = $olog->ListarCalibracionesxPeriodo($id, $fecha1, $fecha2);
        $cont = 0;
        foreach ($lista as $ingreso) {
            $cont++;
            $subArray = array();
            $subArray[] = $cont;
            $subArray[] = $ingreso[0];
            $subArray[] = $ingreso[1];
            $subArray[] = $ingreso[2];
            $datos[] = $subArray;
        }

        echo json_encode($datos);
        break;
}
