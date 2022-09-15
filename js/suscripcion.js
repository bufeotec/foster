function eliminar_suscripcion(id_suscripcion){
    var valor = true;
    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_parametro_vacio(id_suscripcion, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Definimos el mensaje y boton a afectar
        var boton = "btn_eliminar_suscripcion" + id_suscripcion;
        //Cadena donde enviaremos los parametros por POST
        var cadena = "id_suscripcion=" + id_suscripcion;
        $.ajax({
            type: "POST",
            url: urlweb + "api/suscripcion/eliminar_suscripcion",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                //cambiar_estado_boton(boton, "Eliminando...", true);
            },
            success:function (r) {
                //cambiar_estado_boton(boton, "Eliminar Suscripcion", false);
                switch (r.result.code) {
                    case 1:
                        //$('#cliente' + id_cliente).remove();
                        respuesta('¡Suscripcion Eliminado!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al eliminar suscripcion', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

function notificar_suscripcion(id_suscripcion){
    var valor = true;
    //Validamos si los campos a usar no se encuentran vacios
    var fecha = $('#fecha').val();
    valor = validar_parametro_vacio(id_suscripcion, valor);
    valor = validar_parametro_vacio(fecha, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Definimos el mensaje y boton a afectar
        var boton = "btn_eliminar_suscripcion" + id_suscripcion;
        //Cadena donde enviaremos los parametros por POST
        var cadena = "id_suscripcion=" + id_suscripcion + "&fecha_consulta=" + fecha;
        $.ajax({
            type: "POST",
            url: urlweb + "api/suscripcion/notificar_vencimiento_cliente",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                //cambiar_estado_boton(boton, "Eliminando...", true);
                respuesta('Notificando, espere un momento...', 'info');
            },
            success:function (r) {
                //cambiar_estado_boton(boton, "Eliminar Suscripcion", false);
                switch (r.result) {
                    case 1:
                        //$('#cliente' + id_cliente).remove();
                        respuesta('¡Suscripcion Notificada!', 'success');
                        /*setTimeout(function () {
                            location.reload();
                        }, 1000);*/
                        break;
                    case 2:
                        respuesta('Error al eliminar suscripcion', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

$("#editar_suscri_fachera").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-editar-uso-suscri";
    //Extraemos las variable según los valores del campo consultado
    var id_suscripcion = $('#id_suscripcion').val();
    var suscripcion_inicio = $('#suscripcion_inicio').val();
    var suscripcion_fin_actual = $('#suscripcion_fin_actual').val();
    var id_horario = $('#id_horario').val();
    var suscripcion_comentario = $('#suscripcion_comentario').val();

    valor = validar_campo_vacio('id_suscripcion', id_suscripcion, valor);
    valor = validar_campo_vacio('suscripcion_inicio', suscripcion_inicio, valor);
    valor = validar_campo_vacio('suscripcion_fin_actual', suscripcion_fin_actual, valor);
    valor = validar_campo_vacio('id_horario', id_horario, valor);
    //valor = validar_campo_vacio('suscripcion_comentario', suscripcion_comentario, valor);


    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/suscripcion/editar_suscripcion_creada",
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
                        respuesta('¡Guardado! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('¡Error!', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});


$("#mebresiaGratuita").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-membresia";
    //Extraemos las variable según los valores del campo consultado
    var id_horario = $('#id_horario').val();
    var client_number = $('#client_number').val();
    var cliente_nombre = $('#cliente_nombre').val();
    var membresia_inicio = $('#membresia_inicio').val();
    var membresia_cantidad = $('#membresia_cantidad').val();


    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_campo_vacio('id_horario', id_horario, valor);
    valor = validar_campo_vacio('client_number', client_number, valor);
    valor = validar_campo_vacio('cliente_nombre', cliente_nombre, valor);
    valor = validar_campo_vacio('membresia_inicio', membresia_inicio, valor);
    valor = validar_campo_vacio('membresia_cantidad', membresia_cantidad, valor);

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Suscripcion/guardar_membresia_free",
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
                        respuesta('¡Guardado! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar membresia, vuelva a intentarlo', 'error');
                        break;
                    case 5:
                        respuesta('Ya existe una suscripción activa dentro del inicio de fecha estipulado.', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});

$("#gastar_servicio").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-uso-servicio";
    //Extraemos las variable según los valores del campo consultado
    var id_servicio_cliente = $('#id_servicio_cliente').val();
    var cantidad_maxima_usada = $('#cantidad_maxima_usada').val();
    var servicio_historial_cantidad = $('#servicio_historial_cantidad').val();
    var servicio_historial_comentarios = $('#servicio_historial_comentarios').val();


    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_campo_vacio('id_servicio_cliente', id_servicio_cliente, valor);
    valor = validar_campo_vacio('cantidad_maxima_usada', cantidad_maxima_usada, valor);
    valor = validar_campo_vacio('servicio_historial_cantidad', servicio_historial_cantidad, valor);

    var balance = (cantidad_maxima_usada * 1) - (servicio_historial_cantidad * 1);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        if(balance >= 0){
            //Cadena donde enviaremos los parametros por POST
            $.ajax({
                type: "POST",
                url: urlweb + "api/Suscripcion/registrar_historia_servicio",
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
                            respuesta('¡Guardado! Recargando...', 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                            break;
                        case 2:
                            respuesta('Error al guardar servicio, vuelva a intentarlo', 'error');
                            break;
                        default:
                            respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                            break;
                    }
                }
            });
        } else {
            respuesta('No se puede usar más servicios de los restantes', 'error');
        }
    }
});

$("#ficha_nueva").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-ficha-nueva";
    //Extraemos las variable según los valores del campo consultado
    var id_cliente = $('#id_cliente').val();

    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_campo_vacio('id_cliente', id_cliente, valor);
    if(valor){
        $.ajax({
            type: "POST",
            url: urlweb + "api/Suscripcion/guardar_ficha",
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
                        respuesta('¡Guardado! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar ficha, vuelva a intentarlo', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});

function eliminar_ficha(id_ficha){
    var valor = true;
    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_parametro_vacio(id_ficha, valor);
    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Definimos el mensaje y boton a afectar
        var boton = "btn-fichita" + id_ficha;
        //Cadena donde enviaremos los parametros por POST
        var cadena = "id_ficha=" + id_ficha;
        $.ajax({
            type: "POST",
            url: urlweb + "api/suscripcion/eliminar_ficha",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, "<i class=\"fa fa-trash\"></i>", true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-trash\"></i>", false);
                switch (r.result.code) {
                    case 1:
                        //$('#cliente' + id_cliente).remove();
                        respuesta('¡Ficha Eliminada!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al eliminar ficha', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}