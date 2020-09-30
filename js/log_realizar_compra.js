$(document).ready(function () {
    $("#afecto").focus();
    ListarAlmacenesGral()
    var $producto = $("#id_cmb_pro").select2({
        dropdownAutoWidth: true,
        width: '97%'
    });
    var $proveedor = $("#id_cmb_prov").select2({
        dropdownAutoWidth: true,
        width: '97%'
    });
    var $almacen= $("#id_cmb_alm").select2({
        dropdownAutoWidth: true,
        width: '97%'
    });
    var $sucursal = $("#id_cmb_suc").select2({
        dropdownAutoWidth: true,
        width: '97%'
    });



    $('.numero').on("keypress", function () {
        if (event.keyCode > 47 && event.keyCode < 60 || event.keyCode == 46) {

        } else {
            event.preventDefault();
        }

    });

    $('.entero').on("keypress", function () {
        if (event.keyCode > 47 && event.keyCode < 58) {

        } else {
            event.preventDefault();
        }

    });
    $("#monto_igv_total").val("0.00");
    $("#monto_sin_igv").val("0.00");
    $("#total").val("0.00");
    $("#igv").val("0.00");
});


//COMPRA

function llenarIGV() {
    if ($('input:radio[name=tipo_afectacion]:checked').val() == "1") {
        $("#igv").val("0.18");

        $('input:radio[name=tipo_afectacion]:checked').val()
    };
    if ($('input:radio[name=tipo_afectacion]:checked').val() == "2") {
        $("#igv").val("0.00");
    };
    listar()

}


function guardar() {



    if (compra.length == 0) {
        swal("Vacío", "Inserte datos", "warning");
        return false;
    }


    if ($("#fecha").val() == "") {
        swal("Campo requerido", "Inserte fecha", "warning");
        $("#fecha").focus();
        return false;
    }
    if ($("#d_cmb_prov").val() == "") {
        swal("Campo requerido", "Seleccione un proveedor", "warning");
        $("#d_cmb_prov").focus();
        return false;
    }
    if ($("#tipo_documento").val() == "") {
        swal("Campo requerido", "Seleccione un tipo de documento", "warning");
        $("#tipo_documento").focus();
        return false;
    }
    if ($("#nro_documento").val() == "") {
        swal("Campo requerido", "Inserte número de documento", "warning");
        $("#nro_documento").focus();
        return false;
    }



    if ($("#tipo_compra").val() == "Contado") {

        $("#nro_dias").val("0")

    } else {
        if ($("#nro_dias").val() == "") {
            swal("Campo requerido", "Inserte número de dias", "warning");
            $("#nro_dias").focus();
            return false;
        }

    }


    //Validacion de precios y cantidades antes de guardar

    for (var i = 0; i < compra.length; i++) {

        if ((compra[i].fecha_vencimiento) == "") {
            swal("Ingrese fecha de vencimiento", compra[i].nombre_producto, "warning")
            return false
        }
        if ((compra[i].nro_lote) == "") {
            swal("Ingrese número de lote", compra[i].nombre_producto, "warning")
            return false
        }
        if (parseInt(compra[i].cantidad) <= 0) {
            swal("Ingrese cantidad", compra[i].nombre_producto, "warning")
            return false
        }


        if (!$.isNumeric(compra[i].cantidad)) {
            swal("Ingrese cantidad", compra[i].nombre_producto, "warning")
            return false
        }

        if (parseFloat(compra[i].precio) <= 0) {
            swal("Ingrese precio", compra[i].nombre_producto, "warning")
            return false
        }

        if (!$.isNumeric(compra[i].precio)) {
            swal("Ingrese precio", compra[i].nombre_producto, "warning")
            return false
        }


    }



    //comprobacion del total de la orden
    for (var i = 0; i < compra.length; i++) {

        if (compra[i].orden == '1') {
            cantidad_total = 0;

            for (var j = 0; j < compra.length; j++) {
                if (compra[j].id_producto == compra[i].id_producto) {
                    cantidad_total += parseInt(compra[j].cantidad)
                }
            }

            if (parseInt(cantidad_total) > parseInt(compra[i].cantidad_orden)) {

                swal("Cantidad execede a la orden", compra[i].nombre_producto, "error")
                return false;
            }
        }
    }



    $.post("controlador/Clogistica.php?op=NUEVO_COM", {


        compra: JSON.stringify(compra),
        proveedor: $("#id_cmb_prov").val(),
        fecha: $("#fecha").val(),
        tipo_documento: $("#tipo_documento").val(),
        nro_documento: $("#nro_documento").val(),
        tipo_afectacion: $("input:radio[name=tipo_afectacion]:checked").val(),
        nota_credito: "0",
        tipo_compra: $("#tipo_compra").val(),
        nro_dias: $("#nro_dias").val(),
        id_orden: $("#orden").val(),
        monto_igv: $("#monto_igv_total").val(),
        igv: $("#igv").val(),
        monto_sin_igv: $("#monto_sin_igv").val(),
        total: $("#total").val(),
        id_almacen: $("#id_cmb_alm").val()
    }, function (data) {
        console.log(data);
        if (data.indexOf("OK") > -1) {
            swal("Correcto", "Compra registrada correctamente", "success");
        } else {
            swal("Error", "Compra no registrada ", "error");
        }
        cancelar();

    });
}


function cancelar() {
    compra = new Array();
    $("#monto_igv_total").val("0.00");
    $("#nro_documento").val("");
    $("#nro_dias").val("");
    $("#nro_lote").val("");
    $("#cantidad").val("");
    $("#precio_anterior").val("");
    $("#monto_sin_igv").val("0.00");
    $("#total").val("0.00");
    $("#fecha").val("");
    $("#orden").val("");
    $("#fecha_vencimiento").val("");
    //        $("#igv").val("");
    /* setTimeout(function() {
         $("#id_cmb_pro").val("").trigger('chosen:updated');
     }, 200);
     setTimeout(function() {
         $("#id_cmb_prov").val("").trigger('chosen:updated');
     }, 200);
     setTimeout(function() {
         $("#tipo_documento").val("").trigger('chosen:updated');
     }, 200);
     setTimeout(function() {
         $("#tipo_compra").val("").trigger('chosen:updated');
     }, 200);
     setTimeout(function() {
         $("#bonificacion").val("").trigger('chosen:updated');
     }, 200);*/
    listar();
}


//DETALLE_COMPRA
var compra = new Array();

function listar() {
    $("#IdCuerpoCD").html("");

    var stotal = 0;
    for (var i = 0; i < compra.length; i++) {
        if (compra[i].bonificacion == '0') {
            bonificacion = "<input id='" + i + "_bonificacion' type='checkbox' onchange='ModificarDetalleBonificacion(" + i + ")' >";
        } else {
            bonificacion = "<input id='" + i + "_bonificacion' type='checkbox' checked  onchange='ModificarDetalleBonificacion(" + i + ")'>";
        }

        if (compra[i].orden == '0') {
            orden = "<input  type='checkbox' disabled >";
        } else {
            orden = "<input  type='checkbox' checked  disabled>";
        }
        if (compra[i].dividir) {
            dividir = "<span class='text-left' onclick=\"Dividir(" + i + "," + compra[i].cantidad_orden + "," + compra[i].id_producto + ",'" + compra[i].nombre_producto + "','" + compra[i].tipo_producto + "')\"><icon class='fa fa-plus'></icon></span>";
        } else {
            dividir = "<span class='text-left' > </span>";
        }

        //Calculo del IGV
        //.toFixed(2) RECORTA A DOS DECIMALES SIN REDONDEAR INCLUIDO ENTEROS .00
        if ($("#igv_detalle").prop("checked")) {
            compra[i].precio_sin_igv = (Math.round((compra[i].precio * (100 / 118)) * 100) / 100).toFixed(2);
            compra[i].monto_igv = (Math.round(compra[i].precio * (18 / 118) * 100) / 100).toFixed(2);
            //compra[i].subtotal = (Math.round((compra[i].precio_sin_igv * compra[i].cantidad) * 100) / 100).toFixed(2);
            compra[i].subtotal = (Math.round((parseFloat(compra[i].precio_sin_igv) + parseFloat(compra[i].monto_igv)) * 100) / 100).toFixed(2);;
        } else {
            compra[i].precio_sin_igv = (Math.round(compra[i].precio * 100) / 100).toFixed(2);
            compra[i].monto_igv = (Math.round(compra[i].precio * (0.18) * 100) / 100).toFixed(2);
            //compra[i].subtotal = (Math.round((parseFloat(compra[i].precio_sin_igv * compra[i].cantidad)) * 100) / 100).toFixed(2);
            compra[i].subtotal = (Math.round((parseFloat(compra[i].precio_sin_igv) + parseFloat(compra[i].monto_igv)) * 100) / 100).toFixed(2);;
        }

        if (compra[i].bonificacion == '0') {
            stotal += parseFloat(compra[i].subtotal);
        } else {
            compra[i].subtotal = "0.00"
        }

        if (compra[i].tipo_producto == '0') {
            nro_lote_input = "<input style='width:100%'  class='form-control' onchange=\"ModificarDetalleLote(" + i + ")\" id='" + i + "_lote'  value='" + compra[i].nro_lote + "'>"
        } else {
            nro_lote_input = ""
        }


        $("#IdCuerpoCD").append("<tr><td width='3%' class='text-left'><span class=' text-left' onclick='eliminar(" + i + ")'><icon class='fa fa-trash'></icon></span></td>\n\
                <td width='3%' class='text-left'>" + dividir + "</td>\n\
                <td width='3%'  style='text-align:left;'>" + orden + "</td>\n\
            <td width='3%'>" + parseInt(i + 1) + "</td>\n\
            <td width='18%' style='text-align:left;'>" + compra[i].nombre_producto + "</td>\n\
            <td width='14%' style='text-align:left;'><input type='date' style='width:100%' class='form-control' onchange=\"ModificarDetalleVencimiento(" + i + ")\" id='" + i + "_fecha_vencimiento' value='" + compra[i].fecha_vencimiento + "'> </td>\n\
            <td width='8%' style='text-align:left;'> " + nro_lote_input + "</td>\n\
            <td width='8%' align='center'> " + compra[i].cantidad_orden + "</td>\n\
            <td width='8%' align='center'> <input '  type='number'  style='width:100%' class='form-control text-right entero'  onchange=\"ModificarDetalleCantidad(" + i + ")\" id='" + i + "_cantidad'  value='" + compra[i].cantidad + "'></td>\n\
            <td width='8%' align='center'> <input type='number' style='width:100%' class='form-control text-right' onchange=\"ModificarDetallePrecio(" + i + ")\" id='" + i + "_precio'  value='" + compra[i].precio + "'></td>\n\
            <td width='8%' align='right'>S/. " + compra[i].precio_sin_igv + "</td>\n\
            <td width='8%' align='right'>S/. " + compra[i].monto_igv + "</td>\n\
            <td width='8%' align='right'>S/. " + compra[i].subtotal + "</td>\n\
            <td width='3%'> " + bonificacion + "</td></tr>");
        console.log(compra[i]);
    }


    igv = $("#igv").val();

    if (igv != 0) {
        $("#monto_sin_igv").val(((Math.round((stotal) * 100) / 100) / 1.18).toFixed(2));
        monto_sin_igv = $("#monto_sin_igv").val();
    } else {
        $("#monto_sin_igv").val(((Math.round((stotal) * 100) / 100)).toFixed(2));
        monto_sin_igv = $("#monto_sin_igv").val();
    }



    $("#monto_igv_total").val((parseFloat(stotal - monto_sin_igv)).toFixed(2));
    monto_igv_total = $("#monto_igv_total").val();


    total = (Math.round((parseFloat(stotal) * 100) / 100).toFixed(2));
    $("#total").val(total);
}


function SoloEnteros(id) {
    if (event.keyCode > 47 && event.keyCode < 60 || event.keyCode == 46) {

    } else {
        event.preventDefault();
    }
}

function ModificarDetalleBonificacion($fila) {
    if ($("#" + $fila + "_bonificacion").prop("checked")) {
        compra[$fila].bonificacion = '1'
    } else {
        compra[$fila].bonificacion = '0'
    }


    listar()


}

function ModificarDetalleVencimiento($fila) {

    compra[$fila].fecha_vencimiento = $("#" + $fila + "_fecha_vencimiento").val()

    listar()


}

function ModificarDetalleLote($fila) {

    compra[$fila].nro_lote = $("#" + $fila + "_lote").val()
    listar()


}

function ModificarDetallePrecio($fila) {

    compra[$fila].precio = $("#" + $fila + "_precio").val()
    listar()


}

function ModificarDetalleCantidad($fila) {

    compra[$fila].cantidad = $("#" + $fila + "_cantidad").val()
    //console.log(compra[$fila].cantidad)
    //console.log(compra[$fila].cantidad_orden)


    //comprobacion del total de la orden
    cantidad_total = 0;

    for (var i = 0; i < compra.length; i++) {
        if (compra[i].id_producto == compra[$fila].id_producto && compra[$fila].orden == '1') {
            cantidad_total += parseInt(compra[i].cantidad)
        }

    }

    if (parseInt(cantidad_total) > parseInt(compra[$fila].cantidad_orden)) {
        compra[$fila].cantidad = 0;
        swal("Cantidad execede a la orden", "", "error")

    }



    listar()


}

function Dividir(fila, cantidad_orden, id_producto, nombre_producto, tipo_producto) {
    $("#dividir-btn_añadir").attr("disabled", false)
    $("#ECModalDividir").modal()
    $("#dividir-producto").html(nombre_producto)
    $("#dividir-id_producto").val(id_producto)
    $("#dividir-nombre_producto").val(nombre_producto)
    $("#dividir-tipo_producto").val(tipo_producto)
    $("#dividir-cantidad_orden").val(cantidad_orden)
    $("#dividir-fila").val(fila)


    dividir = new Array()
    DividirListar()


}

function AñadirDetalle() {


    if ($("#id_cmb_pro").val() == "") {
        swal("Campo requerido", "Seleccione un producto", "warning");
        $("#id_cmb_pro").focus();
        return false;
    }
    if ($("#precio").val() == "") {
        swal("Campo requerido", "Inserte un precio", "warning");
        $("#precio").focus();
        return false;
    }
    if ($("#cantidad").val() == "") {
        swal("Campo requerido", "Inserte una cantidad", "warning");
        $("#cantidad").focus();
        return false;
    }

    if ($("#fecha_vencimiento").val() == "") {
        swal("Campo requerido", "Inserte una fecha", "warning");
        $("#fecha_vencimiento").focus();
        return false;
    }

    if ($("#nro_lote").val() == "") {
        swal("Campo requerido", "Inserte unvlote", "warning");
        $("#nro_lote").focus();
        return false;
    }

    if ($("#bonificacion").val() == "") {
        swal("Campo requerido", "Seleccione bonificación", "warning");
        $("#bonificacion").focus();
        return false;
    }

    var id_producto = $("#id_cmb_pro").val();
    var seleccionado = $("#id_cmb_pro").val();
    var nombre_producto = $("#pro_" + seleccionado).attr("nombre_producto");
    var tipo_producto = $("#pro_" + seleccionado).attr("tipo_producto");
    var cantidad = $("#cantidad").val();
    var precio = Math.round(parseFloat($("#precio").val()) * 100) / 100;
    var fecha_vencimiento = $("#fecha_vencimiento").val();
    var nro_lote = $("#nro_lote").val();
    var precio_anterior = $("#precio_anterior").val();
    var bonificacion = $("#bonificacion").val();
    precio_sin_igv = "";
    monto_igv = "";
    subtotal = "";

    for (var i = 0; i < compra.length; i++) {

        if (compra[i].id_producto == id_producto) {
            /*compra[i].cantidad = parseInt(compra[i].cantidad) + parseInt(cantidad);*/
            swal("Producto ya añadido", "", "info")

            return false;
        }
    }

    var detalle = {
        id_producto: id_producto,
        nombre_producto: nombre_producto,
        tipo_producto: tipo_producto,
        dividir: false,
        orden: '0',
        cantidad_orden: "-",
        cantidad: cantidad,
        precio: precio,
        precio_sin_igv: precio_sin_igv,
        monto_igv: monto_igv,
        subtotal: subtotal,
        fecha_vencimiento: fecha_vencimiento,
        bonificacion: bonificacion,
        precio_anterior: precio_anterior,
        nro_lote: nro_lote
    };
    compra.push(detalle);
    listar();
    //
    $("#nro_lote").val("");
    $("#cantidad").val("");
    $("#precio").val("");
    //        $("#precio_anterior").val("0.00");
    $("#fecha_vencimiento").val("");
    setTimeout(function () {
        $("#bonificacion").val("").trigger('chosen:updated');
    }, 200);
    setTimeout(function () {
        $("#id_cmb_pro").val("").trigger('chosen:updated');
    }, 200);
    setTimeout(function () {
        $("#id_cmb_pro").select2('open');
    }, 200);
}

function eliminar(id) {
    // if (compra[id].orden == "0") {
    compra.splice(id, 1);
    listar();
    //} else {
    //  swal("No se puede eliminar registro de orden", "", "error")
    //   }

}


//DIVIDIR PRODUCTO
dividir = new Array()

function DividirAñadirDetalle() {

    if ($("#dividir-fecha_vencimiento").val() == "") {
        swal("Campo requerido", "Inserte una fecha", "warning");
        $("#dividir-fecha_vencimiento").focus();
        return false;
    }
    if ($("#dividir-cantidad").val() == "") {
        swal("Campo requerido", "Inserte una cantidad", "warning");
        $("#dividir-cantidad").focus();
        return false;
    }
    if ($("#dividir-precio").val() == "") {
        swal("Campo requerido", "Inserte un precio", "warning");
        $("#dividir-precio").focus();
        return false;
    }
    if ($("#dividir-bonificacion").val() == "") {
        swal("Campo requerido", "Seleccione bonificación", "warning");
        $("#dividir-bonificacion").focus();
        return false;
    }

    var id_producto = $("#dividir-id_producto").val();
    var nombre_producto = $("#dividir-nombre_producto").val();
    var tipo_producto = $("#dividir-tipo_producto").val();
    var cantidad = $("#dividir-cantidad").val();
    var cantidad_orden = $("#dividir-cantidad_orden").val();
    var precio = Math.round(parseFloat($("#dividir-precio").val()) * 100) / 100;
    var fecha_vencimiento = $("#dividir-fecha_vencimiento").val();
    var nro_lote = $("#dividir-nro_lote").val();
    var precio_anterior = $("#dividir-precio_anterior").val();
    var bonificacion = $("#dividir-bonificacion").val();
    precio_sin_igv = "";
    monto_igv = "";
    subtotal = "";

    //comprobacion del total de la orden
    cantidad_total = 0;

    for (var i = 0; i < dividir.length; i++) {

        cantidad_total += parseInt(dividir[i].cantidad)


    }

    if (parseInt(cantidad_total) + parseInt(cantidad) > parseInt(cantidad_orden)) {

        swal("Cantidad execede a la orden", "", "error")
        return false;
    }


    //igual lote solo aumenta la cantidad
    for (var i = 0; i < dividir.length; i++) {

        if (dividir[i].nro_lote == nro_lote) {
            dividir[i].cantidad = parseInt(dividir[i].cantidad) + parseInt(cantidad);
            DividirListar();

            $("#dividir-cantidad").val("");
            $("#dividir-unidad").val("");


            return false;
        }
    }
    var detalle = {
        id_producto: id_producto,
        nombre_producto: nombre_producto,
        tipo_producto: tipo_producto,
        orden: '1',
        dividir: false,
        cantidad_orden: cantidad_orden,
        cantidad: cantidad,
        precio: precio,
        precio_sin_igv: precio_sin_igv,
        monto_igv: monto_igv,
        subtotal: subtotal,
        fecha_vencimiento: fecha_vencimiento,
        bonificacion: bonificacion,
        precio_anterior: precio_anterior,
        nro_lote: nro_lote
    };
    dividir.push(detalle);
    DividirListar();


}

function DividirListar() {
    $("#IdCuerpoCD-dividir").html("");

    for (var i = 0; i < dividir.length; i++) {
        if (dividir[i].bonificacion == '0') {
            dividir_bonificacion = "<input type='checkbox' disabled >";
        } else {
            dividir_bonificacion = "<input type='checkbox' checked  disabled >";
        }
        if (dividir[i].orden == '0') {
            orden = "<input type='checkbox' disabled >";
        } else {
            orden = "<input type='checkbox' checked  disabled>";
        }



        //Calculo del IGV
        //.toFixed(2) RECORTA A DOS DECIMALES SIN REDONDEAR INCLUIDO ENTEROS .00
        if ($("#igv_detalle").prop("checked")) {
            dividir[i].precio_sin_igv = (Math.round((dividir[i].precio * (100 / 118)) * 100) / 100).toFixed(2);
            dividir[i].monto_igv = (Math.round(dividir[i].precio * (18 / 118) * 100) / 100).toFixed(2);
            //dividir[i].subtotal = (Math.round((dividir[i].precio_sin_igv * dividir[i].cantidad) * 100) / 100).toFixed(2);
            dividir[i].subtotal = (Math.round((parseFloat(dividir[i].precio_sin_igv) + parseFloat(dividir[i].monto_igv)) * 100) / 100).toFixed(2);;

        } else {
            dividir[i].precio_sin_igv = (Math.round(dividir[i].precio * 100) / 100).toFixed(2);
            dividir[i].monto_igv = (Math.round(dividir[i].precio * (0.18) * 100) / 100).toFixed(2);
            //dividir[i].subtotal = (Math.round((parseFloat(dividir[i].precio_sin_igv * dividir[i].cantidad)) * 100) / 100).toFixed(2);
            dividir[i].subtotal = (Math.round((parseFloat(dividir[i].precio_sin_igv) + parseFloat(dividir[i].monto_igv)) * 100) / 100).toFixed(2);;

        }



        $("#IdCuerpoCD-dividir").append("<tr><td width='3%' class='text-left'><span class=' text-left' onclick='DividirEliminar(" + i + ")'><icon class='ft-trash'></icon></span></td>\n\
                <td width='3%'  style='text-align:left;'>" + orden + "</td>\n\
            <td width='3%'>" + parseInt(i + 1) + "</td>\n\
            <td width='10%' style='text-align:left;'>" + dividir[i].nombre_producto + "</td>\n\
            <td width='10%' style='text-align:left;'>" + dividir[i].fecha_vencimiento + " </td>\n\
            <td width='10%' style='text-align:left;'> " + dividir[i].nro_lote + "</td>\n\
            <td width='8%'> " + dividir[i].cantidad_orden + "</td>\n\
            <td width='10%'>" + dividir[i].cantidad + "</td>\n\
            <td width='10%'>" + dividir[i].precio + "</td>\n\
            <td width='10%'>S/. " + dividir[i].precio_sin_igv + "</td>\n\
            <td width='10%'>S/. " + dividir[i].monto_igv + "</td>\n\
            <td width='10%'>S/. " + dividir[i].subtotal + "</td>\n\
            <td width='3%'> " + dividir_bonificacion + "</td></tr>");
        //console.log(dividir[i]);
    }


}

function DividirEliminar(id) {

    dividir.splice(id, 1);
    DividirListar();
}

function DividirAñadirACompra() {
    compra.splice($("#dividir-fila").val(), 1);
    $("#dividir-btn_añadir").attr("disabled", true)
    for (var i = 0; i < dividir.length; i++) {
        compra.push(dividir[i])
    }

    $("#dividir-fila").val("")
    listar()
    $("#ECModalDividir").modal("hide")

}


function DividirComprobarCantidad(fila, nro_lote) {
    cantidad = 0;

    for (var i = 0; i < dividir.length; i++) {
        if (dividir[i].lote == lote) {
            cantidad = cantidad + dividir[i].cantidad

        }

    }

    if (cantidad > $("#dividir-cantidad_orden")) {
        dividir[fila].cantidad = "0"
        swal("Cantidad execede a la orden", "", "error")
        return true;
    } else {
        return false;
    }

}
//ORDEN_COMPRA
function AbrirModalOrdenCompra() {
    ECBuscarOrden();
    $("#ECModalOrdenCompra").modal();
}

function ECLlenarOrdenDetalle($id) {
    var $id_orden = $("#" + $id).attr("idECOC");

    $.post("controlador/Clogistica.php?op=LLENAR_ORD_COM_DET", {

        id: $id_orden
    },
        function (detalles) {
            //console.log(detalles);
            $("#IdCuerpoECbuscardetalle").html("");
            for (var i = 0; i < detalles.length; i++) {

                $("#IdCuerpoECbuscardetalle").append("<tr><td>" + parseInt(i + 1) + "</td><td>" + detalles[i].nombre + "</td><td>" +
                    detalles[i].cantidad + "</td><td>" + detalles[i].nombre_unidad + "</td><td>" +
                    detalles[i].despachado + "</td><td>" + detalles[i].pendiente + "</td></tr>");

            }

        }, 'JSON');
}

function ECBuscarOrden() {
    $("#IdCuerpoECbuscardetalle").html("");
    var $nro = $("#ECbuscar-nro_orden").val();
    $.post('controlador/Clogistica.php?op=LIS_ORD_COMxnro', {

        nro: $nro
    },
        function (data) {
            $("#IdCuerpoECbuscar").html(data);
            $("#IdFilaEC").val(0);
            // $("#ECbuscar-nro_orden").val("");
        });
}

$("#ECbuscar-nro_orden").keypress(function (e) {
    if (e.which == 13) {
        ECBuscarOrden();
    }

});


function PintarFilaECOC($id) {
    var $idfilaanterior = $("#IdFilaECOC").val()

    var $par = $idfilaanterior.split('_')
    var $par_int = parseInt($par[1]);
    // alert($par_int)
    $("#" + $idfilaanterior).css("background-color", "white")
    $("#" + $idfilaanterior).css("color", "black")

    $("#" + $id).css("background-color", "#6FA0B9")
    $("#" + $id).css("color", "white")


    $("#IdFilaECOC").val($id);
    ECLlenarOrdenDetalle($id);
}

function ListarAlmacenesGral(){
    $.post("controlador/Clogistica.php?op=LISTAR_ALM_GRAL",  function (data) {

        $("#id_cmb_alm").html(data)

})
}

function SeleccionarAlmacenxOrden_Compra(id_orden){
    $.post("controlador/Clogistica.php?op=ALMxORD_COMPRA",{id_orden :id_orden },function (data) {

        $("#id_cmb_alm").val(data).change();
        console.log(data)

})
}


function LlenarDatos() {

    var $ident = $("#IdFilaECOC").val();
    var $id = $("#" + $ident).attr("idECOC");
    if ($ident == 0) {
        swal("Debe seleccionar un Registro", "Obligatorio", "warning");
        return false;
    }

    ListarAlmacenesGral()
    $.post("controlador/Clogistica.php?op=LLENAR_ORD_COM_DET", {
        id: $id
    }, function (detalles) {
        //console.log(detalles)

        compra = new Array();
        $("#orden").val($id)


        SeleccionarAlmacenxOrden_Compra($id)
        $("#id_cmb_suc").attr("disabled",true)

        $("#id_cmb_alm").attr("disabled",true)



        orden_detalles = Array()
        for (var i = 0; i < detalles.length; i++) {
            compra_detalle = {
                id_producto: detalles[i].id_producto,
                nombre_producto: detalles[i].nombre,
                tipo_producto: detalles[i].tipo_producto,
                dividir: true,
                orden: "1",
                cantidad_orden: detalles[i].pendiente,
                cantidad: "0",
                unidad: detalles[i].nombre_unidad,
                precio: "0",
                precio_sin_igv: "0",
                monto_igv: "0",
                subtotal: "0",
                fecha_vencimiento: "",
                bonificacion: "0",
                precio_anterior: "0",
                nro_lote: ""

            };
            if (detalles[i].pendiente > 0) {
                compra.push(compra_detalle);
            }


        }

        listar();
        $("#ECModalOrdenCompra").modal('hide');

        console.log(compra);
    }, 'JSON');



}


//DESPLAZAMIENTO FORMULARIO

$("#fecha").keypress(function (e) {
    if (e.which == 13) {


        setTimeout(function () {
            $("#tipo_compra").select2('open');
        }, 200);
    }
});

function ChangeProv() {
    setTimeout(function () {
        $("#tipo_documento").select2('open');
    }, 200);
}


function ChangeTipoDoc() {
    $("#nro_documento").focus();
}

$("#nro_documento").keypress(function (e) {
    if (e.which == 13) {
        $("#fecha").focus();
    }
});

function ClickAfecto() {
    setTimeout(function () {
        $("#id_cmb_prov").select2('open');
    }, 200);
}

function ClickInafecto() {
    setTimeout(function () {
        $("#id_cmb_prov").select2('open');
    }, 200);
}

function ChangeTipoCompra() {
    if ($("#tipo_compra").val() == 'Contado') {
        $("#td-nro_dias").hide();
        $("#igv_detalle").focus();
    } else {
        $("#td-nro_dias").show();
        $("#nro_dias").focus();
    }



}

$("#nro_dias").keypress(function (e) {
    if (e.which == 13) {

        setTimeout(function () {
            $("#id_cmb_pro").select2('open');
        }, 200);
    }
})

function ClickIGV() {
    setTimeout(function () {
        $("#id_cmb_pro").select2('open');
    }, 200);
}

function ChangeProducto() {

    $.post("controlador/Clogistica.php?op=PRECIO_COMPRA_ULTIMO", {

        id: $("#id_cmb_pro").val()
    }, function (data) {
        if (!data.precio_sin_igv) {
            $("#precio_anterior").val("0.00");
        } else {
            $("#precio_anterior").val(data.precio_sin_igv);
        }

        console.log(data);
    }, "JSON").fail(function () {
        $("#precio_anterior").val("0.00");
    });
    
    setTimeout(function () {
        $("#id_cmb_suc").select2('open');
    }, 200);
}


function ChangeSucursal() {

    $("#id_cmb_alm").val("").trigger('change');
    $("#id_cmb_alm").html("");
    $.post("controlador/Clogistica.php?op=LISTAR_ALM_GRALxSUC", {
        sucursal: $("#id_cmb_suc").val(),

    }, function (data) {

        $("#id_cmb_alm").html(data);

    });


    setTimeout(function () {
        $("#id_cmb_alm").select2('open');

    }, 200);
}
function ChangeAlmacen() {
    $("#precio").focus()
}

$("#precio").keypress(function (e) {
    if (e.which == 13) {
        $("#cantidad").focus();
    }
})
$("#cantidad").keypress(function (e) {
    if (e.which == 13) {
        $("#fecha_vencimiento").focus();
    }
})
$("#fecha_vencimiento").keypress(function (e) {
    if (e.which == 13) {
        $("#nro_lote").focus();
    }
})

$("#nro_lote").keypress(function (e) {
    if (e.which == 13) {
        setTimeout(function () {
            $("#bonificacion").select2('open');
        }, 200);
    }
})

function ChangeBonificacion() {
    AñadirDetalle();
}

$(document).keydown(function (tecla) {


    if (tecla.ctrlKey && tecla.keyCode == 83) {
        tecla.preventDefault();
        guardar();
    }

});