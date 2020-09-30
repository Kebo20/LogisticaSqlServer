<div class="page-header" style="background-color:#EFF3F8; margin:0">
    <h1><i class="menu-icon"><img src="imagenes/grupo_user.png" style="border:0;" height="25" width="25"></i>
        <span id="Titulo" style="font-size:13px; font-weight:bold">PRODUCTOS</span>

    </h1>

</div>
<?php
require_once('cado/ClaseLogistica.php');

$olog = new Logistica();
$lista_reactivos = $olog->ListarReactivos();


?>

<input type="hidden" id="IdFilaUsu" />
<input type="hidden" id="idvalor" />
<div class="bodycontainer scrollable">

    <table class="table table-responsive table-bordered table-striped text-left" style="margin:0">
        <thead>
            <tr>
                <th width="">N°</th>

                <th>FECHA</th>
                <th>INGRESÓ</th>
                <th>UTILIZÓ</th>
                <th>STOCK</th>
                <th>DETALLES</th>
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
                    <select onchange="Listar(1)" class="form-control" id="buscar">
                        <option value="">Seleccione </option>
                        <?php foreach ($lista_reactivos as $reactivo) { ?>
                            <option value="<?= $reactivo[0] ?>"><?= $reactivo[1] ?></option>
                        <?php } ?>
                    </select>
                </span></td>
            
        </tr>
    </table>
</div>




<!--Modal Registrar -->
<div id="ModalDetalles" class="modal fade text-left" role="dialog">
    <form id="formRegistrar">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="color:#030"> <img src="imagenes/grupo_user.png" height="30" width="30" />
                        &nbsp; Detalles</h4>

                </div>
                <div class="modal-body scroll">
                    <h4>Exámenes</h4>
                    <table wdith="100%" id="" class="table table-responsive table-bordered table-striped text-left">
                        <th>N°</th>
                        <th>Fecha</th>
                        <th>Examen</th>
                        <th>Cantidad</th>
                        <tbody id="lista-detalles-examenes">

                        </tbody>


                    </table>
                    <h4>Calibraciones</h4>
                    <table wdith="100%" id="" class="table table-responsive table-bordered table-striped text-left">
                        <th>N°</th>
                        <th>Fecha</th>
                        <th>Maquina</th>
                        <th>Cantidad</th>

                        <tbody id="lista-detalles-calibraciones">

                        </tbody>

                    </table>


                </div>
                <div class="modal-footer">
                   
                    <button class="btn btn-white btn-info btn-bold  " type="reset" data-dismiss="modal">
                        <i class="ace-icon fa fa-times red2"></i>Cerrar</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script src='js/log_reporte_reactivo.js'></script>




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