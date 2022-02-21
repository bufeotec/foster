<?php

class Reporte
{
    private $pdo;
    private $log;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }


    public function listar_datos_egresos($dato,$id_caja_numero=null){
        try{
            if($id_caja_numero==null){
                $sql = 'select SUM(egreso_monto) total from movimientos where date(egreso_fecha_registro) = ? and egreso_estado = 1 and movimiento_tipo = 2';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato]);
            }else{
                $sql = 'select SUM(egreso_monto) total from movimientos where date(egreso_fecha_registro) = ? and id_caja_numero = ? and egreso_estado = 1 
                    and movimiento_tipo = 2';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato,$id_caja_numero]);
            }
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function listar_datos_ingresos($dato,$id_caja_numero=null,$id_caja = null){
        try{
            if($id_caja_numero==null){
                if($id_caja==null){
                    $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                    where date(venta_fecha) = ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 3 and vdp.venta_detalle_pago_estado = 1';
                    $stm = $this->pdo->prepare($sql);
                    $stm->execute([$dato]);
                }else{
                    $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                    inner join caja c on v.id_caja_numero = c.id_caja_numero where date(venta_fecha) = ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 3 and vdp.venta_detalle_pago_estado = 1 and c.id_caja = ?';
                    $stm = $this->pdo->prepare($sql);
                    $stm->execute([$dato,$id_caja]);
                }

            }else{
                if($id_caja==null){
                    $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                    where date(venta_fecha) = ? and id_caja_numero = ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 3 and vdp.venta_detalle_pago_estado = 1';
                    $stm = $this->pdo->prepare($sql);
                    $stm->execute([$dato,$id_caja_numero]);
                }else{
                    $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                    inner join caja c on v.id_caja_numero = c.id_caja_numero where date(venta_fecha) = ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 3 and vdp.venta_detalle_pago_estado = 1 and c.id_caja_numero = ? and c.id_caja = ?';
                    $stm = $this->pdo->prepare($sql);
                    $stm->execute([$dato,$id_caja_numero,$id_caja]);
                }
            }
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }


    public function listar_monto_op($dato){
        try{
            $sql = 'select SUM(detalle_compra_total_pagado) total from orden_compra oc inner join detalle_compra dc on oc.id_orden_compra = dc.id_orden_compra 
                    where date(orden_compra_fecha_aprob) = ? and orden_compra_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$dato]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }


    public function clientes_sucursal_todo($dni_cliente,$fecha_i,$fecha_f){
        try{
            $sql = 'select count(v.id_venta) total,sum(v.venta_total) total_venta, v.venta_fecha, c. * from clientes c inner join ventas v 
                    on c.id_cliente = v.id_cliente where c.cliente_numero = ? and date(venta_fecha) between ? and ? and c.id_cliente <> 0 
                    and v.venta_tipo <> 07 and v.venta_estado_sunat = 1 and v.anulado_sunat = 0 and v.venta_cancelar = 1 group by v.id_cliente';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$dni_cliente,$fecha_i,$fecha_f]);
            $return = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function clientes_fechas($fecha_i,$fecha_f){
        try{
            $sql = 'select count(v.id_venta) total,sum(v.venta_total) total_venta, v.venta_fecha, c. * from clientes c inner join ventas v 
                    on c.id_cliente = v.id_cliente where date(venta_fecha) between ? and ? and c.id_cliente <> 0 group by v.id_cliente';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_i,$fecha_f]);
            $return = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function clientes_dni($dni_cliente){
        try{
            $sql = 'select count(v.id_venta) total,sum(v.venta_total) total_venta, v.venta_fecha, c. * from clientes c inner join ventas v 
                    on c.id_cliente = v.id_cliente where c.cliente_numero = ? and c.id_cliente <> 0 group by v.id_cliente';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$dni_cliente]);
            $return = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function datos_meseros($fecha_i,$fecha_f, $id_usuario){
        try{
            $sql = 'select count(c.id_comanda) total, sum(comanda_total) total_comanda, p.persona_nombre from usuarios_sucursal u inner join usuarios u2 on u.id_usuario = u2.id_usuario inner join personas p 
                    on u2.id_persona = p.id_persona inner join roles r on u.id_rol = r.id_rol inner join  comanda c on u.id_usuario = c.id_usuario 
                    where date(comanda_fecha_registro) between ? and ? and u.id_usuario = ? group by u2.id_persona';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_i,$fecha_f,$id_usuario]);
            $return = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function datos_proveedores($fecha_i,$fecha_f){
        try{
            $sql = 'select * from orden_compra oc inner join usuarios u on oc.id_solicitante = u.id_usuario inner join personas p2 on u.id_persona = p2.id_persona 
                    inner join detalle_compra dc on oc.id_orden_compra = dc.id_orden_compra inner join tipo_pago tp on oc.id_tipo_pago = tp.id_tipo_pago
                    inner join recursos_sede rs on dc.id_recurso_sede = rs.id_recurso_sede inner join recursos r on rs.id_recurso = r.id_recurso 
                    inner join proveedor p on oc.id_proveedor = p.id_proveedor where date(orden_compra_fecha_recibida) between ? and ? and oc.orden_compra_usuario_recibido = 1
                    group by oc.id_orden_compra';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_i,$fecha_f]);
            $return = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function datos_insumos($fecha_i,$fecha_f){
        try{
            $sql = 'select * from orden_compra oc inner join detalle_compra dc on oc.id_orden_compra = dc.id_orden_compra inner join recursos_sede rs on dc.id_recurso_sede = rs.id_recurso_sede 
                    inner join recursos r on rs.id_recurso = r.id_recurso where date(orden_compra_fecha_recibida) BETWEEN ? and ? group by rs.id_recurso_sede ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_i,$fecha_f]);
            $return = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function listar_insumos($id){
        try{
            $sql = 'select * from detalle_compra dc inner join recursos_sede rs on dc.id_recurso_sede = rs.id_recurso_sede inner join recursos r on rs.id_recurso = r.id_recurso
                    where dc.id_orden_compra = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function calcular_total($id){
        try{
            $sql = 'select sum(detalle_compra_total_pagado) total from detalle_compra where id_orden_compra = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function cantidad_compra($id_recurdo_sede){
        try{
            $sql = 'select count(id_detalle_compra) total from detalle_compra where id_recurso_sede = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_recurdo_sede]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function sumar_kilos($id_recurdo_sede){
        try{
            $sql = 'select sum(detalle_compra_cantidad_recibida) total from detalle_compra where id_recurso_sede = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_recurdo_sede]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_tipos_pago(){
        try{
            $sql = 'select * from tipo_pago where tipo_pago_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_tipos_pagos($pago_tipo){
        try{
            $sql = 'select * from tipo_pago where id_tipo_pago = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$pago_tipo]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function ventas_tipo_pago($pago_tipo,$fecha_hoy, $fecha_fin){
        try{
            $sql = 'select * from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta inner join tipo_pago tp 
                    on v.id_tipo_pago = tp.id_tipo_pago inner join clientes c on v.id_cliente = c.id_cliente where vdp.id_tipo_pago = ?
                    and date(venta_fecha) between ? and ? and vdp.venta_detalle_pago_estado = 1 and anulado_sunat = 0 and venta_cancelar = 1 
                    order by venta_fecha desc ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$pago_tipo,$fecha_hoy, $fecha_fin]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function ventas_tipo_pago_fechas($fecha_hoy, $fecha_fin){
        try{
            $sql = 'select * from ventas v inner join tipo_pago tp on v.id_tipo_pago = tp.id_tipo_pago inner join clientes c on v.id_cliente = c.id_cliente
                    where date(venta_fecha) between ? and ? order by venta_fecha desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_hoy, $fecha_fin]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }


    public function restar_horas($horaini,$horafin)
    {

        $f1 = new DateTime($horaini);
        $f2 = new DateTime($horafin);
        $d = $f1->diff($f2);
        return $d->format('%H :%I :%S ');

    }

    public function sumar_horas($horas) {
        $total = 0;
        foreach($horas as $h) {
            $parts = explode(":", $h);
            $total += $parts[2] + $parts[1]*60 + $parts[0]*3600;
        }
        return gmdate("H:i:s", $total);
    }

    public function listar_grupos(){
        try{
            $sql = 'select * from grupos where grupo_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function datos_comandas($fecha_i,$fecha_f){
        try{
            $sql = 'select * from comanda where comanda_estado = 1 and date(comanda_fecha_registro) between ? and ? ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_i,$fecha_f]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function datos_comanda_detalles($id_comanda , $id_grupo){
        try{
            $sql = 'select * from comanda_detalle cd inner join productos p on cd.id_producto = p.id_producto inner join grupos g 
                    on p.id_grupo = g.id_grupo where id_comanda = ? and p.id_grupo = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comanda, $id_grupo]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function sumar_caja($dato,$id_caja_numero=null){
        try{
            if($id_caja_numero==null){
                $sql = 'select SUM(caja_apertura) total from caja where date(caja_fecha) = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato]);
            }else{
                $sql = 'select SUM(caja_apertura) total from caja where date(caja_fecha) = ? and id_caja_numero = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato,$id_caja_numero]);
            }
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function reporte_productos_($fecha_filtro,$fecha_filtro_fin){
        try{
            $sql = 'select sum(vd.venta_detalle_cantidad) total, p.producto_nombre from ventas v inner join ventas_detalle vd on v.id_venta = vd.id_venta
                    inner join producto_precio pp on vd.id_producto_precio = pp.id_producto_precio inner join productos p on pp.id_producto = p.id_producto
                    where date(venta_fecha) between ? and ? 
                    group by vd.venta_detalle_nombre_producto';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_filtro,$fecha_filtro_fin]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 0;
        }
        return $result;
    }


    public function reporte_productos($id_familia,$fecha_filtro,$fecha_filtro_fin){
        try{
            $sql = 'select sum(vd.venta_detalle_cantidad) total, p.producto_nombre, sum(vd.venta_detalle_valor_total) sumita from ventas v inner join ventas_detalle vd on v.id_venta = vd.id_venta
                    inner join producto_precio pp on vd.id_producto_precio = pp.id_producto_precio inner join productos p on pp.id_producto = p.id_producto
                    inner join familias f on p.id_familia = f.id_familia
                    where p.id_familia = ? and date(venta_fecha) between ? and ? 
                    group by vd.venta_detalle_nombre_producto';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_familia,$fecha_filtro,$fecha_filtro_fin]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 0;
        }
        return $result;
    }

    public function listar_datos_ingresos_tarjeta($dato){
        try{
            $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta
                    where date(venta_fecha) = ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 1 and vdp.venta_detalle_pago_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$dato]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function listar_datos_ingresos_caja($dato,$id_caja_numero=null){
        try{
            if($id_caja_numero==null){
                $sql = 'select SUM(egreso_monto) total from movimientos where date(egreso_fecha_registro) = ? and egreso_estado = 1 
                        and movimiento_tipo = 1';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato]);
            }else{
                $sql = 'select SUM(egreso_monto) total from movimientos where date(egreso_fecha_registro) = ? and id_caja_numero = ? and egreso_estado = 1 
                        and movimiento_tipo = 1';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$dato,$id_caja_numero]);
            }
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function listar_datos_ingresos_transferencia($dato){
        try{
            $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta
                    where date(venta_fecha) = ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 2 and vdp.venta_detalle_pago_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$dato]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }


    public function listar_cajas(){
        try{
            $sql = 'select * from caja_numero where caja_numero_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }


    public function datos_por_apertura_caja($fecha_i,$fecha_f){
        try{
            $sql = 'select id_caja from caja where date(caja_fecha_apertura) between ? and ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_i,$fecha_f]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    //NUVAS FUNCIONES OJALA SIRVA
    public function datitos_caja($id_caja){
        try{
            $sql = 'select * from caja where id_caja = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function reporte_ingresos_x_caja($id_caja, $fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select sum(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta 
                    inner join caja c on v.id_caja_numero = c.id_caja_numero where c.id_caja = ? and v.venta_fecha between ? and ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja, $fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function reporte_caja_x_caja($id_caja, $fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select sum(caja_apertura) total from caja where id_caja = ? and caja_fecha_apertura between ? and ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja, $fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function ingreso_caja_chica_x_caja($id_caja, $fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select sum(egreso_monto) total from movimientos m inner join caja c on m.id_caja_numero = c.id_caja_numero 
                    where c.id_caja = ? and egreso_fecha_registro between ? and ? and m.movimiento_tipo = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja, $fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function ventas_efectivo($id_caja, $fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta
                    inner join caja c on v.id_caja_numero = c.id_caja_numero
                    where c.id_caja = ? and  v.venta_fecha between  ? and ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 3 and vdp.venta_detalle_pago_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja, $fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }
    public function ventas_trans($id_caja, $fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta
                    inner join caja c on v.id_caja_numero = c.id_caja_numero
                    where c.id_caja = ? and  v.venta_fecha between  ? and ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 2 and vdp.venta_detalle_pago_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja, $fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }
    public function ventas_tarjeta($id_caja, $fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select SUM(vdp.venta_detalle_pago_monto) total from ventas v inner join ventas_detalle_pagos vdp on v.id_venta = vdp.id_venta
                    inner join caja c on v.id_caja_numero = c.id_caja_numero
                    where c.id_caja = ? and  v.venta_fecha between  ? and ? and venta_tipo <> 07 
                    and anulado_sunat = 0 and venta_cancelar = 1 and vdp.id_tipo_pago = 1 and vdp.venta_detalle_pago_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja, $fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function salida_caja_chica_x_caja($id_caja, $fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select sum(egreso_monto) total from movimientos m inner join caja c on m.id_caja_numero = c.id_caja_numero 
                    where c.id_caja = ? and egreso_fecha_registro between ? and ? and m.movimiento_tipo = 2';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja, $fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function datos_gastos_p($id_caja, $fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select * from gastos_personal gp inner join caja c on gp.id_caja_numero = c.id_caja_numero 
                    inner join personas p on gp.id_persona = p.id_persona where c.id_caja = ? and gp.gasto_personal_fecha_registro
                    between ? and ? and gp.gasto_personal_estado = 1 group by p.id_persona';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja, $fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function sumar_datos_p($id_caja, $fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select sum(gp.gasto_personal_monto) total from gastos_personal gp inner join caja c on gp.id_caja_numero = c.id_caja_numero where c.id_caja = ? and gp.gasto_personal_fecha_registro
                    between ? and ? and gp.gasto_personal_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_caja, $fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }
    public function valores($id_persona,$fecha_ini_caja, $fecha_fin_caja){
        try{
            $sql = 'select sum(gasto_personal_monto) total from gastos_personal where id_persona = ? and gasto_personal_fecha_registro between 
                    ? and ? and gasto_personal_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_persona,$fecha_ini_caja, $fecha_fin_caja]);
            $return = $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }

    public function listar_familias_f(){
        try{
            $sql = 'select * from familias where familia_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

}