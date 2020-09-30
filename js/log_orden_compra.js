$(document).ready(function() {

    var $sucursal = $("#OCid_cmb_suc").select2({
        dropdownAutoWidth: true,
        width: '97%'
    });
    var $categoria = $("#OCcategoria").select2({
        dropdownAutoWidth: true,
        width: '97%'
    });
    var $buscar_sucursal = $("#OCbuscar-id_cmb_suc").select2({
        dropdownAutoWidth: true,
        width: '97%'
    });

    var $almacen = $("#OCid_cmb_alm").select2({
        dropdownAutoWidth: true,
        width: '97%'
    });
    var $buscar_almacen = $("#OCbuscar-id_cmb_alm").select2({
        dropdownAutoWidth: true,
        width: '97%'
    });

    var $tipo = $("#OCtipo").select2({
        dropdownAutoWidth: true,
        width: '97%'
    });

    var $producto = $("#OCid_cmb_pro").select2({
        dropdownAutoWidth: true,
        width: '97%'
    });

    var $buscar_estado = $("#OCbuscar-estado").select2({
        dropdownAutoWidth: true,
        width: '97%'
    });



    $("#OCid_cmb_suc").focus();



    $('.numero').on("keypress", function() {
        if (event.keyCode > 47 && event.keyCode < 60 || event.keyCode == 46) {

        } else {
            event.preventDefault();
        }

    });

});



//DEZPLAZAR POR FORMULARIO
$("#OCid_cmb_suc").change(function() {
    almacenxsucursal()
    setTimeout(function() {
        $("#OCid_cmb_alm").select2('open');

    }, 100);

});



$("#OCid_cmb_alm").change(function() {

    $("#OCtipo").select2('open');


});

$("#OCtipo").change(function(e) {
    setTimeout(function() {
        $("#OCcategoria").select2('open');
        OCListarProductos()

    }, 100);


});
$("#OCcategoria").change(function(e) {
    setTimeout(function() {
        $("#OCnro").focus();
        OCListarProductos()


    }, 100);


});
$("#OCnro").keypress(function(e) {
    if (e.which == 13) {
        $("#OCfecha").focus();
    }
});

$("#OCfecha").keypress(function(e) {

    if (e.which == 13) {
        $("#OCreferencia").focus()
    }

});



$("#OCreferencia").keypress(function(e) {
    if (e.which == 13) {

        $("#OCid_cmb_pro").select2('open');

    }

});
$("#OCid_cmb_pro").change(function() {

    LlenarStockUnidad()

    setTimeout(function() {
        $("#OCcantidad").focus();
    }, 300);

});
$("#OCcantidad").keypress(function(e) {

    if (e.which == 13) {
        OCAñadirDetalle();
        $("#OCid_cmb_pro").select2('open');
    }
});



$(document).keydown(function(e) {

    if (e.ctrlKey && e.keyCode == 83) {
        e.preventDefault();
        OCguardar();
        setTimeout(OCcancelar, 300);
    }




});


$("#OCbuscar-id_cmb_suc").change(function() {
    setTimeout(function() {
        almacenxsucursal2()
    }, 300);

});




//BOTONES

$("#OCbtn_guardar,#OCbtn_imprimir,#OCbtn_limpiar,#OCbtn_finalizar,#OCbtn_anular").attr("disabled", "true");
$("input,select").attr("disabled", "true");
$("#OCbtn_nuevo").click(function() {
    $("#OCbtn_guardar,input,select").attr("disabled", false);
    $("#OCbtn_buscar,#OCusuario").attr("disabled", "true")
    $("#OCid_cmb_suc").select2('open');


});
$("#OCbtn_guardar").click(function() {
    OCguardar();
    OCcancelar()

});
$("#OCbtn_buscar").click(function() {
    OCListarBuscar();
    $("#OCbtn_nuevo").attr("disabled", "true");
    $(".input").attr("disabled", false);
    $("#OCModal").modal();
});
$("#OCbtn_imprimir").click(function() {

});
$("#OCbtn_limpiar").click(function() {
    OCcancelar()

});
$("#OCbtn_cancelar").click(function() {
    OCcancelar()
    $("#OCbtn_nuevo,#OCbtn_buscar").attr("disabled", false);
    $("#OCbtn_guardar,#OCbtn_imprimir,#OCbtn_limpiar,#OCbtn_finalizar,#OCbtn_anular").attr("disabled", "true");

});
$("#OCbtn_anular").click(function() {

    var $ident = $("#IdFilaOC").val();
    if ($ident == 0) {
        swal("Debe seleccionar un Registro", "Obligatorio", "warning");
        return false;
    }

    $.post("controlador/Clogistica.php?op=ESTADO_ORD_COM", {

        estado: "anulada",
        id: $("#id_OC").val()
    }, function(data) {
        if (data == 1) {
            swal("Correcto", "Orden anulada", "success");
        } else {
            swal("Error", "No se pudo anular la orden", "error");
        }
    });



});
$("#OCbtn_finalizar").click(function() {
    var $ident = $("#IdFilaOC").val();
    if ($ident == 0) {
        swal("Debe seleccionar un Registro", "Obligatorio", "warning");
        return false;
    }

    $.post("controlador/Clogistica.php?op=ESTADO_ORD_COM", {

        estado: "finalizada",
        id: $("#id_OC").val()
    }, function(data) {
        if (data == 1) {
            swal("Correcto", "Orden finalizada", "success");
        } else {
            swal("Error", "No se pudo anular la orden", "error");
        }
    });

});


//DETALLE ORDEN DE COMPRA
var orden_compra = new Array();

function OClistar() {
    $("#IdCuerpoOCD").html("");
    for (var i = 0; i < orden_compra.length; i++) {

        $("#IdCuerpoOCD").append("<tr><td class='text-left'><a class=' text-left' onclick='OCeliminar(" + i + ")'>\n\
<icon class='fa fa-trash'> </icon></a></td><td>" + parseInt(i + 1) + "</td>\n\
<td style='text-align:left;'>" + orden_compra[i].nombre_producto + "</td>\n\
<td style='text-align:left;'> " + orden_compra[i].cantidad + "</td>\n\
<td> " + orden_compra[i].unidad + "</td><td> " + orden_compra[i].despachado + "</td><td> " + orden_compra[i].pendiente + "</td>");
        console.log(orden_compra[i]);
    }
}

function OCAñadirDetalle() {


    if ($("#OCid_cmb_pro").val() == "") {
        swal("Campo requerido", "Seleccione un producto", "warning");
        setTimeout(function() {
            $("#OCid_cmb_pro").select2('open');
        }, 200);
        return false;
    }

    if ($("#OCcantidad").val() == "") {
        swal("Campo requerido", "Inserte una cantidad", "warning");
        $("#OCcantidad").focus();
        return false;
    }

    if ($("#OCunidad").val() == "") {
        swal("Campo requerido", "Inserte una unidad", "warning");
        $("#OCunidad").focus();
        return false;
    }

    var id_producto = $("#OCid_cmb_pro").val();
    var seleccionado = $("#OCid_cmb_pro").val();
    var nombre_producto = $("#OCpro_" + seleccionado).attr("nombre_producto");
    var cantidad = $("#OCcantidad").val();
    var unidad = $("#OCunidad").val();


    for (var i = 0; i < orden_compra.length; i++) {

        if (orden_compra[i].id_producto == id_producto) {
            orden_compra[i].cantidad = parseInt(orden_compra[i].cantidad) + parseInt(cantidad);
            orden_compra[i].pendiente = parseInt(orden_compra[i].pendiente) + parseInt(cantidad);
            OClistar();

            $("#OCcantidad").val("");
            $("#OCunidad").val("");

            setTimeout(function() {
                $("#OCid_cmb_pro").val("").trigger("change");

                $("#OCid_cmb_pro").trigger('chosen:open');
            }, 300);
            return false;
        }
    }

    var detalle = {
        id_producto: id_producto,
        nombre_producto: nombre_producto,
        cantidad: cantidad,
        unidad: unidad,
        despachado: "0",
        pendiente: cantidad
    };
    orden_compra.push(detalle);
    OClistar();
    $("#OCcantidad").val("");
    $("#OCunidad").val("");
    setTimeout(function() {
        $("#OCid_cmb_pro").val("").trigger('chosen:updated');

        $("#OCid_cmb_pro").trigger('select:open');
    }, 300);
}

function OCeliminar(id) {

    orden_compra.splice(id, 1);
    OClistar();
}

// FUNCIONES DEL FORMULARIO


function LlenarStockUnidad() {

    $.post("controlador/Clogistica.php?op=LLENAR_PRO", {
        id: $("#OCid_cmb_pro").val()
    }, function(data) {
        $("#OCunidad").val(data.unidad)
    }, 'JSON');


    $.post("controlador/Clogistica.php?op=LLENAR_PRO", {
        id: $("#OCid_cmb_pro").val()
    }, function(data) {
        $("#OCstock").val(data.stock)
    }, 'JSON');
}

function OCListarProductos() {


    $.post("controlador/Clogistica.php?op=LISTAR_PRO_OC", {
        tipo: $("#OCtipo").val(),
        categoria: $("#OCcategoria").val()
    }, function(data) {
        $("#OCid_cmb_pro").html(data);


    });

}



function almacenxsucursal() {
    $("#OCid_cmb_alm").html("");
    // $('#OCid_cmb_alm').chosen('destroy');
    $.post("controlador/Clogistica.php?op=LISTAR_ALM_GRALxSUC", {
        sucursal: $("#OCid_cmb_suc").val(),

    }, function(data) {

        $("#OCid_cmb_alm").html(data);
        console.log(data);

    });
}


function OCguardar() {

    if (orden_compra.length == 0) {
        swal("Vacío", "Inserte datos", "warning");
        return false;
    }
    if ($("#OCid_cmb_suc").val() == "") {
        swal("Campo requerido", "Seleccione una sucursal", "warning");
        setTimeout(function() {
            $("#OCid_cmb_suc").select2('open');
        }, 200);
        return false;
    }
    if ($("#OCid_cmb_alm").val() == "") {
        swal("Campo requerido", "Seleccione un almacén", "warning");
        setTimeout(function() {
            $("#OCid_cmb_alm").select2('open');
        }, 200);
        return false;
    }

    if ($("#OCtipo").val() == "") {
        swal("Campo requerido", "Seleccione un tipo de orden", "warning");
        setTimeout(function() {
            $("#OCtipo").select2('open');
        }, 200);
        return false;
    }

    if ($("#OCnro").val() == "") {
        swal("Campo requerido", "Inserte fecha", "warning");
        $("#OCnro").focus();
        return false;
    }

    if ($("#OCfecha").val() == "") {
        swal("Campo requerido", "Inserte fecha", "warning");
        $("#OCfecha").focus();
        return false;
    }


    $.post("controlador/Clogistica.php?op=NUEVO_ORD_COM", {


        orden_compra: JSON.stringify(orden_compra),
        fecha: $("#OCfecha").val(),
        id: $("#id_OC").val(),
        referencia: $("#OCreferencia").val(),
        nro: $("#OCnro").val(),
        almacen: $("#OCid_cmb_alm").val(),
        sucursal: $("#OCid_cmb_suc").val(),
        tipo: $("#OCtipo").val(),
        valor: $("#OCvalor").val()

    }, function(data) {

        if (data == 1) {
            swal("Correcto", "Orden registrada correctamente", "success");
        } else {
            swal("Error", "Orden no registrada ", "error");
        }
        $("#OCbtn_nuevo").removeAttr("disabled");
        $("#OCbtn_limpiar").removeAttr("disabled");
        $("#OCvalor").val("1")
        console.log(data);
    });

    $("#OCbtn_guardar,#OCbtn_imprimir,#OCbtn_limpiar,#OCbtn_finalizar,#OCbtn_anular,.input").attr("disabled", "true");
    $("#OCbtn_buscar").attr("disabled", false);
}


function OCcancelar() {
    orden_compra = new Array();
    $("#OCnro").val("");
    $("#OCid_cmb_suc").val("").trigger('change');


    $("#OCreferencia").val("");
    $("#OCfecha").val("");

    $("#OCtipo").val("").trigger('change');

    $("#OCcantidad").val("");
    $("#OCunidad").val("");
    $("#OCvalor").val("1")
    setTimeout(function() {
        $("#OCbtn_guardar,#OCbtn_imprimir,#OCbtn_limpiar,#OCbtn_finalizar,#OCbtn_anular").attr("disabled", "true");
        $(".input").attr("disabled", "true");

    }, 100);

    OClistar();
}

function PintarFilaOC($id) {
    var $idfilaanterior = $("#IdFilaOC").val()

    var $par = $idfilaanterior.split('_')
    var $par_int = parseInt($par[1]);
    // alert($par_int)
    $("#" + $idfilaanterior).css("background-color","white")
    $("#" + $idfilaanterior).css("color","black")
    if ($par_int % 2 == 0) {
        // alert("hola")
        $("#" + $idfilaanterior).css({
            //"background-color": "#f5f5f5",
            "background-color": "#FFFFFF",
            "color": "#000000"
        });
    } else {
        $("#" + $idfilaanterior).css({
            "background-color": "#FFFFFF",
            "color": "#000000"
        });
    }
    //alert($id);alert($idfilaanterior)
    /*$("#" + $id).css({
        "background-color": "darkgrey",
        "color": "#FFFFFF"
    });*/
    $("#" + $id).css("background-color","#6FA0B9")
    $("#" + $id).css("color","white")
    $("#IdFilaOC").val($id);

}



//FUNCIONES MODAL
function OCListarBuscar() {
    var $fecha = $("#OCbuscar-fecha").val();
    var $estado = $("#OCbuscar-estado").val();
    var $nro = $("#OCbuscar-nro_orden").val();
    var $almacen = $("#OCbuscar-id_cmb_alm").val();
    $.post('controlador/Clogistica.php?op=LIS_ORD_COM', {

            fecha: $fecha,
            estado: $estado,
            nro: $nro,
            almacen: $almacen
        },
        function(data) {
            $("#IdCuerpoOCbuscar").html(data);
            $("#IdFilaOC").val(0);
        });
}

function almacenxsucursal2() {
    $("#OCbuscar-id_cmb_alm").html("");
    $.post("controlador/Clogistica.php?op=LISTAR_ALM_GRALxSUC", {
        sucursal: $("#OCbuscar-id_cmb_suc").val(),
    }, function(data) {

        $("#OCbuscar-id_cmb_alm").html(data);
        // console.log(data);

    });
}

function OCLlenarDatos() {
    $("#OCbtn_guardar,#OCbtn_imprimir,#OCbtn_limpiar,#OCbtn_finalizar,#OCbtn_anular").attr("disabled", false);

    $("#OCvalor").val(2);
    var $ident = $("#IdFilaOC").val();
    var $id = $("#" + $ident).attr("idOC");
    if ($ident == 0) {
        swal("Debe seleccionar un Registro", "Obligatorio", "warning");
        return false;
    }
    $.post("controlador/Clogistica.php?op=LLENAR_ORD_COM", {

        id: $id
    }, function(data) {
        console.log(data);
        /*$.blockUI({
            css: {
                backgroundColor: 'white',
                color: 'darkslategray'
            },
            message: '<h1>Espere...</h1>'
        });
        setTimeout($.unblockUI, 1500);*/

        $("#OCvalor").val("2");
        $("#id_OC").val(data.id);
        $("#OCnro").val(data.numero);
        $("#OCfecha").val(data.fecha);
        $("#OCreferencia").val(data.referencia);
        $("#OCid_cmb_suc").val(data.id_sucursal).trigger("change");


        setTimeout(function() {
            $("#OCid_cmb_alm").val(data.id_almacen).trigger("change");
            $("#OCid_cmb_alm").select2("close");

        }, 200);
        setTimeout(function() {

            $("#OCtipo").val(data.tipo).trigger("change");
            $("#OCtipo").select2("close");
        }, 200);

        setTimeout(function() {
            $("#OCModal").modal("hide");
        }, 100);

        $.post("controlador/Clogistica.php?op=LLENAR_ORD_COM_DET", {

            id: data.id
        }, function(detalles) {
            //console.log(detalles)
            orden_compra = new Array();

            for (var i = 0; i < detalles.length; i++) {
                orden_compra_detalle = {
                    id_producto: detalles[i].id_producto,
                    nombre_producto: detalles[i].nombre,
                    cantidad: detalles[i].cantidad,
                    unidad: detalles[i].unidad,
                    despachado: detalles[i].despachado,
                    pendiente: detalles[i].pendiente
                };
                orden_compra.push(orden_compra_detalle);

            }


            OClistar();

            console.log(orden_compra);
        }, 'JSON');

    }, 'JSON');


}