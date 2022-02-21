<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Reporte/reporte_insumos">
                <input type="hidden" id="enviar_fecha" name="enviar_fecha" value="1">
                <div class="row">
                    <div class="col-lg-3">
                        <label for="turno">Seleccionar fecha a Filtrar Inicio:</label>
                        <input type="date" class="form-control" id="fecha_hoy" name="fecha_hoy" value="<?php echo $fecha_hoy;?>">
                    </div>
                    <div class="col-lg-3">
                        <label for="turno">Seleccionar fecha a Filtrar Fin:</label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?php echo $fecha_fin;?>">
                    </div>
                    <div class="col-lg-3">
                        <button style="margin-top: 34px;" class="btn btn-success" ><i class="fa fa-search"></i> Buscar Registro</button>
                    </div>
                </div>
            </form>
            <br>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>Insumos</th>
                                        <th>Cant. Orden Compra</th>
                                        <th>Cant. Kilos</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($insumos as $i){

                                        $calcular = $this->reporte->cantidad_compra($i->id_recurso_sede);
                                        $sumar = $this->reporte->sumar_kilos($i->id_recurso_sede);
                                        ?>
                                        <tr>
                                            <td><?= $a;?></td>
                                            <td><?= $i->orden_compra_fecha_recibida;?></td>
                                            <td><?= $i->recurso_nombre;?></td>
                                            <td><?= $calcular->total;?></td>
                                            <td><?= $sumar->total;?></td>
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