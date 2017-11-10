/**
 * Created by alejandro.gomez on 29/05/2017.
 */

var viewContentVenta = false;
var gPagoInicial = false,gPagoEfectivo = true,gPagoTerjeta = false,gPagoCombinado = false;

function WindowsOpenReport(idReport,arrayid) {


    switch (idReport){
        //Ticket de Entradas y Salidas
        case 1:
            var idEntrada = arrayid.idEntrada;
            window.open("modules/ventas/reportes/PDFEntradas-01.php?pc="+idReport+"&id="+idEntrada+"","","location=no,width=600,height=700,scrollbars=NO,menubar=NO,titlebar=NO,toolbar=NO");
            break;
        //Ticket de Aportacion y retiros
        case 2:
            var idAportacion = arrayid.idAportacion;
            window.open("modules/ventas/reportes/PDFAportaciones-01.php?pc="+idReport+"&id="+idAportacion+"","","location=no,width=600,height=700,scrollbars=NO,menubar=NO,titlebar=NO,toolbar=NO");
            break;
         //Cancelaciones de Entras y Salidas
        case 3:
            var idEntrada = arrayid.idEntrada;
            window.open("modules/ventas/reportes/PDFEntradas-01.php?pc="+idReport+"&id="+idEntrada+"","","location=no,width=600,height=700,scrollbars=NO,menubar=NO,titlebar=NO,toolbar=NO");
            break;
        //Cancelaciones de Aportaciones y retiros
        case 4:
            var idAportacion = arrayid.idAportacion;
            window.open("modules/ventas/reportes/PDFAportaciones-01.php?pc="+idReport+"&id="+idAportacion+"","","location=no,width=600,height=700,scrollbars=NO,menubar=NO,titlebar=NO,toolbar=NO");
            break;
    }

}

function setCancelarNotaVenta(idVenta) {
    bootbox.confirm({
      title:"Cancelacion de Nota",
      message:"Esta seguro de ralizar la cancelación",
      size:"small",
       buttons:buttonBootBox,
       callback:function (result) {
           if(result){




           }
       }
   });
}

function getCorteDiario(opc,Departamento) {

    switch (opc){
        //Mostrar Plantilla de Corte Diario
        case 1:
            SenderAjax(
                "modules/ventas/views/ventas/",
                "FrmCorteDiario.php",
                null,
                "form_caja",
                "post", {opc:opc}
            );
            break;
        //Llamr la funcion de corte diario
        case 2:
            $.ajax({
                url:"modules/ventas/src/ventas/getCorteDiario.php",
                type:"get",
                dataType:"json",
                data:{opc:opc,idDepartamento:Departamento},
                beforeSend:function () {
                    fnloadSpinner(1);
                }
            }).done(function (response) {
                fnloadSpinner(2);

                console.log(response);
                if(response.result){

                    var CajaInicial = 0,SubTotal = 0, Total = 0;

                    $("#nnotasventa").text(response.data.Movimientos.Notas);
                    $("#npagos").text(response.data.Movimientos.Pagos);
                    $("#ncancelaciones").text(response.data.Movimientos.Cancelaciones);
                    $("#TotalMovimientos").text(response.data.Movimientos.Total);

                    $("#aportacion").text(response.data.Aportaciones.Aportacion);
                    $("#retiro").text(response.data.Aportaciones.Retiro);
                    $("#cancelacion_aportaciones").text(response.data.Aportaciones.Cancelacion);
                    $("#total_aportaciones").text(response.data.Aportaciones.Total);

                    $("#entrada").text(response.data.Entradas.Entradas);
                    $("#salida").text(response.data.Entradas.Salidas);
                    $("#cancelacion_entrada").text(response.data.Entradas.Cancelacion);
                    $("#total_entrada").text(response.data.Entradas.Total);

                    SubTotal = response.data.Movimientos.Total + response.data.Aportaciones.Total + response.data.Entradas.Total ;

                    $("#total").text(SubTotal + CajaInicial);
                    $("#caja_inicial").text(CajaInicial);
                    $("#subtotal").text(SubTotal);

                    $('.currency').numeric({prefix:'$ ', cents: true});

                }else{
                    MyAlert(response.message);
                }

            }).fail(function (jqhr,textStatus,errno) {

                fnloadSpinner(2);

                if(console && console.log){
                    if(textStatus == "timeout"){
                        MyAlert("Tiempo de espera agotado");
                    }else{
                        MyAlert("Error al llamar la vista solicitada");
                    }
                }
            });

            break;
        default:
            MyAlert("La opcion no existe");
            break;
    }

}

function getReorteMovimientosDiario(opc) {

    switch (opc){
        //Mostrar Modal de Movimientos Diario
        case 1:
            SenderAjax(
                "modules/ventas/views/ventas/",
                "FrmMovimientosDiario.php",
                null,
                "idgeneral",
                "post", {opc:opc}
            );
            break;
        case 2:
            //Mostrar Reporte de Movimientos diarios
            $.ajax({
                url:"modules/ventas/src/ventas/getMovimientosDiarios.php",
                type:"get",
                dataType:"json",
                data:{opc:opc}
            }).done(function (response) {

                if(response.result){
                    console.log(response);

                    var templete = '<table id="tableMovimientos" class="table table-bordered table-hover table-striped table-condensed"><thead><tr><th>Nota de Venta</th><th>Cliente</th><th>NoPago</th><th>Importe</th><th>Pago</th><th>Estatus</th><th>Fecha</th></tr></thead><tbody>';
                    var endTemplete = '</tbody></table>';
                    var dataRows = '';
                    var Total=0;
                    var rows = response.data;

                    for(i=0;i<rows.length;i++){

                        dataRows = dataRows + "<tr><td>"+rows[i].FolioVenta+"</td><td>"+rows[i].nombre_completo+"</td><td>"+rows[i].FolioPago+"</td><td class='currency text-right'>"+rows[i].Importe+"</td><td class='currency text-right'>"+rows[i].TotalPagado+"</td><td>"+rows[i].idestatus+"</td><td>"+rows[i].FechaMovimiento+"</td></tr>";

                    }
                    Total = response.Total;
                    var footer = "<tr><td colspan='4' class='text-bold text-right'>Total</td><td class='currency text-right'>"+Total+"</td><td colspan='2'></td></tr>";


                    $("#form_caja").html(templete+dataRows+footer+endTemplete);
                    $("#tableMovimientos th").addClass("bg-bareylev");
                    $("#mdlMovimientos").click();
                    $(".currency").numeric({prefix:'$ ',cents:true});

                }else{
                    MyAlert(response.message)
                }

            }).fail(function (jqhr,textStatus,errno) {

                if(console && console.log){
                    if(textStatus == "timeout"){
                        MyAlert("Tiempo de espera agotado");
                    }else{
                        MyAlert("Error al cargar la vista");
                    }
                }
            });

            break;
        default:
            MyAlert("La opcion no existe");
            break;
    }

}

function getCancelarAportacionesRetiros(opc,Tipo,Folios) {

    switch (opc) {
        case 1:
            SenderAjax(
                "modules/ventas/views/aportaciones/",
                "FrmCancelarAportaciones.php",
                null,
                "idgeneral",
                "post", {opc: opc, Tipo: Tipo, Folio: Folios}
            );
            break;
        case 2:
            var Folio = $('#FolioAportacion').val();
            var Motivo = $("#motivo").val();

            if(Folio <= 0 || $.trim(Folio) == ""){
                MyAlert("Ingrese un numero de Folio");
            }else if(isNaN(Folio)){
                MyAlert("El folio debe ser numerico");
            }else if($.trim(Motivo) == ""){
                MyAlert("Ingrese un motivo de cancelación");
            }else{

                $.ajax({
                    url:"modules/ventas/src/aportaciones/fnCancelarAportacion.php",
                    type:"POST",
                    dataType:"json",
                    data:{opc:opc,Tipo:Tipo,Folio:Folio,Motivo:Motivo}
                }).done(function (response) {

                    if(response.result){

                        console.log(response);
                        $("#FolioCancelacion").val(+response.data.Folio);
                        $("#box2").addClass("hidden");
                        $("#box3").removeClass("hidden");

                    }else{
                        MyAlert(response.message);
                    }

                }).fail(function (jqhr,textStatus,errno) {

                    if(console && console.log){

                        if(textStatus == "timeout"){
                            MyAlert("Tiempo de espera agotado");
                        }else{
                            MyAlert("Error al cargar la vista");
                        }

                    }

                });
            }
            break;
        default:
            MyAlert("Opcion no encontrada");
            break;
    }

}

function getCancelarEntradaSalidas(opc,Tipo,Folio){

    switch (opc){
        case 1:
            SenderAjax(
                "modules/ventas/views/entradas/",
                "FrmCancelarEntrada.php",
                null,
                "idgeneral",
                "post",{opc:opc,Tipo:Tipo,Folio:Folio}
            );
            break;
        case 2:

            var Motivo = $("#motivo").val();

            if(Folio <= 0 || $.trim(Folio) == ""){
                MyAlert("Ingrese un numero de Folio");
            }else if(isNaN(Folio)){
                MyAlert("El folio debe ser numerico");
            }else if($.trim(Motivo) == ""){
                MyAlert("Ingrese un motivo de cancelación");
            }else{

                $.ajax({
                    url:"modules/ventas/src/entradas/fnCancelarEntrada.php",
                    type:"POST",
                    dataType:"json",
                    data:{opc:opc,Tipo:Tipo,Folio:Folio,Motivo:Motivo}
                }).done(function (response) {

                    if(response.result){

                        console.log(response);
                        $("#FolioCancelacion").val(+response.data.Folio);
                        $("#box2").addClass("hidden");
                        $("#box3").removeClass("hidden");

                    }else{
                        MyAlert(response.message);
                    }

                }).fail(function (jqhr,textStatus,errno) {

                    if(console && console.log){

                        if(textStatus == "timeout"){
                            MyAlert("Tiempo de espera agotado");
                        }else{
                            MyAlert("Error al cargar la vista");
                        }

                    }

                });


            }

            break;
        default:
            MyAlert("La opcion solicitada no existe");
            break;
    }

}

function getAportaciones(opc,TipoAportacion) {

    switch (opc){
        case 1:
            SenderAjax(
                "modules/ventas/views/aportaciones/",
                "FrmAportaciones.php",
                null,
                "idgeneral",
                "post",{opc:opc,TipoAportacion:TipoAportacion}
            );
            break;
        case 2:

            console.log(TipoAportacion);
            var idorigen = $("#sucursal_origen").val(),
                iddestino = $("#sucursal_destino").val(),
                importe = $("#importe_aportacion").val(),
                observaciones = $("#observaciones").val();

            importe = setFormatoMoneda(1,importe);

            if(idorigen == 0){
                MyAlert("Seleccione la sucursal origen");
            }else if(iddestino == 0){
                MyAlert("Seleccione la sucursal destino");
            }else if(importe == 0.00){
                MyAlert("Ingrese un importe");
            }else if($.trim(observaciones)==""){
                MyAlert("Ingrese una observacion");
            }else{

                $.ajax({
                    url:"modules/ventas/src/aportaciones/fnRegistrarAportacion.php",
                    type:"post",
                    dataType:"json",
                    data:{opc:TipoAportacion,idorigen:idorigen,iddestino:iddestino,importe:importe,observaciones:observaciones},
                    beforeSend:function () {
                        fnloadSpinner(1);
                    }
                }).done(function (response) {

                    fnloadSpinner(2);
                    if(response.result){

                        $("#box1").addClass("hidden");
                        $("#box2").removeClass("hidden");
                        $("#mdlBtnGuardar").addClass("hidden");
                        $("#FolioAportacion").val(''+response.data.Folio+'');

                        if(TipoAportacion == 1){
                            getMessage("Aportacion registrada correctamente","Aportacion","success",800);
                        }else{
                            getMessage("Retiro registrado correctamente","Retiro","success",800);
                        }

                    }else{
                        MyAlert(response.message);
                    }
                    console.log(response);
                }).fail(function (jqhr,textStatus,errno) {
                    fnloadSpinner(2);
                    if(console && console.log){
                        if(textStatus == "timeout"){
                            MyAlert("Tiempo de espera agotad");
                        }else{
                            MyAlert("Error al cargar la vista");
                        }
                    }
                })

            }

            break;
        case 3:
            SenderAjax(
                "modules/ventas/views/entradas/",
                "FrmSalida.php",
                null,
                "idgeneral",
                "post",{opc:opc}
            );
            break;
        case 4:
            var idconcepto = $("#idconcepto_salida").val(),
                importe = $("#importe_salida").val(),
                observaciones = $("#observaciones_salida").val();

            importe = setFormatoMoneda(1,importe);

            if(idconcepto == 0){
                MyAlert("Seleccione un concepto");
            }else if(importe == 0.00){
                MyAlert("Ingrese un importe");
            }else if($.trim(observaciones)==""){
                MyAlert("Ingrese una observacion");
            }else{

                $.ajax({
                    url:"modules/ventas/src/entradas/fnRegistrarSalida.php",
                    type:"post",
                    dataType:"json",
                    data:{idconcepto:idconcepto,importe:importe,observaciones:observaciones},
                    beforeSend:function () {
                        fnloadSpinner(1);
                    }
                }).done(function (response) {

                    console.log(response);

                    fnloadSpinner(2);

                    if(response.result){

                        $("#box1").addClass("hidden");
                        $("#box2").removeClass("hidden");
                        $("#mdlBtnGuardar").addClass("hidden");
                        $("#FolioEntrada").val(''+response.data.Folio+'');
                        getMessage("Salida registrada correctamente","Salida","success",900);

                    }else{
                        MyAlert(response.message);
                    }

                }).fail(function (jqhr,textStatus,errno) {
                    fnloadSpinner(2);
                    if(console && console.log){
                        if(textStatus == "timeout"){
                            MyAlert("Tiempo de espera agotad");
                        }else{
                            MyAlert("Error al cargar la vista");
                        }
                    }
                });

            }
            break;
        case 5:
            SenderAjax(
                "modules/ventas/views/aportaciones/",
                "FrmReimpresionAportaciones.php",
                null,
                "idgeneral",
                "post",{opc:opc,TipoAportacion:TipoAportacion}
            );
            break;
        case 6:
            var Folio = $("#FolioAportacion").val();

            if(Folio <= 0 || $.trim(Folio) == ""){
                MyAlert("Ingrese un numero de Folio");
            }else if(isNaN(Folio)){
                MyAlert("El folio debe ser numerico");
            }else{

                $.ajax({
                    url:"modules/ventas/src/aportaciones/fnBuscarFolio.php",
                    type:"get",
                    dataType:"json",
                    data:{opc:opc,Folio:Folio,TipoAportacion:TipoAportacion},
                    timeout:8000
                }).done(function (response) {
                    console.log(response.data);

                    if(response.result){

                        $("#tituloMovimiento").html("<b>Transacción</b>: "+response.data.tipo);
                        $("#cajaorigen").val(response.data.origen);
                        $("#cajadestino").val(response.data.destino);
                        $("#importe").val(response.data.importe);
                        $("#observacion").val(response.data.descripcion);

                        $(".currency").numeric({prefix:'$ ',cents:true});
                        $("#box2").removeClass("hidden");

                    }else{
                        MyAlert(response.message);
                    }

                }).fail(function (jqhr,textStatus,errno) {

                    if(console && console.log){

                        if(textStatus == "timeout"){
                            MyAlert("Tiempo de espera agotado");
                        }else{
                            MyAlert("Error al cargar la vista");
                        }

                    }

                });
            }

            break;
        default:
            MyAlert("Opcion no encontrada");
            break;
    }

}

function getEntradas(opc,Tipo) {

    switch (opc){
        case 1:
            SenderAjax(
                "modules/ventas/views/entradas/",
                "FrmEntrada.php",
                null,
                "idgeneral",
                "post",{opc:opc}
            );
            break;
        case 2:

            var idconcepto = $("#idconcepto").val(),
                importe = $("#importe_entrada").val(),
                observaciones = $("#observaciones").val();

            importe = setFormatoMoneda(1,importe);

            if(idconcepto == 0){
                MyAlert("Seleccione un concepto");
            }else if(importe == 0.00){
                MyAlert("Ingrese un importe");
            }else if($.trim(observaciones)==""){
                MyAlert("Ingrese una observacion");
            }else{

                $.ajax({
                    url:"modules/ventas/src/entradas/fnRegistrarEntrada.php",
                    type:"post",
                    dataType:"json",
                    data:{idconcepto:idconcepto,importe:importe,observaciones:observaciones},
                    beforeSend:function () {
                        fnloadSpinner(1);
                    }
                }).done(function (response) {

                    fnloadSpinner(2);
                    if(response.result){

                        $("#box1").addClass("hidden");
                        $("#box2").removeClass("hidden");
                        $("#mdlBtnGuardar").addClass("hidden");
                        $("#FolioEntrada").val(''+response.data.Folio+'');
                        getMessage("Entrada registrada correctamente","Entradas","success",800);


                    }else{
                        MyAlert(response.message);
                    }
                    console.log(response);
                }).fail(function (jqhr,textStatus,errno) {
                    fnloadSpinner(2);
                    if(console && console.log){
                        if(textStatus == "timeout"){
                            MyAlert("Tiempo de espera agotad");
                        }else{
                            MyAlert("Error al cargar la vista");
                        }
                    }
                })

            }

            break;
        case 3:
            SenderAjax(
                "modules/ventas/views/entradas/",
                "FrmSalida.php",
                null,
                "idgeneral",
                "post",{opc:opc}
            );
            break;
        case 4:
            var idconcepto = $("#idconcepto_salida").val(),
                importe = $("#importe_salida").val(),
                observaciones = $("#observaciones_salida").val();

            importe = setFormatoMoneda(1,importe);

            if(idconcepto == 0){
                MyAlert("Seleccione un concepto");
            }else if(importe == 0.00){
                MyAlert("Ingrese un importe");
            }else if($.trim(observaciones)==""){
                MyAlert("Ingrese una observacion");
            }else{

                $.ajax({
                    url:"modules/ventas/src/entradas/fnRegistrarSalida.php",
                    type:"post",
                    dataType:"json",
                    data:{idconcepto:idconcepto,importe:importe,observaciones:observaciones},
                    beforeSend:function () {
                        fnloadSpinner(1);
                    }
                }).done(function (response) {

                    console.log(response);

                    fnloadSpinner(2);

                    if(response.result){

                        $("#box1").addClass("hidden");
                        $("#box2").removeClass("hidden");
                        $("#mdlBtnGuardar").addClass("hidden");
                        $("#FolioEntrada").val(''+response.data.Folio+'');
                        getMessage("Salida registrada correctamente","Salida","success",900);

                    }else{
                        MyAlert(response.message);
                    }

                }).fail(function (jqhr,textStatus,errno) {
                    fnloadSpinner(2);
                    if(console && console.log){
                        if(textStatus == "timeout"){
                            MyAlert("Tiempo de espera agotad");
                        }else{
                            MyAlert("Error al cargar la vista");
                        }
                    }
                });

            }
            break;
        case 5:
            SenderAjax(
                "modules/ventas/views/entradas/",
                "FrmReimpresionEntradas.php",
                null,
                "idgeneral",
                "post",{opc:opc}
            );
            break;
        case 6:
            var Folio = $("#FolioEntrada").val();

            if(Folio <= 0 || $.trim(Folio) == ""){
                MyAlert("Ingrese un numero de Folio");
            }else if(isNaN(Folio)){
                MyAlert("El folio debe ser numerico");
            }else{
                $.ajax({
                    url:"modules/ventas/src/entradas/fnBuscarFolio.php",
                    type:"get",
                    dataType:"json",
                    data:{opc:opc,Folio:Folio,Tipo:Tipo},
                    beforeSend:function () {
                        fnloadSpinner(1);
                    }
                }).done(function (response) {
                    fnloadSpinner(2);
                    if(response.result){

                        console.log(response);

                        $("#tituloMovimiento").html("<b>Transacción</b>: "+response.data.tipo);

                        $("#importe").val(response.data.importe);
                        $("#observacion").val(response.data.descripcion);

                        $(".currency").numeric({prefix:'$ ',cents:true});
                        $("#box2").removeClass("hidden");

                    }else{
                        MyAlert(response.message);
                    }

                }).fail(function (jqhr,textStatus,errno) {
                    fnloadSpinner(2);

                    if(console && console.log){

                        if(textStatus == "timeout"){
                            MyAlert("Tiempo de espera agotado");
                        }else{
                            MyAlert("Error al cargar la vista");
                        }

                    }

                });
            }

            break;
        default:
            MyAlert("Opcion no encontrada");
            break;
    }
}

function fngetDetaleTrabajo(idventa,data) {

    var divDetalle = $("#getDetalleOrden");

    divDetalle.html("");

    var TempleteART = '',
        TempleteMAT = '',NombreArticulo='';

    divDetalle.html("<input id='txtidVenta' class='hidden' disabled value='"+idventa+"'/>");


    for(i=0;i<data.length;i++){

        if(idventa == data[i].idventa){


            $("#getTituloDetalle").text(data[i].Folio+" - "+ data[i].NombreCliente);

            $(".toolbars").removeClass('hidden');


            if(data[i].tipo_articulo == "ART"){

                    $("#datos_cliente").html('<div class="col-md-12 invoice-col no-padding "><address class="well well-sm no-margin"><strong>Datos del cliente</strong><br>Nombre: '+data[i].NombreCliente+'<br>Fecha venta: '+data[i].FechaVenta+'<br>Fecha promesa: '+data[i].FechaPromesa+'</address></div>');


                NombreArticulo = data[i].nombre_articulo;
                TempleteART = '<div class="col-md-6 ">\n' +
                    '                        <div class="panel panel-info">\n' +
                    '                            <div class="panel-heading padding-x3"><b>Articulo</b>: '+NombreArticulo +'</div>\n' +
                    '                            <div class="panel-body no-padding scroll-auto" style="min-height: 25vh;">\n' +
                            '                       <table class="table table-condensed table-hover  no-border"><tr><td><strong><i class="fa fa-book margin-r-5"></i>  Producto</strong><p class="text-muted">'+ NombreArticulo  +'</p></td><td><strong><i class="fa fa-book margin-r-5"></i>  Cantidad</strong><p class="text-muted">'+ data[i].cantidad  +'</p></td></tr><tr><td colspan="2"><strong><i class="fa fa-bookmark margin-r-5"></i> Descripción</strong><p class="text-muted">'+data[i].descripcion+'</p></td></tr><tr><td colspan="2"><strong><i class="fa fa-paper-plane"></i> Material</strong><p id="textMat" class="text-muted">'+TempleteMAT+'</p></td></tr></table>' +
                            '                    </div>' +
                        '                    </div>' +
                    '                    </div>';
                divDetalle.html(divDetalle.html()+TempleteART);
            }

            if(data[i].tipo_articulo=="MAT"){
                TempleteMAT = "Material: " +data[i].nombre_articulo+"<br>Cantidad: "+data[i].cantidad;
                $("#textMat").html($("#textMat").text()+TempleteMAT);
            }

        }
    }

}

function fnListarTrabajos(opc) {

    $.ajax({
        url:"modules/ventas/src/trabajos/fnListarTrabajos.php",
        type:"get",
        dataType:"json",
        data:{opc:opc}
    }).done(function (response) {

        if(response.result){

            var i,trs='',trabajos = response.detalle;
            var vdata,idVenta,FolioVenta,NombreCliente,FechaVenta,FechaPromesa;

            if(trabajos.length > 0){

                for(i=0;i<trabajos.length;i++){

                    if(response.data[i] == trabajos[i].idventa){

                        idVenta = trabajos[i].idventa;
                        FolioVenta = trabajos[i].Folio;
                        NombreCliente = trabajos[i].NombreCliente;
                        FechaVenta = trabajos[i].FechaVenta;
                        FechaPromesa = trabajos[i].FechaPromesa;

                        vdata = JSON.stringify(trabajos);

                        trs = trs + "<tr onclick='fngetDetaleTrabajo("+idVenta+","+vdata+")' style='cursor: pointer'><td class='text-center'>"+FolioVenta+"</td><td>"+NombreCliente+"</td><td>"+FechaVenta+"</td><td>"+FechaPromesa+"</td></tr>";


                    }
                }

                $("#tblListaTrabajos").html(trs);
                $("#tblListaTrabajos tr ").click(function () {
                    $("#tblListaTrabajos tr ").removeClass('bg-light-blue-gradient text-white');
                    $(this).addClass('bg-light-blue-gradient text-white');
                });
                $(".toolbars").addClass("hidden");

            }else{
                getMessage("No se encontraron trabajos","Trabajos","success",850);
            }

        }else{
            MyAlert(response.message);
        }

    }).fail(function (jqhr,textStatus,errno) {
       if(console && console.log){
           if(textStatus == "timeout"){
               MyAlert("Tiempo de espera agotado");
           }else{
               MyAlert("Error al cargar la visra");
           }
       }
    });
}
function fnTrabajosPendientes(opc){

    switch (opc){
        case 1:
            SenderAjax(
                "modules/ventas/views/trabajos/",
                "FrmTrabajos.php",
                null,
                "form_caja",
                "post",
                {
                   opc:opc
                }
            )
            break;
    }
}

function fnVentaCierreCaja(opcion){

    switch (opcion){
        //Validar cierre del dia anterior
        case 1:

            $.ajax({
                url:"modules/ventas/src/cierre/fn_cierre_caja.php",
                type:"POST",
                data:{opc:opcion},
                dataType:"JSON"
            }).done(function(response){

                if(response.result == "success"){


                    switch (response.mensaje){
                        case 'cierre_anterior':
                            //No se realizo cierre del dia enterior
                            $("#form_caja").html('<div class="row"><div class="col-md-12"><div class="callout callout-danger"><h4>No se ha realizado el cierre del dia anterior !</h4><p>Realize primeramente el cierre del día anterior, para hacer la apertura de la caja.</p></div></div></div>');
                            break;
                        case 'dia_cerrado':
                            //Ciere del dia realizado
                            $("#form_caja").html('<div class="row"><div class="col-md-12"><div class="callout callout-success"><h4>Cierre Realizado !</h4><p>Movimientos no proceden El día ya fue cerrado.</p></div></div></div>');
                            break;
                        case 'sistema_nuevo':
                            //Realizar Apertura
                            $("#form_caja").html('<div class="row"><div class="col-md-12"><div class="callout callout-warning"><h4>No se ha realizado la apertura !</h4><p>Realize primeramente la apertura del dia para poder realizar las ventas diarias.</p></div></div></div>');

                            break;
                        case 'Apertura_mayor':
                            //
                            break;
                        default:
                            $("#form_caja").html('<div class="row"><div class="col-md-12"><div class="callout callout-danger"><h4>Error 404</h4><p>Intentelo nuevamente o Contacte al administrador.</p></div></div></div>');
                            break;
                    }
                }
            }).fail(function(jqh,textStatus){
                MyAlert("error al realizar la solicitud" + textStatus,"alert");
            });

            break;
        case 2:

            var saldo_final_caja = $("#saldo_final_caja").val(),
                saldo_final_caja = setFormatoMoneda(1,saldo_final_caja),
                fecha_cierre = $("#fecha_cierre").val();

            $.ajax({
                url:"modules/ventas/src/cierre/fn_cierre_caja.php",
                type:"POST",
                data:{opc:opcion,saldo_final_caja:saldo_final_caja,fecha_cierre:fecha_cierre},
                dataType:"JSON"
            }).done(function(data){

                if(data.result == "error"){
                    MyAlert(data.mensaje,"error");
                }

                if(data.result == "ok"){
                    MyAlert("Cierre finalizado correctamente","alert");
                }

            }).fail(function(jqh,textStatus){
                MyAlert("error al realizar la solicitud" + textStatus,"alert");
            });

            break;
        default:
            break;
    }

}

function setApertura(opc,FechaApertura,SaldoApertura) {
    switch (opc){
        case 1:
            //Mostrar Formulario de Apertura
            SenderAjax(
              "modules/ventas/views/apertura/",
                "frm_apertura.php",
                null,
                "idgeneral",
                "post",
                {opc:opc,FechaApertura:FechaApertura}
            );
            break;
        case 2:

            var FechaApertura = $("#FechaApertura").val(),
                SaldoApertura = $("#SaldoApertura").val();

            SaldoApertura = setFormatoMoneda(1,SaldoApertura);

            $.ajax({
                url:"modules/ventas/src/apertura/fn_apertura_caja.php",
                type:"post",
                dataType:"json",
                data:{
                    FechaApertura:FechaApertura,
                    SaldoApertura:SaldoApertura,
                    opc:opc
                }
            }).done(function (response) {

                MyAlert(response.message);

            }).fail(function (jqhr,textStatus,errno) {

                if(console && console.log){

                    if(textStatus == "timeout"){
                        MyAlert("Tiempo de espera agotado");
                    }else{
                        MyAlert("Error al cargar la vista");
                    }

                }

            });



            break;
    }
}

function getValidarApertura(FechaActual) {
    $.ajax({
        url:"modules/ventas/src/apertura/getValidaApertura.php",
        type:"get",
        dataType:"json",
        data:{FechaActual:FechaActual}
    }).done(function (response) {

        //console.log(response);
        return response;


    }).fail(function (jqhr,textStatus,errno) {
        if(console && console.log){

            if(textStatus == "timeout"){
                return "error";
            }else{
                return "error";
            }
        }
    });
}

function getValidarCierre(FechaActual) {

    $.ajax({
        url:"modules/ventas/src/cierre/getValidaCierre.php",
        type:"get",
        dataType:"json",
        data:{FechaActual:FechaActual}
    }).done(function (response) {

        if(response.result){

            switch (response.data.opc){
                case 1:

                   var res = getValidarApertura(FechaActual);

                    if(res.result){

                        setApertura(1,FechaActual,1);
                        $("#form_caja").html('<div class="row"><div class="col-md-12"><div class="callout callout-info"><h4>Realizar Apertura!</h4><p>Realize la apertura del dia.</p></div></div></div>');

                    }else {
                        setApertura(1,FechaActual,1);

                    }


                    break;
                case 2:
                    $("#form_caja").html('<div class="row"><div class="col-md-12"><div class="callout callout-success"><h4>Cierre Realizado !</h4><p>Movimientos no proceden El día ya fue cerrado.</p></div></div></div>');
                    break;
                case 3:
                    $("#form_caja").html('<div class="row"><div class="col-md-12"><div class="callout callout-danger"><h4>No se ha realizado el cierre del dia anterior !</h4><p>Realize primeramente el cierre del día anterior, para hacer la apertura de la caja.</p></div></div></div>');

                    break;
            }

        }else{
            MyAlert(response.message);
        }


    }).fail(function (jqhr,textStatus,errno) {

        if(console && console.log){

            if(textStatus == "timeout"){
                MyAlert("Tiempo de espera agotado");
            }else{
                MyAlert("Vista no encontrada");
            }
        }

    })
}

//Apertura Caja
function fnVentaAperturaCaja(opcion) {

    switch (opcion){
        case 1:

            //Validar si existe el cierre del dia anterior
            $.ajax({
                url:"modules/ventas/src/apertura/fn_apertura_caja.php",
                type:"POST",
                data:{opc:opcion},
                dataType:"JSON"
            }).done(function(data){

                if(data.result == "error"){
                    MyAlert(data.mensaje,"alert");
                    $("#form_caja").html('<div class="row"><div class="col-md-12"><div class="callout callout-warning"><h4>No se ha realizado la apertura !</h4><p>Realize primeramente la apertura del dia para poder realizar las ventas diarias.</p></div></div></div>');
                }

            }).fail(function(jqh,textStatus){
                MyAlert("error al realizar la solicitud" + textStatus,"alert");
            });

            break;
        case 2:
            //realizar apertura de caja
            var SaldoInicial = $("#saldo_inicial").val();
            SaldoInicial = setFormatoMoneda(1,SaldoInicial);

            $.ajax({
                url:"modules/ventas/src/apertura/fn_apertura_caja.php",
                type:"POST",
                data:{opc:opcion,SaldoInicial:SaldoInicial},
                dataType:"JSON"
            }).done(function(data){

                if(data.result == "ok"){
                    gn_menu_principal(9,9);
                }

                if(data.result == "error"){
                    MyAlert(data.mensaje,"alert");
                    $("#form_caja").html('<div class="row"><div class="col-md-12"><div class="callout callout-warning"><h4>No se ha realizado la apertura !</h4><p>Realize primeramente la apertura del dia para poder realizar las ventas diarias.</p></div></div></div>');
                    viewContentVenta = false;
                }

            }).fail(function(jqh,textStatus){
                MyAlert("error al realizar la solicitud" + textStatus,"alert");
            });

            break;
        case 3:
            break;
        default:
            break;

    }

}

function fnVentaTrabajosPendientes(opc) {

    SenderAjax(
      "modules/ventas/views/ventas/",
        "frm_trabajos_pendientes.php",
        null,
        "cashOpen",
        "post",
        {opc:opc}
    );

}

function fnVentaServicios() {


    $.ajax({
        url:"modules/servicios/src/servicios/fn_registrar_recarga.php",
        type:"post",
        dataType:"json",
        beforeSend:function () {
          fnloadSpinner(1);
        },
        data:{
            SysKey:"12345",
            id:"19201012021",
            referencia:"5555555525",
            producto:"TEL200",
            bolsaID:"1"
        },
    }).done(function (response) {

        fnloadSpinner(2);

        if(response.error == 0){
            MyAlert("<span class='text-bold' ><i class='fa fa-check-circle-o text-success'></i> "+response.message+"<br><span class='text-center'>Fecha: "+response.data.Fecha+"<br>Transaccion: "+response.data.TransID+"<br>Folio: "+response.data.Folio+"</span></span>","alert");
        }else{

            MyAlert("<span class='text-bold' ><i class='fa fa-exclamation-triangle'></i>"+response.message+"</span>","alert");

        }

    }).fail(function (jqh,textStatus) {

        fnloadSpinner(2);
        console.log("Error: "+textStatus);
    })

}

function fnVentaAceptarPago(){

    var folio_venta = $("#folio_venta").val(),
        importe_pendiente = setFormatoMoneda(1,$("#textSaldoPendiente").val()),
        importe_pago = setFormatoMoneda(1,$("#textPago").val()),
        importe_total = setFormatoMoneda(1,$("#textImporteTotal").val()),
        tipo_venta = $("#textTipoVenta").val();

    $.ajax(
        {
            url:"modules/ventas/src/ventas/fn_realizar_pago.php",
            type:"post",
            dataType:"json",
            data:{
             folio_venta:folio_venta,
                importe_pendiente:importe_pendiente,
                importe_pago:importe_pago,
                importe_total:importe_total,
                tipo_venta:tipo_venta
            },
            beforeSend:function(){
                $("#btnAceptarPago").attr("disabled",true);
            }
        }
    ).done(function(response){

            //$("#modal_result").text(response.toString());

            switch (response.result){
                case "ok":

                    $("#folio_venta").attr("disabled",true);
                    $("#result_pago").toggleClass("hidden");
                    $("#detalle_pago").toggleClass("hidden");

                    if(response.data.tipo_ticket == 'abono'){
                        $("#row_cambio").toggleClass("hidden");
                    }

                    $("#folio_pago").val(response.data.folio_pago);
                    $("#total_cambio").val(response.data.cambio);
                    $("#total_cambio").addClass("currency");
                    $(".currency").numeric({prefix:'$ ', cents: true});

                    break;
                case "error":
                    MyAlert(response.mensaje,"error");
                    break;
            }


        }).fail(function(jxqh,textStatus){
            MyAlert("Error al llamar el metodo fn_realiza_pago: "+textStatus,"error");
        })

}

/**
 * Historial Cliente
 * @param {data}
 */

function fnVentaHistorialCliente(data){

    var opcion = data.opc;

    switch (opcion){

        case 1: //Mostrar formulario para buscar cliente

            SenderAjax(
                "modules/ventas/views/clientes/",
                "frm_cliente.php",
                null,
                "form_caja",
                "post",
                {opc:opcion}
            );

            break;
        case 2: // Realizar la busqueda del cliente

            SenderAjax(
                "modules/ventas/views/clientes/",
                "frm_folios_clientes.php",
                null,
                "lista_folios_cte",
                "post",
                {
                    idcliente:data.idcliente
                }

            );

            break;
        case 3: //Mostrar detalles y pagos del folio de venta seleccionado
            SenderAjax(
                "modules/ventas/views/clientes/",
                "frm_folios_clientes.php",
                null,
                "lista_folios_cte",
                "post",
                {
                    idcliente:data.idcliente
                }

            );
            break;
        case 4: //Mostrar detalles y pagos del folio de venta seleccionado
            SenderAjax(
                "modules/ventas/views/clientes/",
                "frm_detalle_venta_cliente.php",
                null,
                "detalle_venta",
                "post",
                {
                    idcliente:data.idcliente,
                    folio_venta:data.folio_venta
                }

            );
            break;

    }






}

function fnVentaEliminarProducto(idproducto){

    $.ajax({
        url:"modules/ventas/src/ventas/fn_eliminar_producto.php",
        data:{idproducto:idproducto},
        type:"post",
        dataType:"JSON"
    }).done(function(data){

        if(data.result == "ok"){

            fnVentaShowCartProducto(2);

        }else{
            MyAlert(data.mensaje,"alert");
        }

    }).fail(function(jqh,textStatus){
       MyAlert("Error al llamar el metodo delete","alert");
    });

}

function fnVentaTipoPago(valor) {
    switch (valor){
        case '1':
            // Pago en Efectivo
            gPagoEfectivo = true;
            gPagoCombinado = false;
            gPagoTerjeta = false;
            $("#gpoPagoEfectivo").removeClass("hidden");
            $("#gpoPagoTarjeta").addClass("hidden");
            break;
        case '2':
            // Pago en Tarjeta
            gPagoEfectivo = false;
            gPagoCombinado = false;
            gPagoTerjeta = true;
            $("#gpoPagoEfectivo").addClass("hidden");
            $("#gpoPagoTarjeta").removeClass("hidden");
            break;
        case '3':
            // Pago en Combinado
            gPagoEfectivo = false;
            gPagoCombinado = true;
            gPagoTerjeta = false;
            $("#gpoPagoEfectivo").removeClass("hidden");
            $("#gpoPagoTarjeta").removeClass("hidden");
            break;
    }
}

function fnVentaTipoVenta(valor) {


   if(valor == 2){
        $("#txtPagoMinimo").toggleClass("hidden");
       gPagoInicial = true;
   }else{
       $("#txtPagoMinimo").toggleClass("hidden");
       gPagoInicial = false;
   }


}

function fnAgregarTipoDiseno(idDiseno){

    if(idDiseno > 0){
        $.ajax({
            url:"modules/ventas/src/ventas/fnAgregarTipoDiseno.php",
            type:"post",
            dataType:"json",
            data:{idDiseno:idDiseno}
        }).done(function(response){

            console.log(response);

            if(response.result){

                fnVentaShowCartProducto(1);

            }else{
                MyAlert(response.message);
            }

        }).fail(function(jqhR,textStatus,errno){

            if(console && console.log){

                if(textStatus == "timeout"){
                    MyAlert("Tiempo de espera agotado");
                }else{
                    MyAlert("Error al cargar la vista");
                }

            }

        })
    }

}

function fnVentaCobrarVenta(opc) {

    switch (opc){
        //Abrir modal para cobrar
        case 1:

            var idcliente = $('#idcliente').val();
            var tipodiseno = $("#costotrabajo").val();

            if(idcliente == 0){
                MyAlert("Seleccione un cliente, antes de realizar el cobro","alert");
            }else{

                SenderAjax(
                    "modules/ventas/views/ventas/",
                    "frm_caja_ventas.php",
                    null,
                    "show_modal",
                    "post",
                    {opc: opc}
                );
            }
            break;
        case 2:
            //Realizar Cobro de la venta
            var idcliente = $("#idcliente").val(),
                TipoVenta = $("#opcTipoVenta").val(),
                pago_efectivo = $("#idpago_efectivo").val(),
                pago_tarjeta = $("#idpago_tarjeta").val(),
                total_venta = $("#idtotal_venta").val();

            var pago_inicial = $("#idtotal_pago_inicial").text(),
                descripcion_general = $("#descripcion_general").val();

            var FechaEntrega = $("#FechaEntrega").val(),
                HoraEntrega = $("#HoraEntrega").val(),
                MinutoEntrega = $("#MinutoEntrega").val(),
                FormatoHora = $("#FormatoHora").val();

            pago_efectivo = parseFloat(setFormatoMoneda(1,pago_efectivo));
            pago_tarjeta = parseFloat(setFormatoMoneda(1,pago_tarjeta));
            total_venta = parseFloat(setFormatoMoneda(1,total_venta));
            pago_inicial = parseFloat(setFormatoMoneda(1,pago_inicial));

            if(FechaEntrega == ""){
                MyAlert("Seleccione la fecha de entrega");
            }else{

                var myConfirm = false;

                if(TipoVenta == 2 && pago_efectivo < pago_inicial){

                    //Venta a credito
                    MyAlert("El pago minimo debe ser de : " + pago_inicial ,"alert");
                    myConfirm = false;

                }else{ myConfirm = true;  }

                if(TipoVenta == 1 && pago_efectivo < total_venta){

                    //Venta de contado
                    MyAlert("El pago es inferior al total de la venta","alert");
                    myConfirm = false;

                }else{ myConfirm = true;pago_inicial = 0;}

                if(myConfirm){

                    $("#btnRealizarCobro").attr('disabled',true);

                    $.ajax({
                        url:"modules/ventas/src/ventas/fn_realizar_cobro.php",
                        type:"post",
                        dataType:"json",
                        beforeSend:function () {
                            fnloadSpinner(1);
                        },
                        data:{
                            tipo_venta:TipoVenta,
                            tipo_pago:1,
                            total_venta:total_venta,
                            pago_inicial:pago_inicial,
                            pago_efectivo:pago_efectivo,
                            pago_tarjeta:0,
                            descripcion_general:descripcion_general,
                            idcliente:idcliente,
                            FechaEntrega:FechaEntrega,
                            HoraEntrega:HoraEntrega,
                            MinutoEntrega:MinutoEntrega,
                            FormatoHora:FormatoHora
                        }
                    }).done(function (response) {
                        fnloadSpinner(2);
                        console.log(response);

                        var dataRegistraVenta = response.data;

                        if(response.result){

                            if(response.data.existencias >= 1 ){
                                /**
                                 * Sin existencias
                                 * Se genera Orden de Compra
                                 */
                                getMessage("Registrando orden de compra","","warning",300);
                                $.ajax({
                                    url:"modules/compras/src/ordenes_compra/fn_abc_orden_compra.php",
                                    type:"post",
                                    dataType:"json",
                                    beforeSend:function () {
                                        fnloadSpinner(1);
                                    },
                                    data:{
                                        parametro:1,
                                        lista_articulos:dataRegistraVenta.articulos
                                    }
                                }).done(function (response2) {

                                    console.log(response2)

                                    fnloadSpinner(2);

                                    if(response2.result){

                                        getMessage("Orden de Compra Registrada","","success",800);
                                    }else{
                                        MyAlert(response2.message);
                                    }

                                }).fail(function (jqhr,textStatus,errno) {
                                   fnloadSpinner(2);
                                   if(console && console.log){
                                       if(textStatus == "timeout"){
                                           MyAlert("Tiempo de espera agotado");
                                       }else{
                                           MyAlert("Error al cargar la vista");
                                       }
                                   }
                                });

                            }


                            if(TipoVenta  == 1){

                                $('#folio_venta').val(response.data.FolioVenta);
                                $('#form_caja').html('');
                                $('#total_cambio').val(response.data.cambio);
                                $('#vta01').addClass('hidden');
                                $('#vta02').removeClass('hidden');
                                $('.modal-body .callout').fadeOut('slow')

                            }else if(TipoVenta == 2){
                                $('#folio_venta').val(response.data.FolioVenta);
                                $('#form_caja').html('');
                                $('#result_caja').addClass('hidden');
                                $('#vta01').addClass('hidden');
                                $('#vta02').removeClass('hidden');
                                $('.modal-body .callout').fadeOut('slow');

                            }

                            $('.currency').numeric({prefix:'$ ', cents: true});



                        }else{
                            MyAlert(response.message);
                        }

                    }).fail(function (jqhr,textStatus,errno) {
                       fnloadSpinner(2);
                        if(console && console.log){
                            if(textStatus == "timeout"){
                                MyAlert("Tiempo de espera agotado");
                            }else{
                                MyAlert("Error al cargar la vista");
                            }
                        }
                    });


                    /**SenderAjax(
                        "modules/ventas/src/ventas/",
                        "fn_realizar_cobro.php",
                        null,
                        "modal_result",
                        "post",
                        {
                            tipo_venta:TipoVenta,
                            tipo_pago:1,
                            total_venta:total_venta,
                            pago_inicial:pago_inicial,
                            pago_efectivo:pago_efectivo,
                            pago_tarjeta:0,
                            descripcion_general:descripcion_general,
                            idcliente:idcliente,
                            FechaEntrega:FechaEntrega,
                            HoraEntrega:HoraEntrega,
                            MinutoEntrega:MinutoEntrega,
                            FormatoHora:FormatoHora
                        }
                    );**/
                }
            }


            break;
        default:
            MyAlert("Processnado : 31212012","alert");
            break;
    }


}

function fnVentaAgregarCombo(opc){

    var descripcion = $("#descripcion_combo").val(),
        idcombo = setFormatoColor(1,$("#idcombo").val()),
        send = false;

    if($.trim(descripcion) == ""){
        bootbox.confirm({
            title: "Agregar Combo",
            message: "No agrego ninguna descripción, está seguro de continuar ?",
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

                    //SI Continuar si descripcion
                    send = true;

                }
            }
        });
    }else{

        send = true;

    }

    if(send){

        $.ajax({
            url:"modules/ventas/src/combos/fn_agregar_combo.php",
            type:"post",
            dataType:"json",
            data:{idcombo:idcombo,descripcion:descripcion}
        }).done(function (response) {

            for (l in response.data.ART) {

                $.ajax({
                    url:"modules/ventas/src/ventas/fn_agregar_producto.php",
                    type:"post",
                    data:{
                        producto:response.data.ART[l].idproducto    ,
                        tipo_producto:response.data.ART[l].tipo_producto,
                        descripcion:response.data.ART[l].descripcion,
                        nombre_producto:response.data.ART[l].nombre_producto,
                        idproducto:response.data.ART[l].idproducto,
                        idcantidad:1
                    },
                    dataType:"JSON"
                }).done(function(response2){

                    if(response2.result == "ok"){

                        fnVentaShowCartProducto(1);

                    }else if(response2.result == "error"){
                        MyAlert(response2.mensaje,"alert");
                    }

                }).fail(function(jqXHR,textStatus,errorThrown){

                    console.log(textStatus + errorThrown);

                });

                //data.libros.lib[l].autores[0]
            }

            for (l in response.data.MAT) {

                $.ajax({
                    url:"modules/ventas/src/ventas/fn_agregar_producto.php",
                    type:"post",
                    data:{
                        producto:response.data.MAT[l].idproducto    ,
                        tipo_producto:response.data.MAT[l].tipo_producto,
                        descripcion:response.data.MAT[l].descripcion,
                        nombre_producto:response.data.MAT[l].nombre_producto,
                        idproducto:response.data.MAT[l].idproducto,
                        idcantidad:1
                    },
                    dataType:"JSON"
                }).done(function(response2){

                    if(response2.result == "ok"){

                        fnVentaShowCartProducto(1);

                    }else if(response2.result == "error"){
                        MyAlert(response2.mensaje,"alert");
                    }

                }).fail(function(jqXHR,textStatus,errorThrown){

                    console.log(textStatus + errorThrown);

                });

                //data.libros.lib[l].autores[0]
            }


        }).fail(function (jqh,textStatus) {
            MyAlert("error al registrar el combo"+textStatus,"alert");
        })
    }
}

function fnVentaShowCartProducto(opc) {

    switch (opc){

        case 1:
            SenderAjax(
              "modules/ventas/src/ventas/",
               "fn_mostrar_productos.php",
                null,
                "list_cart_ventas",
                "post",
                {opc:opc}
            );
            getMessage("Producto agregado",'','success',150);
            break;
        case 2:
            SenderAjax(
                "modules/ventas/src/ventas/",
                "fn_mostrar_productos.php",
                null,
                "list_cart_ventas",
                "post",
                {opc:opc}
            );
            getMessage("Producto eliminado",'','danger',150);
            break;
    }

}

function fnVentaAddCartMateriales(){

    var producto = $("#material").val(),
        idproducto = setFormatoColor(1,producto),
        nombre_producto = setFormatoColor(2,producto),
        idcantidad = $("#txtCantidadMat").val(),
        tipo_producto = "MAT";

    if(idcantidad == 100){idcantidad = '1';}else{idcantidad = '0.'+idcantidad;}

    if($.trim(producto) == ""){
        MyAlert("No se encontro ningun producto seleccionado","alert");
    }else if(isNaN(idcantidad)){
        MyAlert("La cantidad seleccionada es incorrecta","alert");
    }else if(idcantidad <= 0.0){
        MyAlert("La cantidad seleccionada es incorrecta","alert");
    }else{

        $.ajax({
            url:"modules/ventas/src/ventas/fn_agregar_producto.php",
            type:"post",
            data:{
                producto:producto,
                nombre_producto:nombre_producto,idproducto:idproducto,idcantidad:idcantidad,tipo_producto:tipo_producto},
            dataType:"JSON"
        }).done(function(data){

            console.log(data);

            if(data.result){

                var articulo = data.data;

                fnVentaShowCartProducto(1);

                if(articulo.existencias <= 0){
                    getMessage("No cuenta con existencias del articulo "+articulo.nombre,"Sin Existencias","warning",750);
                }


            }else{
                MyAlert(data.message,"alert");
            }

        }).fail(function(jqXHR,textStatus,errorThrown){

            console.log(textStatus + errorThrown);

        });


    }

}

function fnVentaAddCartProducto(opc,param) {

    var producto = $("#producto").val(),
        idproducto = setFormatoColor(1,producto),
        nombre_producto = setFormatoColor(2,producto),
        idcantidad = $("#txtCantidad").val(),
        descripcion_por_producto = $("#descripcion_por_producto").val(),
        tipo_producto = "ART";

    if($.trim(producto) == ""){
        MyAlert("No se encontro ningun producto seleccionado","alert");
    }else if(isNaN(idcantidad)){
        MyAlert("La cantidad seleccionada es incorrecta","alert");
    }else if(idcantidad <= 0){
        MyAlert("La cantidad seleccionada es incorrecta","alert");
    }else{

        $.ajax({
            url:"modules/ventas/src/ventas/fn_agregar_producto.php",
            type:"post",
            data:{
                opc:opc,
                producto:producto,
                tipo_producto:tipo_producto,
                descripcion:descripcion_por_producto,
                nombre_producto:nombre_producto,
                idproducto:idproducto,
                idcantidad:idcantidad
            },
            dataType:"JSON"
        }).done(function(response){

            console.log(response);


            if(response.result){

                var articulo = response.data;

                fnVentaShowCartProducto(1);

                if(articulo.existencias <= 0){
                    getMessage("No cuenta con existencias del articulo "+articulo.nombre,"Sin Existencias","warning",900);
                }
                $("#producto").val("");
                $("#txtCantidad").val(1);

            }else {

                MyAlert(response.message,"alert");


            }

        }).fail(function(jqXHR,textStatus,errorThrown){

            console.log(textStatus + errorThrown);

        });
    }
}

function getCrearTrabajo(opc,array) {

    console.log(array);

    switch (opc){
        //Mostrar Contenedor para ingresar la descripcion del trabajo
        case 1:
            var ValorProducto = array.valor;
            var NombreProducto = array.NombreProducto;

            $("#producto").val(ValorProducto);
            $("#txtNameProduc").html(NombreProducto);
            $("#descripcion_por_producto").val('').focus();
            $("#content02").removeClass("hidden");
            $("#content01").addClass("hidden");

            break;
        //Regresar al Paso 1 (Seleccionar el producto)
        case 2:

            if(array.opc == 1){
                bootbox.confirm({
                    title:"Regresar",
                    message:"Se perderan los datos, esta seguro de continuar",
                    size:"small",
                    buttons:buttonBootBox,
                    callback:function (result) {
                        if(result){
                            $('#textSearch').val('');
                            $('#textSearch').focus();
                            $('#lista_busqueda_producto').html('');
                            $('#txtCantidad').val(1);
                            $('#content02').addClass('hidden');
                            $('#content01').removeClass('hidden');
                        }
                    }
                });
            }else if(array.opc == 2){
                bootbox.confirm({
                    title:"Regresar",
                    message:"Se perderan los datos, esta seguro de continuar",
                    size:"small",
                    buttons:buttonBootBox,
                    callback:function (result) {
                        if(result){

                            $('#content03').addClass('hidden');
                            $('#content02').removeClass('hidden');

                            $("#content02MAT").addClass("hidden");
                            $("#content01MAT").addClass("hidden");
                            $("#tipoMaterial").removeClass('hidden');
                            $("#lista_materiales").html('');
                        }
                    }
                });
            }

            break;
         //Mostrar Contenedor para Agegar Material
        case 3:
            var Descripcion = $("#descripcion_por_producto").val(),isNext = false;

            if($.trim(Descripcion)==""){
                bootbox.confirm({
                    title:"Continuar",
                    message:"La descripción esta vacía, esta seguro de continuar",
                    size:"small",
                    buttons:buttonBootBox,
                    callback:function (result) {
                        if(result){
                            isNext = true;
                            $("#content02").addClass("hidden");
                            $("#content03").removeClass("hidden");

                        }
                    }
                });
            }else{
                $("#content02").addClass("hidden");
                $("#content03").removeClass("hidden");
            }


            break;
        //Seleccionar el Nombre del Material
        case 4:
            var ValorProducto = array.valor;
            var NombreProducto = "Material: "+array.NombreProducto;

            $("#material").val(ValorProducto);
            $("#title_cantida").html(NombreProducto);
            $("#content02MAT").removeClass("hidden");
            $("#content01MAT").addClass("hidden");
            $("#txtCantidad").val(100);
            $("#btnregresar2").addClass('hidden');

            break;
        // Agrear producto, material Utilizado, Tipo de Diseño y Cantidad al carrito
        case 5:

            var producto = $("#producto").val(),
                idproducto = setFormatoColor(1,producto),
                nombre_producto = setFormatoColor(2,producto),
                idcantidad = $("#txtCantidad").val(),
                descripcion_por_producto = $("#descripcion_por_producto").val(),
                TipoDiseno = $("#costotrabajo").val(),
                tipo_producto = "ART";


            if($.trim(producto) == ""){
                MyAlert("No se encontro ningun producto seleccionado","alert");
            }else if(isNaN(idcantidad)){
                MyAlert("La cantidad seleccionada es incorrecta","alert");
            }else if(idcantidad <= 0){
                MyAlert("La cantidad seleccionada es incorrecta","alert");
            }else if(TipoDiseno=='sin'){
                MyAlert("Ingrese el tipo de diseño");
            }else{

                $.ajax({
                    url:"modules/ventas/src/ventas/fn_agregar_producto.php",
                    type:"post",
                    data:{
                        opc:opc,
                        producto:producto,
                        tipo_producto:tipo_producto,
                        descripcion:descripcion_por_producto,
                        nombre_producto:nombre_producto,
                        idproducto:idproducto,
                        idcantidad:idcantidad,
                        TipoDiseno:TipoDiseno
                    },
                    dataType:"JSON"
                }).done(function(response){


                    console.log(response);


                    if(response.result){

                        var articulo = response.data;

                        fnVentaShowCartProducto(1);

                        if(articulo.existencias <= 0){
                            getMessage("No cuenta con existencias del articulo "+articulo.nombre,"Sin Existencias","warning",900);
                        }
                        $("#btnModalClose").click();

                    }else{

                        MyAlert(response.message,"alert");

                    }

                }).fail(function(jqXHR,textStatus,errorThrown){

                    console.log(textStatus + errorThrown);

                });
            }

            break;
        default:
            MyAlert("La opcion solicitada no existe");
            break;
    }

}


function fnVentaOpenModal(data) {

    var opcion = data.opc;


    switch (opcion){
        case 1:
            //frm_modal_productos.php
                SenderAjax(
                    "modules/ventas/views/ventas/",
                    "FrmDisenador.php",
                    null,"show_modal","post",{
                    }
                );
            break;
        case 2:

            var textSearch = $("#textSearch").val();

            if(textSearch.length >= 3){
                $.ajax({
                    url:"modules/ventas/src/ventas/fn_buscar_producto.php",
                    type:"post",
                    data:{opc:opcion,textSearch:textSearch},
                    beforeSend:function(){
                        $("#lista_busqueda_producto").html("Espere un momento.....");
                    }
                }).done(function(data){

                    $("#lista_busqueda_producto").html(data);

                }).fail(function(jqr,textstatus){

                });
            }

            break;
        case 3:
            //Abrir modal buscar material
            SenderAjax(
                "modules/ventas/views/ventas/",
                "frm_modal_materiales.php",
                null,"show_modal","post",{

                }
            );
            break;
        case 4:
            //Buscar MAterial
            var textSearch = $("#txtNombreMaterial").val();

            if(textSearch.length >= 3){
                $.ajax({
                    url:"modules/ventas/views/ventas/frm_modal_colores_materiales.php",
                    type:"post",
                    data:{opc:opcion,textSearch:textSearch},
                    beforeSend:function(){
                        $("#lista_materiales").html("<div class='col-md-12'>Espere un momento.....</div>");
                    }
                }).done(function(data){

                    $("#lista_materiales").html(data);

                }).fail(function(jqr,textstatus){

                });
            }
            break;
        //Modal para apertura de caja
        case 5:
            SenderAjax(
                "modules/ventas/views/apertura/",
                "frm_apertura.php",
                null,"show_modal","post",{

                }
            );
            break;
        //Modal para cierre de caja
        case 6:
            SenderAjax(
                "modules/ventas/views/cierre/",
                "frm_cierre.php",
                null,"show_modal","post",{

                }
            );
            break;
        //Modal para arqueo de caja
        case 7:
            SenderAjax(
                "modules/ventas/views/arqueo/",
                "frm_arqueo.php",
                null,"show_modal","post",{

                }
            );
            break;
        case 8:
            SenderAjax(
                "modules/ventas/views/ventas/",
                "frm_productos_virtuales.php",
                null,"show_modal","post",{

                }
            );
            break;
        case 9:

            var textSearch = $("#textSearchCombo").val();

            $.ajax({
                url: "modules/ventas/src/ventas/fn_buscar_producto_virtual.php",
                type:"post",
                data:{opc:opcion,textSearch:textSearch},
                beforeSend:function(){
                    $("#lista_combos").html("<div class='col-md-12'>Espere un momento.....</div>");
                }
            }).done(function(data){

                $("#lista_combos").html(data);

            }).fail(function(jqr,textstatus){

            });

            break;
    }
}