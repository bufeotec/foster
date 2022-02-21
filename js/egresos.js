$("#agregar_egresos").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-egreso";
    //Extraemos las variable según los valores del campo consultado
    var egreso_descripcion = $('#egreso_descripcion').val();
    var id_sucursal = $('#id_sucursal').val();
    var egreso_monto = $('#egreso_monto').val();

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Egreso/guardar_egresos",
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
                        respuesta('¡Movimiento guardado! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar, Comuniquese con BufeoTec', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});


function eliminar_egreso(id_movimiento){
    var valor = true;
    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_parametro_vacio(id_movimiento, valor);
    if(valor) {
        var boton = "btn-eliminar_egreso" + id_movimiento;
        var cadena = "id_movimiento=" + id_movimiento;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Egreso/eliminar_egreso",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, "Eliminando...", true);
            },
            success: function (r) {
                switch (r.result.code) {
                    case 1:
                        $('#egresos' + id_movimiento).remove();
                        respuesta('¡Registro Eliminado!', 'success');
                        break;
                    case 2:
                        respuesta('Error al eliminar registro', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

function eliminar_gasto(id_gasto_personal){
    var valor = true;
    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_parametro_vacio(id_gasto_personal, valor);
    if(valor) {
        var boton = "btn-eliminar_gasto" + id_gasto_personal;
        var cadena = "id_gasto_personal=" + id_gasto_personal;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Egreso/eliminar_gasto_personal",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, "Eliminando...", true);
            },
            success: function (r) {
                switch (r.result.code) {
                    case 1:
                        $('#gasto' + id_gasto_personal).remove();
                        respuesta('¡Registro Eliminado!', 'success');
                        break;
                    case 2:
                        respuesta('Error al eliminar registro', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}
function editar_egreso(id_movimiento,id_sucursal,movimiento_tipo, egreso_descripcion, egreso_monto){
    $('#id_movimiento').val(id_movimiento);
    $('#id_sucursal_e').val(id_sucursal);
    $('#movimiento_tipo_e').val(movimiento_tipo);
    $('#egreso_descripcion_e').val(egreso_descripcion);
    $('#egreso_monto_e').val(egreso_monto);
}


function editar_gasto(id_gasto_personal,id_persona,gasto_persona_concepto,gasto_persona_monto){
    $('#id_gasto_personal').val(id_gasto_personal);
    $('#id_persona_e').val(id_persona);
    $('#gasto_personal_concepto_e').val(gasto_persona_concepto);
    $('#gasto_personal_monto_e').val(gasto_persona_monto);
}

$("#editar_egresos").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-editar-egreso";
    //Extraemos las variable según los valores del campo consultado
    var egreso_descripcion_e = $('#egreso_descripcion_e').val();
    var id_sucursal_e = $('#id_sucursal_e').val();
    var movimiento_tipo_e = $('#movimiento_tipo_e').val();
    var egreso_monto_e = $('#egreso_monto_e').val();
    var id_movimiento = $('#id_movimiento').val();

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Egreso/editar_egresos",
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
                        respuesta('¡Movimiento Editado correctamente! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al editar egreso, vuelva a intentarlo', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});


$("#gastos").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-gasto";
    //Extraemos las variable según los valores del campo consultado
    var gasto_personal_concepto = $('#gasto_personal_concepto').val();
    var id_persona = $('#id_persona').val();

    validar_campo_vacio('gasto_personal_concepto', gasto_personal_concepto, valor);
    validar_campo_vacio('id_persona', id_persona, valor);

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Egreso/guardar_gasto_personal",
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
                        respuesta('¡Guardado exitosamente! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 600);
                        break;
                    case 2:
                        respuesta('Error al guardar, Comuniquese con BufeoTec', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});

$("#editar_gastos").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-editar-gasto";
    //Extraemos las variable según los valores del campo consultado
    var gasto_personal_concepto = $('#gasto_personal_concepto').val();
    var id_persona = $('#id_persona').val();


    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Egreso/guardar_gasto_personal_editado",
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
                        respuesta('¡Guardado exitosamente! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 600);
                        break;
                    case 2:
                        respuesta('Error al guardar, Comuniquese con BufeoTec', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});


$("#save_persona").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var persona_nombre = $('#persona_nombre').val();
    var persona_apellido_paterno = $('#persona_apellido_paterno').val();
    var persona_apellido_materno = $('#persona_apellido_materno').val();

    valor = validar_campo_vacio('persona_nombre', persona_nombre, valor);
    valor = validar_campo_vacio('persona_apellido_paterno', persona_apellido_paterno, valor);
    valor = validar_campo_vacio('persona_apellido_materno', persona_apellido_materno, valor);

    if (valor){
        $.ajax({
            type:"POST",
            url: urlweb + "api/Egreso/guardar_personal",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            dataType: 'json',
            beforeSend: function () {
                $("#btn-person-add").attr("disabled", true);
            },
            success:function (r) {
                $("#btn-person-add").attr("disabled", false);
                switch (r.result.code) {
                    case 1:
                        respuesta("¡Guardado con Exito...Recargando!",'success');
                        setTimeout(function () {
                            location.reload();
                        }, 400);
                        break;
                    case 2:
                        respuesta("Fallo el envio",'error');
                        break;
                    case 6:
                        respuesta("Algún dato fue ingresado de manera erronéa. Por favor ingrese todos los datos de forma correcta.",'error');
                        break;
                    default:
                        respuesta("ERROR DESCONOCIDO",'error');
                }
            }
        });
    }
});