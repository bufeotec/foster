


<div class="modal fade" id="agregar_venta_cliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 50% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Pedidos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Elegir Cliente</label>
                            <select class="form-control" name="id_cliente" id="id_cliente" onchange="valor_id_cliente()">
                                <option value="">Elegir Cliente</option>
                                <?php
                                foreach($clientes as $p){
                                    ?>
                                    <option value="<?php echo $p->id_cliente;?>"><?php echo $p->cliente_nombre ;?> <?php echo $p->cliente_razonsocial ;?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="">Porductos</label>
                            <select class="form-control" name="id_producto" id="id_producto" onchange="jalar_datos_prodcutos()">
                                <option value="">Elegir Producto</option>
                                <?php
                                foreach($productos as $p){
                                    ?>
                                    <option value="<?php echo $p->id_producto;?>"><?php echo $p->producto_nombre ;?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="">Precio</label>
                            <span id="datos_precio"></span>
                        </div>
                        <div class="col-lg-3">
                            <label for="">Cantidad</label>
                            <input class="form-control" type="number" id="cantidad" name="cantidad" value="1" onchange="calcular_total_pvc()">
                        </div>
                        <div class="col-lg-3">
                            <label for="">Total</label>
                            <input type="text" id="total" name="total" class="form-control">
                        </div>
                        <div class="col-lg-3" style="margin-top: 34px">
                            <button type="button" class="btn btn-success" id="btn-preventa" onclick="agregar_pv()"><i class="fa fa-save fa-sm text-white-50"></i> AGREGAR</button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-md-12 col-lg-12 col-xs-12">
                                <form class="" enctype="multipart/form-data" id="guardar_pre_venta">
                                    <input type="hidden" id="contenido" name="contenido">
                                    <input type="hidden" class="form-control" id="id_producto_" name="id_producto_">
                                    <input type="hidden" class="form-control" id="id_cliente_" name="id_cliente_">
                                    <input type="hidden" class="form-control" id="pre_venta_total" name="pre_venta_total">

                                    <table class="table table-bordered" style="background: darksalmon;">
                                        <thead>
                                        <tr style="font-weight: bold;text-align: center">
                                            <td>PRODUCTO</td>
                                            <td>PU</td>
                                            <td>CANT</td>
                                            <td>TOTAL</td>
                                            <td>ACCIÓN</td>
                                        </tr>
                                        </thead>
                                        <tbody id="contenido_detalle_pre_venta">
                                        </tbody>
                                        <!--<tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>-->
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Total</td>
                                            <td><span id="pre_venta_total_">S/ 0.00</span></td>
                                        </tr>
                                    </table>
                                    <div class="row">
                                        <div class="col-lg-10"></div>
                                        <div class="col-lg-2 col-sm-3 col-md-3 col-xs-3" style="margin-top: 12px">
                                            <button type="submit" class="btn btn-primary submitBtn"><i class="fa fa-check"></i> Generar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Content Header (Page header) -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <button class="btn btn-success" data-toggle="modal" data-target="#agregar_venta_cliente"  id="btn-agregar-venta"><i class="fa fa-save"></i> Agregar Venta</button>
                </div>
            </div>
            <br>
            <br>

            <div class="row">
                <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h3>LISTADO DE CLIENTES CON PEDIDO</h3></div>
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Producto</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($datitos as $m){
                                        $jalar_productos_pv = $this->ventas->jalar_producto_pv($m->id_cliente);
                                        ?>
                                        <tr id="pv<?= $m->id_pre_venta;?>">
                                            <td><?= $a;?></td>
                                            <td><?= $m->cliente_nombre;?> <?= $m->cliente_razonsocial;?></td>
                                            <td>
                                                <?php
                                                    foreach ($jalar_productos_pv as $p){
                                                        ?>
                                                        - <?= $p->pre_venta_nombre_producto;?> / Cant. <?= $p->pre_venta_cantidad?>
                                                        <br>
                                                    <?php
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <a id="btn-eliminar_pv<?= $m->id_pre_venta;?>" class="btn btn-danger" onclick="preguntar('¿Esta Seguro que desea Eliminar este registro?','eliminar_pre_venta','SÍ','NO',<?= $m->id_pre_venta?>)" style="color: red" data-toggle='tooltip' title='Eliminar'><i class='fa fa-times text-white'></i></a>
                                                <a class="btn btn-success" target='_blank' href="<?= _SERVER_ . 'Ventas/cobrar_venta_rapida/' . $m->id_cliente ;?>" data-toggle='tooltip' title='Cobrar'><i class="fa fa-money"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                        $a++;
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>venta.js"></script>
<script>
    $(document).ready(function (){
        $("#id_cliente").select2({
            dropdownParent: $("#agregar_venta_cliente")
        });
    });

    var contenido = "";
    var conteo = 1;
    var total_total = 0;

    function jalar_datos_prodcutos(){
        var id_producto = $("#id_producto").val();
        console.log(id_producto);
        $.ajax({
            type: "POST",
            url: urlweb + "api/Ventas/jalar_datos_productos",
            data: "id_producto="+id_producto,
            dataType: 'json',
            success:function (r) {
                $("#datos_precio").html(r);
                calcular_total_pvc();
            }
        });
    }

    function valor_id_cliente(){
        var id = $("#id_cliente").val();
        $("#id_cliente_").val(id);
        console.log(id);
    }

    function agregar_pv(){
        var id_cliente = $("#id_cliente").val();
        var id_producto = $("#id_producto").val();
        if(id_producto!=""){
            var pre_venta_nombre_producto = $("select[name='id_producto'] option:selected").text();
        }else{
            var pre_venta_nombre_producto = "";
        }
        var pre_venta_precio_unitario = $("#producto_precio").val() * 1;
        var pre_venta_cantidad = $("#cantidad").val() * 1;
        var pre_venta_total = $("#total").val();
        var id_producto = $("#id_producto").val();
        var comanda_detalle_precio = $("#comanda_detalle_precio").val() * 1;

        var subtotal = pre_venta_cantidad * pre_venta_precio_unitario;
        subtotal.toFixed(2);
        subtotal = subtotal.toFixed(2);

        if(id_cliente!="" && id_producto !="" && pre_venta_precio_unitario!="" && pre_venta_nombre_producto!="" && pre_venta_cantidad !="" && subtotal!=""){
            contenido += id_cliente + "-.-."+id_producto + "-.-." + pre_venta_nombre_producto + "-.-."+ pre_venta_precio_unitario+"-.-." + pre_venta_cantidad +"-.-."+subtotal+"/./.";
            $("#contenido").val(contenido);
            //$("#comanda_total_pedido").val(subtotal);
            respuesta('Agregado', 'success');
            show_table();
            clean();
        }else{
            respuesta('Ingrese todos los campos');
        }
    }

    function show_table() {
        var llenar="";
        conteo=1;
        var monto_total = 0;
        var total = 0.00;
        var id_producto_ = "";
        var id_cliente_ = "";
        if (contenido.length>0){
            var filas=contenido.split('/./.');
            if(filas.length>0){
                for(var i=0;i<filas.length - 1;i++){
                    var celdas =filas[i].split('-.-.');
                    llenar +="<tr>" +
                        "<td>"+celdas[2]+"</td>"+
                        "<td>"+celdas[3]+"</td>"+
                        "<td>"+celdas[4]+"</td>"+
                        "<td>"+celdas[5]+"</td>"+
                        "<td><a data-toggle=\"tooltip\" onclick='delete_detalle("+i+")' title=\"Eliminar\" type=\"button\" class=\"text-danger\" ><i class=\"fa fa-times ver_detalle\"></i></a></td>"+
                        "</tr>";
                    conteo++;
                    var monto_total = monto_total + celdas[5] * 1;
                    var total = monto_total.toFixed(2);
                }
            }
        }
        $("#contenido_detalle_pre_venta").html(llenar);
        $("#conteo").html(conteo);
        $("#pre_venta_total").val(total);
        $("#pre_venta_total_").html("S/ " + total);
        $("#contenido").val(contenido);
        $("#id_producto_").val(id_producto_);
    }

    function clean() {
        $("#id_producto").val("");
        $("#cantidad").val("1");
        $("#total").val("");
        $("#producto_precio").val("");
    }



    $("#guardar_pre_venta").on('submit', function(e){
        e.preventDefault();
        var valor = true;
        var pre_venta_total = $('#pre_venta_total').val();
        var id_producto = $('#id_producto').val();
        var contenido = $('#contenido').val();
        console.log(id_cliente);
        valor = validar_campo_vacio('contenido', contenido, valor);
        valor = validar_campo_vacio('pre_venta_total', pre_venta_total, valor);
        valor = validar_campo_vacio('id_cliente', id_cliente, valor);
        //valor = validar_campo_vacio('id_producto', id_producto, valor);

        if (valor){
            $.ajax({
                type:"POST",
                url: urlweb + "api/Ventas/guardar_pre_venta",
                dataType: 'json',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('.submitBtn').attr("disabled","disabled");
                    $('#guardar_pre_venta').css("opacity",".5");
                },
                success:function (r) {
                    switch (r.result.code) {
                        case 1:
                            respuesta('¡Guardado con Exito!','success');
                            setTimeout(function () {
                                location.reload()
                            }, 300);
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
                    $('#guardar_pre_venta').css("opacity","");
                    $(".submitBtn").removeAttr("disabled");
                }
            });
        }
    });

    function agregar_pre_venta(){
        var valor = true;
        var boton = 'btn-preventa';
        var id_cliente = $("#id_cliente").val();

        var id_producto = $("#id_producto").val();
        var pre_venta_nombre_producto =$("#id_producto option:selected").text();
        var pre_venta_precio_unitario = $("#producto_precio").val();
        var pre_venta_cantidad = $("#cantidad").val();
        var pre_venta_total = $("#total").val();

        if(valor){
            var cadena = "id_cliente=" + id_cliente +
                "&id_producto=" + id_producto +
                "&pre_venta_nombre_producto=" + pre_venta_nombre_producto +
                "&pre_venta_cantidad=" + pre_venta_cantidad +
                "&pre_venta_precio_unitario=" + pre_venta_precio_unitario +
                "&pre_venta_total=" + pre_venta_total;
            $.ajax({
                type: "POST",
                url: urlweb + "api/Ventas/guardar_pre_venta",
                data: cadena,
                dataType: 'json',
                beforeSend: function () {
                    cambiar_estado_boton(boton, 'cobrando...', true);
                },
                success: function (r) {
                    cambiar_estado_boton(boton, "<i class=\"fa fa-money\"></i> GUARDAR", false);
                    switch (r.result.code) {
                        case 1:
                            respuesta('¡Pre-venta realizada...!', 'success');
                            setTimeout(function () {
                                location.reload()
                            }, 300);
                            break;
                        case 2:
                            respuesta('Error al generar pre venta', 'error');
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

    function calcular_total_pvc(){
        var precio =$("#producto_precio").val();
        var cantidad = $("#cantidad").val();
        var subtotal = precio * cantidad;
        subtotal.toFixed(2)
        $("#total").val(subtotal);
    }


</script>