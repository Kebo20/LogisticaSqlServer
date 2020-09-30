<div class="page-header" style="background-color:#EFF3F8; margin:0">
    <h1><i class="menu-icon"><img src="imagenes/grupo_user.png" style="border:0;" height="25" width="25"></i>
        <span id="Titulo" style="font-size:13px; font-weight:bold">Orden de compra</span>

    </h1>

</div>
<?php
require_once('cado/ClaseLogistica.php');


$olog = new Logistica();
$lista_productos = $olog->ListarProductoLog("", 0, 1000);
require_once('cado/ClaseContabilidad.php');

$osucursal = new Contabilidad();
$lista_sucursales = $osucursal->ListarTodoSucursal();
$lista_sucursales2 = $osucursal->ListarTodoSucursal();
$lista_categorias = $olog->ListarCategoriaProducto('', 0, 1000);

?>

<input type="hidden" id="IdFilaUsu" />
<input type="hidden" id="idvalor" />
<div align='center' class="modal-body scroll">

    <table width="81%" style="font-size:12px; font-weight:bold;">
        <tr style='display:none'>
            <td><b>Id</b>
                <input type="text" id="id_OC" size="5" readonly="readonly" class='form-control' />
            </td>

        </tr>

        <tr>

            <td width="35%"><b>Sucursales</b>

                <select id="OCid_cmb_suc" class='form-control' style="width:90%">
                    <option value="">Seleccione</option>
                    <?php foreach ($lista_sucursales as $s) { ?>
                        <option value="<?= $s[0] ?>"><?= $s[1] ?> - <?= $s["nombre_empresa"] ?></option>
                    <?php } ?>

                </select>
            </td>


            <td width="35%"><b>Almacén</b>


                <select id="OCid_cmb_alm" class=" input" style="width:90%">
                    <option value="">Seleccione</option>

                </select>
            </td>

            <td width="15%"><b>Tipo</b>


                <select id="OCtipo" class='form-control' style="width:90%">
                    <option value="">Seleccione</option>
                    <option value="0">Producto</option>
                    <option value="1">Servicio</option>



                </select>
            </td>
            <td width="15%"><b>Categoría</b>


                <select id="OCcategoria" class='form-control' style="width:90%">
                    <option value="">Seleccione</option>
                    <?php foreach ($lista_categorias as $categoria) { ?>
                        <option value="<?= $categoria[0] ?>"><?= $categoria[1] ?></option>
                    <?php } ?>




                </select>
            </td>


        </tr>
    </table>
    <br>
    <table width="81%" style="font-size:12px; font-weight:bold;">
        <tr>

            <td width="30%"><b>N° orden</b><input type="number" id="OCnro" class="input numero" value="" style="width:95%" autocomplete="off"></td>
            <td width="30%"><b>Fecha</b><input type="date" id="OCfecha" class='form-control' value="" style="width:95%" autocomplete="off"></td>




            <td width="30%"><b>Usuario</b>
                <input type="text" disabled="" id="OCusuario" style="text-transform:uppercase;width:95%" class='form-control' autocomplete="off"></td>


        </tr>
        <tr>
            <td colspan="4" width="90%"><b>Referencia</b>
                <input type="text" id="OCreferencia" value="" style="text-transform:uppercase;width:98.5%" class='form-control' autocomplete="off"></td>
        </tr>

    </table>
    <hr>
    <table width="82%" class="" style="font-size:12px; font-weight:bold;">


        <tr>
            <td width="60%"><b>Producto</b><br>

                <select id="OCid_cmb_pro" class='form-control' style="width: 95%">
                    <option value="">Seleccione </option>


                </select>

            </td>

            <td width="10%"><b>Cantidad</b><br>
                <input type="text" id="OCcantidad" value="" style="width:95%" class="input numero" autocomplete="off">
            </td>
            <td width="10%"><b>Unidad</b><br>
                <input type="text" id="OCunidad" readonly value="" style="width:95%" class='form-control' autocomplete="off">
            </td>
            <td width="10%"><b>Stock</b><br>
                <input type="text" readonly value="" style="text-transform:uppercase;width:95%" class='form-control' autocomplete="off">
            </td>


            <td width="9%"><b></b><br>
                <button type="button" style="width:95%;height: 35px" class="btn btn-white btn-info btn-bold " onClick="OCAñadirDetalle()"><i class='fa fa-plus'></i></button>
            <td>

            </td>

        </tr>
    </table>
    <br>
    <div align='center'  style="overflow-y: scroll;height: 200px;">

        <table id="IdTblOCD" style="border:1.5px solid darkgrey;border-radius: 4px;padding: 10px;" width="100%" class="table table-responsive table-bordered table-striped text-left">
            <thead>
                <tr style="font-size:13px;" class="bg-secondary text-white">
                    <Th></Th>
                    <Th>N°</Th>
                    <Th>Producto</Th>
                    <Th>Cantidad</Th>
                    <Th>Unidad</Th>
                    <Th>Despachado</Th>
                    <Th>Pendiente</Th>

                </tr>
            </thead>
            <tbody id="IdCuerpoOCD" style="font-size:13px;">

                <tr>
                    <td colspan="7"></td>

                </tr>
                <tr>
                    <td colspan="7"></td>

                </tr>
                <tr>
                    <td colspan="7"></td>

                </tr>
                <tr>
                    <td colspan="7"></td>

                </tr>
                <tr>
                    <td colspan="7"></td>

                </tr>


            </tbody>
        </table>

    </div>


    <br>
    <div class="row">

        <div class="col-lg-12 col-md-12 ">
            <div class="form-group">
                &nbsp;&nbsp;
                <button type="button" id="OCbtn_nuevo" class="btn btn-white btn-info btn-bold  "><i class="fa fa-plus-circle"></i> Nuevo</button>
                <button type="button" id="OCbtn_guardar" class="btn btn-white btn-info btn-bold  "><i class="fa fa-save"></i> Grabar</button>
                <button type="button" id="OCbtn_buscar" class="btn btn-white btn-info btn-bold  "><i class="fa fa-search"></i> Buscar</button>
                <button type="button" id="OCbtn_imprimir" class="btn btn-white btn-info btn-bold  "><i class="fa fa-print"></i> Imprimir</button>
                <button type="button" id="OCbtn_limpiar" class="btn btn-white btn-info btn-bold  "><i class="fa fa-eraser"></i> Limpiar</button>
                <button type="button" id="OCbtn_anular" class="btn btn-white btn-info btn-bold  ">X Anular</button>
                <button type="button" id="OCbtn_finalizar" class="btn btn-white btn-info btn-bold  "><i class="fa fa-arrow-circle-right"></i> Finalizar</button>
                <button type="button" id="OCbtn_cancelar" class="btn btn-white btn-info btn-bold  "><i class="fa fa-close red"></i>Cancelar</button>

            </div>
        </div>

    </div>

</div>

</div>


<input type="hidden" id="OCvalor" value="1">
<input type="hidden" id="IdFilaOC" value="">

<div id="OCModal" class="modal fade" role="dialog">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="color:#030"> <img src="imagenes/grupo_user.png" height="30" width="30" />
                        &nbsp; ORDENES DE COMPRA</h4>

                </div>
            <div class="modal-body">

                <table width="100%" style="font-size:12px; font-weight:bold;">


                    <tr>

                        <td width="20%"><b>Sucursales</b>


                            <select id="OCbuscar-id_cmb_suc" class='form-control'>
                                <option value="">Seleccione</option>
                                <?php foreach ($lista_sucursales2 as $s) { ?>
                                    <option value="<?= $s[0] ?>"><?= $s[1] ?> - <?= $s["nombre_empresa"] ?></option>
                                <?php } ?>

                            </select>
                        </td>

                        <td width="20%"><b>Almacén</b>


                            <select id="OCbuscar-id_cmb_alm" class='form-control' onchange="">
                                <option value="">Seleccione</option>

                            </select>
                        </td>
                        <td width="20%"><b>Estado</b>
                            <select id="OCbuscar-estado" class='form-control'>
                                <option value="">Seleccione</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="finalizada">Finalizado</option>
                                <option value="anulada">Anulado</option>

                            </select></td>


                    </tr>
                </table>
                <br>
                <table width="100%" style="font-size:12px; font-weight:bold;">
                    <tr>
                        <td width="20%"><b>N° orden</b><input type="text" id="OCbuscar-nro_orden" class="input numero" value="" style="width:97%" autocomplete="off"></td>
                        <td width="20%"><b>Fecha</b><input type="date" id="OCbuscar-fecha" class='form-control' value="" style="width:97%" autocomplete="off"></td>


                        <td width="20%" align="center"><br><button class="btn btn-white    " style="width:15%" onClick="OCListarBuscar()"><i class="fa fa-search"></i> <span> </span></button></td>

                    </tr>
                </table>

                <br>
                <div class="email-app-area">
                    <!-- Email list Area -->

                    <div class="table-responsive" style="overflow-y: scroll;height: 310px;">
                        <table id="IdTblOCbuscar" class="table table-responsive table-bordered table-striped text-left" style="text-align:right;" border="1" bordercolor="#cccccc">
                            <thead>
                                <tr style="font-size:13px !important" class="bg-secondary text-white">
                                    <Th>N°</Th>
                                    <Th>Nro orden</Th>
                                    <Th>Fecha</Th>
                                    <Th>Sucursal</Th>

                                    <Th>Almacén</Th>
                                    <Th>Tipo</Th>
                                    <Th>Estado</Th>

                                </tr>
                            </thead>
                            <tbody id="IdCuerpoOCbuscar" style="font-size:13px !important"> </tbody>

                        </table>

                    </div>



                    <div class="modal-footer">
                        <button id="" class="btn btn-white btn-info btn-bold   " onClick="OCLlenarDatos()"> Aceptar</button>
                        <button class="btn btn-white btn-info btn-bold  " data-dismiss="modal"> Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script src='js/log_orden_compra.js'></script>




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