/**
 * Created by agomez on 29/11/2016.
 */

$(document).ready(function(){
    $('#login_user').focus();


});

function fn_login(){


    if($.trim($("#login_user").val()) == ""){
        MyAlert("Ingrese el usuario","alert");
    }else if($.trim($("#login_pass").val()) == ""){

        MyAlert("Ingrese su contraseña","alert");

    }else{

        var strData = {user:$("#login_user").val(),pass:$("#login_pass").val()};

        SenderAjax("modules/applications/src/login/","fn_login.php",null,"div_result","post",strData);

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
    imgCentro = "<div style='text-align:center;height:" + alto + "px;'><div class='text-white text-bold'  style='margin-top:" + heightdivsito + "px; font-size:20px;'><span class='fa fa-2x fa-spinner fa-spin '></span><br><span style='font-size: 10px;font-weight: normal'>espere un momento</span></div></div>";

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

function SenderAjax(urlPhp,nameView,params,idDiv,is_type,stringData){
    if(params == null){
        params = "";
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