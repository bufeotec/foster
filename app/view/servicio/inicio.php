<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE
 * Date: 24/01/2022
 * Time: 12:24
 */
?>
<div class="modal fade" id="gestionServicio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Servicio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="gestionarServicio">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12" >
                                <div class="form-group">
                                    <label class="col-form-label">Nombre:</label>
                                    <input class="form-control" type="text" id="servicio_nombre" name="servicio_nombre" maxlength="500" placeholder="Ingrese Nombre...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label">Descripción:</label>
                                    <input class="form-control" type="text" id="servicio_descripcion" name="servicio_descripcion" maxlength="500" placeholder="Ingrese Nombre...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Estado:</label>
                                    <select class="form-control" onchange="cambiar_color_estado('servicio_estado')" id="servicio_estado" name="servicio_estado">
                                        <option value="1">HABILITADO</option>
                                        <option value="0">DESHABILITADO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="limpiar()" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-agregar-servicio"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editarServicio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Servicio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="gestionarServicioEditar">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12" >
                                <div class="form-group">
                                    <label class="col-form-label">Nombre:</label>
                                    <input class="form-control" type="hidden" id="id_servicio" name="id_servicio" maxlength="12" placeholder="Ingrese Nombre...">
                                    <input class="form-control" type="text" id="servicio_nombre_e" name="servicio_nombre_e" maxlength="500" placeholder="Ingrese Nombre...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label">Descripción:</label>
                                    <input class="form-control" type="text" id="servicio_descripcion_e" name="servicio_descripcion_e" maxlength="500" placeholder="Ingrese Nombre...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Estado:</label>
                                    <select class="form-control" id="servicio_estado_e" onchange="cambiar_color_estado('servicio_estado_e')" name="servicio_estado_e">
                                        <option value="1">HABILITADO</option>
                                        <option value="0">DESHABILITADO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-editar-servicio"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
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
            <div class="form-group col-lg-3 col-md-3 col-sm-3" >
                <button type="submit" data-toggle="modal" data-target="#gestionServicio" style="width: 100%" class="btn btn-primary"><i class="fa fa-plus"></i> Agregar Nuevo</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h2><b><u>Listado de Servicios Registrados</u></b></h2></div>
        <div class="col-lg-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped table-earning" id="dataTable2" width="100%" cellspacing="0">
                            <thead class="text-capitalize">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a = 1;
                            foreach ($servicios as $m){
                                $estado = "DESHABILITADO";
                                $estilo_estado = "class=\"texto-deshabilitado\"";
                                if($m->servicio_estado == 1){
                                    $estado = "HABILITADO";
                                    $estilo_estado = "class=\"texto-habilitado\"";
                                }

                                ?>

                                <tr>
                                    <td><?= $a;?></td>
                                    <td><?= $m->servicio_nombre;?></td>
                                    <td><?= $m->servicio_descripcion;?></td>
                                    <td <?=$estilo_estado;?> ><?= $estado;?></td>
                                    <td>
                                        <div id="botoncliente<?= $m->id_servicio;?>">
                                            <button data-toggle="modal" data-target="#editarServicio" onclick="editar_servicio(<?= $m->id_servicio;?>, '<?= $m->servicio_nombre;?>', '<?= $m->servicio_descripcion;?>', <?= $m->servicio_estado;?>)"  class="btn btn-sm btn-primary btne" ><i class="fa fa-pencil"></i></button>
                                        </div>
                                        <div id="">
                                            <a id="btn-eliminar_servicio<?= $m->id_servicio;?>" style="color: white;" class="btn btn-sm btn-warning btne" href="<?= _SERVER_;?>Servicio/historial_servicios/<?= $m->id_servicio;?>" ><i class="fa fa-eye"></i></a>
                                        </div>
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
</section>

<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>servicio.js"></script>
<script type="text/javascript">
    $(document).ready(function (){
        cambiar_color_estado('servicio_estado');
    });
    function limpiar(){
        $('#servicio_nombre').val('');
        $('#servicio_descripcion').val('');
        $('#servicio_estado').val('1');
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
        var tipo_doc = $('#id_tipodocumento').val();

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

