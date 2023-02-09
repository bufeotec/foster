<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 12/10/2020
 * Time: 17:28
 */
require 'app/models/Ventas.php';
require 'app/models/Rol.php';
require 'app/models/Recursos.php';
require 'app/models/Caja.php';
require 'app/models/Usuario.php';
require 'app/models/Suscripciones.php';
class AdminController{
    //Variables fijas para cada llamada al controlador
    private $sesion;
    private $encriptar;
    private $log;
    private $rol;
    private $validar;
    private $recursos;
    private $caja;
    private $usuario;
    private $suscripcion;
    //private $ventas;
    public function __construct()
    {
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
        $this->rol = new Rol();
        $this->ventas = new Ventas();
        $this->recursos = new Recursos();
        $this->caja = new Caja();
        $this->usuario = new Usuario();
        $this->suscripcion = new Suscripciones();
    }
    //Vistas/Opciones
    //Vista de acceso al panel de inicio
    public function inicio(){
        try{
            //Llamamos a la clase del Navbar, que sólo se usa
            // en funciones para llamar vistas y la instaciamos
            $this->nav = new Navbar();
            $contar_ya_por_vencer = 0;
            $array_nombres = [];
            $clientes_cumples = $this->suscripcion->listar_clientes_cumples(date('Y-m-d'));
            $clientes = $this->suscripcion->listar_clientes_activos_por_vencer_proximos(date('Y-m-d'));
            foreach ($clientes as $cle){
                $pasa = true;
                if (array_key_exists($cle->id_cliente , $array_nombres)) {
                    $pasa = false;
                }
                if($pasa){
                    $verificar_actualizacion_suscripcion = $this->suscripcion->listar_suscripciones_con_continuacion($cle->suscripcion_fin_actual,$cle->id_cliente);
                    if(!isset($verificar_actualizacion_suscripcion->id_suscripcion)){
                        $contar_ya_por_vencer++;
                        $array_nombres[$cle->id_cliente] = $cle->id_cliente . '-';
                    }
                }
            }


            $contar_ya_por_recuperar = 0;
            $array_nombres_recuperar = [];
            $clientes_r = $this->suscripcion->listar_clientes_activos_por_recuperar_proximos(date('Y-m-d'));
            foreach ($clientes_r as $cle){
                $pasa = true;
                if (array_key_exists($cle->id_cliente , $array_nombres_recuperar)) {
                    $pasa = false;
                }
                if($pasa){
                    $verificar_actualizacion_suscripcion = $this->suscripcion->listar_suscripciones_con_continuacion($cle->suscripcion_fin_actual,$cle->id_cliente);
                    if(!isset($verificar_actualizacion_suscripcion->id_suscripcion)){
                        $contar_ya_por_recuperar++;
                        $array_nombres_recuperar[$cle->id_cliente] = $cle->id_cliente . '-';
                    }
                }
            }

            $role = $this->encriptar->desencriptar($_SESSION['ru'], _FULL_KEY_);
            $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
            $usuario = $this->usuario->jalar_usuario($id_usuario);

            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $venta_dia = $this->ventas->listar_ventas_enviadas_activos_dia();
            $total_dia = 0;
            foreach ($venta_dia as $v){
                $total_dia = $total_dia + $v->venta_total;
            }

            $total_venta = $this->ventas->listar_ventas_enviadas_activos();
            $mes = date('Y-m');
            $total_mes = 0;
            $total_venta_mes = 0;
            foreach ($total_venta as $t){
                $mes_venta = date('Y-m', strtotime($t->venta_fecha));
                if($mes_venta == $mes){
                    $total_mes = $total_mes + $t->venta_total;
                    $total_venta_mes++;
                }
            }
            $turnos = $this->caja->listar_turnos();
            $recurso_sede = $this->recursos->listar_recursos_sede();
            $caja = $this->caja->listar_cajas();
            $listar_ultima_caja = $this->caja->listar_ultima_caja();

            $fecha_hoy = date('Y-m-d');
            $fecha_open = $this->caja->listar_ultima_fecha($listar_ultima_caja->id_caja);
            //Hacemos el require de los archivos a usar en las vistas
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'admin/inicio.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function finalizar_sesion(){
        $this->sesion->finalizar_sesion();
    }

    public function guardar_apertura_caja(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $id_usuario_apertura = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('caja_apertura', 'POST',true,$ok_data,200,'numero',1);
            if($ok_data) {
                //Creamos el modelo y ingresamos los datos a guardar
                $model = new Caja();
                $model->id_turno = $_POST['id_turno'];
                $model->id_caja_numero = $_POST['id_caja_numero'];
                $model->caja_fecha = date('Y-m-d');
                $model->id_usuario_apertura= $id_usuario_apertura;
                $model->caja_apertura = $_POST['caja_apertura'];
                $model->caja_fecha_apertura = date('Y-m-d H:i:s');
                $model->caja_estado = 1;

                //Guardamos el menú y recibimos el resultado
                $result = $this->caja->guardar_apertura_caja($model);
            }

        } catch (Throwable $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function guardar_cierre_caja(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('id_caja', 'POST',true,$ok_data,200,'numero',0);
            if($ok_data) {
                //Creamos el modelo y ingresamos los datos a guardar
                $fecha = date('Y-m-d');
                $id_caja = $_POST['id_caja'];
                $id_usuario_cierre = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                $caja_cierre = $_POST['caja_monto_cierre'];
                $caja_fecha_cierre = date('Y-m-d H:i:s');
                $caja_estado = 0;
                //$comparar_id = $this->caja->id_por_caja($fecha,$id_usuario_cierre);
                $result = $this->caja->guardar_cierre_caja($id_usuario_cierre,$caja_cierre,$caja_fecha_cierre,$caja_estado,$id_caja);
            }
        }catch (Throwable $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

}

