var $producto = $("#producto").select2({ dropdownAutoWidth: true, width: '100%' });
function ReporteExcel() {
    if ($("#producto").val() == '') {
        swal("Seleccione un producto", "", "warning")
        return false;

    }
    window.location = 'reporte_excel_kardex.php?producto=' + $("#producto").val()
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
                    entrada = "<td width='8%'align='right'>S/. " + parseFloat(val[5]).toFixed(2) + "</td>" + "<td width='10%'align='right'>S/. " + parseFloat(val[6]).toFixed(2) + "</td>";
                } else {
                    entrada = "<td width='8%'>" + parseFloat(val[5]).toFixed(2) + "</td>" + "<td width='10%'>" + parseFloat(val[6]).toFixed(2) + "</td>";
                }

                if (val[9] != '') {
                    salida = "<td width='8%' align='right'>S/." + parseFloat(val[8]).toFixed(2) + "</td>" + "<td width='10%'align='right'>S/.  " + parseFloat(val[9]).toFixed(2) + "</td>";
                } else {
                    salida = "<td width='8%'>" + parseFloat(val[8]).toFixed(2) + "</td>" + "<td width='10%'>" + parseFloat(val[9]).toFixed(2) + "</td>"

                }

                $("#lista").append("<tr>"
                    + "<td width='10%'>" + val[0] + "</td>"
                    + "<td width='5%' align='right'>" + val[1] + "</td>"
                    + "<td width='8%'>" + val[2] + "</td>"
                    + "<td width='5%' align='right'>" + val[3] + "</td>"
                    + "<td width='5%' align='right'>" + val[4] + "</td>"
                    + entrada
                    + "<td width='5%' align='right'>" + val[7] + "</td>"
                    + salida
                    + "<td width='5%' align='right'>" + val[10] + "</td>"
                    + "<td width='10%' align='right'>S/. " + parseFloat(val[11]).toFixed(2) + "</td>"
                    + "<td width='10%' align='right'>S/.  " + parseFloat(val[12]).toFixed(2) + "</td>"
                    + "</tr>");

            })


        },

        error: function (e) {
            console.log(e)
            $("#paginacion").html("");
            $("#lista").html("<td class='text-center' colspan='12'>No se encontraron resultados<td></tr>");
        }
    });
}



