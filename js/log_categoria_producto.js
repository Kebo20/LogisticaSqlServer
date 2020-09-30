
Listar(1);
function Listar(pagina) {

    //  $("#lista").html("<tr><td class='text-center' colspan='5'>Cargando ...<td></tr>");
    //    $("#paginacion").html("<span class='btn btn-info'>Anterior</span> <span class='btn btn-success'>1</span> <span class='btn btn-info'>Siguiente</span>")

    $.ajax({

        url: 'controlador/Clogistica.php?op=LIS_CAT&q=' + $("#buscar").val() + "&pagina=" + pagina,
        type: "POST",
        dataType: "json",

        success: function (data) {
            console.log(data)
            $("#lista").html("");


            $.each(data, function (key, val) {

                $("#lista").append("<tr>"
                +"<td width='10%'>" + val[0] + "</td>"
               +"<td width='70%'>" + val[1] + "</td>"
               +"<td width='20%'>" + val[2] + "</td>"
               +"</tr>");
                

            })

            $.ajax({

                url: 'controlador/Clogistica.php?op=PAG_CAT&q=' + $("#buscar").val(),
                type: "POST",
                dataType: "json",

                success: function (cont) {

                    $("#paginacion").html("");
                    if (cont == 0) {
                        $("#lista").html("<td class='text-center' colspan='3'>No se encontraron resultados</tr>");
                        return false
                    }
                    if (pagina > 1) {
                        $("#paginacion").append("<span class='btn btn-icon ' onclick='Listar(" + (pagina - 1) + ")' ><b><icon class='ft-chevron-left'></icon></span>");

                    }

                    for (var i = 1; i <= cont; i++) {

                        $("#paginacion").append("<span class='btn btn-icon ' id='pagina" + i + "' onclick='Listar(" + i + ")' >" + i + "</span>");

                    }

                    if (pagina < cont) {
                        $("#paginacion").append("<span class='btn btn-icon 'onclick='Listar(" + (pagina + 1) + ")'><b><icon class=' ft-chevron-right'></icon></span>");

                    }

                    $("#pagina" + pagina).removeAttr("class");
                    $("#pagina" + pagina).attr("class", "btn btn-dark");
                },

                error: function (e) {
                    console.log(e)
                    $("#lista").html("<td class='text-center' colspan='3'>No se encontraron resultados</tr>");

                    $("#paginacion").html("");
                }
            });


        },

        error: function (e) {
            console.log(e)
            $("#paginacion").html("");
            $("#lista").html("<td class='text-center' colspan='3'>No se encontraron resultados<td></tr>");
        }
    });
}


function abrirModal(){
    $("#cat_valor").val("1");
    $("#ModalRegistrar").modal("show");
    $("#cat_nombre").val("")

    $("#cat_nombre").focus()
    
}

function editar($id) {
    $.post("controlador/Clogistica.php?op=LLENAR_CAT", { id: $id }, function (data) {
        console.log(data);

        $("#cat_id").val(data.id);
        $("#cat_nombre").val(data.nombre);
        $("#cat_valor").val("2");



        $("#ModalRegistrar").modal("show");

    }, "JSON")



}

function eliminar(id) {
    $("#ModalEliminar").modal("show");
    $("#eliminar").val(id);
}



$("#formRegistrar").on("submit", function (e) {
    e.preventDefault();


    $.ajax({

        url: 'controlador/Clogistica.php?op=NUEVO_CAT',
        type: "POST",
        data: $(this).serialize(),

        success: function (data) {
            $('#ModalRegistrar').modal('hide');
            Listar(1);
            console.log(data);
            $('#formRegistrar').trigger("reset");
            if (data == 1) {

                swal("Datos registrados Correctamente ..", "Felicitaciones", "success");

                return false;
            } else
                if (data == 0) {
                    swal("Datos no registrados Correctamente ..", "Error", "error");
                    return false;
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

        url: 'controlador/Clogistica.php?op=ELIMINAR_CAT',
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