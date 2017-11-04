/**
 * Created by alejandro.gomez on 15/04/2017.
 */

function menu_catalogos(opc,param){
    switch (opc){
        case 1:
            SenderAjax(
              "modules/applications/views/catalogos/",
                "frm_catalogo_productos.php",
                null,"contenedor_catalogos","post",{opc:opc,param:param}
            );
            break;
        case 2:
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_catalogo_categoria.php",
                null,"contenedor_catalogos","post",{opc:opc,param:param}
            );
            break;
        case 3:
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_catalogo_subcategoria.php",
                null,"contenedor_catalogos","post",{opc:opc,param:param}
            );
            break;
        case 4:
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_catalogo_tallas.php",
                null,"contenedor_catalogos","post",{opc:opc,param:param}
            );
            break;
        case 5:
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_catalogo_colores.php",
                null,"contenedor_catalogos","post",{opc:opc,param:param}
            );
            break;
        case 6:
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_catalogo_almacen.php",
                null,"contenedor_catalogos","post",{opc:opc,param:param}
            );
            break;
        case 7:
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_catalogo_proveedores.php",
                null,"contenedor_catalogos","post",{opc:opc,param:param}
            );
            break;
        case 8:
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_catalogo_materiales.php",
                null,"contenedor_catalogos","post",{opc:opc,param:param}
            );
            break;
        case 9:
            SenderAjax(
                "modules/applications/views/clientes/",
                "frm_clientes.php",
                null,"contenedor_catalogos","post",{opc:opc,param:param}
            );
            break;
        case 10:
            SenderAjax(
                "modules/applications/views/departamentos/",
                "frm_departamentos.php",
                null,"contenedor_catalogos","post",{opc:opc,param:param}
            );
            break;
        case 11:
            SenderAjax(
                "modules/applications/views/usuarios/",
                "frm_usuarios.php",
                null,"contenedor_catalogos","post",{opc:opc,param:param}
            );
            break;
        case 12:
            SenderAjax(
                "modules/applications/views/perfiles/",
                "frm_perfiles.php",
                null,"contenedor_catalogos","post",{opc:opc,param:param}
            );
            break;
        case 13:
            SenderAjax(
                "modules/applications/views/catalogo_combos/",
                "frm_combos.php",
                null,"contenedor_catalogos","post",{opc:opc,param:param}
            );
            break;
        default:
            MyAlert("Errro opción no encontrada","alert");
    }
}


function nuevo_usuario(opc){

    switch (opc){
        case 1:
            SenderAjax(
                "modules/applications/views/usuarios/",
                "frm_nuevo_usuario.php",
                null,"DataList","post",{opc:opc}
            );
            break;
        case 2:
            //Guardar Nuevo Usuario

            var nombre = $("#nombre").val(),
                apaterno = $("#apaterno").val(),
                amaterno = $("#amaterno").val(),
                telefono = $("#telefono").val(),
                celular = $("#celular").val(),
                departamento = $("#idsucursal").val(),
                usuario_login = $("#usuario_login").val(),
                nickname = $("#nickname").val(),
                clave1 = $("#clave1").val(),
                clave2 = $("#clave2").val(),
                perfil = $("#idperfil").val();

            if($.trim(nombre) == ""){
                MyAlert("Ingrese el nombre del usuario","alert");
            }else if($.trim(apaterno) == ""){
                MyAlert("Ingrese el apellido paterno","alert");
            }else if($.trim(amaterno) == ""){
                MyAlert("Ingrese el apellido materno","alert");
            }else if(departamento == 0){
                MyAlert("Seleccione una sucursal ","alert");
            }else if($.trim(nickname)==""){
                MyAlert("Ingrese el nickname del usuario")
            }else if($.trim(usuario_login) == ""){
                MyAlert("Ingrese el usuario de acceso","alert");
            }else if(usuario_login.length <= 3 ){
                MyAlert("El usuario de acceso es demasiado corto","alert");
            }else if($.trim(clave1) == ""){
                MyAlert("Ingrese la contraseña","alert");
            }else if($.trim(clave2) == ""){
                MyAlert("Confirme la contraseña","alert");
            }else if($.trim(clave1) != $.trim(clave2)){
                MyAlert("Las contraseñas no coinciden","alert");
            }else if(perfil == 0){
                MyAlert("Ingrese el perfil del usuario","alert");
            }else{

                $.ajax({
                    url:"modules/applications/src/usuarios/fn_registra_usuario.php",
                    type:"post",
                    dataType:"json",
                    data:{
                        nombre:nombre,
                        apaterno:apaterno,
                        amaterno:amaterno,
                        telefono:telefono,
                        celular:celular,
                        departamento:departamento,
                        nickname:nickname,
                        usuario_login:usuario_login,
                        clave1:clave1,
                        clave2:clave2,
                        perfil:perfil,
                        accesos:JSON.stringify($('[name="app[]"]').serializeArray())
                    },
                    beforeSend:function () {
                        fnloadSpinner(1);
                    }
                }).done(function (response) {
                    console.log(response);
                    fnloadSpinner(2);


                }).fail(function (jqhr,textStatus,errno) {

                    console.log(jqhr);

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

    }

}


/**
 * Catalogo Combos
 * @param id
 */

function elimina_producto_combo(id) {
    $.ajax({
        url:"modules/applications/src/catalogo_combos/fn_elimina_producto.php",
        type:"post",
        dataType:"json",
        data:{id:id}

    }).done(function (response) {

        switch (response.result){
            case "success":
                //Mostrar Lista de productos agregados al combo
                nuevo_combo(5);
                break;
            case "error":
                MyAlert(response.mensaje,"error");
                break;
        }


    }).fail(function (jqh,textStatus) {
        MyAlert("Error al agregar el producto al combo:"+textStatus,"error");
    });

}

function nuevo_combo (opc) {

    var codigo_combo = $("#codigo_combo").val();

    switch (opc){
        case 1: //Opcion para mostrar el formulario para la alta del combo

            SenderAjax(
                "modules/applications/views/catalogo_combos/",
                "frm_nuevo_combo.php",
                null,
                "listCombos",
                "post",
                {
                    opc:opc
                }
            );

            break;
        case 2: //Agregar producto al combo (carrito de combo)

            var tipo_producto = $("#tipo_producto").val(),
                idproducto = $("#idproducto").val(),
                nombre_producto = $("#idproducto option:selected").text();

        if(tipo_producto == 0){
            MyAlert("Seleccione el tipo de producto","alert");
        }else if(idproducto == 0 ){
            MyAlert("Seleccione un producto","alert");
        }else{

            $.ajax({
                url:"modules/applications/src/catalogo_combos/fn_agregar_productos.php",
                type:"post",
                dataType:"json",
                data:{tipo_producto:tipo_producto,idproducto:idproducto,nombre_producto:nombre_producto}

            }).done(function (response) {

                switch (response.result){
                    case "success":
                       nuevo_combo(5);
                        break;
                    case "error":
                        MyAlert(response.mensaje,"error");
                        break;
                }


            }).fail(function (jqh,textStatus) {
                MyAlert("Error al agregar el producto al combo:"+textStatus,"error");
            });


        }

            break;
        case 3://Opcion para llamar el metodo de nuevo combo y registrarlo en la BD:.

            var codigo_combo = $("#codigo_combo").val(),
                nombre_combo = $("#nombre_combo").val(),
                descripcion = $("#descripcion").val();

            if($.trim(codigo_combo) == ""){

                MyAlert("Ingrese el codigo del combo","alert");

            }else if($.trim(nombre_combo) == ""){
                MyAlert("Ingrese el nombre del combo","alert");
            }else{
                $.ajax({
                    url:"modules/applications/src/catalogo_combos/fn_registra_combo.php",
                    type:"post",
                    dataType:"json",
                    data:{codigo_combo:codigo_combo,nombre_combo:nombre_combo,descripcion:descripcion},
                    beforeSend:function () {
                        fnloadSpinner(1);
                    }

                }).done(function (response) {

                    fnloadSpinner(2);

                    switch (response.result){
                        case "success":
                            menu_catalogos(13,13);
                            break;
                        case "error":
                            MyAlert(response.mensaje,"error");
                            break;
                    }


                }).fail(function (jqh,textStatus) {
                    fnloadSpinner(2);
                    MyAlert("Error al registrar el combo:"+textStatus,"error");
                });
            }

            break;
        case 4://Recargar el select de acuerdo al tipo de producto seleccionado

            var tipo_producto = $("#tipo_producto").val();

                SenderAjax(
                "modules/applications/src/catalogo_combos/",
                "fn_recargar_productos.php",
                null,"idproducto","post",{tipo_producto:tipo_producto}
            );

            break;
        case 5: //Mostrar los productos agregados al combo
            SenderAjax(
                "modules/applications/src/catalogo_combos/",
                "fn_mostrar_productos.php",
                null,"lista_productos_combo","post",{}
            );
            break;
    }

}
/**
 * Catalogo de perfiles
 * @param opc
 * @param idperfil
 */

function nuevo_perfil(opc,idperfil){

    var strData,nombre_perfil = $("#nombre_perfil").val(),
        descripcion = $("#descripcion").val();

    switch (opc){
        case 1:
            SenderAjax(
                "modules/applications/views/perfiles/",
                "frm_nuevo_perfil.php",
                null,"show_modal","post",{opc:opc,idperfil:idperfil}
            );
            break;
        case 2:

            if($.trim(nombre_perfil) == ""){
                MyAlert("Ingrese el nombre del  perfil","alert");
            }else if($.trim(descripcion) == ""){
                MyAlert("Ingrese una descripción");
            }else {

                strData = {
                    nombre_perfil:nombre_perfil,
                    descripcion:descripcion
                };

                SenderAjax(
                    "modules/applications/src/perfiles/",
                    "fn_registra_perfil.php",
                    null,"response_modal","post",strData
                );
            }

            break;
        case 3:
            //Mostrar fomulario para editar el nombre del perfil
            SenderAjax(
                "modules/applications/views/perfiles/",
                "frm_editar_perfil.php",
                null,"show_modal","post",
                {
                    opc:opc,
                    idperfil:idperfil
                }
            );
            break;
        case 4:
            //Guardar datos modificados del pefil
            var idestado = $("#idestado").val();
            if($.trim(nombre_perfil) == ""){
                MyAlert("Ingrese el nombre del  perfil","alert");
            }else if($.trim(descripcion) == ""){
                MyAlert("Ingrese una descripción");
            }else {

                strData = {
                    nombre_perfil:nombre_perfil,
                    descripcion:descripcion,
                    idestado:idestado,
                    idperfil:idperfil
                };

                SenderAjax(
                    "modules/applications/src/perfiles/",
                    "fn_editar_perfil.php",
                    null,"response_modal","post",strData
                );
            }
            break;
        default :
            MyAlert("La opcion no existe","alert");
            break;
    }

}

/**
 * Catalogo de clientes
 * @param opc
 * @param idcliente
 */
function nuevo_cliente(opc,idcliente){

    var strData,nombre_completo = $("#nombre_cliente").val(),
        correo = $("#correo_cliente").val(),
        telefono = $("#telefono_cliente").val(),
        celular = $("#celular_cliente").val();

    switch (opc){
        case 1:
            SenderAjax(
                "modules/applications/views/clientes/",
                "frm_nuevo_cliente.php",
                null,"show_modal","post",{opc:opc,idcliente:idcliente}
            );
            break;
        case 2:

            if($.trim(nombre_completo) == ""){
                MyAlert("Ingrese el nombre del  cliente","alert");
            }else if(nombre_completo.length <= 8){
                MyAlert("Ingrese el Nombre y almenos un apellido");
            }else if($.trim(correo) == "" && $.trim(telefono) == "" && $.trim(celular)==""){
                MyAlert("Ingrese algun medio de contacto del cliente");
            }else{
                strData = {
                    nombre_cliente:nombre_completo,
                    correo:correo,
                    telefono:telefono,
                    celular:celular
                };
                SenderAjax(
                    "modules/applications/src/clientes/",
                    "fn_registra_cliente.php",
                    null,"response_modal","post",strData
                );
            }

            break;
        case 3:
            SenderAjax(
                "modules/applications/views/clientes/",
                "frm_nuevo_cliente.php",
                null,"show_modal","post",{opc:opc,idcliente:idcliente}
            );
            break;
        default :
            MyAlert("La opcion no existe","alert");
            break;
    }

}
function editar_cliente(opc,idcliente) {

    var strData,nombre_completo = $("#nombre_cliente").val(),
        correo = $("#correo_cliente").val(),
        telefono = $("#telefono_cliente").val(),
        celular = $("#celular_cliente").val(),
        idestado = $("#idestado").val();

    switch (opc){
        case 1:
            SenderAjax(
                "modules/applications/views/clientes/",
                "frm_editar_cliente.php",
                null,"show_modal","post",{opc:opc,idcliente:idcliente}
            );
            break;
        case 2:

            if($.trim(nombre_completo) == ""){
                MyAlert("Ingrese el nombre del  cliente","alert");
            }else if(nombre_completo.length <= 8){
                MyAlert("Ingrese el Nombre y almenos un apellido");
            }else {
                strData = {
                    nombre_cliente:nombre_completo,
                    correo:correo,
                    telefono:telefono,
                    celular:celular,
                    idestado:idestado,
                    idcliente:idcliente
                };
                SenderAjax(
                    "modules/applications/src/clientes/",
                    "fn_editar_cliente.php",
                    null,"response_modal","post",strData
                );
            }

            break;
        default :
            MyAlert("La opcion no existe","alert");
            break;
    }
}

/**
 * Catalogo de Proveedores
 * @param opc
 * @param idalmacen
 */
function nuevo_proveedor(opc,idproveedor){

    var nombre_proveedor = $('#nombre_proveedor').val(),
        correo_proveedor = $('#correo_proveedor').val(),
        direccion_proveedor = $('#direccion_proveedor').val(),
        telefono1_proveedor = $('#telefono1_proveedor').val(),
        telefono2_proveedor = $('#telefono2_proveedor').val(),
        celular_proveedor = $('#celular_proveedor').val(),
        descripcion_proveedor = $('#descripcion_proveedor').val();

    switch (opc){
        case 1:
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_nuevo_proveedor.php",
                null,"show_modal","post",{opc:opc,idproveedor:idproveedor}
            );
            break;
        case 2:

            if($.trim(nombre_proveedor) == ""){
                MyAlert("Ingrese el nombre del proveedor","alert");
            }else if($.trim(direccion_proveedor) == ""){
                MyAlert("Ingrese la dirección del proveedor","alert");
            }else if($.trim(telefono1_proveedor) == "" && $.trim(telefono2_proveedor) == "" && $.trim(celular_proveedor) == ""){
                MyAlert("Ingrese al menos 1 teléfono del proveedor","alert");
            }else if($.trim(descripcion_proveedor) == ""){
                MyAlert("Ingrese la descripción del proveedor","alert");
            }else{

                SenderAjax(
                    "modules/applications/src/catalogos/",
                    "fn_registra_proveedor.php",
                    null,"response_modal","post",
                    {
                        opc:opc,
                        idproveedor:idproveedor,
                        nombre_proveedor:nombre_proveedor,
                        correo_proveedor:correo_proveedor,
                        direccion_proveedor:direccion_proveedor,
                        telefono1_proveedor:telefono1_proveedor,
                        telefono2_proveedor:telefono2_proveedor,
                        celular_proveedor:celular_proveedor,
                        descripcion_proveedor:descripcion_proveedor
                    }
                );
            }
            break;
        default:
            MyAlert("Error opción no encontrada","alert");
    }
}
function editar_proveedor(opc,idproveedor){

    var nombre_proveedor = $('#nombre_proveedor').val(),
        correo_proveedor = $('#correo_proveedor').val(),
        direccion_proveedor = $('#direccion_proveedor').val(),
        telefono1_proveedor = $('#telefono1_proveedor').val(),
        telefono2_proveedor = $('#telefono2_proveedor').val(),
        celular_proveedor = $('#celular_proveedor').val(),
        descripcion_proveedor = $('#descripcion_proveedor').val(),
        idestado_proveedor = $('#idestado_proveedor').val();

    switch (opc){
        case 1:
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_editar_proveedor.php",
                null,"show_modal","post",{opc:opc,idproveedor:idproveedor}
            );
            break;
        case 2:

            if($.trim(nombre_proveedor) == ""){
                MyAlert("Ingrese el nombre del proveedor","alert");
            }else if($.trim(direccion_proveedor) == ""){
                MyAlert("Ingrese la dirección del proveedor","alert");
            }else if($.trim(telefono1_proveedor) == "" && $.trim(telefono2_proveedor) == "" && $.trim(celular_proveedor) == ""){
                MyAlert("Ingrese al menos 1 teléfono del proveedor","alert");
            }else if($.trim(descripcion_proveedor) == ""){
                MyAlert("Ingrese la descripción del proveedor","alert");
            }else{

                SenderAjax(
                    "modules/applications/src/catalogos/",
                    "fn_editar_proveedor.php",
                    null,"response_modal","post",
                    {
                        opc:opc,
                        idproveedor:idproveedor,
                        nombre_proveedor:nombre_proveedor,
                        correo_proveedor:correo_proveedor,
                        direccion_proveedor:direccion_proveedor,
                        telefono1_proveedor:telefono1_proveedor,
                        telefono2_proveedor:telefono2_proveedor,
                        celular_proveedor:celular_proveedor,
                        descripcion_proveedor:descripcion_proveedor,
                        idestado_proveedor:idestado_proveedor
                    }
                );
            }

            break;
        default:
            MyAlert("Error opción no encontrada","alert");
    }

}

/**
 * Catalogo de almacenes
 * @param opc
 * @param idcolor
 */
function nuevo_almacen(opc,idalmacen){

    var nombre_almacen = $('#nombre_almacen').val(),
        descripcion_almacen = $('#descripcion_almacen').val(),
        opcion_traspaso = $('#opcion_traspaso').val();

    switch (opc){
        case 1:
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_nuevo_almacen.php",
                null,"show_modal","post",{opc:opc,idalmacen:idalmacen}
            );
            break;
        case 2:

            if($.trim(nombre_almacen) == ""){
                MyAlert("Ingrese el nombre del almacén","alert");
            }else if($.trim(descripcion_almacen) == ""){
                MyAlert("Ingrese la descripción del almacén","alert");
            }else{

                SenderAjax(
                    "modules/applications/src/catalogos/",
                    "fn_registra_almacen.php",
                    null,"response_modal","post",
                    {
                        opc:opc,
                        idalmacen:idalmacen,
                        nombre_almacen:nombre_almacen,
                        descripcion_almacen:descripcion_almacen,
                        opcion_traspaso:opcion_traspaso
                    }
                );
            }
            break;
        default:
            MyAlert("Error opción no encontrada","alert");
    }
}
function editar_almacen(opc,idalmacen){

    var nombre_almacen = $('#nombre_almacen').val(),
        descripcion_almacen = $('#descripcion_almacen').val(),
        opcion_traspasos = $('#opcion_traspasos').val(),
        idestado_almacen = $('#idestado_almacen').val();

    switch (opc){
        case 1:
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_editar_almacen.php",
                null,"show_modal","post",{opc:opc,idalmacen:idalmacen}
            );
            break;
        case 2:

            if($.trim(nombre_almacen) == ""){
                MyAlert("Ingrese el nombre del almacén","alert");
            }else if($.trim(descripcion_almacen) == ""){
                MyAlert("Ingrese la descripción del almacén","alert");
            }else{

                SenderAjax(
                    "modules/applications/src/catalogos/",
                    "fn_edita_almacen.php",
                    null,"response_modal","post",
                    {
                        opc:opc,
                        idalmacen:idalmacen,
                        nombre_almacen:nombre_almacen,
                        descripcion_almacen:descripcion_almacen,
                        opcion_traspasos:opcion_traspasos,
                        idestado_almacen:idestado_almacen
                    }
                );
            }
            break;
        default:
            MyAlert("Error opción no encontrada","alert");
    }

}

/**
 * Catalogo de Colores
 * @param opc
 * @param idtalla
 */
function nuevo_color(opc,idcolor){

    var codigo_color = $('#codigo_color').val(),
        nombre_color = $('#nombre_color').val();

    switch (opc){
        case 1:
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_nuevo_color.php",
                null,"show_modal","post",{opc:opc,idcolor:idcolor}
            );
            break;
        case 2:

            if($.trim(codigo_color) == ""){
                MyAlert("Ingrese el código","alert");
            }else if($.trim(nombre_color) == ""){
                MyAlert("Ingrese el nombre del color","alert");
            }else{

                SenderAjax(
                    "modules/applications/src/catalogos/",
                    "fn_registra_color.php",
                    null,"response_modal","post",
                    {
                        opc:opc,
                        idcolor:idcolor,
                        codigo_color:codigo_color,
                        nombre_color:nombre_color
                    }
                );
            }


            break;
        default:
            MyAlert("Error opción no encontrada","alert");
    }
}
function editar_color(opc,idcolor){

    var codigo_color = $('#codigo_color').val(),
        nombre_color = $('#nombre_color').val(),
        idestado_color = $('#idestado_color').val();

    switch (opc){
        case 1:
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_editar_color.php",
                null,"show_modal","post",{opc:opc,idcolor:idcolor}
            );
            break;
        case 2:

            if($.trim(codigo_color) == ""){
                MyAlert("Ingrese el código del color","alert");
            }else if($.trim(nombre_color) == ""){
                MyAlert("Ingrese el nombre del color","alert");
            }else{

                SenderAjax(
                    "modules/applications/src/catalogos/",
                    "fn_edita_color.php",
                    null,"response_modal","post",
                    {
                        opc:opc,
                        idcolor:idcolor,
                        codigo_color:codigo_color,
                        nombre_color:nombre_color,
                        idestado_color:idestado_color
                    }
                );
            }
            break;
        default:
            MyAlert("Error opción no encontrada","alert");
    }

}
function fn_seleccionar_color(opc,idcolor,codigo_color){
    switch (opc){
        case 1:
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_modal_seleccionar_color.php",
                null,"show_modal","post",{opc:opc}
            );
            break;
        case 2:
            $("#idcolor").val(idcolor+"-"+codigo_color);
            $("#idcolor").css('background',codigo_color);
            $("#modalbtnclose").click();
            break;
    }
}
/**
 * Catalogo Tallas y Medidas
 * @param opc
 * @param idcategoria
 */
function nueva_tallas(opc,idtalla){

    var nombre_talla = $('#nombre_talla').val(),
        descripcion_talla = $('#descripcion_talla').val();

    switch (opc){
        case 1:
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_nueva_talla.php",
                null,"show_modal","post",{opc:opc,idtalla:idtalla}
            );
            break;
        case 2:

            if($.trim(nombre_talla) == ""){
                MyAlert("Ingrese el nombre de la talla","alert");
            }else if($.trim(descripcion_talla) == ""){
                MyAlert("Ingrese la descripción de la talla","alert");
            }else{

                SenderAjax(
                    "modules/applications/src/catalogos/",
                    "fn_registra_talla.php",
                    null,"response_modal","post",
                    {
                        opc:opc,
                        idtalla:idtalla,
                        nombre_talla:nombre_talla,
                        descripcion_talla:descripcion_talla
                    }
                );
            }
            break;
        default:
            MyAlert("Error opción no encontrada","alert");
    }
}
function editar_tallas(opc,idtalla){

    var nombre_talla = $('#nombre_talla').val(),
        descripcion_talla = $('#descripcion_talla').val(),
        idestado_talla = $('#idestado_talla').val();

    switch (opc){
        case 1:
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_editar_tallas.php",
                null,"show_modal","post",{opc:opc,idtalla:idtalla}
            );
            break;
        case 2:

            if($.trim(nombre_talla) == ""){
                MyAlert("Ingrese el nombre de la talla","alert");
            }else if($.trim(descripcion_talla) == ""){
                MyAlert("Ingrese la descripción de la talla","alert");
            }else{

                SenderAjax(
                    "modules/applications/src/catalogos/",
                    "fn_edita_talla.php",
                    null,"response_modal","post",
                    {
                        opc:opc,
                        idtalla:idtalla,
                        nombre_talla:nombre_talla,
                        descripcion_talla:descripcion_talla,
                        idestado_talla:idestado_talla
                    }
                );
            }
            break;
        default:
            MyAlert("Error opción no encontrada","alert");
    }

}

/**
 * Catalogo de subcategproas
 * @param opc
 * @param idcategoria
 */
function nueva_subcategoria(opc,idcategoria){

    var nombre_subcategoria = $('#nombre_subcategoria').val(),
        descripcion_subcategoria = $('#descripcion_subcategoria').val();

    switch (opc){
        case 1:
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_nueva_subcategoria.php",
                null,"show_modal","post",{opc:opc,idcategoria:idcategoria}
            );
            break;
        case 2:

            if($.trim(nombre_subcategoria) == ""){
                MyAlert("Ingrese el nombre de la subcategoría","alert");
            }else if($.trim(descripcion_subcategoria) == ""){
                MyAlert("Ingrese la descripción de la subcategoría","alert");
            }else{

                SenderAjax(
                    "modules/applications/src/catalogos/",
                    "fn_registra_subcategoria.php",
                    null,"response_modal","post",
                    {
                        opc:opc,
                        idcategoria:idcategoria,
                        nombre_subcategoria:nombre_subcategoria,
                        descripcion_subcategoria:descripcion_subcategoria
                    }
                );
            }
            break;
        default:
            MyAlert("Error opción no encontrada","alert");
    }
}
function editar_subcategoria(opc,idcategoria){

    var nombre_subcategoria = $('#nombre_subcategoria').val(),
        descripcion_subcategoria = $('#descripcion_subcategoria').val(),
        idestado_subcategoria = $('#idestado_subcategoria').val();

    switch (opc){
        case 1:
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_editar_subcategoria.php",
                null,"show_modal","post",{opc:opc,idcategoria:idcategoria}
            );
            break;
        case 2:

            if($.trim(nombre_subcategoria) == ""){
                MyAlert("Ingrese el nombre de la sub categoria","alert");
            }else if($.trim(descripcion_subcategoria) == ""){
                MyAlert("Ingrese la descripción de la sub categoria","alert");
            }else{

                SenderAjax(
                    "modules/applications/src/catalogos/",
                    "fn_edita_subcategoria.php",
                    null,"response_modal","post",
                    {
                        opc:opc,
                        idcategoria:idcategoria,
                        nombre_subcategoria:nombre_subcategoria,
                        descripcion_subcategoria:descripcion_subcategoria,
                        idestado_subcategoria:idestado_subcategoria
                    }
                );
            }
            break;
        default:
            MyAlert("Error opción no encontrada","alert");
    }

}

/**
 * Catalogo de Categorías
 * @param opc
 */

function editar_categoria(opc,idcategoria){

    var nombre_categoria = $('#nombre_categoria').val(),
        descripcion_categoria = $('#descripcion_categoria').val(),
        idestado_categoria = $('#idestado_categoria').val();

    switch (opc){
        case 1:
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_editar_categoria.php",
                null,"show_modal","post",{opc:opc,idcategoria:idcategoria}
            );
            break;
        case 2:

            if($.trim(nombre_categoria) == ""){
                MyAlert("Ingrese el nombre de la categoria","alert");
            }else if($.trim(descripcion_categoria) == ""){
                MyAlert("Ingrese la descripción de la categoria","alert");
            }else{

                SenderAjax(
                    "modules/applications/src/catalogos/",
                    "fn_edita_categoria.php",
                    null,"response_modal","post",
                    {
                        opc:opc,
                        idcategoria:idcategoria,
                        nombre_categoria:nombre_categoria,
                        descripcion_categoria:descripcion_categoria,
                        idestado_categoria:idestado_categoria
                    }
                );
            }
            break;
        default:
            MyAlert("Error opción no encontrada","alert");
    }

}
function nueva_categoria(opc,idcategoria){

    var nombre_categoria = $('#nombre_categoria').val(),
        descripcion_categoria = $('#descripcion_categoria').val();

   switch (opc){
       case 1:
           SenderAjax(
               "modules/applications/views/catalogos/",
               "frm_nueva_categoria.php",
               null,"show_modal","post",{opc:opc,idcategoria:idcategoria}
           );
           break;
       case 2:

           if($.trim(nombre_categoria) == ""){
               MyAlert("Ingrese el nombre de la categoria","alert");
           }else if($.trim(descripcion_categoria) == ""){
               MyAlert("Ingrese la descripción de la categoria","alert");
           }else{

               SenderAjax(
                   "modules/applications/src/catalogos/",
                   "fn_registra_categoria.php",
                   null,"response_modal","post",
                   {
                       opc:opc,
                       idcategoria:idcategoria,
                       nombre_categoria:nombre_categoria,
                       descripcion_categoria:descripcion_categoria
                   }
               );
           }
           break;
       default:
           MyAlert("Error opción no encontrada","alert");
   }
}

/**
 * Catalogo de materiales
 * @param opc
 * @param idproducto
 */
function nuevo_material(opc,idmaterial){
    var nombre_material = $('#nombre_material').val(),
        idcolor = $('#idcolor').val(),
        precio_compra = $("#precio_compra").val(),
        precio_venta = $("#precio_venta").val(),
        stock_minimo = $("#stock_minimo").val(),
        stock_maximo = $("#stock_maximo").val();

    switch (opc){
        case 1:
            $('#btnGuardar_material').show();
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_nuevo_material.php",
                null,"DataList","post",{opc:opc,idmaterial:idmaterial}
            );
            break;
        case 2:

            idcolor = setFormatoColor(1,idcolor);
            precio_compra = setFormatoMoneda(1,precio_compra);
            precio_venta = setFormatoMoneda(1,precio_venta);

            if($.trim(nombre_material) == ""){
                MyAlert("Ingrese el nombre del material","alert");
            }else if($.trim(idcolor) == ""){
                MyAlert("Seleccione un color de material","alert");
            }else if($.trim(precio_compra) == "0.00"){
                MyAlert("Ingrese el precio de compra","alert");
            }else if($.trim(precio_venta) == ""){
                MyAlert("Ingrese el precio de venta","alert");
            }else if(isNaN(stock_minimo) || isNaN(stock_maximo)){
                MyAlert("Inrgese un numero valido","error");
            }else if(stock_minimo <= 0 ){
                MyAlert("El invenario minimo debde se mayor a 0","alert");
            }else if(stock_maximo <=0 ){
                MyAlert("El inventario maximo debe ser mayor a 0","alert");
            }else{

                var strData = {
                    nombre_material:nombre_material,
                    idcolor:idcolor,
                    precio_compra:precio_compra,
                    precio_venta:precio_venta,
                    stock_minimo:stock_minimo,
                    stock_maximo:stock_maximo,
                    tipo_unidad:1
                };

                $.ajax({
                    data:strData,
                    type:"POST",
                    dataType:"JSON",
                    url:"modules/applications/src/catalogos/fn_registra_material.php"
                }).done( function(data) {

                    if(data.confirm == "ok"){

                      menu_catalogos(8,8);

                    }else{

                        MyAlert(data.mensaje,"alert");

                    }

                }).fail(function(jqXHR,textStatus,errorThrown){
                    console.log(textStatus + errorThrown);

                });

            }
            break;
        default:
            MyAlert("Error opción no encontrada","alert");
    }
}
function editar_material(opc,idmaterial){
    var nombre_material = $('#nombre_material').val(),
        idcolor = $('#idcolor').val(),
        precio_compra = $("#precio_compra").val(),
        precio_venta = $("#precio_venta").val(),
        stock_minimo = $("#stock_minimo").val(),
        stock_maximo = $("#stock_maximo").val();
    switch (opc){
        case 1:
            $('#btnGuardar_material').show();
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_editar_material.php",
                null,"DataList","post",{opc:opc,idmaterial:idmaterial}
            );
            break;
        case 2:

            idcolor = setFormatoColor(1,idcolor);
            precio_compra = setFormatoMoneda(1,precio_compra);
            precio_venta = setFormatoMoneda(1,precio_venta);

            if($.trim(nombre_material) == ""){
                MyAlert("Ingrese el nombre del material","alert");
            }else if($.trim(idcolor) == ""){
                MyAlert("Seleccione un color de material","alert");
            }else if($.trim(precio_compra) == "0.00"){
                MyAlert("Ingrese el precio de compra","alert");
            }else if($.trim(precio_venta) == ""){
                MyAlert("Ingrese el precio de venta","alert");
            }else if(isNaN(stock_minimo) || isNaN(stock_maximo)){
                MyAlert("Inrgese un numero valido","error");
            }else if(stock_minimo <= 0 ){
                MyAlert("El invenario minimo debde se mayor a 0","alert");
            }else if(stock_maximo <=0 ){
                MyAlert("El inventario maximo debe ser mayor a 0","alert");
            }else{

                var strData = {
                    idmaterial:idmaterial,
                    nombre_material:nombre_material,
                    descripcion_material:nombre_material,
                    idcolor:idcolor,
                    precio_compra:precio_compra,
                    precio_venta:precio_venta,
                    stock_minimo:stock_minimo,
                    stock_maximo:stock_maximo,
                    tipo_unidad:1
                };

                $.ajax({
                    data:strData,
                    type:"POST",
                    dataType:"JSON",
                    url:"modules/applications/src/catalogos/fn_editar_material.php"
                }).done( function(data) {

                    if(data.confirm == "ok"){

                        menu_catalogos(8,8);

                    }else{

                        MyAlert(data.mensaje,"alert");

                    }

                }).fail(function(jqXHR,textStatus,errorThrown){
                    console.log(textStatus + errorThrown);

                });

            }
            break;
        default:
            MyAlert("Error opción no encontrada","alert");
    }
}


/**
 * Catalogo de departamento
 * @param opc
 * @param iddepartamento
 */
function nuevo_departamento(opc,iddepartamento){

    var strData,
        nombre_departamento = $("#nombre_departamento").val(),
        idalmacen = $("#idalmacen").val(),
        total_cajas = $("#total_cajas").val(),
        domicilio = $("#domicilio").val(),
        correo = $("#correo").val(),
        telefono01 = $("#telefono01").val(),
        telefono02 = $("#telefono02").val(),
        celular = $("#celular").val(),
        horario_semanal = $("#horario_semanal").val(),
        idestado = $("#idestado").val(),
        horario_findesemana = $("#horario_findesemana").val();


    switch (opc){
        case 1:
            $('#btnGuardar_departamento').show();
            SenderAjax(
                "modules/applications/views/departamentos/",
                "frm_nuevo_departamento.php",
                null,"DataList","post",{opc:opc,iddepartamento:iddepartamento}
            );
            break;
        case 2:

            if($.trim(nombre_departamento) == ""){
                MyAlert("Ingrese el nombre de la sucursal","alert");
            }else if(idalmacen == 0){
                MyAlert("Seleccione el almacén al que pertenece la sucursal");
            }else if($.trim(total_cajas) == 0){
                MyAlert("Ingrese la cantidad de cajas a la sucursal","alert");
            }else if(isNaN(total_cajas)){
                MyAlert("El numero de cajas incorrecto","alert");
            }else if($.trim(domicilio) == ""){
                MyAlert("Ingrese el domicilio de la sucursaal","alert");
            }else if($.trim(telefono01) == "" && $.trim(telefono02) == "" && $.trim(celular) == "" ){
                MyAlert("Ingrese al menos un numero de contacto","alert");
            }else if($.trim(horario_semanal)=="" || $.trim(horario_findesemana) == ""){
                MyAlert("Ingrese al menos el horario de lunes a viernes","alert");
            }else{

                strData = {
                    nombre_departamento:nombre_departamento,
                    idalmacen :idalmacen,
                    total_cajas:total_cajas,
                    domicilio:domicilio,
                    correo:correo,
                    telefono01:telefono01,
                    telefono02:telefono02,
                    celular:celular,
                    horario_semanal:horario_semanal,
                    horario_findesemana:horario_findesemana
                };
                $.ajax({
                    data:strData,
                    type:"POST",
                    beforeSend:function(){
                        fnloadSpinner(1);
                    },
                    dataType:"JSON",
                    url:"modules/applications/src/departamentos/fn_registra_departamento.php"
                }).done( function(data) {

                    fnloadSpinner(2);
                    if(data.confirm == "ok"){

                        getMessage(data.mensaje);
                        menu_catalogos(10,10);

                    }else{

                        MyAlert(data.mensaje,"alert");

                    }

                }).fail(function(jqXHR,textStatus,errorThrown){
                    //fnloadSpinner(2);
                    console.log(textStatus + errorThrown);

                });
            }

            break;
        case 3:

            $('#btnGuardar_departamento').hide();
            $('#btnNuevo_departamento').hide();
            $("#btnGuardarCambios_departamento").show();
            SenderAjax(
                "modules/applications/views/departamentos/",
                "frm_editar_departamento.php",
                null,"DataList","post",{opc:opc,iddepartamento:iddepartamento}
            );
            break;
        case 4:

            if($.trim(iddepartamento) == ""){
                MyAlert("Error no se encontro el id del departamento","alert");
            }else if($.trim(nombre_departamento) == ""){
                MyAlert("Ingrese el nombre de la sucursal","alert");
            }else if(idalmacen == 0){
                MyAlert("Seleccione el almacén al que pertenece la sucursal");
            }else if($.trim(total_cajas) == 0){
                MyAlert("Ingrese la cantidad de cajas a la sucursal","alert");
            }else if(isNaN(total_cajas)){
                MyAlert("El numero de cajas incorrecto","alert");
            }else if($.trim(domicilio) == ""){
                MyAlert("Ingrese el domicilio de la sucursaal","alert");
            }else if($.trim(telefono01) == "" && $.trim(telefono02) == "" && $.trim(celular) == "" ){
                MyAlert("Ingrese al menos un numero de contacto","alert");
            }else if($.trim(horario_semanal)=="" || $.trim(horario_findesemana) == ""){
                MyAlert("Ingrese al menos el horario de lunes a viernes","alert");
            }else{

                strData = {
                    nombre_departamento:nombre_departamento,
                    idalmacen :idalmacen,
                    total_cajas:total_cajas,
                    domicilio:domicilio,
                    correo:correo,
                    telefono01:telefono01,
                    telefono02:telefono02,
                    celular:celular,
                    horario_semanal:horario_semanal,
                    horario_findesemana:horario_findesemana,
                    iddepartamento:iddepartamento,
                    idestado:idestado
                };
                $.ajax({
                    data:strData,
                    type:"POST",
                    beforeSend:function(){
                        fnloadSpinner(1);
                    },
                    dataType:"JSON",
                    url:"modules/applications/src/departamentos/fn_editar_departamento.php"
                }).done( function(data) {

                    fnloadSpinner(2);
                    if(data.confirm == "ok"){

                        getMessage(data.mensaje);
                        menu_catalogos(10,10);

                    }else{

                        MyAlert(data.mensaje,"alert");

                    }

                }).fail(function(jqXHR,textStatus,errorThrown){
                    //fnloadSpinner(2);
                    console.log(textStatus + errorThrown);

                });
            }
            break;
        default:
            MyAlert("Error opcion no encontrada","alert");
            break;
    }

}

/**
 * Catalogo de Productos
 * @param opc
 * @param idproducto
 */
function nuevo_producto(opc,idproducto){
    var codigo_producto = $('#codigo_producto').val(),
        nombre_producto = $('#nombre_producto').val(),
        descripcion_producto = $("#descripcion_producto").val(),
        categoria_producto = $("#categoria_producto").val(),
        subcategoria_producto = $("#subcategoria_producto").val(),
        talla_producto = $("#talla_producto").val(),
        color_producto = $("#idcolor").val(),
        precio_compra_producto = $("#precio_compra").val(),
        precio_venta_producto = $("#precio_venta").val(),
        precio_mayoreo_producto = $("#precio_mayoreo").val(),
        cantidad_mayoreo_producto = $("#cantidad_mayoreo").val(),
        inventario_minimo_producto = $("#inventario_minimo_producto").val(),
        inventario_maximo_producto = $("#inventario_maximo_producto").val(),
        inventario_inicial_producto = $("#inventario_inicial_producto").val();

    switch (opc){
        case 1:
            $('#btnGuardar_prodcuto').show();
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_nuevo_producto.php",
                null,"DataList","post",{opc:opc,idproducto:idproducto}
            );
            break;
        case 2:
            //extraer la informacion delinput file
            var archivo = document.getElementById('imagen_producto');
            var file = archivo.files[0];
            var data = new FormData();
            if (archivo.files && archivo.files[0]) {
                data.append('archivo',file);
            }

            if($.trim(nombre_producto) == ""){
                MyAlert("Ingrese el nombre del producto","alert");
            }else if($.trim(descripcion_producto)==""){
                MyAlert("Ingrese la descripción del producto","alert");
            }else if(categoria_producto == 0){
                MyAlert("Seleccione la categoría del producto","alert");
            }else if(subcategoria_producto == 0){
                MyAlert("Seleccione la sub categoría del producto","alert");
            }else if(talla_producto == 0 ){
                MyAlert("Seleccione la talla o medida del producto","alert");
            }else if($.trim(color_producto) == "" ){
                MyAlert("Seleccione el color del producto","alert");
            }else if($.trim(inventario_minimo_producto) == "" || isNaN(inventario_minimo_producto)){
                MyAlert("Ingrese la cantidad del inventario minimo","alert");
            }else if($.trim(inventario_maximo_producto) == "" || isNaN(inventario_minimo_producto)){
                MyAlert("Ingrese la cantidad del inventario maximo","alert");
            }else{

                color_producto = setFormatoColor(1,color_producto);
                precio_compra_producto = setFormatoMoneda(1,precio_compra_producto);
                precio_venta_producto = setFormatoMoneda(1,precio_venta_producto);
                precio_mayoreo_producto = setFormatoMoneda(1,precio_mayoreo_producto);

                data.append('nombre_producto',nombre_producto);
                data.append('descripcion',descripcion_producto);
                data.append('codigo',codigo_producto);

                data.append('idcategoria',categoria_producto);
                data.append('idsubcategoria',subcategoria_producto);
                data.append('idtalla',talla_producto);
                data.append('idcolor',color_producto);

                data.append('precio_compra',precio_compra_producto);
                data.append('precio_venta',precio_venta_producto);
                data.append('precio_mayoreo',precio_mayoreo_producto);
                data.append('cantidad_mayoreo',cantidad_mayoreo_producto);

                data.append('stock_minimo',inventario_minimo_producto);
                data.append('stock_maximo',inventario_maximo_producto);
                data.append('stock_inicia',inventario_inicial_producto);

                $.ajax({
                    url:"modules/applications/src/catalogos/fn_registra_articulo.php",
                    type:"post",
                    contentType:false,
                    data:data,
                    processData:false,
                    cache:false,
                    beforeSend:function(){
                        fnloadSpinner(1);
                    },
                    success:function(data){
                        $("#show_modal").html(data);
                        fnloadSpinner(2);
                    }
                });

            }
            break;
        case 3:
            //Mostrar fomulario para ediar el producto
            $('#btnGuardar_prodcuto').hide();
            $('#btnGuardarCambios_producto').show();
            SenderAjax(
                "modules/applications/views/catalogos/",
                "frm_editar_producto.php",
                null,"DataList","post",{opc:opc,idproducto:idproducto}
            );

            break;
        case 4:
            if($.trim(idproducto)== ""){
                MyAlert("No se encontro el id del producto","alert");
            }else if(isNaN(idproducto)){
                MyAlert("No se encontro el id del producto","alert");
            }else{
                var archivo = document.getElementById('imagen_producto');
                var file = archivo.files[0];
                var data = new FormData();
                if (archivo.files && archivo.files[0]) {
                    data.append('archivo',file);
                }

                if($.trim(nombre_producto) == ""){
                    MyAlert("Ingrese el nombre del producto","alert");
                }else if($.trim(descripcion_producto)==""){
                    MyAlert("Ingrese la descripción del producto","alert");
                }else if(categoria_producto == 0){
                    MyAlert("Seleccione la categoría del producto","alert");
                }else if(subcategoria_producto == 0){
                    MyAlert("Seleccione la sub categoría del producto","alert");
                }else if(talla_producto == 0 ){
                    MyAlert("Seleccione la talla o medida del producto","alert");
                }else if($.trim(color_producto) == "" ){
                    MyAlert("Seleccione el color del producto","alert");
                }else if($.trim(inventario_minimo_producto) == "" || isNaN(inventario_minimo_producto)){
                    MyAlert("Ingrese la cantidad del inventario minimo","alert");
                }else if($.trim(inventario_maximo_producto) == "" || isNaN(inventario_minimo_producto)){
                    MyAlert("Ingrese la cantidad del inventario maximo","alert");
                }else{

                    color_producto = setFormatoColor(1,color_producto);
                    precio_compra_producto = setFormatoMoneda(1,precio_compra_producto);
                    precio_venta_producto = setFormatoMoneda(1,precio_venta_producto);
                    precio_mayoreo_producto = setFormatoMoneda(1,precio_mayoreo_producto);

                    data.append('idarticulo',idproducto);
                    data.append('nombre_producto',nombre_producto);
                    data.append('descripcion',descripcion_producto);
                    data.append('codigo',codigo_producto);

                    data.append('idcategoria',categoria_producto);
                    data.append('idsubcategoria',subcategoria_producto);
                    data.append('idtalla',talla_producto);
                    data.append('idcolor',color_producto);

                    data.append('precio_compra',precio_compra_producto);
                    data.append('precio_venta',precio_venta_producto);
                    data.append('precio_mayoreo',precio_mayoreo_producto);
                    data.append('cantidad_mayoreo',cantidad_mayoreo_producto);

                    data.append('stock_minimo',inventario_minimo_producto);
                    data.append('stock_maximo',inventario_maximo_producto);
                    data.append('stock_inicia',inventario_inicial_producto);

                    $.ajax({
                        url:"modules/applications/src/catalogos/fn_editar_articulo.php",
                        type:"post",
                        contentType:false,
                        data:data,
                        processData:false,
                        cache:false,
                        beforeSend:function(){
                            fnloadSpinner(1);
                        },
                        success:function(data){
                            $("#show_modal").html(data);
                            fnloadSpinner(2);
                        }
                    });

                }
            }
            break;
        default:
            MyAlert("Error opción no encontrada","alert");
    }
}