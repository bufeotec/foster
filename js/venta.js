function enviar_comprobante_sunat(id_venta) {
    var cadena = "id_venta=" + id_venta;
    var boton = 'btn_enviar'+id_venta;
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ventas/crear_xml_enviar_sunat",
        data: cadena,
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'enviando...', true);
        },
        success:function (r) {
            cambiar_estado_boton(boton, "<i style=\"font-size: 16pt;\" class=\"fa fa-check margen\"></i>", false);
            switch (r.result.code) {
                case 1:
                    respuesta('¡Comprobante Enviado a Sunat!', 'success');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al generar el comprobante electronico', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 3:
                    respuesta('Error, Sunat rechazó el comprobante', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 4:
                    respuesta('Error de comunicacion con Sunat', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 5:
                    respuesta('Error al guardar en base de datos', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
            }
        }

    });
}
/*function ver_detalle_venta(id){
    var id_venta = id;
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ventas/consular_detalle_venta",
        data: "id_venta=" + id,
        dataType: 'json',
        success:function (r) {
            var series = "";
            //var series = "<option value='' selected>Seleccione</option>";
            for (var i=0; i<r.serie.length; i++){
                series += "<option value='"+r.serie[i].id_serie+"'>"+r.serie[i].serie+"</option>"
            }
            $("#serie").html(series);
            ConsultarCorrelativo();
        }

    });

}*/
function crear_enviar_resumen_sunat(){
    var fecha_post = $('#fecha_post').val();
    var cadena = "fecha=" + fecha_post;
    var boton = 'boton_enviar_resumen';
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ventas/crear_enviar_resumen_sunat",
        data: cadena,
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Enviando...', true);
        },
        success:function (r) {
            cambiar_estado_boton(boton, "Enviar Comprobantes", false);
            switch (r.result.code) {
                case 1:
                    respuesta('¡Resumen Creado y Enviado a Sunat!', 'success');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al generar el Resumen Diario', 'error');
                    break;
                case 3:
                    respuesta('Error, Sunat rechazó el comprobante', 'error');
                    break;
                case 4:
                    respuesta(r.result.message, 'error');
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }

    });
}

function comunicacion_baja(id_venta){
    var cadena = "id_venta=" + id_venta;
    var boton = 'btn_anular'+id_venta;
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ventas/comunicacion_baja",
        data: cadena,
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Anulando...', true);
        },
        success:function (r) {
            cambiar_estado_boton(boton, "ANULAR", false);
            switch (r.result.code) {
                case 1:
                    respuesta('¡Comprobante Enviado a Sunat!', 'success');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al generar el comprobante electronico', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 3:
                    respuesta('Error, Sunat rechazó el comprobante', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 4:
                    respuesta('Error de comunicacion con Sunat', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 5:
                    respuesta('Error al guardar en base de datos', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }

    });
}

function anular_boleta_cambiarestado(id_venta, estado){
    var cadena = "id_venta=" + id_venta + "&estado=" + estado;
    var boton = 'btn_anular_boleta'+id_venta;
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ventas/anular_boleta_cambiarestado",
        data: cadena,
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Anulando...', true);
        },
        success:function (r) {
            cambiar_estado_boton(boton, "ANULAR", false);
            switch (r.result.code) {
                case 1:
                    respuesta('¡Comprobante Anulado, listo para ser enviado por Resumen Diario!', 'success');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al anular el comprobante electronico', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }

    });
}

function realizar_venta_editar(){
    var valor = true;
    var boton = 'btn_generarventa';
    //datos cliente
    var id_venta = $('#id_venta').val();
    var id_mesa = $('#id_mesa').val();
    var serie_correlativo_notaventa = $('#serie_correlativo_notaventa').val();
    var client_number = $('#client_number').val();
    var client_name = $('#client_name').val();
    var saleproduct_direccion = $('#client_address').val();
    var client_telefono = $('#client_telefono').val();
    var select_tipodocumento = $('#select_tipodocumento').val();
    //var saleproductgas_telefono = $('#client_telefono').val();
    //datos venta
    var tipo_venta = $('#tipo_venta').val();
    var serie = $('#serie').val();
    var numero = $('#numero').val();
    var tipo_moneda = $('#tipo_moneda').val();
    //var saleproduct_naturaleza = $('#naturaleza_sell').val();
    var id_tipo_pago = $('#id_tipo_pago').val();
    var total = $('#montototal').val();
    var gravada = $('#gravada').val();
    var igv = $('#igv').val();
    var saleproduct_inafecta = $('#inafecta').val();
    var saleproduct_exonerada = $('#exonerada').val();
    var saleproduct_icbper = $('#icbper').val();
    var saleproduct_total = total;
    var saleproduct_gravada = gravada;
    var saleproduct_igv = igv;
    var saleproduct_gratuita = $('#gratuita').val();
    var pago_con_ = $('#pago_con_').val();
    var vuelto_ = $('#vuelto_').val();
    var des_global = $('#descuento_global').val();
    var des_total = $('#des_total').val();
    var contenido_cuota = $('#contenido_cuota').val();

    var contenido_tipopago = id_tipo_pago + '-.-.' + saleproduct_total + '/-/-';

    var Tipo_documento_modificar = "";
    var serie_modificar = "";
    var numero_modificar = "";
    var notatipo_descripcion = "";
    if (tipo_venta === "07" || tipo_venta === "08"){
        Tipo_documento_modificar = $('#Tipo_documento_modificar').val();
        serie_modificar = $('#serie_modificar').val();
        numero_modificar = $('#numero_modificar').val();
        notatipo_descripcion = $('#notatipo_descripcion').val();
    }
    if(id_tipo_pago == 5){
        if(contenido_cuota == ""){
            respuesta('Falta agregar Cuotas a la Venta', 'error');
            valor=false;
        }else{
            //valor = validar_parametro_vacio(contenido_cuota, valor);
            var importe_cuota = $('#total_cuota').html();
            var total_temporal = $('#montototal_').html();
            if(importe_cuota != total_temporal){
                respuesta('El Total de las Cuotas '+importe_cuota+' no es igual al Total de la Venta '+total_temporal, 'error');
                valor=false;
            }
        }
    }

    //validar campos vacios
    valor = validar_campo_vacio('client_number', client_number, valor);
    valor = validar_campo_vacio('select_tipodocumento', select_tipodocumento, valor);
    valor = validar_campo_vacio('id_tipo_pago', id_tipo_pago, valor);
    valor = validar_campo_vacio('tipo_venta', tipo_venta, valor);
    valor = validar_campo_vacio('tipo_moneda', tipo_moneda, valor);
    valor = validar_campo_vacio('serie', serie, valor);
    valor = validar_campo_vacio('numero', numero, valor);
    valor = validar_campo_vacio('montototal', saleproduct_total, valor);


    if(valor){
        var cadena = "cliente_numero=" + client_number +
            "&cliente_nombre=" + client_name +
            "&cliente_direccion=" + saleproduct_direccion +
            "&cliente_telefono=" + client_telefono +
            "&select_tipodocumento=" + select_tipodocumento +
            "&tipo_venta=" + tipo_venta +
            "&serie=" + serie +
            "&correlativo=" + numero +
            "&tipo_moneda=" + tipo_moneda +
            "&id_tipo_pago=" + id_tipo_pago +
            "&op_exoneradas_=" + saleproduct_exonerada +
            "&op_inafectas_=" + saleproduct_inafecta +
            "&icbper_=" + saleproduct_icbper +
            "&venta_total=" + saleproduct_total +
            "&op_gravadas_=" + saleproduct_gravada +
            "&notatipo_descripcion=" + notatipo_descripcion +
            "&serie_modificar=" + serie_modificar +
            "&numero_modificar=" + numero_modificar +
            "&Tipo_documento_modificar=" + Tipo_documento_modificar +
            "&op_gratuitas_=" + saleproduct_gratuita +
            "&pago_cliente=" + pago_con_ +
            "&vuelto_=" + vuelto_ +
            "&des_global=" + des_global +
            "&des_total=" + des_total +
            "&igv_=" + saleproduct_igv +
            "&id_mesa=" + id_mesa +
            "&contenido_tipopago=" + contenido_tipopago +
            "&serie_correlativo_notaventa=" + serie_correlativo_notaventa +
            "&id_venta=" + id_venta +
            "&contenido_cuota=" + contenido_cuota;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Ventas/guardar_venta_market",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'cobrando...', true);
            },
            success: function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-money\"></i> GENERAR VENTA", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Venta realizada correctamente!', 'success');
                        setTimeout(function () {
                            location.href = urlweb +  'Ventas/ver_detalle_venta/' + r.result.idventa;
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al generar Venta', 'error');
                        break;
                    case 5:
                        respuesta('Error al generar Venta, revisar Cliente', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }

}

function realizar_venta(){
    var valor = true;
    var boton = 'btn_generarventa';
    //datos cliente
    //var id_venta = $('#id_venta').val();
    var client_number = $('#client_number').val();
    var client_name = $('#client_name').val();
    var saleproduct_direccion = $('#client_address').val();
    var client_telefono = $('#client_telefono').val();
    var select_tipodocumento = $('#select_tipodocumento').val();
    //var saleproductgas_telefono = $('#client_telefono').val();
    //datos venta
    var tipo_venta = $('#tipo_venta').val();
    var serie = $('#serie').val();
    var numero = $('#numero').val();
    var tipo_moneda = $('#tipo_moneda').val();
    //var saleproduct_naturaleza = $('#naturaleza_sell').val();
    var id_tipo_pago = $('#id_tipo_pago').val();
    var total = $('#montototal').val();
    var gravada = $('#gravada').val();
    var igv = $('#igv').val();
    var saleproduct_inafecta = $('#inafecta').val();
    var saleproduct_exonerada = $('#exonerada').val();
    var saleproduct_icbper = $('#icbper').val();
    var saleproduct_total = total;
    var saleproduct_gravada = gravada;
    var saleproduct_igv = igv;
    var saleproduct_gratuita = $('#gratuita').val();
    var pago_con_ = $('#pago_con_').val();
    var vuelto_ = $('#vuelto_').val();
    var des_global = $('#descuento_global').val();
    var des_total = $('#des_total').val();
    var contenido_cuota = $('#contenido_cuota').val();
    var membresia_inicio = $('#membresia_inicio').val();
    var id_horario = $('#id_horario').val();
    var ticketcito = $('#ticketcito').val();

    var membresia_crear_suscripcion = $('#membresia_crear_suscripcion').val();
    var membresia_cantidad_suscripcion = $('#membresia_cantidad_suscripcion').val();
    var membresia_tiempo_suscripcion = $('#membresia_tiempo_suscripcion').val();

    var contenido_tipopago = id_tipo_pago + '-.-.' + saleproduct_total + '/-/-';

    var Tipo_documento_modificar = "";
    var serie_modificar = "";
    var numero_modificar = "";
    var notatipo_descripcion = "";
    if (tipo_venta === "07" || tipo_venta === "08"){
        Tipo_documento_modificar = $('#Tipo_documento_modificar').val();
        serie_modificar = $('#serie_modificar').val();
        numero_modificar = $('#numero_modificar').val();
        notatipo_descripcion = $('#notatipo_descripcion').val();
    }
    if(id_tipo_pago == 5){
        if(contenido_cuota == ""){
            respuesta('Falta agregar Cuotas a la Venta', 'error');
            valor=false;
        }else{
            //valor = validar_parametro_vacio(contenido_cuota, valor);
            var importe_cuota = $('#total_cuota').html();
            var total_temporal = $('#montototal_').html();
            if(importe_cuota != total_temporal){
                respuesta('El Total de las Cuotas '+importe_cuota+' no es igual al Total de la Venta '+total_temporal, 'error');
                valor=false;
            }
        }
    }

    //validar campos vacios
    valor = validar_campo_vacio('client_number', client_number, valor);
    valor = validar_campo_vacio('select_tipodocumento', select_tipodocumento, valor);
    valor = validar_campo_vacio('id_tipo_pago', id_tipo_pago, valor);
    valor = validar_campo_vacio('tipo_venta', tipo_venta, valor);
    valor = validar_campo_vacio('tipo_moneda', tipo_moneda, valor);
    valor = validar_campo_vacio('serie', serie, valor);
    valor = validar_campo_vacio('numero', numero, valor);
    valor = validar_campo_vacio('montototal', saleproduct_total, valor);
    valor = validar_campo_vacio('membresia_inicio', membresia_inicio, valor);
    valor = validar_campo_vacio('id_horario', id_horario, valor);

    valor = validar_campo_vacio('membresia_crear_suscripcion', membresia_crear_suscripcion, valor);
    valor = validar_campo_vacio('membresia_cantidad_suscripcion', membresia_cantidad_suscripcion, valor);
    valor = validar_campo_vacio('membresia_tiempo_suscripcion', membresia_tiempo_suscripcion, valor);
    if(valor){
        var cadena = "cliente_numero=" + client_number +
            "&cliente_nombre=" + client_name +
            "&cliente_direccion=" + saleproduct_direccion +
            "&cliente_telefono=" + client_telefono +
            "&select_tipodocumento=" + select_tipodocumento +
            "&tipo_venta=" + tipo_venta +
            "&serie=" + serie +
            "&correlativo=" + numero +
            "&tipo_moneda=" + tipo_moneda +
            "&id_tipo_pago=" + id_tipo_pago +
            "&op_exoneradas_=" + saleproduct_exonerada +
            "&op_inafectas_=" + saleproduct_inafecta +
            "&icbper_=" + saleproduct_icbper +
            "&venta_total=" + saleproduct_total +
            "&op_gravadas_=" + saleproduct_gravada +
            "&notatipo_descripcion=" + notatipo_descripcion +
            "&serie_modificar=" + serie_modificar +
            "&numero_modificar=" + numero_modificar +
            "&Tipo_documento_modificar=" + Tipo_documento_modificar +
            "&op_gratuitas_=" + saleproduct_gratuita +
            "&pago_cliente=" + pago_con_ +
            "&vuelto_=" + vuelto_ +
            "&membresia_inicio=" + membresia_inicio +
            "&id_horario=" + id_horario +
            "&membresia_crear_suscripcion=" + membresia_crear_suscripcion +
            "&membresia_cantidad_suscripcion=" + membresia_cantidad_suscripcion +
            "&membresia_tiempo_suscripcion=" + membresia_tiempo_suscripcion +
            "&des_global=" + des_global +
            "&des_total=" + des_total +
            "&igv_=" + saleproduct_igv +
            "&ticketcito=" + ticketcito +
            "&id_mesa=-2" +
            "&contenido_tipopago=" + contenido_tipopago +
            "&contenido_cuota=" + contenido_cuota;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Ventas/guardar_venta_market",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'cobrando...', true);
            },
            success: function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-money\"></i> GENERAR VENTA", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Venta realizada correctamente!', 'success');
                        setTimeout(function () {
                            location.href = urlweb +  'Ventas/ver_detalle_venta/' + r.result.idventa;
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al generar Venta', 'error');
                        break;
                    case 5:
                        respuesta('Error al generar Venta, revisar Cliente', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }

}

function realizar_venta_rapida_pv(){
    var valor = true;
    var boton = 'btn_generarventa';
    //var saleproductgas_telefono = $('#client_telefono').val();
    //datos venta
    var id_cliente = $('#id_cliente').val();
    var tipo_venta = $('#tipo_venta').val();
    var serie = $('#serie').val();
    var numero = $('#numero').val();
    var tipo_moneda = $('#tipo_moneda').val();
    //var saleproduct_naturaleza = $('#naturaleza_sell').val();
    var id_tipo_pago = $('#id_tipo_pago').val();
    var venta_total_pv = $('#venta_total_pv').val();


    if(valor){
        var cadena = "id_cliente=" + id_cliente +
            "&select_tipodocumento=" + select_tipodocumento +
            "&tipo_venta=" + tipo_venta +
            "&serie=" + serie +
            "&correlativo=" + numero +
            "&tipo_moneda=" + tipo_moneda +
            "&id_tipo_pago=" + id_tipo_pago +
            "&id_mesa=-2" +
            "&venta_total_pv=" + venta_total_pv;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Ventas/guardar_venta_rapida_pv",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'cobrando...', true);
            },
            success: function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-money\"></i> GENERAR VENTA", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Venta realizada correctamente!', 'success');
                        setTimeout(function () {
                            location.href = urlweb +  'Ventas/ventas_por_cliente/';
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al generar Venta', 'error');
                        break;
                    case 5:
                        respuesta('Error al generar Venta, revisar Cliente', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }

}

function eliminar_pre_venta(id_pre_venta,boton){
    var valor = true;
    //Validamos si los campos a usar no se encuentran vacios
    if(valor) {
        var cadena = "id_pre_venta=" + id_pre_venta;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Ventas/eliminar_pre_venta",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, "Eliminando...", true);
            },
            success: function (r) {
                cambiar_estado_boton(boton, "Eliminar Registro", false);
                switch (r.result.code) {
                    case 1:
                        $('#pv' + id_pre_venta).remove();
                        respuesta('¡Registro Eliminado!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 300);
                        break;
                    case 2:
                        respuesta('Error al eliminar producto', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

function poner_id_venta(id){
    $("#id_venta_cliente").val(id);
}

function enviar_email_cliente(){
    var correo = $("#correo_del_cliente").val();
    var id_venta = $("#id_venta_cliente").val();
    if(correo == ""){
        respuesta('Debe introducir una dirección de correo electronico', 'error');
    } else {
        var cadena = "email=" + correo+"&id="+id_venta;

        $.ajax({
            type:"POST",
            url: urlweb + "api/Ventas/enviar_venta_correo",
            data : cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton('guardar_envio_mensajito', 'Enviando correo, espere un momento...', true);
                $('#cancelar_envio_mensajito').hide();
            },
            success:function (r) {
                cambiar_estado_boton('guardar_envio_mensajito', 'Guardar', true);
                $('#cancelar_envio_mensajito').show();
                switch (r.result) {
                    case 1:
                        $("#correo_del_cliente").val("");
                        respuesta('¡Correo Enviado!', 'success');
                        break;
                    case 2:
                        respuesta('Ocurrió Un Error al enviar correo', 'error');
                        break;
                    default:
                        respuesta('Ocurrió Un Error Desconocido', 'error');
                }
            }
        });
    }
}
