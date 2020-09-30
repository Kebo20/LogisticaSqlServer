<div class="page-header" style="background-color:#EFF3F8; margin:0">
    <h1><i class="menu-icon"><img src="imagenes/grupo_user.png" style="border:0;" height="25" width="25"></i>
        <span id="Titulo" style="font-size:13px; font-weight:bold">Fraccionar Lote</span>

    </h1>

</div>
<?php
require_once('cado/ClaseContabilidad.php');
require_once('cado/ClaseLogistica.php');


$osucursal = new Contabilidad();
$olog = new Logistica();

$lista_sucursales = $osucursal->ListarTodoSucursal();
$lista_sucursales2 = $osucursal->ListarTodoSucursal();

?>

<input type="hidden" id="IdFilaUsu" />
<input type="hidden" id="idvalor" />

<div align='center' class="modal-body">

    <table width="90%" style="font-size:12px; font-weight:bold;">

        <tr>

            <td width="50%"><b>Sucursales</b>

                <select id="TAsuc_org" class="input " style="width:95%">
                    <option value="">Seleccione</option>
                    <?php foreach ($lista_sucursales as $s) { ?>
                        <option value="<?= $s[0] ?>"><?= $s[1] ?> - <?= $s["nombre_empresa"] ?></option>
                    <?php } ?>

                </select>
            </td>

            <td width="50%"><b>Almacén</b>


                <select id="TAalm_org" class="input" style="width:95%">
                    <option value="">Seleccione</option>

                </select>
            </td>


        </tr>


    </table>


    <hr>
    <table width="90%" class="" style="font-size:12px; font-weight:bold;">


        <tr>
            <td width="100%" colspan="2"><b>Producto</b><br>

                <select id="TAproducto" class="input" style="width: 100%">
                    <option value="">Seleccione </option>


                </select>

            </td>
        </tr>


    </table>

    <table width="90%" class="" style="font-size:12px; font-weight:bold;">

        <tr>



            <td width="40%"><b></b><br>
                <input disabled id="TAunidad_equi" value="" style="width:95%" class="form-control text-right" autocomplete="off">
            </td>


            <td width="20%" rowspan="3" align='center'>
                <h4>Equilave a :</h4>
            </td>
            <td width="40%"><b></b><br>
                <input disabled id="TAfraccion_equi" value="" style="width:95%" class="form-control text-left" autocomplete="off">
            </td>


        </tr>
    </table>
    <hr>
    <table width="90%" class="" style="font-size:12px; font-weight:bold;">

        <tr>


            <td width="20%"><b>Stock</b><br>
                <input type="text" disabled id="TAstock" value="" style="width:95%" class="form-control text-right" autocomplete="off">
            </td>
            <td width="20%"><b>Cantidad a convertir</b><br>
                <input id="TAcantidad" value="" style="width:95%" class="form-control numero text-right" autocomplete="off">
            </td>

            <td rowspan="3" align='center'>
                <i style="font-size: 40px;" class='la la-chevron-right'></i>
                <i style="font-size: 40px;" class='la la-chevron-right'></i>
            </td>
            <td width="20%"><b>Cantidad</b><br>
                <input type="text" disabled id="TAcantidad_fraccion" value="" style="width:95%" class="form-control " autocomplete="off">
            </td>

            <td width="20%"><b>Unidad</b><br>
                <input type="text" disabled id="TAunidad_fraccion" value="" style="width:95%" class="form-control " autocomplete="off">
            </td>


        </tr>


    </table>

    <hr>
    <div class="row" style="position: absolute;right:8%">

        <button type="button" id="OCbtn_guardar" class="btn btn-white btn-info btn-bold " onclick="Fraccionar()"><i class="fa fa-save"></i> FRACCIONAR </button>

        <button type="button" id="OCbtn_cancelar" class="btn btn-white btn-info btn-bold " onclick="Limpiar()"><i class="ace-icon fa fa-times red2"></i> CANCELAR </button>

    </div>

</div>


</div>



<script src='js/log_fraccionar_lote.js'></script>




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