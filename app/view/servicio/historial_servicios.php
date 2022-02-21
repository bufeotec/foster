<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE
 * Date: 24/01/2022
 * Time: 17:03
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
        </div>
    </div>

    <form method="post" action="<?= _SERVER_ . 'Servicio/historial_servicios/' . $_GET['id'];?>">
        <div class="row">
            <div class="form-group col-md-4">
                <label for="fecha_inicio">Fecha Inicio</label>
                <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" style="height: 44px; font-size: 12px;" value="<?= $fecha_inicio;?>">
            </div>
            <div class="form-group col-md-4">
                <label for="fecha_fin">Fecha Inicio</label>
                <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" style="height: 44px; font-size: 12px;" value="<?= $fecha_fin;?>">
            </div>
            <div class="form-group col-md-4" >
                <button type="submit" style="margin-top: 39px; width: 100%" class="btn btn-success" >Buscar Ahora</button>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h2><b><u>Listado de Servicios Usados</u></b></h2></div>
        <div class="col-lg-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped table-earning" id="dataTable2" width="100%" cellspacing="0">
                            <thead class="text-capitalize">
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Cantidad</th>
                                <th>Comentarios</th>
                                <th>Fecha</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a = 1;
                            $usados = 0;
                            foreach ($servicios as $m){
                                $usados = $usados + $m->servicio_historial_cantidad;
                                ?>
                                <tr>
                                    <td><?= $a;?></td>
                                    <td><?= $m->cliente_nombre;?></td>
                                    <td><?= $m->servicio_historial_cantidad;?></td>
                                    <td><?= $m->servicio_historial_comentarios;?></td>
                                    <td><?= $m->servicio_historial_fecha;?></td>
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
        <div class="col-lg-12" style="text-align: left; padding-bottom:5px; "><h3>Total Usados: <?=$usados;?></h3></div>
    </div>
</section>

<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>servicio.js"></script>
<script type="text/javascript">
    $(document).ready(function (){
        cambiar_color_estado('servicio_estado');
    });
</script>


