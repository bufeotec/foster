<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE
 * Date: 24/01/2022
 * Time: 20:05
 */
?>
<div class="modal fade" id="agregarproducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 40% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Paquete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="agregar_nuevo_paquete">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="persona">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Producto</label>
                                        <select class="form-control" id="id_producto" name="id_producto" >
                                            <option value="">Elegir Producto</option>
                                            <?php
                                            foreach($productos as $r){
                                                ?>
                                                <option value="<?php echo $r->id_producto_precio;?>"><?php echo $r->producto_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Tipo</label>
                                        <select class="form-control" onchange="ver_productito()" id="agregado_tipo" name="agregado_tipo" >
                                            <option value="">Elegir</option>
                                            <option value="SUS">SUSCRIPCION</option>
                                            <option value="SER">SERVICIO</option>
                                            <!--<option value="PRO">PRODUCTO</option>-->
                                        </select>
                                    </div>
                                </div>
                                <div class="no-show col-lg-12" id="asociadito">
                                    <div class="form-group">
                                        <label class="col-form-label">Elegir Producto Asociado</label>
                                        <select class="form-control" id="agregado_id_producto" name="agregado_id_producto" >
                                            <option value="">Elegir Producto</option>
                                            <?php
                                            foreach($productos as $r){
                                                ?>
                                                <option value="<?php echo $r->id_producto;?>"><?php echo $r->producto_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="no-show col-lg-12" id="asociadito_s">
                                    <div class="form-group">
                                        <label class="col-form-label">Elegir Servicio Asociado</label>
                                        <select class="form-control" id="agregado_id_servicio" name="agregado_id_servicio" >
                                            <option value="">Elegir Producto</option>
                                            <?php
                                            foreach($servicios as $rs){
                                                ?>
                                                <option value="<?php echo $rs->id_servicio;?>"><?php echo $rs->servicio_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Cantidad</label>
                                        <input class="form-control" type="text" id="agregado_cantidad" name="agregado_cantidad" placeholder="Ingrese Nombre  ...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Unidad</label>
                                        <select class="form-control"  id="agregado_unidad" name="agregado_unidad" >
                                            <option value="">Elegir</option>
                                            <option value="UNIDAD">UNIDAD</option>
                                            <option value="month">MESES</option>
                                            <option value="days">DIAS</option>
                                            <option value="year">AÑOS</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="limpiar()" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-agregar-paquete"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editarpaquete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 40% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Paquete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="editar_nuevo_paquete">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="persona">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Producto</label>
                                        <input type="hidden" id="id_agregado" name="id_agregado">
                                        <select class="form-control" id="id_producto_e" name="id_producto_e" >
                                            <option value="">Elegir Producto</option>
                                            <?php
                                            foreach($productos as $r){
                                                ?>
                                                <option value="<?php echo $r->id_producto_precio;?>"><?php echo $r->producto_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Tipo</label>
                                        <select class="form-control" onchange="ver_productito_e()" id="agregado_tipo_e" name="agregado_tipo_e" >
                                            <option value="">Elegir</option>
                                            <option value="SUS">SUSCRIPCION</option>
                                            <option value="SER">SERVICIO</option>
                                            <!--<option value="PRO">PRODUCTO</option>-->
                                        </select>
                                    </div>
                                </div>
                                <div class="no-show col-lg-12" id="asociadito_e">
                                    <div class="form-group">
                                        <label class="col-form-label">Elegir Producto Asociado</label>
                                        <select class="form-control" id="agregado_id_producto_e" name="agregado_id_producto_e" >
                                            <option value="">Elegir Producto</option>
                                            <?php
                                            foreach($productos as $r){
                                                ?>
                                                <option value="<?php echo $r->id_producto_precio;?>"><?php echo $r->producto_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="no-show col-lg-12" id="asociadito_se">
                                    <div class="form-group">
                                        <label class="col-form-label">Elegir Servicio Asociado</label>
                                        <select class="form-control" id="agregado_id_servicio_e" name="agregado_id_servicio_e" >
                                            <option value="">Elegir Producto</option>
                                            <?php
                                            foreach($servicios as $rs){
                                                ?>
                                                <option value="<?php echo $rs->id_servicio;?>"><?php echo $rs->servicio_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Cantidad</label>
                                        <input class="form-control" type="text" id="agregado_cantidad_e" name="agregado_cantidad_e" placeholder="Ingrese Nombre  ...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Unidad</label>
                                        <select class="form-control"  id="agregado_unidad_e" name="agregado_unidad_e" >
                                            <option value="">Elegir</option>
                                            <option value="UNIDAD">UNIDAD</option>
                                            <option value="month">MESES</option>
                                            <option value="days">DIAS</option>
                                            <option value="year">AÑOS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Estado</label>
                                        <select class="form-control" onchange="cambiar_color_estado('agregado_estado_e')"  id="agregado_estado_e" name="agregado_estado_e" >
                                            <option value="1">HABILITADO</option>
                                            <option value="0">DESHABILITADO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="limpiar()" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-agregar-paquete"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
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
                <button data-toggle="modal" data-target="#agregarproducto" class="btn btn-primary"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Paquete</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h2><b><u>Listado de Paquetes Registrados</u></b></h2></div>
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
                                <th>Tipo de Paquete</th>
                                <th>Producto Asociado</th>
                                <th>Tipo</th>
                                <th>Cantidad</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a = 1;
                            foreach ($paquetes as $m){
                                $estado = "DESHABILITADO";
                                if($m->agregado_estado == 1){
                                    $estado = "HABILITADO";
                                }

                                $producto_agregado = "--";
                                switch ($m->agregado_tipo){
                                    case "SUS":
                                        $tipo = "SUSCRIPCION";
                                        break;
                                    case "SER":
                                        $tipo = "SERVICIO";
                                        $prod_ = $this->servicio->listar_servicios_id($m->agregado_id_servicio);
                                        $producto_agregado = $prod_->servicio_nombre;
                                        break;
                                    case "PRO":
                                        $tipo = "PRODUCTO";
                                        $prod_ = $this->producto->listar_producto_id($m->agregado_id_producto);
                                        $producto_agregado = $prod_->producto_nombre;
                                        break;
                                    default:

                                }

                                switch ($m->agregado_unidad){
                                    case "month":
                                        $cantidad = "MESES";
                                        break;
                                    case "days":
                                        $cantidad = "DIAS";
                                        break;
                                    case "year":
                                        $cantidad = "AÑOS";
                                        break;
                                    default:
                                        $cantidad = "UNIDAD";
                                        break;
                                }
                                ?>
                                <tr>
                                    <td><?= $a;?></td>
                                    <td><?= $m->producto_nombre;?></td>
                                    <td><?= $tipo;?></td>
                                    <td><?= $producto_agregado;?></td>
                                    <td><?= $cantidad;?></td>
                                    <td><?= $m->agregado_cantidad;?></td>
                                    <td><?= $estado;?></td>
                                    <td>
                                        <div id="botoncliente<?= $m->id_agregado;?>">
                                            <button data-toggle="modal" data-target="#editarpaquete" onclick="editar_paquete(<?= $m->id_agregado;?>, '<?= $m->id_producto;?>', '<?= $m->agregado_tipo;?>', '<?= $m->agregado_id_producto;?>', '<?= $m->agregado_id_servicio;?>', '<?= $m->agregado_cantidad;?>', '<?= $m->agregado_unidad;?>', <?= $m->agregado_estado;?>)"  class="btn btn-sm btn-primary btne" ><i class="fa fa-pencil"></i></button>
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
<script src="<?php echo _SERVER_ . _JS_;?>paquete.js"></script>
<script type="text/javascript">
    $(document).ready(function (){
        cambiar_color_estado('agregado_estado_e');
        $("#id_producto_precio").select2({
            dropdownParent: $("#agregarproducto")
        });

        $("#id_producto_precio_e").select2({
            dropdownParent: $("#editarpaquete")
        });

        $("#agregado_id_producto").select2({
            dropdownParent: $("#agregarproducto")
        });

        $("#agregado_id_producto_e").select2({
            dropdownParent: $("#editarpaquete")
        });
    });

</script>

