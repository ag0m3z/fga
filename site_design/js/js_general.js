/**
 * Created by agomez on 29/11/2016.
 *  SenderAjax(urlPhp,nameView,params,idDiv,is_type,stringData)
 * Created by alejandro.gomez on 14/11/2016.
 */

var validar_cierre = false;
var buttonBootBox = {

    confirm: {
        label: '<i class="fa fa-check"></i> Aceptar',
        className: 'btn-default'
    },cancel: {
        label: '<i class="fa fa-times"></i> Cancelar',
        className: 'btn-danger'
    },
};


function setSendMailNotify(params) {

    $.ajax({
        url:"modules/applications/src/emails/SenMailAlerta.php",
        type:"post",
        dataType:"json",
        data:{
            NombreRecibe:params.Nombre,
            CorreoRecibe:params.Correo,
            Titulo:params.Titulo,
            Mensaje:params.Mensaje
        }
    }).done(function (response) {

    }).fail(function (jqhr,textStatus,errno) {

    });

}


function fnGnEliminarImpresora(idImpresora,idSucursal){
    $.ajax({
        url:"modules/configuracion/src/parametros/fnEliminarImpresora.php",
        type:"post",
        dataType:"json",
        data:{
            idImpresora:idImpresora,
            idSucursal:idSucursal
        },
        beforeSend:function () {
            fnloadSpinner(1);
        }
    }).done(function (response) {
        fnloadSpinner(2);

        if(response.result){
            getMessage(response.message,"","success",1500);
            fnGnListarImpresoras(1);
        }else{
            MyAlert(response.message);
        }

    }).fail(function (jqhR,textStatus,errno) {

        fnloadSpinner(2);
        if(console && console.log){

            if(textStatus == "timeout"){
                MyAlert("Tiempo de espera agotado para esta soliciutd");
            }else{
                MyAlert("Error al cargar la vista");
            }

        }

    });

}
function fnGnListarImpresoras(opc){
    $.ajax({
        url:"modules/configuracion/src/parametros/fnListarImpresoras.php",
        type:"post",
        data:{opc:opc}
    }).done(function (data) {
        $("#listarImpresoras").html(data);
    }).fail(function (jqhR,textStatus,errno) {
        MyAlert("Error al mostrar la lista de costos de trabajo");
    });
}
function fnGnAgregarImpresora(opc){

    var idsucursal = $("#idsucursal"),alias = $("#aliasImpresora"),nombre = $("#nombreImpresora");

    if(idsucursal.val() == 0){
        MyAlert("Seleccione la sucursal donde se encuentra la impresora","alert");
    }else if($.trim(alias.val()) == ""){
        MyAlert("El alias de la impresora no debe estar vacio","alert");
    }else if($.trim(nombre.val()) == ""){
        MyAlert("EL Nombre de la impresora no debe estar vacio","alert");
    }else {

        $.ajax({
            url: "modules/configuracion/src/parametros/fnRegistraImpresra.php",
            type: "post",
            dataType: "json",
            data: {
                opc: opc,
                nombre: nombre.val(),
                alias: alias.val(),
                idsucursal: idsucursal.val()
            },
            beforeSend: function () {
                fnloadSpinner(1);
            }
        }).done(function (response) {
            fnloadSpinner(2);

            if (response.result) {

                fnGnListarImpresoras(1);
                getMessage(response.message, "", "success", 1500);
                $('#idsucursal option[value='+0+' ]').prop('selected', true).change();
                nombre.val("");
                alias.val("");
                nombre.focus();

            } else {
                MyAlert(response.message);
            }

        }).fail(function (jqhR, textStatus, errno) {

            fnloadSpinner(2);
            if (console && console.log) {

                if (textStatus == "timeout") {
                    MyAlert("Tiempo de espera agotado para esta soliciutd");
                } else {
                    MyAlert("Error al cargar la vista");
                }

            }

        });
    }

}

function fnGnListarCostoTrabajo(opc){

    $.ajax({
        url:"modules/configuracion/src/parametros/fnListarCostosTrabajo.php",
        type:"post",
        data:{opc:opc}
    }).done(function (data) {
        $("#listaCostoTrabajos").html(data);
    }).fail(function (jqhR,textStatus,errno) {
        MyAlert("Error al mostrar la lista de costos de trabajo");
    });

}
function fnGnEliminarCostoTrabajo(idCosto){

    $.ajax({
        url:"modules/configuracion/src/parametros/fnEliminarCostoTrabajo.php",
        type:"post",
        dataType:"json",
        data:{
            idCosto:idCosto
        },
        beforeSend:function () {
            fnloadSpinner(1);
        }
    }).done(function (response) {
        fnloadSpinner(2);

        if(response.result){
            getMessage(response.message,"","success",1500);
            fnGnListarCostoTrabajo(1);
        }else{
            MyAlert(response.message);
        }

    }).fail(function (jqhR,textStatus,errno) {

        fnloadSpinner(2);
        if(console && console.log){

            if(textStatus == "timeout"){
                MyAlert("Tiempo de espera agotado para esta soliciutd");
            }else{
                MyAlert("Error al cargar la vista");
            }

        }

    });

}
function fnGnGuardarCostoTRabajo(opc){

    var nombre = $("#nombreCostoTrabajo"),precio = $("#precioCostoTrabajo");

    precio = setFormatoMoneda(1,precio.val());

    if($.trim(nombre.val()) == ""){
        MyAlert("El nombre del costo no debe estar vacio","alert");
    }else if(nombre.val().lenght <= 3 ){
        MyAlert("El nombre del costo es demasiado corto","alert");
    }else{

        $.ajax({
            url:"modules/configuracion/src/parametros/fnRegistrarCostoTrabajo.php",
            type:"post",
            dataType:"json",
            data:{
                opc:opc,
                nombre:nombre.val(),
                precio:precio
            },
            beforeSend:function () {
                fnloadSpinner(1);
            }
        }).done(function (response) {
            fnloadSpinner(2);

            if(response.result){
                getMessage(response.message,"","success",1500);
                fnGnListarCostoTrabajo(1);
                nombre.val('');
                $("#precioCostoTrabajo").val('0');
                nombre.focus();

            }else{
                MyAlert(response.message);
            }

        }).fail(function (jqhR,textStatus,errno) {

            fnloadSpinner(2);
            if(console && console.log){

                if(textStatus == "timeout"){
                    MyAlert("Tiempo de espera agotado para esta soliciutd");
                }else{
                    MyAlert("Error al cargar la vista");
                }

            }

        });

    }


}


function GuardarParametros(){

    var costo_trabajo_cp = $("#costo_trabajo_cp").val(),
        mayoreo_costo_trabajo_cp = $("#cantidad_mayoreo_costo_trabajo_cp").val(),
        costo_trabajo_mayoreo_cp = $("#costo_trabajo_mayoreo_cp").val(),
        costo_trabajo_sp = $("#costo_trabajo_sp").val(),
        mayoreo_costo_trabajo_sp = $("#cantidad_mayoreo_costo_trabajo_sp").val(),
        costo_trabajo_mayoreo_sp = $("#costo_trabajo_mayoreo_sp").val(),
        pago_minimo_credito= $("#pago_minimo_credito").val();

    var nombreEmpresa = $("#nombreEmpresa").val(),
        descripcionEmpresa = $("#descripcionEmpresa").val(),
        correoNotify = $("#correoNotify").val();


    if($.trim(nombreEmpresa) == ""){
        MyAlert("Ingrese el nombre de la empresa","error");
    }else if(isNaN(pago_minimo_credito)){
        MyAlert("El campo de pago minimo en Creditos, es incorrecto","alert");
    }else{

        SenderAjax(
            "modules/configuracion/src/parametros/",
            "fn_guardar_parametros.php",
            null,
            "show_modal",
            "post",
            {
                nombreEmpresa:nombreEmpresa,
                descripcionEmpresa:descripcionEmpresa,
                costo_trabajo_cp:costo_trabajo_cp,
                pago_minimo_credito:pago_minimo_credito,
                correoNotify:correoNotify
            }
        );

    }



}

function fnreadURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.readAsDataURL(input.files[0]);
    }
    var filename = document.getElementById('imagen_producto');
    var file = filename.files[0];
    var data = new FormData();

    data.append('archivo',file);
    console.log(data);
    $.ajax({
        url:"modules/configuracion/src/parametros/fnChangeLogo.php",
        type:"post",
        contentType:false,
        data:data,
        processData:false,
        cache:false,
        success:function(data){
            $("#idgeneral").html(data);
        }
    });
}

function fnVentaImprimirTicket(opc){


    switch (opc){
        case 1:
            //Impresion al realizar la venta
            var folio_venta = $("#folio_venta").val();

            window.open("modules/ventas/reportes/PDFNotaDeVenta.php?pc="+opc+"&id="+folio_venta+"","","location=no,width=600,height=400,scrollbars=NO,menubar=NO,titlebar=NO,toolbar=NO");

            break;
    }


}

function setVentaPagos(data){

    var opcion = data.opc;

    switch (opcion){

        case 1:
            var folio = data.folio;
            SenderAjax(
                "modules/ventas/views/ventas/",
                "frm_pagos.php",
                null,"show_modal","post",{
                    opc:opcion,
                    folio:folio
                }
            );
            break;
        case 2:
            var folio = data.folio;
            SenderAjax(
                "modules/ventas/src/ventas/",
                "fn_detalle_pago.php",
                null,"detalle_pago","post",{
                    folio:folio
                }
            );
            break;
        case 3: //Mostrar Frm para REimprimir Folio de Venta con pagos
            var folio = data.folio;
            SenderAjax(
                "modules/ventas/views/ventas/",
                "FrmReimprimirFolio.php",
                null,"show_modal","post",{
                    opc:opcion,
                    folio:folio
                }
            );
            break;
        case 4: //Llamar Funcion paraREimprimir Folio de Venta con pagos

            var folio = data.folio;

            $.ajax({
                url:"modules/ventas/src/ventas/fnReimprimirFolio.php",
                data:{
                    opc:opcion,
                    folio:folio
                },
                type:"post",
                dataType:"json",
            }).done(function (response) {

                if(response.result){

                    $("#detalle_pago").removeClass("hidden");

                    $("#txtimporte").val(response.data.importe);
                    $("#txtSaldo").val(response.data.saldo);

                    $("#result_pago").removeClass("hidden");

                    $(".currency").numeric({prefix:'$ ', cents: true});

                }else{
                    MyAlert(response.message,"error");
                }


            }).fail(function (jqhR,textStatus,errno) {
                if(console && console.log){

                    if(textStatus == "timeout"){
                        //Tiempo de espera agotado
                        MyAlert("Tiempo de espera agotado","error");
                    }else{
                        MyAlert("Error al cargar la vista","error")
                    }

                }
            });

            break;
        case 5: //Mostrar Frm para Cancelar Folio de Venta o pagos
            var folio = data.folio;
            SenderAjax(
                "modules/ventas/views/ventas/",
                "FrmCancelarFolio.php",
                null,"show_modal","post",{
                    opc:opcion,
                    folio:folio
                }
            );
            break;
        case 6: //Mostrar Lista de Pagos

            var folio = data.folio;
            $.ajax({
                url:"modules/ventas/src/ventas/fnCancelarFolio.php",
                data:{
                    opc:opcion,
                    folio:folio
                },
                type:"post",
                dataType:"json",
            }).done(function (response) {

                if(response.result){

                    var tr="",idmovimiento;
                    var rows = response.data,btnDisabled="";

                    //setVentaPagos({'opc':6,'folio':this.value});

                    if(rows.length > 0){
                        for(i=0;i<rows.length;i++){

                            btnDisabled = "";
                            idmovimiento = rows[i]["idMovimiento"];

                            if(rows[i]["Estatus"] == "C"){
                                btnDisabled = "disabled";
                            }


                            tr = tr + "<tr><td>"+rows[i]["NoPago"]+"</td>" +
                                "<td class='currency' >"+rows[i]["ImporteVenta"]+"</td>" +
                                "<td class='currency'>"+rows[i]["ImportePagado"]+"</td>" +
                                "<td>"+rows[i]["Estatus"]+"</td>" +
                                "<td>"+rows[i]["FechaRegistro"]+"</td>" +
                                "<td><button "+btnDisabled+" onclick='setVentaPagos({opc:7,folio:"+folio+",pago:"+idmovimiento+"})' class='btn btn-xs btn-danger'><i class='fa fa-close'></i></button></td>" +
                                "</tr>";
                        }

                        tr = tr + "<tr><td colspan='6'><button onclick='setCancelarNotaVenta("+rows[0]["idVenta"]+")' class='btn btn-warning btn-sm btn-block'>Cancelar Nota de Venta</button></td></tr>";

                        $("#tableListaPagos").html(tr);
                        $(".currency").numeric({prefix:'$ ', cents: true});
                    }else{
                        MyAlert(response.message);
                    }

                }else{
                    MyAlert(response.message,"error");
                }


            }).fail(function (jqhR,textStatus,errno) {
                if(console && console.log){

                    if(textStatus == "timeout"){
                        //Tiempo de espera agotado
                        MyAlert("Tiempo de espera agotado","error");
                    }else{
                        MyAlert("Error al cargar la vista","error")
                    }

                }
            });

            break;
        case 7: //Cancelar Nota de Pago

            bootbox.confirm({
                title:"Cancelar No Pago",
                size:"small",
                message:"Esta seguro de cancelar el pago ?",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Cancelar'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Aceptar'
                    }
                },
                callback: function (result){

                    if(result){
                        $.ajax({
                            url:"modules/ventas/src/ventas/fnCancelarFolio.php",
                            data:{
                                opc:opcion,
                                folio:folio,
                                pago:data.pago
                            },
                            type:"post",
                            dataType:"json",
                        }).done(function (response) {

                            console.log();

                            if(response.result){

                                var FolioVenta = $("#folio_venta").val();

                                setVentaPagos({opc:6,folio:FolioVenta});

                            }else{
                                MyAlert(response.message,"error");
                            }


                        }).fail(function (jqhR,textStatus,errno) {
                            if(console && console.log){

                                if(textStatus == "timeout"){
                                    //Tiempo de espera agotado
                                    MyAlert("Tiempo de espera agotado","error");
                                }else{
                                    MyAlert("Error al cargar la vista","error")
                                }

                            }
                        });
                    }

                }
            });

            break;
        case 8:
            var folio = $("#txtidVenta").val();
            if(folio == ""){MyAlert("Ingrese un folio");}else{
                SenderAjax(
                    "modules/ventas/views/ventas/",
                    "frm_pagos.php",
                    null,"show_modal","post",{
                        opc:opcion,
                        folio:folio
                    }
                );
            }
            break;
        default:
            MyAlert("Opcion no existe");
            break;
    }




}

getBell = function (e) {

    $.ajax({
        type:"POST",
        dataType:"JSON",
        url:"modules/applications/src/home/fn_alert_bell.php"
    }).done( function(data) {

        if(data.result == "ok"){

            var alert_bell = $("#alert_bell") ;

            alert_bell.html(data.total);

            if(data.total > 0 ){

                $("#alert_bell").prev().addClass("infinite");
                var dlista = "";

                $.each(data.lista, function(i, item) {
                   if(i <= 5 ){
                       dlista = dlista + "<li><a href='#'><i class='fa fa-warning text-danger'></i>" +data.lista[i][2]+ " - "  +data.lista[i][0]+"</a></li>";
                   }
                });

                $("#list_bell").html(dlista);

            }

        }else{

            MyAlert(data.error,"alert");

        }

    }).fail(function(jqXHR,textStatus,errorThrown){
        console.log(textStatus + errorThrown);

    });


}


agregar_carrito_compras =function(idarticulo,tipo_articulo,nombre_articulo,cantidad,precio_venta,precio_compra,e){

    if(cantidad > 0 ){

        $(e).closest("tr").remove();
        SenderAjax(
            "modules/compras/src/ordenes_compra/",
            "fn_agregar_carrito.php",
            null,"lista_productos","post",{
                opc:1,idarticulo:idarticulo,cantidad:cantidad,nombre_articulo:nombre_articulo,precio_compra:precio_compra,
                precio_venta:precio_venta,tipo_articulo:tipo_articulo
            }
        );
    }else{

        MyAlert("Ingrese una Cantidad, antes de agregar un producto","alert");

    }
}

nueva_orden_compra = function(opc,idorden){

    switch (opc){
        case 1:
            //Abrir modal para registrar orden de compra
            SenderAjax(
                "modules/compras/views/ordenes_compra/",
                "frm_nueva_orden_compra.php",
                null,"data_list","post",{
                    opc:opc,
                    idorden:idorden
                }
            );

            break;
        case 2:
            //Abrir modal para agreagr productos a la compra
            if($("#idproveedor").val() == 0 ){
                MyAlert("Seleccione un proveedor para registrar la compra","alert");

            }else if($("#iddepartamento").val()==0){
                MyAlert("Seleccione un departamento de entrega","alert");

            }else{
                SenderAjax(
                    "modules/applications/views/productos/",
                    "frm_buscar_producto.php",
                    null,"show_modal","post",{
                        opc:opc,parametro:2,
                        idorden:idorden
                    }
                );

            }

            break;
        case 3:
            //buscar producto
            $("#list_producto_cart").html('');
            var tipo_producto =  $("#tipo_producto").val();
            SenderAjax(
                "modules/applications/src/productos/",
                "fn_buscar_producto.php",
                null,"list_producto_cart","post",{
                    opc:opc,
                    parametro:2,
                    nombre_producto:$("#nombre_producto").val(),
                    tipo_producto:tipo_producto,
                    idorden:idorden
                }
            );

            break;
        case 4:
            //Guardar Orden de compra

            var idproveedor = $("#idproveedor").val();

            if(idproveedor == 0 ){
                MyAlert("Seleccione un proveedor para registrar la compra","alert");
            }else if($("#iddepartamento").val()==0){
                MyAlert("Seleccione un departamento de entrega","alert");

            }else{
                $.ajax({
                    data:{opc:opc,parametro:4,idproveedor:idproveedor,iddepartamento:$("#iddepartamento").val()},
                    type:"POST",
                    beforeSend:function(){
                        fnloadSpinner(1);
                    },
                    dataType:"JSON",
                    url:"modules/compras/src/ordenes_compra/fn_abc_orden_compra.php"
                }).done( function(data) {

                    fnloadSpinner(2);
                    if(data.confirm == "ok"){

                        getMessage(data.mensaje,'Compra realizada correctamente','success');
                        nueva_orden_compra(1,2);
                        setSendMailNotify({Nombre:"Prueba",Correo:"test",Titulo:"Orden de Compra Registrada",Mensaje:"Se registro orden de Compra<br>Folio: "+data.data.idcompra})
                        VerFacturaDeCompra(1,data.data.idcompra);



                    }else{

                        MyAlert(data.error,"alert");

                    }

                }).fail(function(jqXHR,textStatus,errorThrown){
                    //fnloadSpinner(2);
                    console.log(textStatus + errorThrown);

                });

            }

            break;
        default:
            MyAlert("Error no se encontro el parametro para la consulta","alert");
            break;
    }
};
function setOpenModal(idmodal){
    $('#'+idmodal).modal('toggle');

    setTimeout(function() { $('.modal-body').find('input:text').first().focus(); }, 700);


    $("#"+idmodal).draggable({
        handle: ".modal-header"
    });
}
function valida_salida_de_pantalla(valor) {

    if(valor){
        validar_cierre = true;
    }
}

function AddOptionSelect(selector,valor,texto){

    $(selector).append($("<option value='"+valor+"' selected='selected'></option>").text(texto));
    $(selector +' option[value='+valor+' ]').prop('selected', true).change();



}

shortcut = {
    'all_shortcuts': {}, //All the shortcuts are stored in this array
    'add': function (shortcut_combination, callback, opt) {
        //Provide a set of default options
        var default_options = {
            'type': 'keydown',
            'propagate': false,
            'disable_in_input': false,
            'target': document,
            'keycode': false
        }
        if (!opt) opt = default_options;
        else {
            for (var dfo in default_options) {
                if (typeof opt[dfo] == 'undefined') opt[dfo] = default_options[dfo];
            }
        }

        var ele = opt.target;
        if (typeof opt.target == 'string') ele = document.getElementById(opt.target);
        var ths = this;
        shortcut_combination = shortcut_combination.toLowerCase();

        //The function to be called at keypress
        var func = function (e) {
            e = e || window.event;

            if (opt['disable_in_input']) { //Don't enable shortcut keys in Input, Textarea fields
                var element;
                if (e.target) element = e.target;
                else if (e.srcElement) element = e.srcElement;
                if (element.nodeType == 3) element = element.parentNode;

                if (element.tagName == 'INPUT' || element.tagName == 'TEXTAREA') return;
            }

            //Find Which key is pressed
            if (e.keyCode) code = e.keyCode;
            else if (e.which) code = e.which;
            var character = String.fromCharCode(code).toLowerCase();

            if (code == 188) character = ","; //If the user presses , when the type is onkeydown
            if (code == 190) character = "."; //If the user presses , when the type is onkeydown

            var keys = shortcut_combination.split("+");
            //Key Pressed - counts the number of valid keypresses - if it is same as the number of keys, the shortcut function is invoked
            var kp = 0;

            //Work around for stupid Shift key bug created by using lowercase - as a result the shift+num combination was broken
            var shift_nums = {
                "`": "~",
                "1": "!",
                "2": "@",
                "3": "#",
                "4": "$",
                "5": "%",
                "6": "^",
                "7": "&",
                "8": "*",
                "9": "(",
                "0": ")",
                "-": "_",
                "=": "+",
                ";": ":",
                "'": "\"",
                ",": "<",
                ".": ">",
                "/": "?",
                "\\": "|"
            }
            //Special Keys - and their codes
            var special_keys = {
                'esc': 27,
                'escape': 27,
                'tab': 9,
                'space': 32,
                'return': 13,
                'enter': 13,
                'backspace': 8,

                'scrolllock': 145,
                'scroll_lock': 145,
                'scroll': 145,
                'capslock': 20,
                'caps_lock': 20,
                'caps': 20,
                'numlock': 144,
                'num_lock': 144,
                'num': 144,

                'pause': 19,
                'break': 19,

                'insert': 45,
                'home': 36,
                'delete': 46,
                'end': 35,

                'pageup': 33,
                'page_up': 33,
                'pu': 33,

                'pagedown': 34,
                'page_down': 34,
                'pd': 34,

                'left': 37,
                'up': 38,
                'right': 39,
                'down': 40,

                'f1': 112,
                'f2': 113,
                'f3': 114,
                'f4': 115,
                'f5': 116,
                'f6': 117,
                'f7': 118,
                'f8': 119,
                'f9': 120,
                'f10': 121,
                'f11': 122,
                'f12': 123
            }

            var modifiers = {
                shift: {
                    wanted: false,
                    pressed: false
                },
                ctrl: {
                    wanted: false,
                    pressed: false
                },
                alt: {
                    wanted: false,
                    pressed: false
                },
                meta: {
                    wanted: false,
                    pressed: false
                } //Meta is Mac specific
            };

            if (e.ctrlKey) modifiers.ctrl.pressed = true;
            if (e.shiftKey) modifiers.shift.pressed = true;
            if (e.altKey) modifiers.alt.pressed = true;
            if (e.metaKey) modifiers.meta.pressed = true;

            for (var i = 0; k = keys[i], i < keys.length; i++) {
                //Modifiers
                if (k == 'ctrl' || k == 'control') {
                    kp++;
                    modifiers.ctrl.wanted = true;

                } else if (k == 'shift') {
                    kp++;
                    modifiers.shift.wanted = true;

                } else if (k == 'alt') {
                    kp++;
                    modifiers.alt.wanted = true;
                } else if (k == 'meta') {
                    kp++;
                    modifiers.meta.wanted = true;
                } else if (k.length > 1) { //If it is a special key
                    if (special_keys[k] == code) kp++;

                } else if (opt['keycode']) {
                    if (opt['keycode'] == code) kp++;

                } else { //The special keys did not match
                    if (character == k) kp++;
                    else {
                        if (shift_nums[character] && e.shiftKey) { //Stupid Shift key bug created by using lowercase
                            character = shift_nums[character];
                            if (character == k) kp++;
                        }
                    }
                }
            }

            if (kp == keys.length && modifiers.ctrl.pressed == modifiers.ctrl.wanted && modifiers.shift.pressed == modifiers.shift.wanted && modifiers.alt.pressed == modifiers.alt.wanted && modifiers.meta.pressed == modifiers.meta.wanted) {
                callback(e);

                if (!opt['propagate']) { //Stop the event
                    //e.cancelBubble is supported by IE - this will kill the bubbling process.
                    e.cancelBubble = true;
                    e.returnValue = false;

                    //e.stopPropagation works in Firefox.
                    if (e.stopPropagation) {
                        e.stopPropagation();
                        e.preventDefault();
                    }
                    return false;
                }
            }
        }
        this.all_shortcuts[shortcut_combination] = {
            'callback': func,
            'target': ele,
            'event': opt['type']
        };
        //Attach the function with the event
        if (ele.addEventListener) ele.addEventListener(opt['type'], func, false);
        else if (ele.attachEvent) ele.attachEvent('on' + opt['type'], func);
        else ele['on' + opt['type']] = func;
    },

    //Remove the shortcut - just specify the shortcut and I will remove the binding
    'remove': function (shortcut_combination) {
        shortcut_combination = shortcut_combination.toLowerCase();
        var binding = this.all_shortcuts[shortcut_combination];
        delete(this.all_shortcuts[shortcut_combination])
        if (!binding) return;
        var type = binding['event'];
        var ele = binding['target'];
        var callback = binding['callback'];

        if (ele.detachEvent) ele.detachEvent('on' + type, callback);
        else if (ele.removeEventListener) ele.removeEventListener(type, callback, false);
        else ele['on' + type] = false;
    }
}

function gn_menu_principal(opc,parametro){

    $("#show_modal").html('');
	getBell(1);

	switch(opc){
        case 1:
            // dashboard

            break;
        case 5:
            //Menu Almacenes

            SenderAjax(
                    "modules/almacen/views/almacen/",
                    "frm_home.php",
                    null,
                    "div_general",
                    "post",
                    {opc:5}
            );

            break;
        case 6:
            // Menu Compras
            SenderAjax(
                "modules/compras/views/compras/",
                "frm_home.php",
                null,
                "div_general",
                "post",
                "{opc:5}"
            );
            break;
        case 7:
            // Menu Catálogos
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_lista_catalogos.php",
                null,
                "div_general",
                "post",
                "{opc:5}"
            );
            break;
        case 8:
            // Menu Contabilidiad
            SenderAjax(
                "modules/contabilidad/views/contabilidad/",
                "frm_home.php",
                null,
                "div_general",
                "post",
                "{opc:5}"
            );
            break;
        case 9:
            // Menu Ventas
            SenderAjax(
                "modules/ventas/views/ventas/",
                "frm_home.php",
                null,
                "div_general",
                "post",
                "{opc:5}"
            );
            break;
        case 10:
            // Menu Reportes
            SenderAjax(
                "modules/reportes/views/reportes/",
                "frm_home.php",
                null,
                "div_general",
                "post",
                "{opc:5}"
            );
            break;
        case 11:
            // Menu Reportes - Reporte de Ventas
            SenderAjax(
                "app/modules/reportes/views/reporte_ventas/",
                "frm_reporte_ventas.php",
                null,
                "div_general",
                "post",
                "{opc:5}"
            );
            break;
        case 12:
            // Menu Reportes - Reporte de Productos
            SenderAjax(
                "app/modules/reportes/views/reporte_productos/",
                "frm_reporte_productos.php",
                null,
                "div_general",
                "post",
                "{opc:5}"
            );
            break;
        case 13:
            // Menu Almacen  Marcas

            SenderAjax(
                "modules/almacen/views/marcas/",
                "frm_marcas.php",
                null,
                "div_general",
                "post",
                "{opc:5}"
            );
            break;
        case 14:
            //Menu Configuraciones
            SenderAjax(
                "modules/configuracion/views/parametros/",
                "frm_parametros.php",
                null,
                "div_general",
                "post",
                "{opc:5}"
            );
            break;
        case 15:
            //Menu Ventas / Servicios
            SenderAjax(
                "modules/servicios/views/home/",
                "frm_servicios.php",
                null,
                "form_caja",
                "post",
                "{opc:5}"
            );
            break;
	}
}

function setFormatoMoneda(opc,valor) {

    switch (opc){
        case 1:
            //Desconvertir formato moneda
            var cadena = valor.replace('$', "");
            cadena = cadena.replace(',',"");
            //console.log(cadena);
            return cadena;
            break;
    }

    alert(cadena);

    return valor;

}

function setFormatoColor(opc,valor){

    switch (opc){
        case 1:
            //Convertir a formato color: idcolor + codigoColor
            //Retornar idcolor
            var cadena = valor.split('-');
            //console.log(cadena);
            return cadena[0];
            break;
        case 2:
            //Desconvertir formato color: idcolor + codigoColor
            //Retornar codigoColor
            var cadena = valor.split('-');
            //console.log(cadena);
            return cadena[1];
            break;
    }

}

function setGeneraUtilidad(opc,precio_compra,porcentaje){

    switch (opc){
        case 1:

            precio_compra = setFormatoMoneda(1,precio_compra);


            $.ajax({
                data:{precio_compra:precio_compra,porcentaje:porcentaje },
                type:"POST",
                dataType:"JSON",
                url:"modules/applications/src/catalogos/fn_calcular_precio.php"
            }).done( function(data) {

                //console.log(data);
                $('#precio_venta').val(data.precio_venta);

            }).fail(function(jqXHR,textStatus,errorThrown){
                //console.log(textStatus + errorThrown);

            });

            break;
        case 2:
            //Con Javascre
            var precio = setFormatoMoneda(1,precio);

            //alert(precio + "-" + porcentaje);

            var total = ( parseFloat(precio)  * parseInt(porcentaje) / 100) ;

            return parseFloat(precio) + parseFloat(total);
            break;
    }

}


//Funcion para la pantalla completa
function requestFullScreen() {

    var el = document.body;

    // Supports most browsers and their versions.
    var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen
        || el.mozRequestFullScreen || el.msRequestFullScreen;

    if (requestMethod) {

        // Native full screen.
        requestMethod.call(el);

    } else if (typeof window.ActiveXObject !== "undefined") {

        // Older IE.
        var wscript = new ActiveXObject("WScript.Shell");

        if (wscript !== null) {
            wscript.SendKeys("{F11}");
        }
    }
}

function gnlogin_out(){

	if(validar_cierre){
        bootbox.confirm({
            title: "Salir del Sistema",
            message: "Esta seguro de salir del sistema.",
            size:"small",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancelar'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Aceptar'
                }
            },
            callback: function (result) {

                if(result){

                    SenderAjax(
                        "modules/applications/src/login/",
                        "fn_login_out.php",
                        null,
                        "div_general",
                        "POST",
                        "{opc:0}"
                    );

                }
            }
        });
    }else{
        SenderAjax(
            "modules/applications/src/login/",
            "fn_login_out.php",
            null,
            "div_general",
            "POST",
            "{opc:0}"
        );

    }


}

function jsRemoveWindowLoad() {
    // eliminamos el div que bloquea pantalla
    $("#WindowLoad").remove();

}

function jsShowWindowLoad(mensaje) {
    //eliminamos si existe un div ya bloqueando
    jsRemoveWindowLoad();

    //si no enviamos mensaje se pondra este por defecto
    if (mensaje === undefined) mensaje = " ";

    //centrar imagen gif
    height = 20;//El div del titulo, para que se vea mas arriba (H)
    var ancho = 0;
    var alto = 0;

    //obtenemos el ancho y alto de la ventana de nuestro navegador, compatible con todos los navegadores
    if (window.innerWidth == undefined) ancho = window.screen.width;
    else ancho = window.innerWidth;
    if (window.innerHeight == undefined) alto = window.screen.height;
    else alto = window.innerHeight;

    //operación necesaria para centrar el div que muestra el mensaje
    var heightdivsito = alto/2 - parseInt(height)/2;//Se utiliza en el margen superior, para centrar

    //imagen que aparece mientras nuestro div es mostrado y da apariencia de cargando
    imgCentro = "<div style='text-align:center;height:" + alto + "px;'><div class='text-white text-bold'  style='margin-top:" + heightdivsito + "px; font-size:20px;'>" +
        "<div class='preloader pl-size-l'><div class='spinner-layer pl-teal'><div class='circle-clipper left'><div class='circle'></div> </div><div class='circle-clipper right'><div class='circle'></div> </div></div></div></div></div>";

    //creamos el div que bloquea grande------------------------------------------
    div = document.createElement("div");
    div.id = "WindowLoad";
    div.style.width = ancho + "px";
    div.style.height = alto + "px";
    $("body").append(div);

    //creamos un input text para que el foco se plasme en este y el usuario no pueda escribir en nada de atras
    input = document.createElement("input");
    input.id = "focusInput";
    input.type = "text"

    //asignamos el div que bloquea
    $("#WindowLoad").append(input);

    //asignamos el foco y ocultamos el input text
    $("#focusInput").focus();
    $("#focusInput").hide();

    //centramos el div del texto
    $("#WindowLoad").html(imgCentro);

}

function fnloadSpinner(opc){


    switch (opc){
        // mostrar fa-Spinner
        case 1:
            jsShowWindowLoad();
            break;
        case 2:
            // Ocultar fa-Spinner
            jsRemoveWindowLoad();
            break;
        default :
            MyAlert("error no se encontro la opci&oacute;n solicitada","error");
            break;
    }
}

function MyConfirm(){
    bootbox.confirm({
        title: "Destroy planet?",
        message: "Do you want to activate the Deathstar now? This cannot be undone.",
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> Cancel'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Confirm'
            }
        },
        callback: function (result) {

            if(result){
                return true ;
            }
        }
    });
}

function MyAlert(message,isType){

    bootbox.dialog({
        title:"Alerta",
        message:message,
        size:"small",
        buttons:{
            ok:{
                label:"Aceptar",
                className:"btn-primary btn-sm"
            }
        }
    });

}

function setPush(mensaje){
    Push.create(mensaje);
}

function getMessage (messages,pTitle,typemsg,timer){

    if(timer){
        timer = 3500;
    }

    switch (typemsg){

        case "notice":
            PNotify.prototype.options.delay = timer;
            new PNotify({
                title: pTitle,
                text: messages,
                type: typemsg
            });
            break;
        case "info":
            //PNotify.prototype.options.styling = "jqueryui";
            PNotify.prototype.options.delay = timer;
            new PNotify({
                title: pTitle,
                text: messages
            });
            break;
        case "success":
            PNotify.prototype.options.delay = timer;
            new PNotify({
                title: pTitle,
                text: messages,
                type: typemsg
            });
            break;
        case "error":
            PNotify.prototype.options.delay = timer;
            new PNotify({
                title: pTitle,
                text: messages,
                type: typemsg
            });
            break;
        case "danger":
            PNotify.prototype.options.delay = timer;
            new PNotify({
                title: pTitle,
                text: messages,
                type: typemsg
            });
            break;
        case "warning":
            PNotify.prototype.options.delay = timer;
            new PNotify({
                title: pTitle,
                text: messages,
                type: typemsg
            });
            break;
        case null:
            PNotify.prototype.options.delay = timer;
            PNotify.prototype.options.styling = "jqueryui";
            new PNotify(messages);
            break;
        default :
            PNotify.prototype.options.delay = timer;
            PNotify.prototype.options.styling = "jqueryui";
            new PNotify(messages);
            break;
    }
}

function showalert(message,alerttype) {

    $('#alert').append('<div id="alertdiv" role="alert" class="alert ' +  alerttype + '"><a class="close" data-dismiss="alert">×</a><span>'+message+'</span></div>')

    setTimeout(function() { // this will automatically close the alert and remove this if the users doesnt close it in 5 secs


        $("#alertdiv").remove();

    }, 5000);
}

function SenderAjax(urlPhp,nameView,params,idDiv,is_type,stringData){
    if(params == null){
        params = "";
    }else{
    	params = "?" + params ;
    }

    $.ajax({
        url:urlPhp + nameView + params,
        cache:false,
        data:stringData,
        beforeSend:function(){
            fnloadSpinner(1);
        },
        timeout:300000, //5 minutos de espera
        type:is_type
    }).done(function(data){


        $("#"+idDiv).html(data);
        fnloadSpinner(2);

    }).fail(function(jqHR,textEstatus,errno){
        fnloadSpinner(2);

        if(console && console.log){
            if(textEstatus == 'timeout')
            {
                MyAlert('EL tiempo de la solicitud a sido agotado','alert');
                //do something. Try again perhaps?

            }else{
            	 MyAlert(
                "Error al realizar la carga de la vista: <br>" +
                "{<br> url=>"+urlPhp +"  <br> " +
                "view => "+nameView +", <br>"+
                textEstatus+ " =>  "+
                errno +"<br> "+
                jqHR+ "<br>" +
                "}"
            );
            }
           
        }


    });
}