/**
 * Created by alejandro.gomez on 22/05/2017.
 */

function fnEportarInventario() {

    window.open("modules/almacen/reportes/XLSReporteInventario-02.php","","location=no,width=700,height=800,scrollbars=NO,menubar=NO,titlebar=NO,toolbar=NO");

}

function fnReporteInventario(opc) {

    switch (opc){
        case 1: //Mostrar el formulario para la busqueda

            SenderAjax(
                "modules/almacen/views/inventario/",
                "FrmReporteInventario.php",
                null,
                "show_modal",
                "post",
                {opc:opc}
            );
            break;
        case 2://Llamar a funcion para realizar la busqueda

            var idalmacen = $("#txtidAlmacen").val(),
                idarticulo = $("#txtidArticulo").val(),
                idcategoria = $("#txtidCategoria").val(),
                idTipo = $("#txtidTipo").val(),rows="";

            var tabla = "<div class='padding-x5'><button onclick='fnEportarInventario()' class='btn btn-info btn-xs '><i class='fa fa-file-excel-o'></i> Exportar</button><span class='pull-right'>Se Encntraron <span id='ttInventario' class='badge'>00</span> registros</span></div> <table class='table table-hover table-condensed table-striped'><thead><tr><th class='bg-bareylev'>#</th><th class='bg-bareylev'>Almacen</th><th class='bg-bareylev'>Articulo</th><th class='bg-bareylev'>Categoría</th><th class='bg-bareylev'>Tipo</th><th class='bg-bareylev'>Existencias</th></tr></thead><tbody id='listaReporteInventario'></tbody></table>"

            $.ajax({
                url:"modules/almacen/src/inventario/fnBuscarReporteInventarios.php",
                type:"get",
                dataType:"json",
                data:{idalmacen:idalmacen,idarticulo:idarticulo,idcategoria:idcategoria,idTipo:idTipo},
                beforeSend:function () {
                    fnloadSpinner(1);
                }
            }).done(function (response) {
                fnloadSpinner(2);

                console.log(response);

                if(response.result){

                    for(i=0;i< response.data.length;i++){
                        rows = rows + "<tr><td>1</td><td>"+response.data[i].nombre_almacen+"</td><td>"+response.data[i].nombre_articulo+"</td><td>"+response.data[i].nombre_catalogo+"</td><td>"+response.data[i].tipo_articulo+"</td><td>"+response.data[i].existencias+"</td></tr>";
                    }



                    $("#lista_traspasos").html(tabla);
                    $("#listaReporteInventario").html(rows);
                    $("#mdlBtnReporteInventario").click();
                    $("#ttInventario").text(response.data.length);

                }else{
                    MyAlert(response.message);
                }
                //MyAlert(response.message);


            }).fail(function (jqhr,textStatus,errno) {
               fnloadSpinner(2);

               if(console && console.log()){
                   if(textStatus == "timeout"){
                       MyAlert("Se agoto el tiempo de espera");
                   }else{
                       MyAlert("No se encontro la vista solicitada");
                   }
               }
            });

            break;
        default:
            MyAlert("Opcion no encntrada");
            break;
    }

}

function fnEditarTraspaso(opc,idTraspaso) {

    switch (opc){
        case 1://Mostrar formulario para editar traspaso
            SenderAjax(
                "modules/almacen/views/traspasos/",
                "FrmEditarTraspaso.php",
                null,
                "lista_traspasos",
                "post",
                {opc:opc,idTraspaso:idTraspaso}
            );
            break;
        case 2://Mostrar formulario para editar traspaso

            break;
    }

}

function fnCancelarTraspaso(idTraspaso) {

    if(typeof idTraspaso == null || idTraspaso == ""){
        MyAlert("No se encontro el traspaso");
    }else{

        bootbox.confirm({
           title:"Traspasos",
            message:"Esta seguro de cancelar el traspaso ?",
            size:"small",
            buttons:buttonBootBox,
            callback:function (res) {
                if(res){
                    $.ajax({
                        url:"modules/almacen/src/traspasos/fnCancelarTraspaso.php",
                        type:"post",
                        dataType:"json",
                        data:{idTraspaso:idTraspaso},
                        beforeSend:function () {
                            fnloadSpinner(1);
                        }
                    }).done(function (response) {
                        fnloadSpinner(2);
                        console.log(response);

                        if(response.result){

                            fnListarTraspasos(3,0);
                            getMessage(response.message,null,"success",700);
                            setSendMailNotify({
                                Titulo:"Cancelación de Traspaso - "+idTraspaso,
                                Mensaje:"Se realizo la cancelación del traspaso<br>Folio: "+idTraspaso,
                                Correo:null,
                                Nombre:null
                            });

                        }else{
                            MyAlert(response.message);
                        }

                    }).fail(function (jqhr,textStatus,errno) {

                        fnloadSpinner(2);

                        if(console && console.log){
                            if(textStatus == "timeout"){
                                MyAlert("Tiempo de espera agtado");
                            }else{
                                MyAlert("Vista no encontrada");
                            }
                        }

                    })
                }
            }
        });

    }

}

function fnAutorizarTraspaso(opc,idTraspaso){



    if(typeof idTraspaso == null || idTraspaso == ""){
        MyAlert("No se encontro el traspaso");
    }else{

        $.ajax({
            url:"modules/almacen/src/traspasos/fnAutrizarTraspaso.php",
            type:"post",
            dataType:"json",
            data:{opc:opc, idTraspaso:idTraspaso},
            beforeSend:function () {
                fnloadSpinner(1);
            }
        }).done(function (response) {
            fnloadSpinner(2);
            console.log(response);

            if(response.result){

                fnListarTraspasos(3,0);
                getMessage(response.message,null,"success",700);
                setSendMailNotify({
                    Titulo:"Se Autorizo el Traspaso - "+idTraspaso,
                    Mensaje:"se Autorizo el traspaso "+idTraspaso,
                    Correo:null,
                    Nombre:null
                });

            }else{
                MyAlert(response.message);
            }

        }).fail(function (jqhr,textStatus,errno) {

            fnloadSpinner(2);

            if(console && console.log){
                console.log(textStatus+errno);
                if(textStatus == "timeout"){
                    MyAlert("Tiempo de espera agtado");
                }else{
                    MyAlert("Vista no encontrada");
                }
            }

        });

    }
}

function fnImprimirTraspaso(idtraspaso) {

    window.open("modules/almacen/reportes/PDFReporteTraspasos-01.php?id="+idtraspaso+"","","location=no,width=700,height=800,scrollbars=NO,menubar=NO,titlebar=NO,toolbar=NO");

}

function fnListarTraspasos(opc,idalmacen,nombre_almacen){

    SenderAjax(
        "modules/almacen/views/traspasos/",
        "FrmListarTraspasos.php",
        null,
        "lista_traspasos",
        "post",
        {opc:opc,idalmacen:idalmacen,nombre_almacen:nombre_almacen}
    );

}

function CargarTableroAlmacen(opc,idempresa,idalmacen){

    $.ajax({
        url:"modules/almacen/src/almacen/fnCargarTableroAlmacen.php",
        type:"post",
        dataType:"json",
        data:{opc:opc,idempresa:idempresa,idalmacen:idalmacen},
        beforeSend:function () {
            fnloadSpinner(1);
        }
    }).done(function (response) {

        console.log(response);
        if(response.result){

            $('#IndicadorInventario').html('<span class="info-box-text">'+response.data.indicadores.Inventario.titulo+'</span><span class="info-box-number">'+response.data.indicadores.Inventario.total+'</span>');
            $('#IndicadorTraspasos').html('<span class="info-box-text">'+response.data.indicadores.Traspasos.titulo+'</span><span class="info-box-number">'+response.data.indicadores.Traspasos.total+'</span>')
            $('#IndicadorExisBajas').html('<span class="info-box-text">'+response.data.indicadores.Existencias.titulo+'</span><span class="info-box-number">'+response.data.indicadores.Existencias.total+'</span>')
            $('#IndicadorSinExistencias').html('<span class="info-box-text">'+response.data.indicadores.SinExistencias.titulo+'</span><span class="info-box-number">'+response.data.indicadores.SinExistencias.total+'</span>')

            //Lista para los ultimos 10 Traspasos
            if( response.data.datalist.traspasos.length > 0 ){

                var listaTraspasos = "";

                for(i=0;i < response.data.datalist.traspasos.length;i++){

                    listaTraspasos = listaTraspasos + "<tr><td>"+response.data.datalist.traspasos[i]['FolioTraspaso']+"</td><td>"+response.data.datalist.traspasos[i]['almacen_origen']+"</td><td>"+response.data.datalist.traspasos[i]['almacen_destino']+"</td><td>"+response.data.datalist.traspasos[i]['fecha_alta']+"</td></tr>"

                }

                $("#listaTraspasos").html(listaTraspasos);

            }

            //listar traspasos por confirmar
            if( response.data.datalist.confirmar.length > 0 ){

                var listaTraspasos2 = "";

                for(i=0;i < response.data.datalist.confirmar.length;i++){

                    listaTraspasos2 = listaTraspasos2 + "<tr><td>"+response.data.datalist.confirmar[i]['FolioTraspaso']+"</td><td>"+response.data.datalist.confirmar[i]['almacen_origen']+"</td><td>"+response.data.datalist.confirmar[i]['almacen_destino']+"</td><td>"+response.data.datalist.confirmar[i]['fecha_alta']+"</td><td><button onclick='fnImprimirTraspaso("+response.data.datalist.confirmar[i]['FolioTraspaso']+")' class='btn btn-xs btn-success'><i class='fa fa-print'></i> ver</button>&nbsp;<button onclick='fnAutorizarTraspaso(2,"+response.data.datalist.confirmar[i]['FolioTraspaso']+")' class='btn btn-xs btn-primary'><i class='fa fa-check'></i> confirmar</button></td></tr>"

                }

                $("#listaTraspasosConfirmar").html(listaTraspasos2);

            }

            //Lista para los ultimos 10 Traspasos
            if( response.data.datalist.autorizar.length > 0 ){

                var listaTraspasos3 = "";

                for(i=0;i < response.data.datalist.autorizar.length;i++){


                    listaTraspasos3 = listaTraspasos3 + "<tr><td>"+response.data.datalist.autorizar[i]['FolioTraspaso']+"</td><td>"+response.data.datalist.autorizar[i]['almacen_origen']+"</td><td>"+response.data.datalist.autorizar[i]['almacen_destino']+"</td><td>"+response.data.datalist.autorizar[i]['fecha_alta']+"</td><td><button onclick='fnImprimirTraspaso("+response.data.datalist.autorizar[i]['FolioTraspaso']+")' class='btn btn-xs btn-success'><i class='fa fa-print'></i> ver</button>&nbsp;<button onclick='fnAutorizarTraspaso(1,"+response.data.datalist.autorizar[i]['FolioTraspaso']+")' class='btn btn-xs btn-primary'><i class='fa fa-check'></i> autorizar</button></td></tr>"

                }

                $("#listaTraspasosAutorizar").html(listaTraspasos3);

            }

            //Lista para el Stock Minimo
            if(response.data.datalist.existenciasBajas.length > 0){

                var listaStockMinimo = '';

                for(i=0;i< response.data.datalist.existenciasBajas.length;i++){

                    listaStockMinimo = listaStockMinimo + "<tr><td>"+response.data.datalist.existenciasBajas[i]['nombre_articulo']+"</td><td>"+response.data.datalist.existenciasBajas[i]['Almacen']+"</td><td>"+response.data.datalist.existenciasBajas[i]['Existencias']+"</td></tr>"
                }

                $("#listaStockMinimo").html(listaStockMinimo);

            }


        }else{
            MyAlert(response.message,"alert");
        }
        fnloadSpinner(2);


    }).fail(function (jqH,textStatus,errno) {
        fnloadSpinner(2);

        if(console && console.log){
            if(textStatus == 'timeout')
            {
                MyAlert("Tiempo de Espera Agotado","alert");

            }else{
                MyAlert("Error al llamer el fnCargarTableroAlmacen: "+textStatus,"alert");
            }
        }

    });
}

function setRealizarTraspaso(opc,openReport,idestado){

    $.ajax({
        url:"modules/almacen/src/traspasos/fn_realizar_traspaso.php",
        type:"GET",
        dataType:"JSON",
        beforeSend:function(){
            fnloadSpinner(1);
        },
        data:{
            opc:opc,idestado:idestado,
            openReport:openReport
        }
    }).done(function(dataResult){

        fnloadSpinner(2);
        if(dataResult.result == "ok"){

            getMessage(dataResult.mensaje,'Traspaso','success',700);
            gn_menu_principal(5,5);
            setSendMailNotify({
                Titulo:"Registro de Traspaso",
                Mensaje:"Registro de Nuevo Traspaso",
                Correo:null,
                Nombre:null
            });
        }


    }).fail(function(jqXHR,textStatus,errorThrown){

        fnloadSpinner(2);
        console.log(textStatus + errorThrown);

    });


}

function eliminar_carrito_traspasos(idarticulo){


    $.ajax({
        url:"modules/almacen/src/traspasos/fn_elimina_producto.php",
        type:"POST",
        dataType:"JSON",
        data:{idarticulo:idarticulo,opc:2}
    }).done(function(response){

        switch (response.result){
            case 'ok':

                SenderAjax(
                    "modules/almacen/src/traspasos/",
                    "fn_agregar_carrito_traspaso.php",
                    null,"list_cart_traspasos","post",
                    {
                        opc:2
                    }
                );

                break;

            case 'error':
                MyAlert(response.mensaje,"alert");
                break;
        }

    }).fail(function (jqh,textStatus) {
        MyAlert("Errro al llamar el metodo delete","error");
    })

}

function agregar_carrito_traspasos(idarticulo,nombre_articulo,tipo_articulo,cantidad,existencias,datos,e) {

    //alert(idarticulo + "-" + nombre_articulo + "-" +tipo_articulo +"-"+cantidad +"-" + existencias +"--"+ datos);

    if(existencias < cantidad){
        MyAlert("No cuenta con suficientes articulos en el almacen origen","alert");
    }else{

        if(cantidad > 0 ){
            SenderAjax(
                "modules/almacen/src/traspasos/",
                "fn_agregar_carrito_traspaso.php",
                null,"list_cart_traspasos","post",
                {
                    opc:1,
                    idarticulo:idarticulo,
                    tipo_articulo:tipo_articulo,
                    nombre_articulo:nombre_articulo,
                    cantidad:cantidad,
                    existencias:existencias,
                    datos:datos
                }
            );
            $(e).closest("tr").remove();
        }else{
            MyAlert("La cantidad debe ser mayor a 0","error");
        }
    }


}

function agregar_producto_traspaso(opc,datos) {

    $("#list_producto_cart").html('');
    SenderAjax(
        "modules/almacen/src/traspasos/",
        "fn_buscar_producto.php",
        null,"list_producto_cart","post",{
            opc:3,parametro:2,nombre_producto:$("#nombre_producto").val(),
            tipo_producto:$("#tipo_producto").val(),datos:datos
        }
    );

    $("#idusuario_solicita").attr('disabled','disabled'),
    $("#idalmacen_origen").attr('disabled','disabled'),
    $("#idalmacen_destino").attr('disabled','disabled');
}

function buscar_producto_almacen(){

    var idusuario_solicita = $("#idusuario_solicita").val(),
        idalmacen_origen = $("#idalmacen_origen").val(),
        idalmacen_destino = $("#idalmacen_destino").val();

    if(idusuario_solicita == 0 ){
        MyAlert("Seleccione el usuario solicitante","error");
    }else if(idalmacen_origen == 0){
        MyAlert("Seleccione el almacen de origen","alert");
    }else if(idalmacen_destino == 0){
        MyAlert("Selecione el almacen destino","alert");
    }else{


        //Abrir modal para seleccionar los articulos a traspasar
        SenderAjax(
            "modules/almacen/views/traspasos/",
            "frm_agregar_productos.php",
            null,
            "show_modal",
            "post",
            {
                opc:1,
                idalmacen_origen:idalmacen_origen,
                idusuario_solicita:idusuario_solicita,
                idalmacen_destino:idalmacen_destino
            }
        );


    }

}

function compras_nuevo_traspaso(opc){

    switch (opc){
        //mostrar formulario para nuevo traspaso
        case 1:

            SenderAjax(
                "modules/almacen/views/traspasos/",
                "frm_nuevo_traspaso.php",
                null,
                "lista_traspasos",
                "post",
                {
                    opc:opc
                }
            );
            break;
        case 2:

            SenderAjax(
                "modules/almacen/views/traspasos/",
                "FrmSolicitarTraspaso.php",
                null,
                "lista_traspasos",
                "post",
                {
                    opc:opc
                }
            );
            break;
        default:
            MyAlert("Error no se encontro la opcion","error");
            break;
    }
}

function listar_inventarios(opc,tipo_producto,idalmacen,str){

    switch (opc){
        //Opcion para mostrar lista de almacen general
        case 1:

            SenderAjax(
                "modules/almacen/views/inventario/",
                "frm_almacen_general.php",
                null,
                "lista_traspasos",
                "post",
                {
                    opc:opc,
                    tipo_producto:tipo_producto,
                    idalmacen:idalmacen,
                    str:str
                }
            );

            break;
        case 2:

            SenderAjax(
                "modules/almacen/views/inventario/",
                "frm_almacen_general.php",
                null,
                "lista_traspasos",
                "post",
                {
                    opc:opc,
                    tipo_producto:tipo_producto,
                    idalmacen:idalmacen,
                    str:str
                }
            );

            break;
        default:
            MyAlert("La opcio no existe","error");
    }
}

var listar_inventario3 = function(tipo_articulo,idalmacen,idempresa){

    SenderAjax(
        "modules/almacen/src/inventario/",
        "fn_listar_inventario.php",
        null,
        "tabla_lista_inventarios",
        "post",
        {tipo_articulo:tipo_articulo,idalmacen:idalmacen,idempresa:idempresa}
    );


}