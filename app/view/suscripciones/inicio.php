<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE
 * Date: 20/01/2022
 * Time: 17:44
 */
?>
<div class="modal fade" id="gestionCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Membresia Gratuita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="mebresiaGratuita">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="cliente">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                            <label class="col-form-label">Horario</label>
                                        <select class="form-control" id="id_horario" name="id_horario" >
                                            <option value="">Seleccione</option>
                                            <?php
                                            foreach ($horarios as $h){
                                                echo "<option value='".$h->id_horario."' >" . date('h:i a', strtotime($h->horario_inicio)) . ' - ' . date('h:i a', strtotime($h->horario_fin)) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Nro Documento:</label>
                                        <input class="form-control" type="text" id="client_number" onchange="consultar_documento(this.value)" onkeyup="return validar_numeros(this.id)" name="client_number" maxlength="15" placeholder="Ingrese Numero...">
                                    </div>
                                </div>
                                <div class="col-lg-12" >
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Completo:</label>
                                        <input class="form-control" type="text" id="cliente_nombre" name="cliente_nombre" maxlength="500" placeholder="Ingrese Nombre...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Fecha de Inicio:</label>
                                        <input class="form-control" type="date" id="membresia_inicio" onkeyup="validar_numeros(this.id)" name="membresia_inicio" value="<?= date('Y-m-d');?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Meses:</label>
                                        <input class="form-control" type="text" id="membresia_cantidad" onkeyup="validar_numeros(this.id)" name="membresia_cantidad" maxlength="15" placeholder="Ingrese Numero...">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="limpiar()" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-agregar-membresia"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editarCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Datos del Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="gestionarInfoClienteEdit">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="cliente">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Tipo de documento</label>
                                        <select class="form-control" id="id_tipodocumento_e" name="id_tipodocumento_e">
                                            <option value="">Seleccione</option>
                                            <?php
                                            foreach ($tipos_documento as $td){
                                                echo "<option value='".$td->id_tipodocumento."'>".$td->tipodocumento_identidad."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Nro Documento:</label>
                                        <input class="form-control" type="text" id="cliente_numero_e" onchange="consultar_documento_e(this.value)" onkeyup="return validar_numeros(this.id)" name="cliente_numero_e" maxlength="15" placeholder="Ingrese Telefono...">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Cliente</label>
                                        <input class="form-control" type="hidden" id="id_cliente" name="id_cliente" maxlength="20">
                                        <input class="form-control" type="text" id="cliente_nombre_e" name="cliente_nombre_e" maxlength="500" placeholder="Ingrese Nombre...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Razón Social  o Contacto de Emergencia:</label>
                                        <textarea rows="2" class="form-control" type="text" id="cliente_razonsocial_e" name="cliente_razonsocial_e" maxlength="500" placeholder="Ingrese Razón Social..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Dirección</label>
                                        <textarea rows="2" class="form-control" type="text" id="cliente_direccion_e" name="cliente_direccion_e" maxlength="500" placeholder="Ingrese Dirección..."></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">2° Dirección</label>
                                        <textarea rows="2" class="form-control" type="text" id="cliente_direccion_2_e" name="cliente_direccion_2_e" maxlength="500" placeholder="Ingrese Dirección..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label class="col-form-label">Teléfono</label>
                                        <input class="form-control" type="text" id="cliente_telefono_e" onkeyup="return validar_numeros(this.id)" name="cliente_telefono_e" maxlength="30" placeholder="Ingrese Telefono...">
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="form-group">
                                        <label class="col-form-label">Correo:</label>
                                        <textarea rows="2" class="form-control" type="email" id="cliente_correo_e" name="cliente_correo_e" maxlength="500" placeholder="Ingrese Correo..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-editar-cliente"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<section class="container-fluid">
    <div class="container-fluid">
        <!-- Page Heading -->
        <br>
        <br>
        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <!--<h2 class="col-md-4 text-gray-1000"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h2>-->
                </div>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4" >
                <button type="submit" data-toggle="modal" data-target="#gestionCliente" style="width: 100%" class="btn btn-primary"><i class="fa fa-plus"></i> Agregar Membresia Gratuita</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h2><b><u>Listado de Membresias Activas</u></b></h2></div>
    </div>
    <form method="post" action="<?= _SERVER_ . 'Suscripcion/inicio';?>">
        <div class="row">
            <div class="form-group col-md-3">
                <label for="fecha_inicio">Fecha Inicio</label>
                <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" style="height: 44px; font-size: 12px;" value="<?= $fecha_inicio;?>">
            </div>
            <div class="form-group col-md-3">
                <label for="fecha_fin">Fecha Inicio</label>
                <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" style="height: 44px; font-size: 12px;" value="<?= $fecha_fin;?>">
            </div>
            <div class="form-group col-md-3">
                <label for="id_horario">Horario</label>
                <select class="form-control" id="id_horario" name="id_horario" >
                    <option value="TODOS">TODOS</option>
                    <?php
                    foreach ($horarios as $h){
                        $selectito = "";
                        if($horario == $h->id_horario){
                            $selectito = 'selected';
                        }
                        echo "<option value='".$h->id_horario."' ".$selectito." >" . date('h:i a', strtotime($h->horario_inicio)) . ' - ' . date('h:i a', strtotime($h->horario_fin)) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-3" >
                <button type="submit" style="margin-top: 39px; width: 100%" class="btn btn-success" >Buscar Ahora</button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-lg-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped table-earning" id="dataTable2" width="100%" cellspacing="0">
                            <thead class="text-capitalize">
                            <tr>
                                <th>ID</th>
                                <th>Fin Suscripción</th>
                                <th>Nombre</th>
                                <th>Horario</th>
                                <th>DNI</th>
                                <th>Correo</th>
                                <th>Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a = 1;
                            $repeticua = [];
                            foreach ($clientes as $m){
                                $mostrar = true;
                                if(array_search($m->id_cliente, $repeticua) !== false){
                                    $mostrar = false;
                                } else {
                                    $repeticua[] = $m->id_cliente;
                                }
                                if($mostrar){
                                    if($m->id_tipodocumento != "4"){
                                        $nombre = $m->cliente_nombre;
                                    }else{
                                        $nombre = $m->cliente_razonsocial;
                                    }

                                    ?>

                                    <tr>
                                        <td><?= $a;?></td>
                                        <td><?= date('d-m-Y', strtotime($m->suscripcion_fin_actual));?></td>
                                        <td id="clientenombre<?= $m->id_suscripcion;?>"><?= $nombre;?></td>
                                        <td id="clientenombre<?= $m->id_suscripcion;?>"><?= date('h:i a', strtotime($m->horario_inicio)) . ' - ' . date('h:i a', strtotime($m->horario_fin));?></td>
                                        <td id="clientenumero<?= $m->id_suscripcion;?>"><?= $m->cliente_numero;?></td>
                                        <td id="clientecorreo<?= $m->id_suscripcion;?>"><?= $m->cliente_correo;?></td>
                                        <td>
                                            <div id="botoncliente<?= $m->id_suscripcion;?>">
                                                <button data-toggle="modal" data-target="#editarCliente" onclick="editar_cliente(<?= $m->id_cliente;?>, '<?= $m->cliente_razonsocial;?>', '<?= $m->cliente_nombre;?>', '<?= $m->cliente_apellido_paterno ?? "";?>', '<?= $m->cliente_apellido_materno ?? "";?>', '<?= $m->cliente_numero;?>', '<?= $m->cliente_correo;?>','<?= $m->cliente_direccion;?>','<?= $m->cliente_direccion_2;?>','<?= $m->cliente_telefono;?>','<?= $m->cliente_fecha;?>','<?= $m->cliente_estado;?>',<?= $m->id_tipodocumento;?>)"  class="btn btn-sm btn-primary btne" ><i class="fa fa-edit"></i></button>
                                                <a class="btn btn-sm btn-success btne" target="_blank" href="<?= _SERVER_;?>suscripcion/detalle/<?= $m->id_cliente;?>"><i class="fa fa-eye"></i></a>
                                            </div>
                                            <?php
                                            if(date('Y-m-d') == date('Y-m-d', strtotime($m->suscripcion_registro))){
                                                ?>
                                                <div id="">
                                                    <button id="btn_eliminar_suscripcion<?= $m->id_suscripcion;?>" class="btn btn-sm btn-danger btne" onclick="preguntar('¿Está seguro que desea eliminar este registro?','eliminar_suscripcion','Si','No',<?= $m->id_suscripcion;?>)"><i class="fa fa-trash"></i></button>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $a++;
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>suscripcion.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>cliente.js"></script>
<script type="text/javascript">
    $(document).ready(function (){
        $('#div_razon_social').hide();
        $('#div_nombre').hide();
        $("#div_direcciones").hide();
        $("#div_telefono_correo").hide();
    });
    function limpiar(){
        $('#id_tipodocumento').val('');
        $('#cliente_numero').val('');
        $('#cliente_nombre').val('');
        $('#cliente_razonsocial').val('');
        $('#cliente_direccion').val('');
        $('#cliente_direccion_2').val('');
        $('#cliente_telefono').val('');
        $('#cliente_correo').val('');
    }
    function tipo_documento(){
        var tipo_doc = $('#id_tipodocumento').val();
        if(tipo_doc != ""){
            if(tipo_doc != "4"){
                $('#div_razon_social').hide();
                $('#div_nombre').show();
                $('#cliente_razonsocial').val('');

            }else{
                $('#div_razon_social').show();
                $('#div_nombre').hide();
                $('#cliente_nombre').val('');
            }
            $("#div_direcciones").show();
            $("#div_telefono_correo").show();
        }else{
            $('#div_razon_social').hide();
            $('#div_nombre').hide();
            $("#div_direcciones").hide();
            $("#div_telefono_correo").hide();
        }
    }

    function consultar_documento(valor){
        var tipo_doc = 2;

        if(tipo_doc == "2"){
            if(valor.length==8){
                ObtenerDatosDni(valor);
            }else{
                alert('El numero debe tener 8 digitos');
            }
        }else if(tipo_doc == "4"){
            if (valor.length==11){
                ObtenerDatosRuc(valor);
            }else{
                alert('El numero debe tener 11 digitos');
            }

        }
    }
    function consultar_documento_e(valor){
        var tipo_doc = $('#id_tipodocumento_e').val();
        if(tipo_doc == "2"){
            if(valor.length==8){
                ObtenerDatosDni_e(valor);
            }else{
                alert('El numero debe tener 8 digitos');
            }
        }else if(tipo_doc == "4"){
            if (valor.length==11){
                ObtenerDatosRuc_e(valor);
            }else{
                alert('El numero debe tener 11 digitos');
            }
        }
    }

    function ObtenerDatosDni(valor){
        var numero_dni =  valor;
        var cliente_nombre = 'cliente_nombre';

        $.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/obtener_datos_x_dni",
            data: "numero_dni="+numero_dni,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(cliente_nombre, 'buscando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(cliente_nombre, "", false);
                $("#cliente_nombre").val(r.result.name+ ' ' + r.result.first_name+ ' ' + r.result.last_name);
            }
        });
    }
    function ObtenerDatosRuc(valor){
        var numero_ruc =  valor;
        var cliente_razonsocial = 'cliente_razonsocial';

        $.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/obtener_datos_x_ruc",
            data: "numero_ruc="+numero_ruc,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(cliente_razonsocial, 'buscando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(cliente_razonsocial, "", false);
                $("#cliente_razonsocial").val(r.result.razon_social);
            }
        });
    }
    function ObtenerDatosDni_e(valor){
        var numero_dni =  valor;

        $.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/obtener_datos_x_dni",
            data: "numero_dni="+numero_dni,
            dataType: 'json',
            success:function (r) {
                $("#cliente_nombre_e").val(r.result.name+ ' ' + r.result.first_name+ ' ' + r.result.last_name);
            }
        });
    }
    function ObtenerDatosRuc_e(valor){
        var numero_ruc =  valor;

        $.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/obtener_datos_x_ruc",
            data: "numero_ruc="+numero_ruc,
            dataType: 'json',
            success:function (r) {
                $("#cliente_razonsocial_e").val(r.result.razon_social);
            }
        });
    }
</script>

