<div class="page-header" style="background-color:#EFF3F8; margin:0">
    <h1><i class="menu-icon"><img src="imagenes/grupo_user.png" style="border:0;" height="25" width="25"></i>
        <span id="Titulo" style="font-size:13px; font-weight:bold">PRODUCTOS</span>

    </h1>

</div>
<?php 
require_once('cado/ClaseLogistica.php');

$olog = new Logistica();
$lista_categorias = $olog->ListarCategoriaProducto("", 0, 1000);
$lista_unidades = $olog->ListarUnidades();


?>

<input type="hidden" id="IdFilaUsu" />
<input type="hidden" id="idvalor" />
<div class="bodycontainer scrollable">

    <table class="table table-responsive table-bordered table-striped text-left" style="margin:0">
        <thead>
            <tr>
                <th>N°</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Unid.</th>
                <th>Min.</th>
                <th>Máx.</th>
                
                <th>Tipo</th>
                <th>Fraccion</th>
                <th>Cant.</th>
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
                    <input type="text" id="buscar" placeholder=" Buscar " class="form-control" onkeyup="javascript:Listar(1)" autocomplete="off" />
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
                <h4 class="modal-title">Eliminar producto</h4>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de eliminar esta producto?</p>
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
                        &nbsp; REGISTRAR PRODUCTO</h4>

                </div>
                <div class="modal-body">

                    <table width="100%" style="font-size:13px; font-weight:bold;">

                        <tr>

                            <td width="50%"><b>Nombre</b><br>
                                <input type="hidden" id="pro_id" name="id">
                                <input type="hidden" id="pro_valor" name="valor">
                                <input id="pro_nombre" name="nombre" required class="form-control"></td>
                            <td>&nbsp;&nbsp;</td>

                            <td><b>Unidad</b><br>


                                <select name="unidad" required class="form-control" id="pro_unidad">
                                    <option value="">Seleccione</option>
                                    <?php foreach ($lista_unidades as $s) { ?>

                                        <option value="<?= $s['id'] ?>"><?= $s['codigo'] . ' - ' . $s['descripcion'] ?></option>
                                    <?php } ?>

                                </select>

                            </td>


                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>


                        <tr>

                            <td width="50%"><b>Tipo</b><br>

                                <select id="pro_tipo" name="tipo_producto" required class="form-control">
                                    <option value=""> Seleccione </option>
                                    <option value="0"> Producto</option>
                                    <option value="1"> Servicio</option>
                                </select>
                            </td>
                            <td>&nbsp;&nbsp;</td>
                            <td><b>Categoría</b><br>

                                <select name="categoria" required class="form-control" id="pro_categoria">
                                    <option value="">Seleccione</option>
                                    <?php foreach ($lista_categorias as $s) { ?>

                                        <option value="<?= $s['id'] ?>"><?= $s['nombre'] ?></option>
                                    <?php } ?>

                                </select></td>
                        </tr>


                        <tr>
                            <td>&nbsp;</td>
                        </tr>


                        <tr>
                            <td><b>Stock máximo</b><br>

                                <input id="pro_stock_max" name="stock_max" required class="form-control"></td>

                            <td>&nbsp;&nbsp;</td>
                            <td><b>Stock mínimo</b><br>

                                <input id="pro_stock_min" name="stock_min" required class="form-control"></td>

                        </tr>


                        <tr>
                            <td>&nbsp;</td>
                        </tr>


                        <tr id='tr_especial'>


                        <tr>
                            <td><b>Cantidad fracción</b><br>

                                <input type="number" id="pro_cantidad_fraccion" name="cantidad_fraccion" class="form-control numero"></td>

                            <td>&nbsp;&nbsp;</td>
                            <td width="100%" colspan="3"><b>Producto fracción</b><br>
                                <select id="pro_producto_fraccion" name="id_producto_fraccion" class="form-control " style="width: 95%">
                                    <option value="">Seleccione producto</option>

                                </select>
                            </td>

                        </tr>

                        </tr>


                    </table>

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

<script src='js/log_producto.js'></script>




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