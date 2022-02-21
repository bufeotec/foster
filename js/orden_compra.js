function recursos(){
    var id_sucursal =  $("#id_sucursal").val();
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ordencompra/listar_recursos_x_sucursal",
        data: "id_sucursal="+id_sucursal,
        dataType: 'json',
        success:function (r) {
            $("#div_recurso").show();
            var datos_recurso = "<option value='' selected>Seleccione</option>";
            for(var j =0;j<r.result.length;j++){
                datos_recurso +="<option value='"+r.result[j].id_recurso+"'>"+r.result[j].recurso_nombre+"</option>";
            }
            $("#id_recurso").html(datos_recurso);
        }
    });
}

var contenido = "";
var conteo = 1;
var suma_total = 0;
var suma_total_ = 0;
function show_table() {
    var llenar="";
    conteo=1;
    if (contenido.length>0){
        var filas=contenido.split('/./.');
        if(filas.length>0){
            var sum = 0;
            for(var i=0;i<filas.length - 1;i++){
                var celdas =filas[i].split('-.-.');
                llenar += "<tr><td>"+conteo+"</td>"+
                    "<td>"+celdas[1]+"</td>"+
                    "<td>"+celdas[2]+"</td>"+
                    "<td>"+celdas[3]+"</td>"+
                    "<td>"+celdas[4]+"</td>"+
                    "<td><a data-toggle=\"tooltip\" onclick='delete_detalle("+i+")' title=\"Eliminar\" type=\"button\" class=\"text-danger\" ><i class=\"fa fa-times ver_detalle\"></i></a></td>"+
                    "</tr>";
                conteo++;
                sum = sum + celdas[4] * 1;
            }
            suma_total = sum;
        }
    }else{
        suma_total = 0;
    }
    $("#contenido_detalle_compra").html(llenar);
    $("#conteo").html(conteo);
    $("#suma_total").val(suma_total);
}

function show_table_() {
    var llenar="";
    conteo=1;
    if (contenido.length>0){
        var filas=contenido.split('/./.');
        if(filas.length>0){
            var sum = 0;
            for(var i=0;i<filas.length - 1;i++){
                var celdas =filas[i].split('-.-.');
                llenar += "<tr><td>"+conteo+"</td>"+
                    "<td>"+celdas[1]+"</td>"+
                    "<td>"+celdas[2]+"</td>"+
                    "<td>"+celdas[3]+"</td>"+
                    "<td>"+celdas[4]+"</td>"+
                    "<td><a data-toggle=\"tooltip\" onclick='delete_detalle_("+i+")' title=\"Eliminar\" type=\"button\" class=\"text-danger\" ><i class=\"fa fa-times ver_detalle\"></i></a></td>"+
                    "</tr>";
                conteo++;
                sum = sum + celdas[4] * 1;
            }
            suma_total_ = sum;
        }
    }else{
        suma_total_ = 0;
    }
    $("#contenido_detalle_compra").html(llenar);
    $("#conteo").html(conteo);
    $("#suma_total_").val(suma_total_);
}

function delete_detalle(ind) {
    var contenido_artificio ="";
    var subtotal = "";
    if (contenido.length>0){
        var filas=contenido.split('/./.');
        if(filas.length>0){
            for(var i=0;i<filas.length - 1;i++){
                if(i!=ind){
                    var celdas =filas[i].split('-.-.');
                    contenido_artificio += celdas[0] + "-.-."+celdas[1] + "-.-." + celdas[2] + "-.-." + celdas[3] + "-.-." +celdas[4] + "/./.";
                }
            }
        }
    }

    contenido = contenido_artificio;
    show_table();
}

function delete_detalle_(ind) {
    var contenido_artificio ="";
    var subtotal = "";
    if (contenido.length>0){
        var filas=contenido.split('/./.');
        if(filas.length>0){
            for(var i=0;i<filas.length - 1;i++){
                if(i!=ind){
                    var celdas =filas[i].split('-.-.');
                    contenido_artificio += celdas[0] + "-.-."+celdas[1] + "-.-." + celdas[2] + "-.-." + celdas[3] + "-.-." +celdas[4] + "/./.";
                }
            }
        }
    }

    contenido = contenido_artificio;
    show_table_();
}

function agregar(){

    var recurso_val = $("#id_recurso").val();
    if(recurso_val!=""){
        var id_recurso = $("select[name='id_recurso'] option:selected").text();
    }else{
        var id_recurso = "";
    }

    var detalle_compra_cantidad = $("#detalle_compra_cantidad").val() * 1;
    var detalle_compra_precio_compra = $("#detalle_compra_precio_compra").val() * 1;

    var subtotal = detalle_compra_cantidad * detalle_compra_precio_compra;
    subtotal.toFixed(2);
    subtotal = parseFloat(subtotal);

     //suma_total = suma_total + subtotal;
     //console.log(suma_total);

    if(id_recurso !="" && detalle_compra_cantidad!=""&& detalle_compra_precio_compra!="" && recurso_val!="" && subtotal!=""){
        contenido += recurso_val + "-.-." +id_recurso + "-.-." + detalle_compra_cantidad + "-.-." + detalle_compra_precio_compra +"-.-."+subtotal+"/./.";
        $("#contenido").val(contenido);
        $("#detalle_compra_total_pedido").val(subtotal);
        //$("#suma_total").val(suma_total);

        show_table();
        clean();
    }else{
        respuesta('Ingrese todos los campos');
    }
}

function agregar_fc(){

    var recurso_val = $("#id_recurso").val();
    if(recurso_val!=""){
        var id_recurso = $("select[name='id_recurso'] option:selected").text();
    }else{
        var id_recurso = "";
    }

    var detalle_compra_cantidad = $("#detalle_compra_cantidad").val() * 1;
    var detalle_compra_precio_compra = $("#detalle_compra_precio_compra").val() * 1;

    var subtotal = detalle_compra_cantidad * detalle_compra_precio_compra;
    subtotal.toFixed(2);
    subtotal = parseFloat(subtotal);

     //suma_total = suma_total + subtotal;
     //console.log(suma_total);

    if(id_recurso !="" && detalle_compra_cantidad!=""&& detalle_compra_precio_compra!="" && recurso_val!="" && subtotal!=""){
        contenido += recurso_val + "-.-." +id_recurso + "-.-." + detalle_compra_cantidad + "-.-." + detalle_compra_precio_compra +"-.-."+subtotal+"/./.";
        $("#contenido").val(contenido);
        $("#detalle_compra_total_pedido").val(subtotal);
        //$("#suma_total").val(suma_total);

        show_table_();
        clean_();
    }else{
        respuesta('Ingrese todos los campos');
    }
}

function clean() {
    $("#detalle_compra_precio_compra").val("");
    $("#detalle_compra_cantidad").val("");

    $("#id_recurso option[value='']").attr('selected','selected');
    $("#id_recurso").val("");
    $("#id_recurso").select().trigger('change');
}

function clean_() {
    $("#detalle_compra_precio_compra").val("");
    $("#detalle_compra_cantidad").val("");

    $("#id_recurso option[value='']").attr('selected','selected');
    $("#id_recurso").val("");
    $("#id_recurso").select().trigger('change');
}

$("#fupForm").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var orden_compra_titulo = $('#orden_compra_titulo').val();
    var id_sucursal = $('#id_sucursal').val();
    var id_proveedor = $('#id_proveedor').val();
    var contenido = $('#contenido').val();

    valor = validar_campo_vacio('contenido', contenido, valor);
    valor = validar_campo_vacio('orden_compra_titulo', orden_compra_titulo, valor);
    valor = validar_campo_vacio('id_sucursal', id_sucursal, valor);
    valor = validar_campo_vacio('id_proveedor', id_proveedor, valor);
    if (valor){
        $.ajax({
            type:"POST",
            url: urlweb + "api/Ordencompra/guardar_orden",
            dataType: 'json',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.submitBtn').attr("disabled","disabled");
                $('#fupForm').css("opacity",".5");
            },
            success:function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Guardado con Exito!','success');
                        setTimeout(function () {
                            location.href = urlweb +  'Ordencompra/orden_pendiente';
                        }, 1000);
                        break;
                    case 2:
                        respuesta("Fallo el envio, intentelo de nuevo", 'error');
                        break;
                    case 6:
                        respuesta("Algún dato fue ingresado de manera erronéa. Recargue la página por favor.",'error');
                        break;
                    default:
                        respuesta("ERROR DESCONOCIDO", 'error');
                }
                $('#fupForm').css("opacity","");
                $(".submitBtn").removeAttr("disabled");
            }
        });
    }
});

$("#facturas_sin_oc").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var orden_compra_titulo = $('#orden_compra_titulo').val();
    var id_proveedor = $('#id_proveedor').val();
    var contenido = $('#contenido').val();

    //valor = validar_campo_vacio('contenido', contenido, valor);
    valor = validar_campo_vacio('id_proveedor', id_proveedor, valor);
    if (valor){
        $.ajax({
            type:"POST",
            url: urlweb + "api/Ordencompra/guardar_compra_rapida",
            dataType: 'json',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.submitBtn').attr("disabled","disabled");
                $('#facturas_sin_oc').css("opacity",".5");
            },
            success:function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Guardado con Exito!','success');
                        setTimeout(function () {
                            location.reload()
                        }, 1000);
                        break;
                    case 2:
                        respuesta("Fallo el envio, intentelo de nuevo", 'error');
                        break;
                    case 5:
                        respuesta("El numero de factura ya se encuentra registrado", 'error');
                        break;
                    case 6:
                        respuesta("Algún dato fue ingresado de manera erronéa. Recargue la página por favor.",'error');
                        break;
                    default:
                        respuesta("ERROR DESCONOCIDO", 'error');
                }
                $('#facturas_sin_oc').css("opacity","");
                $(".submitBtn").removeAttr("disabled");
            }
        });
    }
});