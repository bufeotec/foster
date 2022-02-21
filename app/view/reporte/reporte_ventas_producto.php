


<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Reporte/reporte_ventas_productos">
                <input type="hidden" id="enviar_fecha" name="enviar_fecha" value="1">
                <div class="row">
                    <div class="col-lg-2">
                        <label for="">Familia</label>
                        <select class="form-control" id="id_familia" name="id_familia">
                            <?php
                            foreach ($familia as $f){
                                $sele="";
                                if(isset($_POST['id_familia'])){
                                    ($_POST['id_familia']==$f->id_familia)?$sele="selected":$sele="";
                                }
                                ?>
                                <option value="<?php echo $f->id_familia;?>" <?= $sele; ?>><?php echo $f->familia_nombre;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label for="turno">Desde:</label>
                        <input type="date" class="form-control" id="fecha_filtro" name="fecha_filtro" step="1" value="<?php echo $fecha_filtro;?>">
                    </div>
                    <div class="col-lg-2">
                        <label for="turno">Hasta:</label>
                        <input type="date" class="form-control" id="fecha_filtro_fin" name="fecha_filtro_fin" value="<?php echo $fecha_filtro_fin;?>">
                    </div>
                    <div class="col-lg-3">
                        <button style="margin-top: 35px;" class="btn btn-success" ><i class="fa fa-search"></i> Buscar</button>
                    </div>
                </div>
            </form>
            <br>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" style="border-color: black">
                                <thead>
                                <tr style="background-color: #ebebeb">
                                    <th>PRODUCTO</th>
                                    <th>FECHAS</th>
                                    <th>CANTIDAD VENDIDA</th>
                                    <th>TOTAL</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $total_suma = 0;
                                $total_recaudado = 0;
                                foreach ($productos as $p){
                                    ?>
                                    <tr>
                                        <td><?= $p->producto_nombre?></td>
                                        <td><?= $fecha_filtro?> / <?= $fecha_filtro_fin?></td>
                                        <td><?= $p->total?></td>
                                        <td>S/. <?= $p->sumita?></td>
                                    </tr>
                                    <?php
                                    $total_recaudado = $total_recaudado + $p->sumita;
                                    $total_suma = $total_suma + $p->total;
                                }
                                ?>
                                <tr><td  colspan="3" style="text-align: right;">TOTAL DE PRODUCTO VENDIDOS:</td><td style="background-color: #f9f17f"><b> <?php echo $total_suma;?></b></td></tr>
                                <tr><td  colspan="3" style="text-align: right;">TOTAL RECAUDADO:</td><td style="background-color: #f9f17f"><b>S/. <?php echo $total_recaudado;?></b></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12" style="text-align: center">
                    <a href="<?= _SERVER_ ; ?>index.php?c=Reporte&a=reporte_ventas_producto_pdf&fecha_filtro=<?= $_POST['fecha_filtro']?>&fecha_filtro_fin=<?= $_POST['fecha_filtro_fin']?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Imprimir</a>
                </div>
            </div>

        </div>
    </div>
</div>