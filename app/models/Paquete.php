<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE
 * Date: 24/01/2022
 * Time: 20:04
 */
class Paquete{
    private $pdo;
    private $log;
    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }
    public function listar_paquetes(){
        try{
            $sql = 'select * from agregado_compra ac inner join productos p on ac.id_producto = p.id_producto';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function guardar_paquete($model){
        try{
            if(isset($model->id_agregado)){
                $sql = 'update agregado_compra set id_producto = ?, agregado_tipo = ?, agregado_id_producto = ?, agregado_id_servicio = ?, agregado_cantidad = ?, agregado_unidad = ?, agregado_estado = ? where id_agregado = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_producto,
                    $model->agregado_tipo,
                    $model->agregado_id_producto,
                    $model->agregado_id_servicio,
                    $model->agregado_cantidad,
                    $model->agregado_unidad,
                    $model->agregado_estado,
                    $model->id_agregado
                ]);
            } else {
                $sql = 'insert into agregado_compra (id_producto, agregado_tipo, agregado_id_producto, agregado_id_servicio, agregado_cantidad, agregado_unidad, agregado_estado) values (?,?,?,?,?,?,1)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_producto,
                    $model->agregado_tipo,
                    $model->agregado_id_producto,
                    $model->agregado_id_servicio,
                    $model->agregado_cantidad,
                    $model->agregado_unidad
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }
}