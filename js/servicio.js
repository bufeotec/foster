function editar_servicio(id_servicio, servicio_nombre, servicio_descripcion, servicio_estado){
    $('#id_servicio').val(id_servicio);
    $('#servicio_nombre_e').val(servicio_nombre);
    $('#servicio_descripcion_e').val(servicio_descripcion);
    $("#servicio_estado_e").val(servicio_estado);
    cambiar_color_estado('servicio_estado_e');
}

$("#gestionarServicio").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-servicio";
    //Extraemos las variable según los valores del campo consultado
    var servicio_nombre = $('#servicio_nombre').val();
    var servicio_descripcion = $('#servicio_descripcion').val();

    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_campo_vacio('servicio_nombre', servicio_nombre, valor);
    valor = validar_campo_vacio('servicio_descripcion', servicio_descripcion, valor);

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Servicio/guardar_servicio",
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
                        respuesta('¡Servicio guardado! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar Servicio, vuelva a intentarlo', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});

$("#gestionarServicioEditar").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-editar-servicio";
    //Extraemos las variable según los valores del campo consultado
    var id_servicio = $('#id_servicio').val();
    var servicio_nombre = $('#servicio_nombre_e').val();
    var servicio_descripcion = $('#servicio_descripcion_e').val();

    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_campo_vacio('id_servicio', id_servicio, valor);
    valor = validar_campo_vacio('servicio_nombre_e', servicio_nombre, valor);
    valor = validar_campo_vacio('servicio_descripcion_e', servicio_descripcion, valor);

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Servicio/guardar_servicio",
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
                        respuesta('¡Servicio Editado! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al editar Servicio, vuelva a intentarlo', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});