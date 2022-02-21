<?php
/**
 * Created by PhpStorm
 * User: Franz
 * Date: 12/03/2021
 * Time: 10:30
 */

class Mesa{
    private $pdo;
    private $log;
    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    public function listar_mesas(){
        try{
            $sql = 'select * from mesas m inner join sucursal s on m.id_sucursal = s.id_sucursal where s.sucursal_estado = 1 order by rand()';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function mesa($id){
        try{
            $sql = 'select * from mesas where id_mesa = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    //Registrar nuevo mesa
    public function guardar_mesa($model){
        try{
            if(isset($model->id_mesa)){
                $sql = 'update mesas set
                        id_sucursal = ?,
                        mesa_nombre = ?,
                        mesa_capacidad = ?
                        where id_mesa = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_sucursal,
                    $model->mesa_nombre,
                    $model->mesa_capacidad,
                    $model->id_mesa
                ]);
            } else {
                $sql = 'insert into mesas (id_sucursal, mesa_nombre, mesa_capacidad, mesa_estado) values (?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_sucursal,
                    $model->mesa_nombre,
                    $model->mesa_capacidad,
                    $model->mesa_estado
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    //Lista la información del mesa según id
    public function listar_mesa($id_mesa){
        try{
            $sql = 'select m.id_mesa, m.id_sucursal, m.mesa_nombre, m.mesa_capacidad, m.mesa_estado from mesas m inner join sucursal s on m.id_sucursal = s.id_sucursal where m.id_mesa = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_mesa]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    //Eliminar mesa
    public function eliminar_mesa($id_mesa){
        try{
            $sql = 'delete from mesas where id_mesa = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_mesa]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function listar_sucursal_negocio($id){
        try{
            $sql = 'select * from sucursal where id_negocio = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();

        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

}