<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE
 * Date: 24/01/2022
 * Time: 12:21
 */
require 'app/models/Rol.php';
require 'app/models/Usuario.php';
require 'app/models/Servicio.php';

class ServicioController
{
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $rol;
    private $usuario;
    private $servicio;

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

    }

    public function inicio(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $servicios = $this->servicio->listar_servicios();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'servicio/inicio.php';
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


            if(isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])){
                $fecha_fin = $_POST['fecha_fin'];
                $fecha_inicio = $_POST['fecha_inicio'];
            } else {
                $fecha_fin = date('Y-m-d');
                $fecha_inicio = date('Y-m-d', strtotime(date('Y-m-d', strtotime(date('Y-m-d', strtotime(date('Y-m-d') . ' - 1 month')) . ' + 1 days'))));
            }

            $servicios = $this->servicio->listar_historial_servicios_fechas($_GET['id'],$fecha_inicio,$fecha_fin);
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
    public function guardar_servicio(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        $dato_ultimo_cliente = [];
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //Validacion de datos
            if($ok_data){
                $model = new Servicio();
                if(isset($_POST['id_servicio'])){
                    $model->id_servicio = $_POST['id_servicio'];
                    $model->servicio_nombre = $_POST['servicio_nombre_e'];
                    $model->servicio_descripcion = $_POST['servicio_descripcion_e'];
                    $model->servicio_estado = $_POST['servicio_estado_e'];
                } else {
                    $model->servicio_nombre = $_POST['servicio_nombre'];
                    $model->servicio_descripcion = $_POST['servicio_descripcion'];
                    $model->servicio_estado = $_POST['servicio_estado'];
                }

                $result = $this->servicio->guardar_servicio($model);
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
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "dato_ultimo_cliente" =>$dato_ultimo_cliente)));
    }
}