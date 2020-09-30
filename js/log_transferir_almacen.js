$(document).ready(function() {



    var stock;
    var unidad;

    var $sucursal_org = $("#TAsuc_org").select2({
        dropdownAutoWidth: true,
        width: '97%'
    });


    var $almacen_org = $("#TAalm_org").select2({
        dropdownAutoWidth: true,
        width: '97%'
    });

    var $sucursal_des = $("#TAsuc_des").select2({
        dropdownAutoWidth: true,
        width: '97%'
    });


    var $almacen_des = $("#TAalm_des").select2({
        dropdownAutoWidth: true,
        width: '97%'
    });


    var $producto = $("#TAproducto").select2({
        dropdownAutoWidth: true,
        width: '99%'
    });





    $('.numero').on("keypress", function() {
        if (event.keyCode > 47 && event.keyCode < 60 || event.keyCode == 46) {

        } else {
            event.preventDefault();
        }

    });

});


$("#TAsuc_org").change(function() {
    almacenxsucursal1()
    setTimeout(function() {
        $("#TAalm_org").select2('open');

    }, 100);

});


function almacenxsucursal1() {
    $("#TAalm_org").html("");
    $.post("controlador/Clogistica.php?op=LISTAR_ALMxSUC", {
        sucursal: $("#TAsuc_org").val(),
    }, function(data) {

        $("#TAalm_org").html(data);
        console.log(data);

    });
}


$("#TAsuc_des").change(function() {
    almacenxsucursal2()
    setTimeout(function() {
        $("#TAalm_des").select2('open');

    }, 100);

});


function almacenxsucursal2() {
    $("#TAalm_des").html("");
    $.post("controlador/Clogistica.php?op=LISTAR_ALMxSUC", {
        sucursal: $("#TAsuc_des").val(),
    }, function(data) {

        $("#TAalm_des").html(data);
        // console.log(data);

    });
}


$("#TAalm_org").change(function() {
    LotexAlmacen()



});

function LotexAlmacen() {
    $("#TAproducto").html("");
    $.post("controlador/Clogistica.php?op=LISTAR_LOTExALM", {
        almacen: $("#TAalm_org").val(),
    }, function(data) {

        $("#TAproducto").html(data);
        //console.log(data);

    });
}

$("#TAproducto").change(function() {

    MostrarStockUnidad()


});


$("#TAfraccionar").change(function() {

    MostrarStockUnidad()


    // console.log(stock)
    //console.log(unidad)


});


function MostrarStockUnidad() {

    $.post("controlador/Clogistica.php?op=PRODUCTOxLOTE", {
        lote: $("#TAproducto").val(),
    }, function(data) {


        stock = data.stock

        $("#TAstock").val(stock);
        $("#TAunidad").val(data.unidad_lote);




    }, 'JSON');



}




$("#TAcantidad").change(function() {
    if ($("#TAcantidad").val() > parseInt(stock)) {
        swal("Cantidad excede el stock", "", "error")
        // $("#TAcantidad").val("")
        $("#TAcantidad").focus();
        return false
    }




});


function Transferir() {


    if ($("#TAalm_org").val() == "") {
        swal("Campo requerido", "Seleccione un almacén de origen", "warning");
        setTimeout(function() {
            $("#TAalm_org").select2('open');
        }, 200);
        return false;
    }

    if ($("#TAalm_des").val() == "") {
        swal("Campo requerido", "Seleccione un almacén de destino", "warning");
        setTimeout(function() {
            $("#TAalm_des").select2('open');
        }, 200);
        return false;
    }

    if ($("#TAalm_des").val() == $("#TAalm_org").val()) {
        swal("Almacenes iguales", "Seleccione un almacén distinto", "warning");

        return false;
    }


    if ($("#TAproducto").val() == "") {
        swal("Campo requerido", "Seleccione un producto", "warning");
        setTimeout(function() {
            $("#TAproducto").select2('open');
        }, 200);
        return false;
    }

    if ($("#TAcantidad").val() == "") {
        swal("Campo requerido", "Ingrese una cantidad", "warning");

        $("#TAcantidad").focus();

        return false;
    }


    if ($("#TAcantidad").val() > parseInt(stock)) {
        swal("Cantidad excede el stock", "", "error")
        //$("#TAcantidad").val("")
        $("#TAcantidad").focus();
        return false
    }




    $.post("controlador/Clogistica.php?op=TRANSEFERIR_ALM", {


        almacen_origen: $("#TAalm_org").val(),
        almacen_destino: $("#TAalm_des").val(),

        cantidad: $("#TAcantidad").val(),
        lote: $("#TAproducto").val()



    }, function(data) {

        if (data == 1) {
            swal("Correcto", "Orden registrada correctamente", "success");
        } else {
            swal("Error", "Orden no registrada ", "error");
        }
        $("#TAsuc_org,#TAsuc_des,#TAalm_org,#TAalm_des,#TAproducto,#TAcantidad,#TAstock,#TAunidad").val("")
        stock = ''
        unidad = ''
        console.log(data);
    });


}
