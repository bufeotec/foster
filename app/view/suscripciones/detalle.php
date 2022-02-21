<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE
 * Date: 7/02/2022
 * Time: 15:21
 */
?>
<div class="modal fade" id="agregar_ficha" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Ficha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="ficha_nueva">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="fichita">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Peso</label>
                                        <input class="form-control" type="hidden" id="id_cliente" name="id_cliente" maxlength="20" value="<?= $_GET['id']?>">
                                        <input class="form-control" type="text" id="ficha_peso" required name="ficha_peso" value="<?= $fichas[0]->ficha_peso ?? 0;?>" onkeyup="return validar_numeros_decimales_dos(this.id)" maxlength="11" placeholder="Ingresar...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Cintura</label>
                                        <input class="form-control" type="text" id="ficha_cintura" required name="ficha_cintura" value="<?= $fichas[0]->ficha_cintura ?? 0;?>" onkeyup="return validar_numeros_decimales_dos(this.id)" maxlength="11" placeholder="Ingresar...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Cadera</label>
                                        <input class="form-control" type="text" id="ficha_cadera" required name="ficha_cadera" value="<?= $fichas[0]->ficha_cadera ?? 0;?>" onkeyup="return validar_numeros_decimales_dos(this.id)" maxlength="11" placeholder="Ingresar...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Pecho</label>
                                        <input class="form-control" type="text" id="ficha_pecho" required name="ficha_pecho" value="<?= $fichas[0]->ficha_pecho ?? 0;?>" onkeyup="return validar_numeros_decimales_dos(this.id)" maxlength="11" placeholder="Ingresar...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Brazo</label>
                                        <input class="form-control" type="text" id="ficha_brazo" required name="ficha_brazo" value="<?= $fichas[0]->ficha_brazo ?? 0;?>" onkeyup="return validar_numeros_decimales_dos(this.id)" maxlength="11" placeholder="Ingresar...">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Estatura</label>
                                        <input class="form-control" type="text" id="ficha_estatura" required name="ficha_estatura" value="<?= $fichas[0]->ficha_estatura ?? 0;?>" onkeyup="return validar_numeros_decimales_dos(this.id)" maxlength="11" placeholder="Ingresar...">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Grupo Sanguineo</label>
                                        <input class="form-control" type="text" id="ficha_grupo_sanguineo" required name="ficha_grupo_sanguineo" value="<?= $fichas[0]->ficha_grupo_sanguineo ?? "";?>"  maxlength="3" placeholder="Ingresar...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="col-form-label">Patologia de Columna</label>
                                        <select class="form-control" id="ficha_columna" required name="ficha_columna" >
                                            <?php
                                            $ficha_columna = "NO";
                                            if (isset($fichas[0]->ficha_columna)){
                                                $ficha_columna = $fichas[0]->ficha_columna;
                                            }
                                            ?>
                                            <option value="NO" <?php if($ficha_columna == "NO") { echo "selected";} ?> >NO</option>
                                            <option value="SI" <?php if($ficha_columna == "SI") { echo "selected";} ?> >SI</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <label class="col-form-label">Especifique</label>
                                        <input class="form-control" type="text" id="ficha_columna_comentario" name="ficha_columna_comentario" value="<?= $fichas[0]->ficha_columna_comentario ?? "";?>"  maxlength="2000" placeholder="Ingresar...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="col-form-label">Problemas Cardiacos</label>
                                        <select class="form-control" id="ficha_cardiacos" required name="ficha_cardiacos" >
                                            <?php
                                            $ficha_cardiacos = "NO";
                                            if (isset($fichas[0]->ficha_cardiacos)){
                                                $ficha_cardiacos = $fichas[0]->ficha_cardiacos;
                                            }
                                            ?>
                                            <option value="NO" <?php if($ficha_cardiacos == "NO") { echo "selected";} ?> >NO</option>
                                            <option value="SI" <?php if($ficha_cardiacos == "SI") { echo "selected";} ?> >SI</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <label class="col-form-label">Especifique</label>
                                        <input class="form-control" type="text" id="ficha_cardiacos_comentarios" name="ficha_cardiacos_comentarios" value="<?= $fichas[0]->ficha_cardiacos_comentarios ?? "";?>"  maxlength="2000" placeholder="Ingresar...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="col-form-label">Lesiones Resientes</label>
                                        <select class="form-control" id="ficha_lesiones" required name="ficha_lesiones" >
                                            <?php
                                            $ficha_lesiones = "NO";
                                            if (isset($fichas[0]->ficha_lesiones)){
                                                $ficha_lesiones = $fichas[0]->ficha_lesiones;
                                            }
                                            ?>
                                            <option value="NO" <?php if($ficha_lesiones == "NO") { echo "selected";} ?> >NO</option>
                                            <option value="SI" <?php if($ficha_lesiones == "SI") { echo "selected";} ?> >SI</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <label class="col-form-label">Especifique</label>
                                        <input class="form-control" type="text" id="ficha_lesiones_comentarios" name="ficha_lesiones_comentarios" value="<?= $fichas[0]->ficha_lesiones_comentarios ?? "";?>"  maxlength="2000" placeholder="Ingresar...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="col-form-label">Toma Medicamentos</label>
                                        <select class="form-control" id="ficha_medicamentos" required name="ficha_medicamentos" >
                                            <?php
                                            $ficha_medicamentos = "NO";
                                            if (isset($fichas[0]->ficha_medicamentos)){
                                                $ficha_medicamentos = $fichas[0]->ficha_medicamentos;
                                            }
                                            ?>
                                            <option value="NO" <?php if($ficha_medicamentos == "NO") { echo "selected";} ?> >NO</option>
                                            <option value="SI" <?php if($ficha_medicamentos == "SI") { echo "selected";} ?> >SI</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <label class="col-form-label">Especifique</label>
                                        <input class="form-control" type="text" id="ficha_medicamentos_comentarios" name="ficha_medicamentos_comentarios" value="<?= $fichas[0]->ficha_medicamentos_comentarios ?? "";?>"  maxlength="2000" placeholder="Ingresar...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="col-form-label">Mareos, dolor de cabeza</label>
                                        <select class="form-control" id="ficha_mareos" required name="ficha_mareos" >
                                            <?php
                                            $ficha_mareos = "NO";
                                            if (isset($fichas[0]->ficha_mareos)){
                                                $ficha_mareos = $fichas[0]->ficha_mareos;
                                            }
                                            ?>
                                            <option value="NO" <?php if($ficha_mareos == "NO") { echo "selected";} ?> >NO</option>
                                            <option value="SI" <?php if($ficha_mareos == "SI") { echo "selected";} ?> >SI</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <label class="col-form-label">Especifique</label>
                                        <input class="form-control" type="text" id="ficha_mareos_comentarios" name="ficha_mareos_comentarios" value="<?= $fichas[0]->ficha_mareos_comentarios ?? "";?>"  maxlength="2000" placeholder="Ingresar...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">¿Sufre alguna enfermedad?</label>
                                        <input class="form-control" type="text" id="ficha_enfermedades" name="ficha_enfermedades" value="<?= $fichas[0]->ficha_enfermedades ?? "";?>"  maxlength="2000" placeholder="Ingresar...">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-ficha-nueva"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>





<div class="modal fade" id="usar_servicio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Membresia Gratuita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="gastar_servicio">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="cliente_servicio">
                            <div class="row">
                                <div class="col-lg-12" >
                                    <div class="form-group">
                                        <label class="col-form-label">Cantidad a Usar:</label>
                                        <input class="form-control" type="hidden" id="id_servicio_cliente" onkeyup="validar_numeros(this.id)" name="id_servicio_cliente" maxlength="11" value="1" placeholder="Ingrese Cantidad...">
                                        <input class="form-control" type="hidden" id="cantidad_maxima_usada" onkeyup="validar_numeros(this.id)" name="cantidad_maxima_usada" maxlength="11" value="1" placeholder="Ingrese Cantidad...">
                                        <input class="form-control" type="text" id="servicio_historial_cantidad" onkeyup="validar_numeros(this.id)" name="servicio_historial_cantidad" maxlength="11" value="1" placeholder="Ingrese Cantidad...">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Comentarios:</label>
                                        <input class="form-control" type="text" id="servicio_historial_comentarios" name="servicio_historial_comentarios" maxlength="500" placeholder="Ingrese Comentarios...">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="limpiar()" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-agregar-uso-servicio"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
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
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h2><b><u>Información del Cliente: <?= $cliente->cliente_nombre;?></u></b></h2></div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Historial de Suscripciones</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped table-earning" id="dataTable4" width="100%" cellspacing="0">
                            <thead class="text-capitalize">
                            <tr>
                                <th>ID</th>
                                <th>Inicio</th>
                                <th>Fin</th>
                                <th>Horario</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a = 1;
                            $repeticua = [];
                            foreach ($suscripciones as $m){
                                ?>
                                <tr>
                                    <td><?= $a;?></td>
                                    <td><?= date('d-m-Y', strtotime($m->suscripcion_inicio));?></td>
                                    <td><?= date('d-m-Y', strtotime($m->suscripcion_fin_actual));?></td>
                                    <td id="clientenombre<?= $m->id_suscripcion;?>"><?= date('h:i a', strtotime($m->horario_inicio)) . ' - ' . date('h:i a', strtotime($m->horario_fin));?></td>
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
        <div class="col-lg-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-lg-6"><h6 class="m-0 font-weight-bold text-primary">Historial de Fichas</h6></div>
                        <div class="col-lg-6" style="text-align: right;">
                            <a data-toggle="modal" data-target="#agregar_ficha"  class="btn btn-sm btn-primary btne" style="color: white;" ><i class="fa fa-file"></i> Nueva Ficha</a>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped table-earning" id="dataTable6" width="100%" cellspacing="0">
                            <thead class="text-capitalize">
                            <tr>
                                <th>ID</th>
                                <th>Peso</th>
                                <th>Cintura</th>
                                <th>Cadera</th>
                                <th>Pecho</th>
                                <th>Brazo</th>
                                <th>Estatura</th>
                                <th>Grupo Sanguineo</th>
                                <th>Patologia de Columna</th>
                                <th>Problemas Cardiacos</th>
                                <th>Lesiones Resientes</th>
                                <th>¿Toma Algún Medicamento?</th>
                                <th>¿Sufre de Mareos?</th>
                                <th>¿Sufre Alguna Enfermedad?</th>
                                <th>Fecha de Creación</th>
                                <th>Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a = 1;
                            foreach ($fichas as $m){
                                ?>
                                <tr>
                                    <td><?= $a;?></td>
                                    <td><?= $m->ficha_peso;?></td>
                                    <td><?= $m->ficha_cintura;?></td>
                                    <td><?= $m->ficha_cadera;?></td>
                                    <td><?= $m->ficha_pecho;?></td>
                                    <td><?= $m->ficha_brazo;?></td>
                                    <td><?= $m->ficha_estatura;?></td>
                                    <td><?= $m->ficha_grupo_sanguineo;?></td>
                                    <td><?= $m->ficha_columna;?><br><?= $m->ficha_columna_comentario;?></td>
                                    <td><?= $m->ficha_cardiacos;?><br><?= $m->ficha_cardiacos_comentarios;?></td>
                                    <td><?= $m->ficha_lesiones;?><br><?= $m->ficha_lesiones_comentarios;?></td>
                                    <td><?= $m->ficha_medicamentos;?><br><?= $m->ficha_medicamentos_comentarios;?></td>
                                    <td><?= $m->ficha_mareos;?><br><?= $m->ficha_mareos_comentarios;?></td>
                                    <td><?= $m->ficha_enfermedades;?></td>
                                    <td><?= $m->ficha_creacion;?></td>
                                    <td>
                                        <?php
                                        if(date('Y-m-d') == date('Y-m-d', strtotime($m->ficha_creacion))){
                                            ?>
                                            <button id="btn-fichita<?= $m->id_ficha;?>" class="btn btn-sm btn-danger btne" onclick="preguntar('¿Está seguro que desea eliminar este registro?','eliminar_ficha','Si','No',<?= $m->id_ficha;?>)"><i class="fa fa-trash"></i></button>
                                            <?php
                                        } else {
                                            ?>--<?php
                                        }
                                        ?>
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
        <div class="col-lg-6">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Beneficios</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped table-earning" id="dataTable2" width="100%" cellspacing="0">
                            <thead class="text-capitalize">
                            <tr>
                                <th>ID</th>
                                <th>Nombre de Beneficio</th>
                                <th>Cantidad Disponible</th>
                                <th>Accion</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a = 1;
                            foreach ($servicios_cliente as $m){
                                $contar_usos = $this->suscripcion->contar_usos_servicio_cliente($m->id_servicio_cliente);
                                $disponible = intval($m->servicio_cliente_cantidad - $contar_usos->total);
                                if($disponible > 0){
                                    ?>
                                    <tr>
                                        <td><?= $a;?></td>
                                        <td><?= $m->servicio_nombre;?></td>
                                        <td><?= $disponible;?></td>
                                        <td>
                                            <button data-toggle="modal" data-target="#usar_servicio" onclick="usar_servicio_cliente(<?= $m->id_servicio_cliente;?>,<?= $disponible;?>)"  class="btn btn-sm btn-primary btne" ><i class="fa fa-check"></i></button>
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
        <div class="col-lg-6">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Historial de Uso de Beneficios</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped table-earning" id="dataTable1" width="100%" cellspacing="0">
                            <thead class="text-capitalize">
                            <tr>
                                <th>ID</th>
                                <th>Nombre de Beneficio</th>
                                <th>Cantidad Usada</th>
                                <th>Fecha</th>
                                <th>Comentarios</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a = 1;
                            foreach ($historial_servicios_cliente as $m){
                                ?>
                                <tr>
                                    <td><?= $a;?></td>
                                    <td><?= $m->servicio_nombre;?></td>
                                    <td><?= $m->servicio_historial_cantidad;?></td>
                                    <td><?= $m->servicio_historial_fecha;?></td>
                                    <td><?= $m->servicio_historial_comentarios;?></td>
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
        <div class="col-lg-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Historial de Pagos</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">
                            <thead class="text-capitalize">
                            <tr>
                                <th>#</th>
                                <th>Fecha de Emision</th>
                                <th>Comprobante</th>
                                <th>Serie y Correlativo</th>
                                <th>Cliente</th>
                                <th>Forma de Pago</th>
                                <th>Total</th>
                                <th>PDF</th>
                                <th>Estado Sunat</th>
                                <th>Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a = 1;
                            $total = 0;
                            $total_soles = 0;
                            foreach ($ventas as $al){
                                $stylee="style= 'text-align: center;'";
                                if ($al->anulado_sunat == 1){
                                    $stylee="style= 'text-align: center; text-decoration: line-through'";
                                }

                                if($al->venta_tipo == "03"){
                                    $tipo_comprobante = "BOLETA";
                                    if($al->anulado_sunat == 0){
                                        $total_soles = round($total_soles + $al->venta_total, 2);
                                    }
                                }elseif ($al->venta_tipo == "01"){
                                    $tipo_comprobante = "FACTURA";
                                    if($al->anulado_sunat == 0){
                                        $total_soles = round($total_soles + $al->venta_total, 2);
                                    }
                                }elseif($al->venta_tipo == "07"){
                                    $tipo_comprobante = "NOTA DE CRÉDITO";
                                    /*if(($al->anulado_sunat == 0 AND $al->venta_codigo_motivo_nota != "01")){
                                        $total_soles = round($total_soles - $al->venta_total, 2);
                                    }*/
                                }elseif($al->venta_tipo == "08"){
                                    $tipo_comprobante = "NOTA DE DÉBITO";
                                    if($al->anulado_sunat == 0){
                                        $total_soles = round($total_soles + $al->venta_total, 2);
                                    }
                                }else{
                                    $tipo_comprobante = "--";
                                }
                                $estilo_mensaje = "style= 'color: red; font-size: 14px;'";
                                if($al->venta_respuesta_sunat == NULL){
                                    $mensaje = "Sin Enviar a Sunat";

                                }else{
                                    $mensaje = $al->venta_respuesta_sunat;
                                }
                                if($al->id_tipodocumento == 4){
                                    $cliente = $al->cliente_razonsocial;
                                }else{
                                    $cliente = $al->cliente_nombre;
                                }
                                ?>
                                <tr <?= $stylee?>>
                                    <td><?= $a;?></td>
                                    <td><?= date('d-m-Y H:i:s', strtotime($al->venta_fecha));?></td>
                                    <td><?= $tipo_comprobante;?></td>
                                    <td><?= $al->venta_serie. '-' .$al->venta_correlativo;?></td>
                                    <td>
                                        <?= $al->cliente_numero;?><br>
                                        <?= $cliente;?>
                                    </td>
                                    <td style="font-size: 10pt;">
                                        <?php
                                        $detalle_pago = $this->ventas->listar_detalle_pago_x_id_venta($al->id_venta);
                                        foreach ($detalle_pago as $da){
                                            echo "- $da->tipo_pago_nombre S/. $da->venta_detalle_pago_monto <br>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?= $al->simbolo.' '.$al->venta_total;?>
                                    </td>
                                    <td><center><a type="button" target='_blank' href="<?= _SERVER_ . 'Ventas/imprimir_ticket_pdf/' . $al->id_venta ;?>" style="color: red" ><i class="fa fa-file-pdf-o"></i></a></center></td>

                                    <td <?= $estilo_mensaje;?>><?= $mensaje;?></td>
                                    <td style="text-align: left">
                                        <a type="button" title="Ver detalle" class="btn btn-sm btn-primary" target="_blank" style="color: white" href="<?php echo _SERVER_. 'Ventas/ver_detalle_venta/' . $al->id_venta;?>" ><i class="fa fa-eye ver_detalle"></i></a>
                                    </td>
                                </tr>
                                <?php
                                $a++;
                                $total = $total + $al->venta_total;
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