<div class="page-header" style="background-color:#EFF3F8; margin:0">
    <h1><i class="menu-icon"><img src="imagenes/grupo_user.png" style="border:0;" height="25" width="25"></i>
        <span id="Titulo" style="font-size:13px; font-weight:bold">Categorias</span>

    </h1>

</div>
<?php

require_once('cado/ClaseLogistica.php');

$olog = new Logistica();
$lista_productos = $olog->ListarSoloProductos("", 0, 1000);
?>

<input type="hidden" id="IdFilaUsu" />
<input type="hidden" id="idvalor" />
<div class="bodycontainer scrollable">

    <table class="table table-responsive table-bordered table-striped text-left" style="margin:0">
    <thead>
            <tr>
                <th rowspan="2">Fecha</th>
                <th rowspan="2">Tipo documento</th>
                <th rowspan="2">N° documento</th>

                <th rowspan="2">Tipo de operación</th>
                <th colspan="3" class="text-center">Entradas</th>
                
                <th colspan="3" class="text-center"> Salidas</th>
                
                <th colspan="3" class="text-center">Saldos</th>
                

            </tr>
        
            <tr>
                
                <th>Cant.</th>
                <th>Costo</th>
                <th>Total</th>
                <th>Cant.</th>
                <th>Costo</th>
                <th>Total</th>
                <th>Cant.</th>
                <th>Costo unit.</th>
                <th>Total</th>

            </tr>
        </thead>
        <tbody id="lista" style="font-size:12px;"></tbody>

    </table>
    <div id="paginacion" align='right'>

    </div>


</div>


<div class="page-header" style="background-color:#EFF3F8;padding-left:10px; padding-top:15px">
    <table width="100%">
        <tr>
            <td width="40%"><span class="input-icon" style="width:90%">
                    <select id="producto" class="input " onchange="Listar(1)" style="width: 95%">
                        <option value="">Seleccione producto</option>
                        <?php foreach ($lista_productos as $p) { ?>
                            <option value="<?= $p[0] ?>"><?= $p["nombre"] . " - " . $p["categoria"] ?> </option>
                        <?php } ?>
                    </select>
            </td>
            <td>
                <div class="">
                    <btn class="btn btn-white btn-info btn-bold " onclick="ReporteExcel()"><i class="fa fa-file-excel-o fa-6"></i> Excel</btn>
                </div>
            </td>
        </tr>
    </table>
</div>




<script src='js/log_kardex.js'></script>




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