var $categoria = $("#pro_categoria").select2({ dropdownAutoWidth: true, width: '100%' });
var $unidad = $("#pro_unidad").select2({ dropdownAutoWidth: true, width: '100%' });

var $id_producto_fraccion = $("#pro_producto_fraccion").select2({ dropdownAutoWidth: true, width: '100%' });

var $tipo = $("#pro_tipo").select2({ dropdownAutoWidth: true, width: '100%' });
ListarProductosFraccion()
Listar(1);
function Listar(pagina) {

    //  $("#lista").html("<tr><td class='text-center' colspan='5'>Cargando ...<td></tr>");
    //    $("#paginacion").html("<span class='btn btn-info'>Anterior</span> <span class='btn btn-success'>1</span> <span class='btn btn-info'>Siguiente</span>")

    $.ajax({

        url: 'controlador/Clogistica.php?op=LIS_PRO&q=' + $("#buscar").val() + "&pagina=" + pagina,
        type: "POST",
        dataType: "json",
        contetnType:"application_json; charset=utf-8",

        success: function (data) {
            $("#lista").html("");


            $.each(data, function (key, val) {
            
                $("#lista").append("<tr class='todo-item'>"
                +"<td width='5%'>" + val[0] + "</td>"
                +"<td width='25%'>" + val[1] + "</td>"
                +"<td width='15%'>" + val[2] + "</td>"
                +"<td width='10%'>" + val[3] + "</td>"
                +"<td width='5%'>" + val[4] + "</td>"
                +"<td width='5%'>" + val[5] + "</td>"
                +"<td width='10%'>" + val[6] + "</td>"
                +"<td width='10%'>" + val[7] + "</td>"
                +"<td width='5%'>" + val[8] + "</td>"
                +"<td width='5%'>" + val[9] + "</td>"
                +"</tr>");


            })

            $.ajax({

                url: 'controlador/Clogistica.php?op=PAG_PRO&q=' + $("#buscar").val(),
                type: "POST",
                dataType: "json",

                success: function (cont) {

                    $("#paginacion").html("");
                    if (cont == 0) {
                        $("#lista").html("<td class='text-center' colspan='10'>No se encontraron resultados</tr>");
                        return false
                    }
                    if (pagina > 1) {
                        $("#paginacion").append("<span class='btn btn-xs ' onclick='Listar(" + (pagina - 1) + ")' ><b><icon class='fa fa-chevron-left'></icon></span>");

                    }

                    for (var i = 1; i <= cont; i++) {

                        $("#paginacion").append("<span class='btn btn-xs ' id='pagina" + i + "' onclick='Listar(" + i + ")' >" + i + "</span>");

                    }

                    if (pagina < cont) {
                        $("#paginacion").append("<span class='btn btn-xs 'onclick='Listar(" + (pagina + 1) + ")'><b><icon class='fa fa-chevron-right'></icon></span>");

                    }

                    $("#pagina" + pagina).removeAttr("class");
                    $("#pagina" + pagina).attr("class", "btn btn-xs btn-info");
                },

                error: function (e) {
                    console.log(e)
                    $("#lista").html("<td class='text-center' colspan='10'>No se encontraron resultados</tr>");

                    $("#paginacion").html("");
                }
            });


        },

        error: function (e) {
            console.log(e)
            $("#paginacion").html("");
            $("#lista").html("<td class='text-center' colspan='10'>No se encontraron resultados<td></tr>");
        }
    });
}



function abrirModal() {
    ListarProductosFraccion()
    $("#pro_valor").val("1");
    $("#pro_nombre,#pro_stock_min,#pro_stock_max,#pro_cantidad_fraccion").val("");
    $categoria.val("").trigger("change");
    $tipo.val("").trigger("change");
    $id_producto_fraccion.val("").trigger("change");
    $unidad.val("").trigger("change");


    $("#ModalRegistrar").modal("show");
    $("#pro_nombre").focus()
}

function ListarProductosFraccion() {


    $.post("controlador/Clogistica.php?op=LISTAR_PRO_FRACCION", {
    }, function (data) {

        $("#pro_producto_fraccion").html(data);
        console.log(data)


    });

}


function editar($id) {
    $.post("controlador/Clogistica.php?op=LLENAR_PRO", { id: $id }, function (data) {
        console.log(data);

        ListarProductosFraccion()

        $("#pro_id").val(data.id);
        $("#pro_nombre").val(data.nombre);
        $("#pro_stock_min").val(data.stock_min);
        $("#pro_stock_max").val(data.stock_max);
        $("#pro_cantidad_fraccion").val(data.cantidad_fraccion);
        $tipo.val(data.tipo_producto).trigger("change");
        $categoria.val(data.id_categoria).trigger("change");
        $unidad.val(data.id_unidad).trigger("change");

        $("#pro_valor").val("2");


        setTimeout(function () {
            if (data.id_producto_fraccion == 0) {
                $id_producto_fraccion.val('').trigger("change");
            } else {
                $id_producto_fraccion.val(data.id_producto_fraccion).trigger("change");

            }
            $("#ModalRegistrar").modal("show");
        }, 300);

    }, "JSON")



}

function eliminar(id) {
    $("#ModalEliminar").modal("show");
    $("#eliminar").val(id);
}



$("#formRegistrar").on("submit", function (e) {
    e.preventDefault();

    if ($('#pro_tipo').val() == '1' && $('#pro_producto_fraccion').val() != '') {//servicio
        swal("Servicio no pude fraccionarse ..", "", "warning");

        return false;
    }


    if ($('#pro_producto_fraccion').val() == $('#pro_id').val() && $('#pro_id').val() != '' && $("#pro_valor").val() == '2') {

        swal("Error", "Producto fracción no puede ser igual ..", "error");
        return false;
    }
    if ($('#pro_producto_fraccion').val() != '' && ($("#pro_cantidad_fraccion").val() == '' || $("#pro_cantidad_fraccion").val() == '0')) {

        swal("Ingrese una cantidad ..", "", "warning");
        return false;
    }
    if (($('#pro_producto_fraccion').val() == '' || $('#pro_producto_fraccion').val() == '0') && ($("#pro_cantidad_fraccion").val() != '' && $("#pro_cantidad_fraccion").val() != '0')) {

        swal("Seleccione un producto ..", "", "warning");
        return false;
    }
    $.ajax({

        url: 'controlador/Clogistica.php?op=NUEVO_PRO',
        type: "POST",
        data: $(this).serialize(),

        success: function (data) {
            $('#ModalRegistrar').modal('hide');
            Listar(1);
            console.log(data);
            $('#formRegistrar').trigger("reset");
            $("#pro_nombre,#pro_stock_min,#pro_stock_max,#pro_cantidad_fraccion").val("");
            $categoria.val("").trigger("change");
            $tipo.val("").trigger("change");
            $id_producto_fraccion.val("").trigger("change");
            $unidad.val("").trigger("change");


            if (data == 1) {

                swal("Datos registrados Correctamente ..", "Felicitaciones", "success");

                return false;
            } else
                if (data == 0) {
                    swal("Datos no registrados Correctamente ..", "Error", "error");
                    return false;
                } else if (data == 3) {
                    swal("Error", "El producto ya es fracción de otro ", "error");
                } else if (data == 4) {
                    swal("Error", "Producto fracción no puede ser igual", "error");

                } else if (data == 5) {
                    swal("Error", "Producto fracción ya fraccionado", "error");

                } else if (data == 6) {
                    swal("Error", "Producto fracción ya utilizado", "error");

                }  else if (data == 2) {
                    swal("Error", "Nombre ya utilizado", "error");

                } else {
                    swal("Datos no registrados Correctamente ..", "Error", "error");
                }

        },
        error: function (e) {
            console.log(e);
            swal("Datos no registrados Correctamente ..", "Error", "error");
        }
    });
});


$("#formEliminar").on("submit", function (e) {
    e.preventDefault();

    $.ajax({

        url: 'controlador/Clogistica.php?op=ELIMINAR_PRO',
        type: "POST",
        data: { id: $("#eliminar").val() },

        success: function (data) {
            $('#ModalEliminar').modal('hide');
            Listar(1);
            console.log(data);

            if (data == 1) {

                swal("Datos eliminados Correctamente ..", "Felicitaciones", "success");

                return false;
            } else
                if (data == 0) {
                    swal("Datos no eliminados Correctamente ..", "Error", "error");
                    return false;
                } else {
                    swal("Datos no eliminados Correctamente ..", "Error", "error");
                }

        },
        error: function (e) {
            console.log(e);
            swal("Datos no eliminados Correctamente ..", "Error", "error");
        }
    });
});