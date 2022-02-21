<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE
 * Date: 1/02/2022
 * Time: 18:23
 */
?>
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
                <!--<button type="submit" data-toggle="modal" data-target="#gestionCliente" style="width: 100%" class="btn btn-primary"><i class="fa fa-plus"></i> Agregar Membresia Gratuita</button>-->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h2><b><u>Listado de Membresias A Vencer</u></b></h2></div>
    </div>
    <form method="post" action="<?= _SERVER_ . 'Suscripcion/por_vencer';?>">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="fecha">Fecha Inicio</label>
                <input type="date" class="form-control" name="fecha" id="fecha" style="height: 44px; font-size: 12px;" value="<?= $fecha;?>">
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
                                <th>Dias Faltantes</th>
                                <th>Horario</th>
                                <th>Nombre</th>
                                <th>DNI</th>
                                <th>Correo</th>
                                <th>Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a = 1;
                            foreach ($clientes as $m){
                                $publicar = true;

                                $verificar_actualizacion_suscripcion = $this->suscripcion->listar_suscripciones_con_continuacion($m->suscripcion_fin, $m->id_cliente);
                                if(isset($verificar_actualizacion_suscripcion->id_suscripcion)){
                                    $publicar = false;
                                }
                                if($publicar){
                                    if($m->id_tipodocumento != "4"){
                                        $nombre = $m->cliente_nombre;
                                    }else{
                                        $nombre = $m->cliente_razonsocial;
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $a;?></td>
                                        <td><?= date('d-m-Y', strtotime($m->suscripcion_fin_actual));?></td>
                                        <td id="clientenombre<?= $m->id_suscripcion;?>"><?= $this->log->calcular_dias_faltantes($fecha, $m->suscripcion_fin_actual);?></td>
                                        <td id="clientenombre<?= $m->id_suscripcion;?>"><?= $nombre;?></td>
                                        <td id="clientenombre<?= $m->id_suscripcion;?>"><?= date('h:i a', strtotime($m->horario_inicio)) . ' - ' . date('h:i a', strtotime($m->horario_fin));?></td>
                                        <td id="clientenumero<?= $m->id_suscripcion;?>"><?= $m->cliente_numero;?></td>
                                        <td id="clientecorreo<?= $m->id_suscripcion;?>"><?= $m->cliente_correo;?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary btne" onclick="preguntar('¿Desea notificar este vencimiento?','notificar_suscripcion','¡Por Supuesto!','Mejor en Otro Momento',<?= $m->id_suscripcion;?>)" ><i class="fa fa-send"></i></button>
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
</script>
