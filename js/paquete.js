function ver_productito(){
    var producto_precio = $("#agregado_tipo").val();
    if(producto_precio == "PRO"){
        $('#asociadito').removeClass('no-show');
        $("#agregado_id_producto").val("");

        $('#asociadito_s').addClass('no-show');
        $("#agregado_id_servicio").val("");
    } else if (producto_precio == "SER") {
        $('#asociadito_s').removeClass('no-show');
        $("#agregado_id_servicio").val("");

        $('#asociadito').addClass('no-show');
        $("#agregado_id_producto").val("");
    } else {
        $('#asociadito').addClass('no-show');
        $("#agregado_id_producto").val("");

        $('#asociadito_s').addClass('no-show');
        $("#agregado_id_servicio").val("");
    }
}

function ver_productito_e(){
    var producto_precio = $("#agregado_tipo_e").val();
    if(producto_precio == "PRO"){
        $('#asociadito_e').removeClass('no-show');
        //$("#agregado_id_producto_e").val("");

        $('#asociadito_se').addClass('no-show');
        $("#agregado_id_servicio_e").val("");
    } else if(producto_precio == "SER") {
        $('#asociadito_se').removeClass('no-show');
        //$("#agregado_id_servicio_e").val("");

        $('#asociadito_e').addClass('no-show');
        $("#agregado_id_producto_e").val("");
    } else {
        $('#asociadito_e').addClass('no-show');
        $("#agregado_id_producto_e").val("");

        $('#asociadito_se').addClass('no-show');
        $("#agregado_id_servicio_e").val("");
    }
}

$("#agregar_nuevo_paquete").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-paquete";
    //Extraemos las variable según los valores del campo consultado
    var id_producto = $('#id_producto').val();
    var agregado_tipo = $('#agregado_tipo').val();
    var agregado_cantidad = $('#agregado_cantidad').val();
    var agregado_unidad = $('#agregado_unidad').val();

    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_campo_vacio('id_producto', id_producto, valor);
    valor = validar_campo_vacio('agregado_tipo', agregado_tipo, valor);
    valor = validar_campo_vacio('agregado_cantidad', agregado_cantidad, valor);
    valor = validar_campo_vacio('agregado_unidad', agregado_unidad, valor);

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Paquete/guardar_paquete",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Paquete guardado! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar Paquete, vuelva a intentarlo', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});

$("#editar_nuevo_paquete").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-paquete";
    //Extraemos las variable según los valores del campo consultado
    var id_agregado = $('#id_agregado').val();
    var agregado_tipo_e = $('#agregado_tipo_e').val();
    var agregado_cantidad_e = $('#agregado_cantidad_e').val();
    var agregado_unidad_e = $('#agregado_unidad_e').val();
    var agregado_estado_e = $('#agregado_estado_e').val();

    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_campo_vacio('id_agregado', id_agregado, valor);
    valor = validar_campo_vacio('agregado_tipo_e', agregado_tipo_e, valor);
    valor = validar_campo_vacio('agregado_cantidad_e', agregado_cantidad_e, valor);
    valor = validar_campo_vacio('agregado_unidad_e', agregado_unidad_e, valor);
    valor = validar_campo_vacio('agregado_estado_e', agregado_estado_e, valor);

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Paquete/guardar_paquete",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Paquete editado! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al editar Paquete, vuelva a intentarlo', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});

function editar_paquete(id_agregado, id_producto_e, agregado_tipo_e, agregado_id_producto_e, agregado_id_servicio_e, agregado_cantidad_e, agregado_unidad_e, agregado_estado_e){
    $('#id_agregado').val(id_agregado);
    $('#id_producto_e').val(id_producto_e);
    $('#agregado_tipo_e').val(agregado_tipo_e);
    ver_productito_e();
    $("#agregado_id_producto_e").val(agregado_id_producto_e);
    $("#agregado_id_servicio_e").val(agregado_id_servicio_e);
    $("#agregado_cantidad_e").val(agregado_cantidad_e);
    $("#agregado_unidad_e").val(agregado_unidad_e);
    $("#agregado_estado_e").val(agregado_estado_e);

    cambiar_color_estado('agregado_estado_e');

}
