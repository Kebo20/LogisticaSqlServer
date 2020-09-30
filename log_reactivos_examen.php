<div class="page-header" style="background-color:#EFF3F8; margin:0">
    <h1><i class="menu-icon"><img src="imagenes/grupo_user.png" style="border:0;" height="25" width="25"></i>
        <span id="Titulo" style="font-size:13px; font-weight:bold">Reactivos por examen</span>

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
                <th>N°</th>
                <th>EXAMEN</th>
                <th>REACTIVOS</th>
            </tr>
        </thead>
        <tbody id="lista" style="font-size:12px;"></tbody>

    </table>
    
    <div id="paginacion" >

    </div>


</div>


<div class="page-header" style="background-color:#EFF3F8;padding-left:10px; padding-top:15px">
    <table width="100%">
        <tr>
            <td width="40%"><span class="input-icon" style="width:90%">
                    <input type="text" id="buscar" placeholder=" Buscar " class="form-control" onkeyup="javascript:Listar(1)" autocomplete="off" />
                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                </span></td>
            
        </tr>
    </table>
</div>


<!--MODAL ELIMINAR -->
<div class="modal fade" id="ModalEliminar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header ">
                    <h4 class="modal-title">Eliminar reactivo</h4>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de eliminar este reactivo?</p>
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
<div id="ModalDetalles" class="modal fade text-left" role="dialog">
    <form id="formRegistrar">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="color:#030"> <img src="imagenes/grupo_user.png" height="30" width="30" />
                        &nbsp; REACTIVOS - <span id='nombre_examen'></span> </h4>

                </div>
                <div class="modal-body">
                    <form id="formRegistrar">
                        <table width="100%"  style="font-size:13px; font-weight:bold;">

                            <tr>

                                <td width='45%'>
                                    <input type="hidden" id="exr_id" name="id">
                                    <input type="hidden" id="exr_id_examen" name="id_examen">

                                    <input type="hidden" id="exr_valor" name="valor">
                                    <select name="id_reactivo" id="exr_id_reactivo" required>
                                        <option value="">Seleccione reactivo</option>
                                        <?php foreach ($lista_reactivos as $reactivo) { ?>
                                            <option value="<?= $reactivo[0] ?>"><?= $reactivo[1] ?></option>
                                        <?php } ?>
                                    </select>

                                </td>
                                <td width='43%'>
                                    <input id="exr_cantidad" name="cantidad" required type='number' class="form-control" placeholder="Ingrese cantidad">

                                </td>
                                <td width='2%'><span> </span></td>
                                <td width='10%'>
                                    <button class="btn btn-white btn-info btn-bold  " type="submit">
                                        <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>Añadir</button>
                                </td>


                            </tr>

                        </table>
                    </form>
                    <br>
                    <div class="tabla-scroll">
                        <table wdith="100%" id="" class="table table-responsive table-bordered table-striped text-left">
                            <thead class="">

                                <th width="">N°</th>
                                <th>Nombre</th>
                                <th>Cant.</th>
                                <th></th>

                            </thead>
                            <tbody id="lista_detalles">

                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="modal-footer">
                    
                    <button class="btn btn-white btn-info btn-bold  " type="reset" data-dismiss="modal">
                        <i class="ace-icon fa fa-times red2"></i>Cerrar</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script src='js/log_reactivos_examen.js'></script>




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