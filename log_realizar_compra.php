<!--<div class="page-header" style="background-color:#EFF3F8; margin:0">
    <h1><i class="menu-icon"><img src="imagenes/grupo_user.png" style="border:0;" height="25" width="25"></i>
      <span id="Titulo" style="font-size:13px; font-weight:bold">Realizar Compra</span>

    </h1>

</div>-->
<?php
require_once('cado/ClaseLogistica.php');


$olog = new Logistica();
$lista_productos = $olog->ListarProductoLog("", 0, 1000);
$lista_proveedores = $olog->ListarProveedor("", 0, 1000);

require_once('cado/ClaseContabilidad.php');


$osucursal = new Contabilidad();
$lista_sucursales = $osucursal->ListarTodoSucursal();


?>

<input type="hidden" id="IdFilaUsu" />
<input type="hidden" id="idvalor" />

<div align='center' class="modal-body scroll">

    <table width="100%" style="font-size:12px; font-weight:bold;">
        <tr style='display:none'>
            <td><b>Id</b>
                <input name="id_com" type="text" id="id_com" size="5" readonly="readonly" class='form-control' />
            </td>

        </tr>

        <tr>
            <td width="15%">
                <label for="afecto"><b>Afecto</b></label>

                <input type="radio" id="afecto" name="tipo_afectacion" onclick="ClickAfecto()" class="input-radio formulario" value="1" onchange="llenarIGV()">
                <label for="inafecto"><b>Inafecto</b></label>
                <input type="radio" id="inafecto" onclick="ClickInafecto()" name="tipo_afectacion" class="input-radio formulario" value="2" onchange="llenarIGV()">
            </td>

            <td width="60%"><b>Proveedor</b>


                <select id="id_cmb_prov" class="input " onchange="ChangeProv()" style="width:95%">
                    <option value="">Seleccione</option>
                    <?php foreach ($lista_proveedores as $p) { ?>
                        <option value="<?= $p[0] ?>"><?= $p[1] ?></option>
                    <?php } ?>

                </select>
            </td>

            <td width="25%">
                <br>
                <button type="button" id="" style="width:85%" class="btn btn-white btn-info btn-bold" onClick="AbrirModalOrdenCompra()"><i class='fa fa-plus-circle'></i> Orden de compra</button>
            <td>



        </tr>
    </table>
    <br>
    
    <table width="100%" style="font-size:12px; font-weight:bold;">
        <tr>

            <td width="35%"><b>Sucursales</b>

                <select id="id_cmb_suc" class='form-control' onchange="ChangeSucursal()" style="width:90%">
                    <option value="">Seleccione</option>
                    <?php foreach ($lista_sucursales as $s) { ?>
                        <option value="<?= $s[0] ?>"><?= $s[1] ?> - <?= $s["nombre_empresa"] ?></option>
                    <?php } ?>

                </select>
            </td>


            <td width="35%"><b>Almacén</b>

                <select id="id_cmb_alm" class="form-control" onchange="ChangeAlmacen()" style="width:90%">
                    <option value="">Seleccione</option>
                   

                </select>
            </td>
        </tr>
    </table>
    <br>
    <table width='100%' style="font-size:12px; font-weight:bold;">
        <tr>

            <td width="15%"><b>Tipo de doc.</b>
                <select id="tipo_documento" class="input " onchange="ChangeTipoDoc()" style="width:95%">
                    <option value="">Seleccione</option>
                    <option value="2">FA</option>
                    <option value="4">BV</option>

                    <option value="3">RH</option>
                    <option value="10">GR</option>
                </select></td>
            <td width="15%"><b>N° de doc.</b>
                <input type="text" id="nro_documento" style="text-transform:uppercase;width:95%" class="input numero" value="" autocomplete="off"></td>
            <td width="15%"><b>Fecha</b><input type="date" onchange="ChangeFecha()" id="fecha" class='form-control' value="" style="width:95%" autocomplete="off"></td>

            <td width="15%"><b>Tipo de compra</b>
                <select id="tipo_compra" class="input " onchange="ChangeTipoCompra()" style="width:95%">
                    <option value="">Seleccione</option>
                    <option value="Contado">Contado</option>
                    <option value="Crédito">Crédito</option>

                </select></td>
            <td width="13%" id='td-nro_dias'><b>N° de dias</b>
                <input type="number" id="nro_dias" value="0" style="text-transform:uppercase;width:95%" class="input numero" value="" autocomplete="off"></td>
            <td width="27%" align="center">
                <b>Factura afecta a IGV</b>

                <input type="checkbox" id="igv_detalle" class="" onclick="listar(); ClickIGV()">

            </td>


        </tr>

    </table>
   
    <hr>
    <table width="100%" class="" style="font-size:12px; font-weight:bold;">


        <tr>
            <td width="100%"><b>Producto</b><br>
                <select id="id_cmb_pro" class="input " onchange="ChangeProducto()" style="width: 95%">
                    <option value="">Seleccione producto</option>
                    <?php foreach ($lista_productos as $p) { ?>
                        <option id='<?= "pro_" . $p[0] ?>' tipo_producto='<?= $p["tipo_producto"] ?>' nombre_producto='<?= $p["nombre"] ?>' value="<?= $p[0] ?>"><?= $p["nombre"] . " - " . $p["categoria"] ?> - <?= $p["tipo"] ?> </option>
                    <?php } ?>
                </select>
            </td>



        </tr>
    </table>
   
    <br>
    <table width="100%" style="font-size:12px; font-weight:bold;">
        <tr>

            <td width="15%"><b>Precio (S/.)</b>
                <input type="text" id="precio" style="width:95%" class="input numero" value="" autocomplete="off"></td>

            <td width="10%"><b>Cantidad</b>
                <input type="number" id="cantidad" style="width:95%" class="input numero" value="" autocomplete="off"></td>
            <td width="15%"><b>Prec. anterior(S/.)</b>
                <input type="text" id="precio_anterior" disabled="" value="0.00" style="width:95%" class="input numero" autocomplete="off"></td>
            <td width="15%"><b>Vencimiento</b>
                <input type="date" id="fecha_vencimiento" onchange="ChangeFechaVenc()" style="width:95%" class='form-control' value="" autocomplete="off"></td>

            <td width="15%"><b>N° lote</b>
                <input type="text" id="nro_lote" style="width:95%" class="input numero" autocomplete="off"></td>
            <td width="15%"><b>Bonificación</b>
                <select id='bonificacion' class=" input" onclick="ChangeBonificacion" onchange="ChangeBonificacion()">
                    <option value="">Seleccione</option>
                    <option value="0">No</option>
                    <option value="1">Si</option>
                </select>
            </td>
            <td width="2%"></td>
            <td width="10%">
                <br>
                <button type="button" id="BtnGrabarSerie" style="width:95%" class="btn btn-white btn-info btn-bold" onClick="AñadirDetalle()"><i class='fa fa-plus'></i></button>
            <td>
        </tr>




    </table>

    <br>

    <div class="row">
        <div class="col-12 " style="overflow-y: scroll;height: 200px;">
            <table id="IdTblCD" class="table table-responsive table-bordered table-striped text-left">
                <thead>
                    <tr class="bg-secondary text-white">
                        <Th></Th>
                        <Th></Th>
                        <th></th>
                        <Th>N°</Th>
                        <Th>Productos</Th>
                        <Th>Venc.</Th>
                        <Th>N° lote</Th>

                        <Th>Cant. ord.</Th>
                        <Th>Cant.</Th>
                        <Th>Prec.</Th>

                        <Th>Prec. sin igv</Th>
                        <Th>IGV</Th>
                        <Th>Subt.</Th>
                        <Th>Bon.</Th>

                    </tr>
                </thead>
                <tbody id="IdCuerpoCD" style="font-size:12px;">
                    <tr>
                        <td colspan="14"></td>
                    </tr>
                    <tr>
                        <td colspan="14"></td>
                    </tr>
                    <tr>
                        <td colspan="14"></td>
                    </tr>
                    <tr>
                        <td colspan="14"></td>
                    </tr>




                </tbody>
            </table>
        </div>

    </div>
    <br>
    <div class="row">

        <div class="col-lg-9 col-md-12 ">
            <table width="100%" style="font-size:12px; font-weight:bold;">

                <tr>
                    <td><b>SUB. TOTAL(S/.)</b><input id="monto_sin_igv" disabled="" style="font-size:12px; text-align:right;width:95%" class='form-control' autocomplete="off"></td>
                    <td><b>INAFECTA(S/.)</b><input value="0.00" id="inafecta" disabled="" style="font-size:12px; text-align:right;width:95%" class='form-control' autocomplete="off"></td>
                    <td><b>GRATUITA(S/.)</b><input value="0.00" id="gratuita" disabled="" style="font-size:12px; text-align:right;width:95%" class='form-control' autocomplete="off"></td>

                    <td colspan=""><b>IGV(S/.)</b><input disabled="" id="monto_igv_total" style="font-size:12px;text-align:right;  width:95%" class='form-control' autocomplete="off"></td>
                    <td colspan=""><b>IGV(%)</b><input disabled="" id="igv" style="font-size:12px;text-align:right;  width:95%" class='form-control' autocomplete="off"></td>

                    <td colspan=""><b>TOTAL(S/.)</b><input disabled="" id="total" style="font-size:12px;text-align:right;  width:95%" class='form-control' autocomplete="off"></td>

                </tr>


            </table>
        </div>

        <div class="col-lg-3 col-md-12 ">
            <div class="form-group">
                <br>
                <button id="btn_guardar" type="button" class="btn btn-white btn-info btn-bold" onClick="guardar()"><i class="fa fa-save"></i> Guardar</button>
                <button type="button" class="btn btn-white btn-info btn-bold" onClick="cancelar()">
                    <icon class=" ace-icon fa fa-times red2"></icon>Cancelar
                </button>
            </div>
        </div>

    </div>
</div>

</div>


<div id="ECModalOrdenCompra" class="modal fade" role="dialog">

    <div class="modal-dialog modal-xl" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color:#030"> <img src="imagenes/grupo_user.png" height="30" width="30" />
                    &nbsp; Ordenes de compra </h4>

            </div>
            <div class="modal-body">

                <div class='row'>

                    <table width="100%" style="font-size:12px; font-weight:bold;">
                        <tr>
                            <td width="100%"><b></b><br><input placeholder="N° orden - Enter para buscar" style='width: 32%' id="ECbuscar-nro_orden" class="form-control numero" style="width:95%" autocomplete="off"></td>

                        </tr>
                    </table>
                </div>
                <br>
                <div class='row'>
                    <div style="overflow-y: scroll;height: 300px;float:left;width:35%">
                        <h4>Pendientes</h4>

                        <table id="IdTblECbuscar" class="table table-responsive table-bordered table-striped text-left">

                            <thead>
                                <tr class="text-white">
                                    <Th>N°</Th>
                                    <Th>Nro orden</Th>
                                    <Th>Fecha</Th>
                                </tr>
                            </thead>
                            <tbody id="IdCuerpoECbuscar" style="font-size:12px;"> </tbody>
                        </table>
                    </div>
                    <div style="float:right;width:65%">
                        <h4>Detalles</h4>
                        <table id="IdTblECbuscardetalle" class="table table-responsive table-bordered table-striped text-left">
                            <thead>
                                <tr class="bg-secondary text-white">
                                    <Th>N°</Th>
                                    <Th>Producto</Th>
                                    <Th>Cantidad</Th>
                                    <Th>Unidad</Th>
                                    <Th>Despachado</Th>
                                    <Th>Pendiente</Th>

                                </tr>
                            </thead>
                            <tbody id="IdCuerpoECbuscardetalle" style="font-size:12px;"> </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="" class="btn btn-white btn-info btn-bold " onClick="LlenarDatos()"> Aceptar</button>
                <button type="button" class="btn btn-white btn-info btn-bold " data-dismiss="modal"> Cancelar</button>
            </div>
        </div>
    </div>
</div>



<div id="ECModalDividir" class="modal fade" role="dialog">

    <div class="modal-dialog " style="width: 85%;">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color:#030"> <img src="imagenes/grupo_user.png" height="30" width="30" />
                    &nbsp; Producto: <span id="dividir-producto"></span> </h4>

            </div>
            <div class="modal-body">


                <table width="100%" style="font-size:12px; font-weight:bold;">
                    <tr>
                        <input type="hidden" id="dividir-id_producto">
                        <input type="hidden" id="dividir-nombre_producto">
                        <input type="hidden" id="dividir-tipo_producto">
                        <input type="hidden" id="dividir-cantidad_orden">
                        <input type="hidden" id="dividir-fila">

                        <td width="15%"><b>Precio (S/.)</b>
                            <input type="text" id="dividir-precio" style="width:95%" class="form-control numero" value="" autocomplete="off"></td>

                        <td width="10%"><b>Cantidad</b>
                            <input type="number" id="dividir-cantidad" style="width:95%" class="form-control numero" value="" autocomplete="off"></td>
                        <td width="15%"><b>Prec. anterior(S/.)</b>
                            <input type="text" id="dividir-precio_anterior" disabled="" value="0.00" style="width:95%" class="form-control numero" autocomplete="off"></td>
                        <td width="15%"><b>Vencimiento</b>
                            <input type="date" id="dividir-fecha_vencimiento" style="width:95%" class='form-control' value="" autocomplete="off"></td>

                        <td width="15%"><b>N° lote</b>
                            <input type="text" id="dividir-nro_lote" style="width:95%" class="form-control numero" autocomplete="off"></td>
                        <td width="15%"><b>Bonificación</b>
                            <select id='dividir-bonificacion' class=" form-control">
                                <option value="">Seleccione</option>
                                <option value="0">No</option>
                                <option value="1">Si</option>
                            </select>
                        </td>
                        <td width="2%"></td>
                        <td width="10%">
                            <br>
                            <button type="button" style="width:95%" class="btn btn-white btn-info btn-bold" onClick="DividirAñadirDetalle()"><i class='fa fa-plus'></i></button>

                        <td>
                    </tr>




                </table>

                <br>

                <div class="row">
                    <div class="col-12 " style="overflow-y: scroll;height: 200px;">
                        <table class="table table-responsive table-bordered table-striped text-left">
                            <thead>
                                <tr class="">
                                    <Th></Th>
                                    <th></th>
                                    <Th>N°</Th>
                                    <Th>Producto</Th>
                                    <Th>Venc.</Th>
                                    <Th>N° lote</Th>
                                    <Th>Cant. ord.</Th>
                                    <Th>Cant.</Th>
                                    <Th>Precio</Th>
                                    <Th>Prec. sin igv</Th>
                                    <Th>Monto IGV</Th>
                                    <Th>Subotal</Th>
                                    <Th>Bon.</Th>

                                </tr>
                            </thead>
                            <tbody id="IdCuerpoCD-dividir" style="font-size:12px;">
                                <tr>
                                    <td colspan="13"></td>
                                </tr>
                                <tr>
                                    <td colspan="13"></td>
                                </tr>
                                <tr>
                                    <td colspan="13"></td>
                                </tr>
                                <tr>
                                    <td colspan="13"></td>
                                </tr>




                            </tbody>
                        </table>
                    </div>

                </div>
                <br>



            </div>
            <div class="modal-footer">
                <button type="button" id="dividir-btn_añadir" class="btn btn-white btn-info btn-bold" onClick="DividirAñadirACompra()"> Aceptar</button>
                <button type="button" class="btn btn-white btn-info btn-bold" data-dismiss="modal"> Cancelar</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="IdFilaECOC" value="0">
<input type="hidden" id="orden" value="0">



<script src='js/log_realizar_compra.js'></script>




<style>
    .bodycontainer {
        max-height: 340px;
        width: 100%;
        margin: 0;
        overflow-y: auto;
        height: 340px;
    }

    .table-scrollable {
        margin: 0;
        padding: 0;
    }
</style>