<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Reporte/tiempo_promedio_atencion">
                <input type="hidden" id="enviar_fecha" name="enviar_fecha" value="1">
                <div class="row">
                    <div class="col-lg-3">
                        <label for="turno">Seleccionar fecha a Filtrar Inicio:</label>
                        <input type="date" class="form-control" id="fecha_filtro" name="fecha_filtro" value="<?php echo $fecha_filtro;?>">
                    </div>
                    <div class="col-lg-3">
                        <label for="turno">Seleccionar fecha a Filtrar Fin:</label>
                        <input type="date" class="form-control" id="fecha_filtro_fin" name="fecha_filtro_fin" value="<?php echo $fecha_filtro_fin;?>">
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
                                <table class="table table-borderless table-striped table-earning" id="dataTable2" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>#</th>
                                        <th>Grupos</th>
                                        <th>Cantidad de Atenciones</th>
                                        <th>Promedio Atención</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($grupos as $tp){
                                        $comandas = $this->reporte->datos_comandas($fecha_filtro,$fecha_filtro_fin);
                                        $suma_tiempo = 0;
                                        $suma_cantidad = 0;
                                        $dividir_cantidad = 0;
                                        $promedio_comandas = 0;
                                        foreach ($comandas as $c){
                                            $detalle_comandas = $this->reporte->datos_comanda_detalles($c->id_comanda, $tp->id_grupo);
                                            foreach ($detalle_comandas as $dc){
                                                $tiempo_inicio = date('H:i:s',strtotime($dc->comanda_detalle_fecha_registro));
                                                $tiempo_final = $dc->comanda_detalle_hora_entrega;

                                                $intervalo = $this->reporte->restar_horas($tiempo_inicio,$tiempo_final);

                                                $nuevo_intervalo = date('H:i:s',strtotime($intervalo));
                                                //$sumar = $this->reporte->sumar_horas($intervalo);
                                                $suma_tiempo = $suma_tiempo + $intervalo;
                                                $suma_cantidad++;
                                            }
                                        }
                                        $dividir_cantidad = $suma_tiempo / $suma_cantidad;

                                        $dividir_cantidad_convertida  = date('H:i:s',strtotime($dividir_cantidad));
                                        ?>
                                        <tr>
                                            <td><?= $a;?></td>
                                            <td><?= $tp->grupo_nombre?></td>
                                            <td><?= $suma_cantidad?></td>
                                            <td><?= $dividir_cantidad_convertida?></td>
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