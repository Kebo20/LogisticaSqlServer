var $reactivos = $("#ca_id_reactivo").select2({ dropdownAutoWidth: true, width: '100%' });
var $maquinas = $("#ca_id_maquina").select2({ dropdownAutoWidth: true, width: '100%' });


Listar(1);
function Listar(pagina) {

    //  $("#lista").html("<tr><td class='text-center' colspan='5'>Cargando ...<td></tr>");
    //    $("#paginacion").html("<span class='btn btn-info'>Anterior</span> <span class='btn btn-success'>1</span> <span class='btn btn-info'>Siguiente</span>")

    $.ajax({

        url: 'controlador/Clogistica.php?op=LIS_CALIBRACION&fecha=' + $("#fecha-buscar").val() + "&pagina=" + pagina,
        type: "POST",
        dataType: "json",

        success: function (data) {
            console.log(data)
            $("#lista").html("");


            $.each(data, function (key, val) {

                $("#lista").append("<tr>"
                +"<td width='10%'>" + val[0] + "</td>"
                +"<td width='20%'>" + val[1] + "</td>"
                +"<td width='20%'>" + val[2] + "</td>"
                +"<td width='20%'>" + val[3] + "</td>"

                +"<td width='20%'>" + val[4] + "</td>"
                +"<td width='10%'>" + val[5] + "</td>"



                +"</tr>");

            })

            $.ajax({

                url: 'controlador/Clogistica.php?op=PAG_CALIBRACION&fecha=' + $("#fecha-buscar").val() + "&pagina=" + pagina,
                type: "POST",
                dataType: "json",

                success: function (cont) {
                    console.log(cont)
                    $("#paginacion").html("");
                    if (cont == 0) {
                        $("#lista").html("<td class='text-center' colspan='6'>No se encontraron resultados</tr>");
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
                    $("#lista").html("<td class='text-center' colspan='6'>No se encontraron resultados</tr>");

                    $("#paginacion").html("");
                }
            });


        },

        error: function (e) {
            console.log(e)
            $("#paginacion").html("");
            $("#lista").html("<td class='text-center' colspan='6'>No se encontraron resultados<td></tr>");
        }
    });
}


function abrirModal() {
    $("#ca_valor").val("1");
    $("#ModalRegistrar").modal("show");
    $("#ca_fecha,#ca_cantidad,#ca_id").val("");
    $reactivos.val("").change();
    $maquinas.val("").change();


    $("#ca_fecha").focus()

}

function editar(id, fecha,cantidad,id_reactivo,id_maquina) {
    $("#ca_valor").val("2");

    $("#ca_id").val(id);
    $("#ca_fecha").val(fecha);
    $("#ca_cantidad").val(cantidad);
    $("#ca_id_reactivo").val(id_reactivo).change();
    $("#ca_id_maquina").val(id_maquina).change();

    $("#ModalRegistrar").modal("show");




}

function eliminar(id) {
    $("#ModalEliminar").modal("show");
    $("#eliminar").val(id);
}



$("#formRegistrar").on("submit", function (e) {
    e.preventDefault();


    $.ajax({

        url: 'controlador/Clogistica.php?op=NUEVO_CALIBRACION',
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

        url: 'controlador/Clogistica.php?op=ELIMINAR_CALIBRACION',
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