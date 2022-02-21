<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE
 * Date: 24/01/2022
 * Time: 12:29
 */
class Servicio{
    private $pdo;
    private $log;
    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }
    public function listar_servicios(){
        try{
            $sql = 'select * from servicios order by servicio_nombre asc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_servicios_id($id){
        try{
            $sql = 'select * from servicios where id_servicio = ? order by servicio_nombre asc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_historial_servicios($id_servicio){
        try{
            $sql = 'select * from servicio_historial sh inner join servicio_cliente sc on sh.id_servicio_cliente = sc.id_servicio_cliente inner join clientes c on sc.id_cliente = c.id_cliente inner join servicios s on sc.id_servicio = s.id_servicio where s.id_servicio = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_servicio]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_historial_servicios_fechas($id_servicio, $fecha_inicio, $fecha_fin){
        try{
            $sql = 'select * from servicio_historial sh inner join servicio_cliente sc on sh.id_servicio_cliente = sc.id_servicio_cliente inner join clientes c on sc.id_cliente = c.id_cliente inner join servicios s on sc.id_servicio = s.id_servicio where s.id_servicio = ? and date(servicio_historial_fecha) between ? and ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_servicio, $fecha_inicio, $fecha_fin]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function guardar_servicio($model){
        try{
            if(isset($model->id_servicio)){
                $sql = 'update servicios set servicio_nombre = ?, servicio_descripcion = ?, servicio_estado = ? where id_servicio = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->servicio_nombre,
                    $model->servicio_descripcion,
                    $model->servicio_estado,
                    $model->id_servicio
                ]);
            } else {
                $sql = 'insert into servicios (servicio_nombre, servicio_descripcion, servicio_estado) values (?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->servicio_nombre,
                    $model->servicio_descripcion,
                    $model->servicio_estado
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }
}