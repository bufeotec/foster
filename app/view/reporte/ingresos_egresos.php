

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Reporte/ingresos_egresos">
                <input type="hidden" id="enviar_fecha" name="enviar_fecha" value="1">
                <div class="row">
                    <div class="col-lg-3 col-xs-6 col-md-6 col-sm-6" style="display:none;">
                        <label for="">Caja</label>
                        <select class="form-control" id="id_caja_numero" name="id_caja_numero">
                            <option value="">Seleccione...</option>
                            <?php
                            (isset($caja_))?$cajita=$caja_->id_caja_numero:$cajita=0;
                            foreach($caja as $l){
                                ($l->id_caja_numero == $cajita)?$sele='selected':$sele='';
                                ?>
                                <option value="<?php echo $l->id_caja_numero;?>" <?= $sele; ?>><?php echo $l->caja_numero_nombre;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-3 col-xs-6 col-md-6 col-sm-6">
                        <label for="turno">Desde:</label>
                        <input type="date" class="form-control" id="fecha_filtro" name="fecha_filtro" value="<?php echo $fecha_i;?>">
                    </div>
                    <div class="col-lg-3 col-xs-6 col-md-6 col-sm-6">
                        <label for="turno">Hasta:</label>
                        <input type="date" class="form-control" id="fecha_filtro_fin" name="fecha_filtro_fin" value="<?php echo $fecha_f;?>">
                    </div>
                    <div class="col-lg-3 col-sm-12 col-md-12 col-xs-12" style="text-align: center">
                        <button style="margin-top: 35px; width: 65%" class="btn btn-success" ><i class="fa fa-search"></i> Buscar</button>
                    </div>
                </div>
            </form>
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless" id="" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th style="text-align: center">FECHA</th>
                                        <th style="text-align: center">CAJA</th>
                                        <th style="text-align: center">INGRESOS EFECTIVO</th>
                                        <th style="text-align: center">INGRESOS TARJETA</th>
                                        <th style="text-align: center">INGRESOS TRANSFERENCIA</th>
                                        <th style="text-align: center">EGRESOS</th>
                                        <th style="text-align: center">UTILIDAD</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if($datos){
                                        $sumar_caja_ingresos = 0;
                                        $ingresos = 0;
                                        $egresos_total = 0;
                                        $caja_ingresos = 0;
                                        $caja_egresos = 0;
                                        for($i=$fecha_filtro;$i<=$fecha_filtro_fin;$i+=86400){

                                            $reporte_ingresos = $this->reporte->listar_datos_ingresos(date("Y-m-d",$i));
                                            $reporte_ingresos_tarjeta = $this->reporte->listar_datos_ingresos_tarjeta(date("Y-m-d",$i));
                                            $reporte_ingresos_trans = $this->reporte->listar_datos_ingresos_transferencia(date("Y-m-d",$i));
                                            $reporte_egresos = $this->reporte->listar_datos_egresos(date("Y-m-d",$i));
                                            $reporte_orden_pedido = $this->reporte->listar_monto_op(date("Y-m-d",$i));
                                            $caja = $this->reporte->sumar_caja(date("Y-m-d",$i));
                                            $caja_movi_ingreso = $this->reporte->listar_datos_ingresos_caja(date("Y-m-d",$i));


                                            $reporte_ingresos = $reporte_ingresos->total;
                                            $reporte_ingresos_tarjeta = $reporte_ingresos_tarjeta->total;
                                            $reporte_ingresos_trans = $reporte_ingresos_trans->total;
                                            $reporte_egresos = $reporte_egresos->total;
                                            $reporte_orden_pedido = $reporte_orden_pedido->total;
                                            $caja = $caja->total;
                                            $caja_movi_ingreso =  $caja_movi_ingreso->total;


                                            $sumar_caja_ingresos = $caja + $caja_movi_ingreso;
                                            $ingresos_efectivo = $reporte_ingresos;
                                            $ingresos_tarjeta = $reporte_ingresos_tarjeta;
                                            $ingresos_trans = $reporte_ingresos_trans;
                                            $egresos = $reporte_egresos + $reporte_orden_pedido;
                                            $diferencia = $caja + $reporte_ingresos + $caja_movi_ingreso - $reporte_egresos - $reporte_orden_pedido;


                                            $ingresos_total = $ingresos_total + $sumar_caja_ingresos + $ingresos_efectivo;
                                            $egresos_total = $egresos_total + $egresos;

                                            $fecha = date("d-m-Y",$i);
                                            ?>
                                            <tr>
                                                <td style="text-align: center"><?= $fecha;?></td>
                                                <td style="text-align: center"><?= $sumar_caja_ingresos ?? 0?></td>
                                                <td style="text-align: center"><?= $ingresos_efectivo ?? 0;?></td>
                                                <td style="text-align: center"><?= $ingresos_tarjeta ?? 0;?></td>
                                                <td style="text-align: center"><?= $ingresos_trans ?? 0;?></td>
                                                <td style="text-align: center"><?= $egresos ?? 0;?></td>
                                                <?php
                                                $estilo = "";
                                                if($diferencia < 0){
                                                    $estilo = "style=\"background-color: lightpink\"";
                                                }
                                                ?>
                                                <td style="text-align: center" <?= $estilo;?>><?= $diferencia;?></td>
                                            </tr>
                                            <?php
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
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <p>Ingresos: <?= $ingresos_total; ?></p>
                                <p style="border-bottom: 1px solid red">Egresos: <?= $egresos_total; ?></p>
                                <p>Utilidad: <?= $ingresos_total - $egresos_total; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>