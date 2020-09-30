$(document).ready(function() {

    var stock;
    var unidad;
    var cantidad_fraccion;

    var $sucursal_org = $("#TAsuc_org").select2({
        dropdownAutoWidth: true,
        width: '97%'
    });


    var $almacen_org = $("#TAalm_org").select2({
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
    $.post("controlador/Clogistica.php?op=LIS_LOTE_FRACCIONxALM", {
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

    $.post("controlador/Clogistica.php?op=PRODUCTO_FRACCIONxLOTE", {
        lote: $("#TAproducto").val(),
    }, function(data) {


        stock = data.stock
        cantidad_fraccion = data.cantidad_fraccion
        $("#TAunidad_equi").val("1 " + data.nombre_unidad + "  ");
       
        $("#TAstock").val(stock + " " + data.nombre_unidad + " ");

        $.post("controlador/Clogistica.php?op=LLENAR_PRO", {
            id: data.id_producto_fraccion,
        }, function(data) {


           
            $("#TAfraccion_equi").val(cantidad_fraccion + " " +data.unidad+" "+ data.nombre);

            $("#TAunidad_fraccion").val(data.unidad);




        }, 'JSON');



    }, 'JSON');



}




$("#TAcantidad").change(function() {
    if ($("#TAcantidad").val() > parseInt(stock)) {
        swal("Cantidad excede el stock", "", "error")
        // $("#TAcantidad").val("")
        $("#TAcantidad").focus();
        return false
    } else {

        $("#TAcantidad_fraccion").val(parseInt($("#TAcantidad").val()) * parseInt(cantidad_fraccion))
    }




});


function Fraccionar() {


    if ($("#TAalm_org").val() == "") {
        swal("Campo requerido", "Seleccione un almacén ", "warning");
        setTimeout(function() {
            $("#TAalm_org").select2('open');
        }, 200);
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




    $.post("controlador/Clogistica.php?op=FRACCIONAR_LOTE", {


        almacen: $("#TAalm_org").val(),
        cantidad: $("#TAcantidad").val(),
        lote: $("#TAproducto").val()



    }, function(data) {

        if (data == 1) {
            swal("Correcto", "Registrado correctamente", "success");
        } else {
            swal("Error", "No registrado correctamente ", "error");
        }
        $("#TAsuc_org,#TAalm_org,#TAproducto,#TAcantidad,#TAstock,#TAunidad,#TAunidad_equi,#TAfraccion_equi,#TAcantidad_fraccion,#TAunidad_fraccion").val("").change()

        stock = ''
        unidad = ''
        cantidad_fraccion = ''
        console.log(data);
        $("#TAcantidad_fraccion").val("")
    });


}

function Limpiar() {
    $("#TAsuc_org,#TAalm_org,#TAproducto,#TAcantidad,#TAstock,#TAunidad,#TAunidad_equi,#TAfraccion_equi,#TAcantidad_fraccion,#TAunidad_fraccion").val("").change()

    stock = ''
    unidad = ''
    cantidad_fraccion = ''
    $("#TAcantidad_fraccion").val("")

}
