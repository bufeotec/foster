<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 09/03/2021
 * Time: 16:18
 */
?>
    <div class="main-content">
        <div class="section__content section__content--p30">
        <?php
        if($role == 2 || $role == 3 || $role == 4 || $role == 5){
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Datos de Ventas</h2>
                        </div>
                    </div>
                </div>
                <div class="row m-t-25">
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c1">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-shopping-cart"></i>
                                    </div>
                                    <div class="text">
                                        <h2><?= count($venta_dia);?></h2>
                                        <span>Ventas del Día</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart1"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c2">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-shopping-cart"></i>
                                    </div>
                                    <div class="text">
                                        <h2><?= number_format($total_dia, 2); ?></h2>
                                        <span>Ingresos del Día</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c3">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-calendar-note"></i>
                                    </div>
                                    <div class="text">
                                        <h2><?= $total_venta_mes;?></h2>
                                        <span>Ventas del Mes</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart3"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c4">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i style="font-size: 25px;">S/.</i>
                                    </div>
                                    <div class="text">
                                        <h2><?= number_format($total_mes, 2);?></h2>
                                        <span>Ingreso del Mes</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart4"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <?php if(!$fecha_open)
                        {
                            ?>
                            <div class="parent-wrapper">
                                <span class="close-btn glyphicon glyphicon-remove"></span>
                                <div class="subscribe-wrapper">
                                    <h4 style="padding-bottom: 10px;">APERTURA DE CAJA - <?= date('d-m-Y'); ?></h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control" id= "id_turno" name="id_turno">
                                                <?php
                                                foreach($turnos as $l){
                                                    ?>
                                                    <option value="<?php echo $l->id_turno;?>"><?php echo $l->turno_nombre;?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" id= "id_caja_numero" name="id_caja_numero">
                                                <?php
                                                foreach($caja as $l){
                                                    ?>
                                                    <option value="<?php echo $l->id_caja_numero;?>"><?php echo $l->caja_numero_nombre;?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="text" id="caja_apertura" name="caja_apertura" onkeyup="validar_numeros_decimales_dos(this.id)" class="subscribe-input" placeholder="Ingrese el monto de apertura">
                                    <div class="submit-btn" id="btn-agregar-apertura" onclick="apertura()">GUARDAR</div>
                                </div>
                            </div>
                        <?php
                        } else {
                            $monto_apertura = $this->caja->mostrar_valor_apertura($fecha_hoy,$id_usuario);
                            $valor_por_caja = $this->caja->valor_por_caja($listar_ultima_caja->id_caja);
                            $jalar_turno = $this->caja->jalar_turno($listar_ultima_caja->id_caja);
                            ?>
                            <br>
                            <div class="parent-wrapper">
                                <span class="close-btn glyphicon glyphicon-remove"></span>
                                <div class="subscribe-wrapper">
                                    <h4><?= $valor_por_caja->caja_numero_nombre;?></h4>
                                    <h6><?= $jalar_turno;?></h6>
                                    <h6>Usuario: <?= $usuario->usuario_nickname;?></h6>
                                    <h5>Monto de apertura: S/.<?= $valor_por_caja->caja_apertura ?? 0?></h5>
                                    <input type="text" id="caja_monto_cierre" name="caja_monto_cierre" onkeyup="validar_numeros_decimales_dos(this.id)" class="subscribe-input" placeholder="Ingrese el monto de cierre de caja">
                                    <div class="submit-btn" onclick="guardar_cierre_caja(<?= $listar_ultima_caja->id_caja;?>)">GUARDAR</div>
                                </div>
                            </div>
                            <br>
                        <?php
                       /* $buscar_cierre_caja = $this->caja->buscar_cierre_caja($listar_ultima_caja->id_caja,$id_usuario);
                        if(empty($buscar_cierre_caja)){

                            }*/
                        }
                        ?>
                    </div>
                    <div class="col-lg-4">
                        <div id="container">
                            <h2>Suscripciones</h2>
                            <p>Próximas a Caducar</p>
                            <form>
                                <input type="text" value="<?= $contar_ya_por_vencer;?>" readonly>
                                <br>
                                <a style="color:white;" target="_blank" href="<?= _SERVER_;?>Suscripcion/por_vencer">Ver Todas</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
<style>
    #container{
        background-image: linear-gradient(to top, rgba(205, 156, 242, 0.40) 0%, rgba(246, 255, 255, 0.71) 100%);
        box-shadow: 0 15px 30px 1px rgba(128, 128, 128, 0.31);
        text-align: center;
        border-radius: 5px;
        margin: 3em auto;
        background: rgba(255, 255, 255, 0.95);
        width: 100%;
        padding: 1em;
    }
    #container h2 {
        background: #0f6848;
        -webkit-text-fill-color: transparent;
        -webkit-background-clip: text;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size:cover;
        letter-spacing: 2px;
        font-size: 2em;
        margin: 0;
    }
    #container p {
        font-family: 'Farsan', cursive;
        margin: 3px 0 1.5em 0;
        font-size: 1.3em;
        color: #7d7d7d;
    }
    #container input {
        width: 210px;
        display: inline-block;
        text-align: center;
        border-radius: 7px;
        background: #eee;
        padding: 1em 2em;
        outline: none;
        border: none;
        color: #222;
        transition: 0.3s linear;
        font-size: 20pt;
        font-weight: bold;
    }
    ::placeholder{color: #999;}
    #container input:focus {background: rgba(0, 0, 333, 0.10);}

    #container a {
        background-image: linear-gradient(to left, #a77cf4, rgba(145, 149, 251, 0.86) 100%);
        box-shadow: 0 9px 25px -5px #df91fb;
        font-family: 'Abel', sans-serif;
        padding: 0.5em 1.9em;
        margin: 2.3em 0 0 0;
        border-radius: 7px;
        cursor: pointer;
        color: #FFFFFF;
        font-size: 1em;
        outline: none;
        border: none;
        transition: 0.3s linear;

    }
    #container button:hover{transform: translatey(2px);}
    #container button:active{transform: translatey(5px);}

    .parent-wrapper {
        position: relative;
        width: 400px;
        height: 270px;
        margin: 40px auto 0;
        background-size: 100%;
        background-repeat: no-repeat;
        background-position-y: -600%;
        background-color: beige;
        border-radius: 4px;
        color: #FFF;
        box-shadow: 0 0 50px 5px rgba(0, 0, 0, 0.5);
    }
    .close-btn {
        margin: 20px;
        font-size: 18px;
        cursor: pointer;
    }

    .subscribe-wrapper {
        position: absolute;
        left: -30px;
        right: -30px;
        height: 200px;
        padding: 30px;
        background-image: url('<?= _SERVER_ ?>media/fondo_tarjeta.png');
        background-position-x: 272%;
        background-position-y: -1px;
        background-repeat: no-repeat;
        background-color: #FFF;
        border-radius: 4px;
        color: #333;
        box-shadow: 0 0 60px 5px rgba(0, 0, 0, 0.4);
    }

    .subscribe-wrapper:after {
        position: absolute;
        content: "";
        right: -10px;
        bottom: 71px;
        width: 0;
        height: 0;
        border-left: 0 solid transparent;
        border-right: 10px solid transparent;
        border-bottom: 10px solid #7149c7;
    }

    .subscribe-wrapper h4 {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        letter-spacing: 3px;
        line-height: 28px;
    }

    .subscribe-wrapper input {
        position: absolute;
        bottom: 30px;
        border: none;
        border-bottom: 1px solid #d4d4d4;
        padding: 10px;
        width: 65%;
        background: transparent;
        transition: all .25s ease;
    }

    .subscribe-wrapper input:focus {
        outline: none;
        border-bottom: 1px solid #a77cf4;
    }

    .subscribe-wrapper .submit-btn {
        position: absolute;
        border-radius: 30px;
        border-bottom-right-radius: 0;
        border-top-right-radius: 0;
        background-color: #a77cf4;
        color: #FFF;
        padding: 12px 25px;
        display: inline-block;
        font-size: 12px;
        font-weight: bold;
        letter-spacing: 2px;
        right: -10px;
        bottom: 30px;
        cursor: pointer;
        transition: all .25s ease;
        box-shadow: -5px 6px 20px 0px rgba(51, 51, 51, 0.4);
    }

    .subscribe-wrapper .submit-btn:hover {
        background-color: #8e62dc;
    }
</style>
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script>
    function apertura(){
        var valor = true;
        //Extraemos las variable según los valores del campo consultado
        var caja_apertura = $('#caja_apertura').val();
        var id_caja_numero = $('#id_caja_numero').val();
        var id_turno = $('#id_turno').val();

        if(valor){
            //Definimos el mensaje y boton a afectar
            var boton = "btn-agregar-apertura";
            //Cadena donde enviaremos los parametros por POST
            var cadena = "caja_apertura=" + caja_apertura +
                "&id_caja_numero=" + id_caja_numero +
                "&id_turno=" + id_turno;
            $.ajax({
                type: "POST",
                url: urlweb + "api/Admin/guardar_apertura_caja",
                data: cadena,
                dataType: 'json',
                beforeSend: function () {
                    cambiar_estado_boton(boton, "Guardando...", true);
                },
                success:function (r) {
                    cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i>  Aperturar Caja", false);
                    switch (r.result.code) {
                        case 1:
                            respuesta('¡Ingreso de Apertura Exitoso!', 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                            break;
                        case 2:
                            respuesta('Error al ingresar la apertura de la caja', 'error');
                            break;
                        default:
                            respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                            break;
                    }
                }
            });
        }
    }

    function guardar_cierre_caja(id){
        var valor = true;
        var caja_monto_cierre = $('#caja_monto_cierre').val();
        console.log(id);
        //valor = validar_campo_vacio('caja_monto_cierre', caja_monto_cierre, valor);
        if(valor){
            //Definimos el mensaje y boton a afectar
            var boton = "btn-agregar-cierre";
            //Cadena donde enviaremos los parametros por POST
            var cadena = "caja_monto_cierre=" + caja_monto_cierre +
                "&id_caja=" + id;
            $.ajax({
                type: "POST",
                url: urlweb + "api/Admin/guardar_cierre_caja",
                data: cadena,
                dataType: 'json',
                beforeSend: function () {
                    cambiar_estado_boton(boton, "Guardando...", true);
                },
                success:function (r) {
                    cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar Cierre", false);
                    switch (r.result.code) {
                        case 1:
                            respuesta('¡Cierre de caja Exitoso!', 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                            break;
                        case 2:
                            respuesta('Error al guardar, comuniquese con BufeoTec Company', 'error');
                            break;
                        default:
                            respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                            break;
                    }
                }
            });
        }
    }
</script>