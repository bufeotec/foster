
<div class="modal fade" id="recursos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 50% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Asignar Recurso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="categoria">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Sucursal</label>
                                        <select class="form-control" onchange="jalar_categorias()" id= "id_sucursal" name="id_sucursal">
                                            <option value="">Seleccionar Negocio</option>
                                            <?php
                                            foreach($sucursal as $n){
                                                ?>
                                                <option <?= ($n->id_sucursal == 1)?'selected':'';?> value="<?php echo $n->id_sucursal;?>"><?php echo $n->sucursal_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Categoria</label>
                                        <div id="datos_categoria"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6" style="display: none">
                                    <div class="form-group">
                                        <label class="col-form-label">Seleccionar </label>
                                        <select id="id_ne" onchange="elegir_ne()" name="id_ne" class="form-control">
                                            <option value="0">Seleccionar</option>
                                            <option value="1">Nuevo</option>
                                            <option value="2">Existente</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Recurso</label>
                                        <div id="datos_recurso"></div>
                                        <input type="text" id="recurso_nombre" name="recurso_nombre" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Unidad de medida: </label>
                                        <select id="id_medida" name="id_medida" class="form-control">
                                            <?php
                                            foreach($unidad_medida as $um){
                                                ?>
                                                <option value="<?php echo $um->id_medida;?>" <?=($um->id_medida == 58)?'selected':'';?>><?php echo $um->medida_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Stock Inicial: </label>
                                        <input class="form-control" type="text" id="recurso_sede_stock" name="recurso_sede_stock" onkeyup="validar_numeros_decimales_dos(this.id)" placeholder="Stock Inicial...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Stock Minimo: </label>
                                        <input class="form-control" type="text" id="recurso_sede_stock_minimo" name="recurso_sede_stock_minimo" onkeyup="validar_numeros_decimales_dos(this.id)" placeholder="Stock Minimo...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Precio de Compra: </label>
                                        <input class="form-control" type="text" id="recurso_sede_precio" name="recurso_sede_precio" onkeyup="validar_numeros_decimales_dos(this.id)" placeholder="Ingrese Precio...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="btn-agregar-recursos" onclick="guardar()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editar_recurso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div id="categoria">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label">Recursos</label>
                                        <input type="text" class="form-control" id="id_recurso_e" name="id_recurso_e" readonly>
                                </div>
                            </div>
                            <input type="hidden" id="id_recurso_sede" name="id_recurso_sede" value="">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Categoria</label>
                                    <select id="id_medida_e" name="id_medida_e" class="form-control">
                                        <?php
                                        foreach($categoria as $c){
                                            ?>
                                            <option value="<?php echo $c->id_categoria;?>"><?php echo $c->categoria_nombre;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="btn-editar-recursos" onclick="guardar()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editar_stock_minimo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Stock Minimo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div id="categoria">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for=""> Stock Minimo</label>
                                <input class="form-control" type="text" id="recurso_sede_stock_minimo_e" name="recurso_sede_stock_minimo_e" value="">
                            </div>
                            <input type="hidden" id="id_recurso_sede" name="id_recurso_sede" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="btn-editar-recursos" onclick="guardar_stock_minimo_actializado()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>


<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>

            </div>
            <!-- /.row (main row) -->
            <div class="row">
                <div class="col-lg-10"></div>
                <div class="col-lg-2">
                    <button data-toggle="modal" data-target="#recursos" class="btn btn-sm btn-primary shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Nuevo</button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h2> Recursos Asignados</h2></div>
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-earning" id="dataTable2" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Sucursal</th>
                                        <th>Recurso</th>
                                        <th>Categoria</th>
                                        <th>Unidad de Medida</th>
                                        <th>Precio Compra</th>
                                        <th>Stock Actual</th>
                                        <th>Stock Minimo</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($recurso_sede as $ar){
                                        $stock_actual = $ar->recurso_sede_stock;
                                        $stock_minimo = $ar->recurso_sede_stock_minimo;

                                        $estilo = "";
                                        $estilo_ = "";
                                        if($ar->negocio_estado == "0"){
                                            $estilo = "style=\"background-color: #FF6B70\"";
                                        }
                                        if($stock_actual <= $stock_minimo){
                                            $estilo_ = "style=\"background-color: #FF6B70\"";
                                        }

                                        ?>
                                        <tr <?= $estilo;?>>
                                            <td><?= $a;?></td>
                                            <td><?= $ar->sucursal_nombre;?></td>
                                            <td><?= $ar->recurso_nombre;?></td>
                                            <td><?= $ar->categoria_nombre;?></td>
                                            <td><?= $ar->medida_nombre;?></td>
                                            <td><?= $ar->recurso_sede_precio;?></td>
                                            <td <?= $estilo_;?>><?= $ar->recurso_sede_stock;?></td>
                                            <td><?= $ar->recurso_sede_stock_minimo;?></td>
                                            <td>
                                                <!--<button class="btn btn-success" data-toggle="modal" data-target="#editar_recurso" onclick="editar_recurso(<?= $ar->id_recurso_sede;?>,'<?= $ar->recurso_nombre?>','<?= $ar->id_medida;?>')"><i class="fa fa-edit"></i> Editar</button> -->
                                                <?php
                                                if ($ar->recurso_sede_estado == 0) {
                                                    ?>
                                                    <button class="btn btn-success" onclick="preguntar('¿Esta seguro que quiere Habilitar este recurso?','habilitar','Si','No',<?= $ar->id_recurso_sede ?>,1)" title='Cambiar Estado'><i class='fa fa-check editar margen'></i></button>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <button class="btn btn-danger" onclick="preguntar('¿Esta seguro que quiere eliminar este recurso?','deshabilitar','Si','No',<?= $ar->id_recurso_sede ?>,0)" title='Cambiar Estado'><i class='fa fa-trash editar margen'></i></button>
                                                    <button class="btn btn-success" data-toggle="modal" data-target="#editar_stock_minimo" onclick="editar_stock_minimo(<?= $ar->id_recurso_sede;?>,'<?= $ar->recurso_sede_stock_minimo;?>')"><i class="fa fa-edit"></i></button>
                                                    <?php
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
            </div>
    </div>
</div>
<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>recursos.js"></script>

    <script>
        $(document).ready(function(){
        jalar_categorias();
    });
        function elegir_ne(){
            var eleccion = $("#id_ne").val();
            if(eleccion == 1){
                $("#recurso_nombre").show();
                $("#datos_recurso").hide();
            }else{
                $("#recurso_nombre").hide();
                $("#datos_recurso").show();
            }
        }

    </script>