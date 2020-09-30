<div class="page-header" style="background-color:#EFF3F8; margin:0">
    <h1><i class="menu-icon"><img src="imagenes/grupo_user.png" style="border:0;" height="25" width="25"></i>
        <span id="Titulo" style="font-size:13px; font-weight:bold">PRODUCTOS</span>

    </h1>

</div>
<?php
include 'cado/ClaseLogistica.php';
$olog = new Logistica();
$lista_clientes = $olog->ListarClientes();
$lista_examenes = $olog->ListarExamenes('', '0', '1000');


?>

<input type="hidden" id="IdFilaUsu" />
<input type="hidden" id="idvalor" />
<div class="bodycontainer scrollable">

    <table class="table table-responsive table-bordered table-striped text-left" style="margin:0">
        <thead>
            <tr>
                <th width="">N°</th>

                <th>FECHA</th>
                <th>CLIENTE</th>
                <th>EXÁMEN</th>

                <th></th>
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
                    <input type="date" id="buscar" placeholder=" Buscar " class="form-control" onkeyup="javascript:Listar(1)" autocomplete="off" />
                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                </span></td>
            <td width="50%"> <button type="button" class="btn btn-primary" onclick="javascript:abrirModal()">Nuevo </button>
            </td>
        </tr>
    </table>
</div>


<!--MODAL ELIMINAR -->
<div class="modal fade" id="ModalEliminar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title">Eliminar examen</h4>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de eliminar esta examen?</p>
            </div>

            <div class="modal-footer">
                <form id="formEliminar">
                    <input type="hidden" name="id" id="eliminar">
                    <button type="button" class="btn btn-white btn-info btn-bold " data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-white btn-info btn-bold  btn-danger waves-effect">Eliminar</button>
                </form>
            </div>

        </div>
    </div>
</div>

<!--Modal Registrar -->
<div id="ModalRegistrar" class="modal fade text-left" role="dialog">
    <form id="formRegistrar">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="color:#030"> <img src="imagenes/grupo_user.png" height="30" width="30" />
                        &nbsp; REGISTRAR </h4>

                </div>
                <div class="modal-body">

                    <div class="modal-body">

                        <table width="100%" style="font-size:13px; font-weight:bold;">


                            <tr>

                                <td><b>Fecha</b><br>
                                    <input type="hidden" id="ca_id" name="id">
                                    <input type="hidden" id="ca_valor" name="valor">
                                    <input name="fecha" type="date" id="ca_fecha" name="fecha" required class="form-control"></td>

                            </tr>
                            <tr>
                                <td><br></td>
                            </tr>
                            <tr>

                                <td><b>Cliente</b><br>
                                    <select onchange="Listar(1)" id="ca_id_cliente" name="id_cliente" required>
                                        <option value="">Seleccione </option>
                                        <?php foreach ($lista_clientes as $cliente) { ?>
                                            <option value="<?= $cliente[0] ?>"><?= $cliente[1] ?></option>
                                        <?php } ?>
                                    </select>
                                </td>

                            </tr>
                            <tr>
                                <td><br></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Examen</b><br>
                                    <select onchange="Listar(1)" id="ca_id_examen" name="id_examen" required>
                                        <option value="">Seleccione </option>
                                        <?php foreach ($lista_examenes as $examen) { ?>
                                            <option value="<?= $examen[0] ?>"><?= $examen[1] ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>




                        </table>

                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-white btn-info btn-bold  " type="submit">
                        <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>Grabar</button>
                    <button class="btn btn-white btn-info btn-bold  " type="reset" data-dismiss="modal">
                        <i class="ace-icon fa fa-times red2"></i>Cancelar</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script src='js/log_examenes_clientes.js'></script>




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