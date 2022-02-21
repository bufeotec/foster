<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE
 * Date: 20/01/2022
 * Time: 17:45
 */
class Suscripciones{
    private $pdo;
    private $log;
    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }
    public function listar_clientes_activos($fecha){
        try{
            //$sql = 'select * from clientes where id_tipodocumento = 2';
            $sql = 'select * from suscripciones s inner join clientes c on s.id_cliente = c.id_cliente inner join horarios h on s.id_horario = h.id_horario where s.suscripcion_estado = 1 and (? between s.suscripcion_inicio and s.suscripcion_fin) order by c.cliente_nombre asc ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_clientes_activos_por_vencer($fecha){
        try{
            $fecha_fin = date('Y-m-d', strtotime($fecha . ' + 15 days'));
            //$sql = 'select * from clientes where id_tipodocumento = 2';
            $sql = 'select * from suscripciones s inner join clientes c on s.id_cliente = c.id_cliente inner join horarios h on s.id_horario = h.id_horario where s.suscripcion_estado = 1 and (s.suscripcion_fin between ? and ?) order by c.cliente_nombre asc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha, $fecha_fin]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_clientes_activos_rango_fecha($fecha_inicio, $fecha_fin, $query){
        try{
            //$sql = 'select * from clientes where id_tipodocumento = 2';
            $sql = 'select * from suscripciones s inner join clientes c on s.id_cliente = c.id_cliente inner join horarios h on s.id_horario = h.id_horario 
                    where 
                          s.suscripcion_estado = 1 '.$query.' and (s.suscripcion_inicio <= ? and s.suscripcion_fin >= ?) or
                          s.suscripcion_estado = 1 '.$query.' and (s.suscripcion_inicio >= ? and s.suscripcion_fin <= ?) or
                          s.suscripcion_estado = 1 '.$query.' and (s.suscripcion_inicio <= ? and s.suscripcion_fin between ? and ?) or
                          s.suscripcion_estado = 1 '.$query.' and (s.suscripcion_inicio between ? and ? and s.suscripcion_fin >= ?) 
                    order by s.suscripcion_fin desc ';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_inicio, $fecha_fin,$fecha_inicio, $fecha_fin,$fecha_inicio,$fecha_inicio, $fecha_fin,$fecha_inicio, $fecha_fin,$fecha_fin]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function eliminar_suscripcion($id_suscripcion){
        try{
            //$sql = 'delete from pagos_suscripcion where id_suscripcion = ?; delete from suscripciones where id_suscripcion = ?';
            $sql = 'update suscripciones set suscripcion_estado = 0 where id_suscripcion = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_suscripcion]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function guardar_servicio_cliente($model){
        try{
            $sql = 'insert into servicio_historial (id_servicio_cliente, servicio_historial_cantidad, servicio_historial_fecha, servicio_historial_comentarios) values (?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_servicio_cliente,
                $model->servicio_historial_cantidad,
                $model->servicio_historial_fecha,
                $model->servicio_historial_comentarios
            ]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function listar_horarios(){
        try{

            $sql = 'select * from horarios where horario_estado = 1 order by horario_inicio asc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([

            ]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function registrar_suscripcion($model){
        try{

            $sql = 'insert into suscripciones (id_cliente,id_usuario, id_horario, suscripcion_total, suscripcion_inicio, suscripcion_fin, suscripcion_fin_actual, suscripcion_costo, suscripcion_pagado, suscripcion_registro, suscripcion_estado) values (?,?,?,?,?,?,?,?,?,?,1)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_cliente,
                $model->id_usuario,
                $model->id_horario,
                $model->suscripcion_total,
                $model->suscripcion_inicio,
                $model->suscripcion_fin,
                $model->suscripcion_fin_actual,
                $model->suscripcion_costo,
                $model->suscripcion_pagado,
                $model->suscripcion_registro
            ]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function listar_suscripcion_cliente($id_suscripcion){
        try{

            $sql = 'select * from suscripciones s inner join clientes c on s.id_cliente = c.id_cliente inner join horarios h on s.id_horario = h.id_horario where s.id_suscripcion = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $id_suscripcion
            ]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_suscripciones_con_continuacion($fecha, $id_cliente){
        $fecha = date('Y-m-d', strtotime($fecha . ' + 1 days'));
        try{
            $sql = "select * from suscripciones where id_cliente = ? and suscripcion_estado = 1 and ? between suscripcion_inicio and suscripcion_fin";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_cliente, $fecha]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_suscripciones_cliente($id_cliente){
        try{

            $sql = 'select * from suscripciones s inner join horarios h on s.id_horario = h.id_horario where s.id_cliente = ? order by s.suscripcion_fin desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_cliente]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function servicios_clientes($id_cliente){
        try{

            $sql = 'select * from servicio_cliente sc inner join servicios s on sc.id_servicio = s.id_servicio where sc.id_cliente = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_cliente]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function contar_usos_servicio_cliente($id_servicio_cliente){
        try{

            $sql = 'select sum(servicio_historial_cantidad) total from servicio_historial where id_servicio_cliente = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_servicio_cliente]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function buscar_suscripcion_activa_cliente($id_cliente, $fecha){
        try{

            $sql = 'select * from suscripciones where id_cliente = ? and ? between suscripcion_inicio and suscripcion_fin';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_cliente, $fecha]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function servicios_clientes_historial($id_cliente){
        try{

            $sql = 'select * from servicio_historial sh inner join servicio_cliente sc on sh.id_servicio_cliente = sc.id_servicio_cliente inner join servicios s on sc.id_servicio = s.id_servicio where sc.id_cliente = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_cliente]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_fichas($id_cliente){
        try{

            $sql = 'select * from ficha where id_cliente = ? order by ficha_creacion desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_cliente]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function guardar_ficha($model){
        try{
            if(isset($model->id_ficha)){
                $sql = 'update ficha set
                    ficha_peso = ?,
                    ficha_cintura = ?,
                    ficha_cadera = ?,
                    ficha_pecho = ?,
                    ficha_brazo = ?,
                    ficha_estatura = ?,
                    ficha_grupo_sanguineo = ?,
                    ficha_columna = ?,
                    ficha_columna_comentario = ?,
                    ficha_cardiacos = ?,
                    ficha_cardiacos_comentarios = ?,
                    ficha_lesiones = ?,
                    ficha_lesiones_comentarios = ?,
                    ficha_medicamentos = ?,
                    ficha_medicamentos_comentarios = ?,
                    ficha_mareos = ?,
                    ficha_mareos_comentarios = ?,
                    ficha_enfermedades = ?
                    where id_ficha = ?
                ';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->ficha_peso,
                    $model->ficha_cintura,
                    $model->ficha_cadera,
                    $model->ficha_pecho,
                    $model->ficha_brazo,
                    $model->ficha_estatura,
                    $model->ficha_grupo_sanguineo,
                    $model->ficha_columna,
                    $model->ficha_columna_comentario,
                    $model->ficha_cardiacos,
                    $model->ficha_cardiacos_comentarios,
                    $model->ficha_lesiones,
                    $model->ficha_lesiones_comentarios,
                    $model->ficha_medicamentos,
                    $model->ficha_medicamentos_comentarios,
                    $model->ficha_mareos,
                    $model->ficha_mareos_comentarios,
                    $model->ficha_enfermedades,
                    $model->id_ficha
                ]);
            } else {
                $sql = 'insert into ficha (id_cliente, ficha_peso, ficha_cintura, ficha_cadera, ficha_pecho, ficha_brazo, ficha_estatura, ficha_grupo_sanguineo, ficha_columna, ficha_columna_comentario, ficha_cardiacos, ficha_cardiacos_comentarios, ficha_lesiones, ficha_lesiones_comentarios, ficha_medicamentos, ficha_medicamentos_comentarios, ficha_mareos, ficha_mareos_comentarios, ficha_enfermedades, ficha_creacion) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_cliente,
                    $model->ficha_peso,
                    $model->ficha_cintura,
                    $model->ficha_cadera,
                    $model->ficha_pecho,
                    $model->ficha_brazo,
                    $model->ficha_estatura,
                    $model->ficha_grupo_sanguineo,
                    $model->ficha_columna,
                    $model->ficha_columna_comentario,
                    $model->ficha_cardiacos,
                    $model->ficha_cardiacos_comentarios,
                    $model->ficha_lesiones,
                    $model->ficha_lesiones_comentarios,
                    $model->ficha_medicamentos,
                    $model->ficha_medicamentos_comentarios,
                    $model->ficha_mareos,
                    $model->ficha_mareos_comentarios,
                    $model->ficha_enfermedades,
                    $model->ficha_creacion
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function eliminar_ficha($id_ficha){
        try{
            $sql = 'delete from ficha where id_ficha = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $id_ficha
            ]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }
}