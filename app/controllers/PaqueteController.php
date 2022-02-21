<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE
 * Date: 24/01/2022
 * Time: 20:04
 */
require 'app/models/Rol.php';
require 'app/models/Usuario.php';
require 'app/models/Servicio.php';
require 'app/models/Paquete.php';
require 'app/models/Producto.php';
require 'app/models/Pedido.php';
require 'app/models/Recursos.php';

class PaqueteController
{
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $rol;
    private $usuario;
    private $servicio;
    private $paquete;
    private $producto;
    private $pedido;
    private $recursos;

    public function __construct()
    {
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
        $this->rol = new Rol();
        $this->usuario = new Usuario();
        $this->servicio = new Servicio();
        $this->paquete = new Paquete();
        $this->recursos = new Recursos();
        $this->producto = new Producto();
        $this->pedido = new Pedido();

    }

    public function inicio(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $paquetes = $this->paquete->listar_paquetes();

            $productos = $this->producto->listar_productos();
            $servicios = $this->servicio->listar_servicios();
            $tipo_afectacion = $this->pedido->listar_tipo_afectacion();
            $unidad_medida = $this->recursos->listar_unidad_medida();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'paquete/inicio.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function historial_servicios(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $servicios = $this->servicio->listar_historial_servicios($_GET['id']);
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'servicio/historial_servicios.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    //Funciones
    public function guardar_paquete(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //Validacion de datos
            if($ok_data){
                $model = new Paquete();
                if(isset($_POST['id_agregado'])){
                    $model->id_agregado = $_POST['id_agregado'];
                    $model->id_producto = $_POST['id_producto_e'];
                    $model->agregado_tipo = $_POST['agregado_tipo_e'];
                    if(empty($_POST['agregado_id_producto_e'] )){
                        $model->agregado_id_producto = null;
                    } else {
                        $model->agregado_id_producto = $_POST['agregado_id_producto_e'];
                    }

                    if(empty($_POST['agregado_id_servicio_e'] )){
                        $model->agregado_id_servicio = null;
                    } else {
                        $model->agregado_id_servicio = $_POST['agregado_id_servicio_e'];
                    }
                    $model->agregado_cantidad = $_POST['agregado_cantidad_e'];
                    $model->agregado_unidad = $_POST['agregado_unidad_e'];
                    $model->agregado_estado = $_POST['agregado_estado_e'];
                } else {
                    $model->id_producto = $_POST['id_producto'];
                    $model->agregado_tipo = $_POST['agregado_tipo'];
                    if(empty($_POST['agregado_id_producto'] )){
                        $model->agregado_id_producto = null;
                    } else {
                        $model->agregado_id_producto = $_POST['agregado_id_producto'];
                    }

                    if(empty($_POST['agregado_id_servicio'] )){
                        $model->agregado_id_servicio = null;
                    } else {
                        $model->agregado_id_servicio = $_POST['agregado_id_servicio'];
                    }
                    $model->agregado_cantidad = $_POST['agregado_cantidad'];
                    $model->agregado_unidad = $_POST['agregado_unidad'];
                }

                $result = $this->paquete->guardar_paquete($model);
            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }

        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }
}