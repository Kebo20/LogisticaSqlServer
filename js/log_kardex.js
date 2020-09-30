var $producto = $("#producto").select2({ dropdownAutoWidth: true, width: '100%' });
function ReporteExcel() {
    if ($("#producto").val() == '') {
        swal("Seleccione un producto", "", "warning")
        return false;

    }
    window.location = 'reporte_excel.php?producto=' + $("#producto").val()
}

Listar(1);
function Listar(pagina) {

    //  $("#lista").html("<tr><td class='text-center' colspan='5'>Cargando ...<td></tr>");
    //    $("#paginacion").html("<span class='btn btn-info'>Anterior</span> <span class='btn btn-success'>1</span> <span class='btn btn-info'>Siguiente</span>")

    $.ajax({

        url: 'controlador/Clogistica.php?op=LIS_KARDEX&producto=' + $("#producto").val() + "&pagina=" + pagina,
        type: "POST",
        dataType: "json",

        success: function (data) {
            console.log(data)
            $("#lista").html("");


            $.each(data, function (key, val) {

                if (val[4] != '') {
                    entrada = "<td width='8%'align='right'>S/. " + val[5] + "</td>" + "<td width='10%'align='right'>S/. " + val[6] + "</td>";
                } else {
                    entrada = "<td width='8%'>" + val[5] + "</td>" + "<td width='10%'>" + val[6] + "</td>";
                }

                if (val[9] != '') {
                    salida = "<td width='8%' align='right'>S/." + val[8] + "</td>" + "<td width='10%'align='right'>S/.  " + val[9] + "</td>";
                } else {
                    salida = "<td width='8%'>" + val[8] + "</td>" + "<td width='10%'>" + val[9] + "</td>"

                }

                $("#lista").append("<tr>"
                    + "<td width='10%'>" + val[0] + "</td>"
                    + "<td width='5%' align='right'>" + val[1] + "</td>"
                    + "<td width='8%'>" + val[2] + "</td>"
                    + "<td width='5%' align='right'>" + val[3] + "</td>"
                    + "<td width='5%' >" + val[4] + "</td>"
                    + entrada
                    + "<td width='5%'>" + val[7] + "</td>"
                    + salida
                    + "<td width='5%'>" + val[10] + "</td>"
                    + "<td width='10%' align='right'>S/. " + val[11] + "</td>"
                    + "<td width='10%' align='right'>S/.  " + val[12] + "</td>"
                    + "</tr>");

            })

            $.ajax({

                url: 'controlador/Clogistica.php?op=PAG_KARDEX&producto=' + $("#producto").val(),
                type: "POST",
                dataType: "json",

                success: function (cont) {

                    $("#paginacion").html("");
                    if (cont == 0) {
                        $("#lista").html("<td class='text-center' colspan='12'>No se encontraron resultados</tr>");
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
                    $("#lista").html("<td class='text-center' colspan='12'>No se encontraron resultados</tr>");

                    $("#paginacion").html("");
                }
            });


        },

        error: function (e) {
            console.log(e)
            $("#paginacion").html("");
            $("#lista").html("<td class='text-center' colspan='12'>No se encontraron resultados<td></tr>");
        }
    });
}



