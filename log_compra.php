<div class="page-header" style="background-color:#EFF3F8; margin:0">
    <h1><i class="menu-icon"><img src="imagenes/grupo_user.png" style="border:0;" height="25" width="25"></i>
        <span id="Titulo" style="font-size:13px; font-weight:bold">Proveedores</span>

    </h1>

</div>
<?php
require_once('cado/ClaseLogistica.php');

$olog = new Logistica();
$lista_categorias = $olog->ListarCategoriaProducto("", 0, 1000);

?>

<input type="hidden" id="IdFilaUsu" />
<input type="hidden" id="idvalor" />
<div class="bodycontainer scrollable">

    <table class="table table-responsive table-bordered table-striped text-left" style="margin:0">
        <thead>
            <tr>
                <th width="">N°</th>
                <th>Doc.</th>
                <th>N° Doc.</th>
                <th>Fecha</th>

                <th>Usuario</th>
                <th>Proveedor</th>
                <th>Afec.</th>
                <th>Sin IGV</th>
                <th>IGV %</th>
                <th>IGV</th>
                <th>Total</th>
                <th>Cancel.</th>
                <th>Dias</th>
                <th>Det.</th>

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
            
        </tr>
    </table>
</div>


<!--Modal Registrar -->
<div id="ModalRegistrar" class="modal fade text-left" role="dialog">
        <form id="formRegistrar">
            <div class="modal-dialog " style="width: 85%;">
                <div class="modal-content">
                    <div class="modal-header ">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="color:#030"> <img src="imagenes/grupo_user.png" height="30" width="30" />
                        &nbsp; DETALLES DE COMPRA</h4>


                    </div>
                    <div id='' class="modal-body">

                        <table class="table table-responsive table-bordered table-striped text-left ">
                            <thead class='bg-secondary text-white'>
                                <th>N°</th>
                                <th>N° orden</th>
                                <th>Producto</th>
                                <th>Bon.</th>
                                <th>Venci.</th>
                                <th>Lote</th>
                                <th>Cant.</th>
                                <th>Precio</th>
                                <th>Monto IGV</th>
                                <th>Subtotal</th>
                                <th>Prec. ant.</th>
                            </thead>
                            <tbody id="detalles"></tbody>
                        </table>

                    </div>
                    <div class="modal-footer">
                        
                        <button class="btn btn-white btn-info btn-bold " type="reset" data-dismiss="modal">
                            <i class="ace-icon fa fa-times red2"></i>Cancelar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

<script src='js/log_compra.js'></script>




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