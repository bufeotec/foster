<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE
 * Date: 20/01/2022
 * Time: 17:21
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'libs/PHPMailer/Exception.php';
require 'libs/PHPMailer/PHPMailer.php';
require 'libs/PHPMailer/SMTP.php';


require 'app/models/Rol.php';
require 'app/models/Usuario.php';
require 'app/models/Suscripciones.php';
require 'app/models/Cliente.php';
require 'app/models/Ventas.php';

class SuscripcionController
{
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $rol;
    private $usuario;
    private $suscripcion;
    private $cliente;
    private $ventas;

    public function __construct()
    {
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
        $this->rol = new Rol();
        $this->usuario = new Usuario();
        $this->cliente = new Cliente();
        $this->suscripcion = new Suscripciones();
        $this->ventas = new Ventas();
    }

    public function inicio(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $fecha = date('Y-m-d');
            //$clientes = $this->suscripcion->listar_clientes_activos($fecha);
            $tipos_documento = $this->cliente->listar_tipos_documentos();
            $horarios = $this->suscripcion->listar_horarios();
            $horario = "";
            $query = "";
            if(isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])){
                $fecha_fin = $_POST['fecha_fin'];
                $fecha_inicio = $_POST['fecha_inicio'];
            } else {
                $fecha_fin = date('Y-m-d');
                $fecha_inicio = date('Y-m-d', strtotime(date('Y-m-d', strtotime(date('Y-m-d', strtotime(date('Y-m-d') . ' - 1 month')) . ' + 1 days'))));
            }

            if(isset($_POST['id_horario'])){
                if($_POST['id_horario'] != "TODOS"){
                    $query = " and s.id_horario = " . $_POST['id_horario'];
                    $horario = $_POST['id_horario'];
                }
            }
            $clientes = $this->suscripcion->listar_clientes_activos_rango_fecha($fecha_inicio,$fecha_fin, $query);

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'suscripciones/inicio.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function detalle(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $fecha = date('Y-m-d');
            //$clientes = $this->suscripcion->listar_clientes_activos($fecha);
            $tipos_documento = $this->cliente->listar_tipos_documentos();
            $horarios = $this->suscripcion->listar_horarios();

            $suscripciones = $this->suscripcion->listar_suscripciones_cliente($_GET['id']);
            $fichas = $this->suscripcion->listar_fichas($_GET['id']);
            $cliente = $this->cliente->listar_cliente_id($_GET['id']);

            $servicios_cliente = $this->suscripcion->servicios_clientes($_GET['id']);
            $historial_servicios_cliente = $this->suscripcion->servicios_clientes_historial($_GET['id']);

            $ventas = $this->ventas->listar_ventas_clientes($_GET['id']);

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'suscripciones/detalle.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function por_vencer(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $fecha = date('Y-m-d');
            //$clientes = $this->suscripcion->listar_clientes_activos($fecha);
            $horarios = $this->suscripcion->listar_horarios();
            if(isset($_POST['fecha'])){
                $fecha = $_POST['fecha'];
            } else {
                $fecha = date('Y-m-d');
            }
            $clientes = $this->suscripcion->listar_clientes_activos_por_vencer_proximos($fecha);

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'suscripciones/por_vencer.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function por_recuperar(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $fecha = date('Y-m-d');
            //$clientes = $this->suscripcion->listar_clientes_activos($fecha);
            $horarios = $this->suscripcion->listar_horarios();
            if(isset($_POST['fecha'])){
                $fecha = $_POST['fecha'];
            } else {
                $fecha = date('Y-m-d');
            }
            $clientes = $this->suscripcion->listar_clientes_activos_por_recuperar_proximos($fecha);

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'suscripciones/por_vencer.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function eliminar_suscripcion(){
        //Array donde vamos a recetar los cambios, en caso hagamos alguno
        $cliente = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_suscripcion', 'POST', true, $ok_data, 11, 'numero', 0);
            //Validacion de datos
            if ($ok_data) {
                //Eliminamos el receta

                $result = $this->suscripcion->eliminar_suscripcion($_POST['id_suscripcion']);
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "cliente" => $cliente)));
    }

    public function registrar_historia_servicio(){
        //Array donde vamos a recetar los cambios, en caso hagamos alguno
        $cliente = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_servicio_cliente', 'POST', true, $ok_data, 11, 'numero', 0);
            //Validacion de datos
            if ($ok_data) {
                //Registramos la data fachera
                $model = new Suscripciones();
                $model->id_servicio_cliente = $_POST['id_servicio_cliente'];
                $model->servicio_historial_cantidad = $_POST['servicio_historial_cantidad'];
                $model->servicio_historial_fecha = date('Y-m-d H:i:s');
                $model->servicio_historial_comentarios = $_POST['servicio_historial_comentarios'];
                $result = $this->suscripcion->guardar_servicio_cliente($model);
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "cliente" => $cliente)));
    }

    public function guardar_membresia_free(){
        //Array donde vamos a recetar los cambios, en caso hagamos alguno
        $cliente = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_suscripcion', 'POST', true, $ok_data, 11, 'numero', 0);
            $ok_data = $this->validar->validar_parametro('client_number', 'POST', true, $ok_data, 11, 'numero', 0);
            $ok_data = $this->validar->validar_parametro('membresia_cantidad', 'POST', true, $ok_data, 11, 'numero', 0);
            $ok_data = $this->validar->validar_parametro('cliente_nombre', 'POST', true, $ok_data, 200, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('membresia_inicio', 'POST', true, $ok_data, 10, 'fecha', 0);
            //Validacion de datos
            if ($ok_data) {
                $id_cliente = "";
                //Verificamos el cliente
                if($this->cliente->validar_dni($_POST['client_number'])){
                    //Código 5: DNI duplicado
                    $cliente = $this->cliente->listar_cliente_x_numero($_POST['client_number']);
                    $id_cliente = $cliente->id_cliente;
                    $result = 1;
                } else{
                    $model = new Cliente();
                    $microtime = microtime(true);
                    $model->id_tipodocumento = 2;
                    $model->cliente_razonsocial = "";
                    $model->cliente_nombre = $_POST['cliente_nombre'];
                    $model->cliente_numero = $_POST['client_number'];
                    $model->cliente_correo = "";
                    $model->cliente_direccion = "";
                    $model->cliente_direccion_2 = "";
                    $model->cliente_telefono = "";
                    $model->cliente_codigo = $microtime;
                    $model->cliente_estado = 1;
                    $result = $this->cliente->guardar_cliente($model);
                    if($result == 1){
                        $cliente = $this->cliente->listar_cliente_x_numero($_POST['client_number']);
                        $id_cliente = $cliente->id_cliente;
                    }else{
                        $result = 5;
                    }
                }

                if($result == 1){
                    $buscar_suscri = $this->suscripcion->buscar_suscripcion_activa_cliente($id_cliente, $_POST['membresia_inicio']);
                    if(isset($buscar_suscri->id_suscripcion)){
                        $result = 5;
                    } else {
                        //Primero calculamos la cantidad de servicio a agregar
                        $cantidad_servicio = $_POST['membresia_cantidad'];
                        $fecha_inicio = $_POST['membresia_inicio'];
                        $fecha_fin = date('Y-m-d', strtotime($fecha_inicio . ' + ' . $cantidad_servicio . ' months'));
                        $fecha_fin = date('Y-m-d', strtotime($fecha_fin . ' - 1 days '));

                        $fecha_registro = date('Y-m-d H:i:s');
                        $model_s = new Suscripciones();
                        $model_s->id_cliente = $id_cliente;
                        $model_s->id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                        $model_s->id_horario = $_POST['id_horario'];
                        $model_s->suscripcion_total = 1;
                        $model_s->suscripcion_inicio = $fecha_inicio;
                        $model_s->suscripcion_fin = $fecha_fin;
                        $model_s->suscripcion_fin_actual = $fecha_fin;
                        $model_s->suscripcion_costo = 0;
                        $model_s->suscripcion_pagado = 0;
                        $model_s->suscripcion_registro = $fecha_registro;
                        $result = $this->suscripcion->registrar_suscripcion($model_s);
                    }

                }
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "cliente" => $cliente)));
    }

    public function guardar_ficha(){
        //Array donde vamos a recetar los cambios, en caso hagamos alguno
        $cliente = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_cliente', 'POST', true, $ok_data, 11, 'numero', 0);
            $ok_data = $this->validar->validar_parametro('ficha_peso', 'POST', true, $ok_data, 11, 'numero', 1);
            $ok_data = $this->validar->validar_parametro('ficha_cintura', 'POST', true, $ok_data, 11, 'numero', 1);
            $ok_data = $this->validar->validar_parametro('ficha_cadera', 'POST', true, $ok_data, 11, 'numero', 1);
            $ok_data = $this->validar->validar_parametro('ficha_pecho', 'POST', true, $ok_data, 11, 'numero', 1);
            $ok_data = $this->validar->validar_parametro('ficha_brazo', 'POST', true, $ok_data, 11, 'numero', 1);
            $ok_data = $this->validar->validar_parametro('ficha_estatura', 'POST', true, $ok_data, 11, 'numero', 1);
            $ok_data = $this->validar->validar_parametro('ficha_grupo_sanguineo', 'POST', true, $ok_data, 3, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('ficha_columna', 'POST', true, $ok_data, 2, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('ficha_columna_comentario', 'POST', false, $ok_data, 2000, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('ficha_cardiacos', 'POST', true, $ok_data, 2, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('ficha_cardiacos_comentarios', 'POST', false, $ok_data, 2000, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('ficha_lesiones', 'POST', true, $ok_data, 2, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('ficha_lesiones_comentarios', 'POST', false, $ok_data, 2000, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('ficha_medicamentos', 'POST', true, $ok_data, 2, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('ficha_medicamentos_comentarios', 'POST', false, $ok_data, 2000, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('ficha_mareos', 'POST', true, $ok_data, 2, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('ficha_mareos_comentarios', 'POST', false, $ok_data, 2000, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('ficha_enfermedades', 'POST', false, $ok_data, 2000, 'texto', 0);
            //Validacion de datos
            if ($ok_data) {
                $model = new Suscripciones();
                if(isset($_POST['id_ficha'])){
                    $model->id_cliente = $_POST['id_ficha'];
                }
                $model->id_cliente = $_POST['id_cliente'];
                $model->ficha_peso = $_POST['ficha_peso'];
                $model->ficha_cintura = $_POST['ficha_cintura'];
                $model->ficha_cadera = $_POST['ficha_cadera'];
                $model->ficha_pecho = $_POST['ficha_pecho'];
                $model->ficha_brazo = $_POST['ficha_brazo'];
                $model->ficha_estatura = $_POST['ficha_estatura'];
                $model->ficha_grupo_sanguineo = $_POST['ficha_grupo_sanguineo'];
                $model->ficha_columna = $_POST['ficha_columna'];
                $model->ficha_columna_comentario = $_POST['ficha_columna_comentario'];
                $model->ficha_cardiacos = $_POST['ficha_cardiacos'];
                $model->ficha_cardiacos_comentarios = $_POST['ficha_cardiacos_comentarios'];
                $model->ficha_lesiones = $_POST['ficha_lesiones'];
                $model->ficha_lesiones_comentarios = $_POST['ficha_lesiones_comentarios'];
                $model->ficha_medicamentos = $_POST['ficha_medicamentos'];
                $model->ficha_medicamentos_comentarios = $_POST['ficha_medicamentos_comentarios'];
                $model->ficha_mareos = $_POST['ficha_mareos'];
                $model->ficha_mareos_comentarios = $_POST['ficha_mareos_comentarios'];
                $model->ficha_enfermedades = $_POST['ficha_enfermedades'];
                $model->ficha_creacion = date('Y-m-d H:i:s');
                $result = $this->suscripcion->guardar_ficha($model);
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "cliente" => $cliente)));
    }

    public function eliminar_ficha(){
        //Array donde vamos a recetar los cambios, en caso hagamos alguno
        $cliente = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_ficha', 'POST', true, $ok_data, 11, 'numero', 0);
            //Validacion de datos
            if ($ok_data) {
                //Eliminamos el receta

                $result = $this->suscripcion->eliminar_ficha($_POST['id_ficha']);
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "cliente" => $cliente)));
    }

    public function notificar_vencimiento_cliente(){
        $result = 2;
        try{
            $suscripcion = $this->suscripcion->listar_suscripcion_cliente($_POST['id_suscripcion']);
            if(!empty($suscripcion->cliente_correo)){
                $modelo = new Suscripciones();
                $modelo->cabecera_correo = _TITLE_ . ': Notificación de Vencimiento de Suscripcion';
                $modelo->email = $suscripcion->cliente_correo;
                $modelo->archivo = null;
                $modelo->titulo = 'Tu suscripción esta por vencer';
                $modelo->titulo_mensaje = "Hola, tenemos que informarte algo";
                $modelo->correo_mensaje = "
                 Hola ".$suscripcion->cliente_nombre.", queremos informarte que a la fecha del ".date('d-m-Y', strtotime($_POST['fecha_consulta'])).", tu suscripción en "._TITLE_." está por 
                 cadudar proximamente, especificamente el día ".date('d-m-Y', strtotime($suscripcion->suscripcion_fin_actual)).".<br>
                 Por favor, acercarte a nuestras instalaciones para renovar tu suscripción.<br><br>
                 Att. La Gerencia
                ";
                $result = $this->enviar_correo($modelo);
            } else {
                $result = 2;
            }
        } catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            //$message = $e->getMessage();
        }
        //Retornamos el json
        $respuesta = array("result" => $result);
        echo json_encode($respuesta);
    }

    function enviar_correo($modelo){
        $result = 2;
        //Detalle de modelo:
        //$modelo->cabecera_correo = Cabecera de correo, lo que lee el receptor antes de abrir el correo
        //$modelo->email = Email a quien se enviará el correo
        //$modelo->archivo = Archivo adjunto con el correo
        //$modelo->titulo = Titulo del correo
        //$modelo->titulo_mensaje = Titulo dentro del correo
        //$modelo->correo_mensaje = Mensaje del correo
        //Codigo para enviar correo
        //Inicio de Correo
        $mail = new PHPMailer(true);
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'mail.guabba.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'notificaciones.bufeotec@guabba.com';                     //SMTP username
        $mail->Password   = 'HuevitoElCanrgy';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('notificaciones.bufeotec@guabba.com', utf8_decode($modelo->cabecera_correo));
        //$mail->addAddress($_POST['correo']);     //Add a recipient
        //$this->log->insert('PHPMAILPRE: EMAIL DE ENVIO :' . strtolower($persona_impugnacion->user_email), date('d-m-Y H:i:s'));
        $mail->addAddress(strtolower($modelo->email));   //Add a recipient
        //$mail->addCC('test_bufeotec@brunner.com.pe');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        if($modelo->archivo != null){
            $mail->addAttachment($modelo->archivo);    //Optional name
        }
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = utf8_decode($modelo->titulo);
        $correo_atendido = "";
        require 'app/view/correo_plantilla.php';
        $mail->Body    = utf8_decode($correo_atendido);
        if($mail->send()){
            $result = 1;
        } else {
            $result = 2;
        }

        return $result;
    }

    public function editar_suscripcion_creada(){
        //Array donde vamos a recetar los cambios, en caso hagamos alguno
        $cliente = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_suscripcion', 'POST', true, $ok_data, 11, 'numero', 0);
            //Validacion de datos
            if ($ok_data) {
                //Editamos
                $model = new Suscripciones();
                $model->suscripcion_inicio = $_POST['suscripcion_inicio'];
                $model->suscripcion_fin_actual = $_POST['suscripcion_fin_actual'];
                $model->id_horario = $_POST['id_horario'];
                $model->suscripcion_comentario = $_POST['suscripcion_comentario'];
                $model->id_suscripcion = $_POST['id_suscripcion'];
                $result = $this->suscripcion->editar_suscripcion_creada($model);
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "cliente" => $cliente)));
    }
}
