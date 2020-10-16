var $producto = $("#producto").select2({ dropdownAutoWidth: true, width: '97%' });
var $almacen_select2 = $("#id_cmb_alm").select2({
    dropdownAutoWidth: true,
    width: '97%'
});
var $sucursal_select2 = $("#id_cmb_suc").select2({
    dropdownAutoWidth: true,
    width: '97%'
});
function ReporteExcel() {
    if ($("#producto").val() == '') {
        swal("Seleccione un producto", "", "warning")
        return false;

    }
    if ($("#id_cmb_alm").val() == '') {
        swal("Seleccione un almacén", "", "warning")
        return false;

    }
    window.location = 'reporte_excel_kardex_almacen.php?producto=' + $("#producto").val()+ "&almacen="+ $("#id_cmb_alm").val() 
}

Listar(1);

function ChangeProducto() {

    setTimeout(function () {
        $("#id_cmb_suc").select2('open');

    }, 200);

}
function ChangeSucursal() {

    //$("#id_cmb_alm").val("").trigger('change');
    $("#id_cmb_alm").html("");

    $.post("controlador/Clogistica.php?op=LISTAR_ALMxSUC", {
        sucursal: $("#id_cmb_suc").val(),

    }, function (data) {

        $("#id_cmb_alm").html(data);

    });

    setTimeout(function () {
        $("#id_cmb_alm").select2('open');

    }, 200);

}

function Listar(pagina) {

    //  $("#lista").html("<tr><td class='text-center' colspan='5'>Cargando ...<td></tr>");
    //    $("#paginacion").html("<span class='btn btn-info'>Anterior</span> <span class='btn btn-success'>1</span> <span class='btn btn-info'>Siguiente</span>")

    $.ajax({

        url: 'controlador/Clogistica.php?op=LIS_KARDEX_ALM&producto=' + $("#producto").val() + "&almacen="+ $("#id_cmb_alm").val() +"&pagina=" + pagina,
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
                    salida = "<td width='8%' align='right'>S/." + parseFloat(val[8]).toFixed(2) + "</td>" + "<td width='10%'align='right'>S/.  " +parseFloat(val[9]).toFixed(2) + "</td>";
                } else {
                    salida = "<td width='8%'>" + parseFloat(val[8]).toFixed(2) + "</td>" + "<td width='10%'>" +parseFloat(val[9]).toFixed(2) + "</td>"

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

            $.ajax({

                url: 'controlador/Clogistica.php?op=PAG_KARDEX_ALM&producto=' + $("#producto").val()+ "&almacen="+ $("#id_cmb_alm").val() ,
                type: "POST",
                dataType: "json",

                success: function (cont) {

                    $("#paginacion").html("");
                    if (cont == 0) {
                        $("#lista").html("<td class='text-center' colspan='12'>No se encontraron resultados</tr>");
                        return false
                    }
                    if (pagina > 1) {
                        $("#paginacion").append("<span class='btn btn-xs ' onclick='Listar(" + (pagina - 1) + ")' ><b><icon class='fa fa-chevron-left'></icon></span>");

                    }

                    for (var i = 1; i <= cont; i++) {

                        $("#paginacion").append("<span class='btn btn-xs ' id='pagina" + i + "' onclick='Listar(" + i + ")' >" + i + "</span>");

                    }

                    if (pagina < cont) {
                        $("#paginacion").append("<span class='btn btn-xs 'onclick='Listar(" + (pagina + 1) + ")'><b><icon class=' fa fa-chevron-right'></icon></span>");

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



