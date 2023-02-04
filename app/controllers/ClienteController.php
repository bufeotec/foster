<?php
/**
 * Created by PhpStorm
 * User: Franz
 * Date: 22/03/2021
 * Time: 09:53
 */

require 'app/models/Cliente.php';
class ClienteController
{
    //Variables especificas del controlador
    private $cliente;
    //Variables fijas para cada llamada al controlador
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;

    public function __construct()
    {
        //Instancias especificas del controlador
        $this->cliente = new Cliente();
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
    }

    public function inicio(){
        try{
            //Llamamos a la clase del Navbar, que sólo se usa
            // en funciones para llamar vistas y la instaciamos
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            //Listamos los clientes del sistema
            $clientes = $this->cliente->listar_cliente();
            $tipos_documento = $this->cliente->listar_tipos_documentos();
            //Hacemos el require de los archivos a usar en las vistas
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'cliente/inicio.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function inscritos(){
        try{
            //Llamamos a la clase del Navbar, que sólo se usa
            // en funciones para llamar vistas y la instaciamos
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            //Listamos los clientes del sistema
            $clientes = $this->cliente->listar_cliente_inscritos();
            $tipos_documento = $this->cliente->listar_tipos_documentos();
            //Hacemos el require de los archivos a usar en las vistas
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'cliente/inscritos.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    //FUNCIONES
    public function guardar_cliente(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            //$ok_data = $this->validar->validar_parametro('cliente_nombre', 'POST',true,$ok_data,200,'texto',0);
            $ok_data = $this->validar->validar_parametro('cliente_numero', 'POST',true,$ok_data,15,'numero',0);

            //Validacion de datos
            if($ok_data){
                $model = new Cliente();

                if($this->cliente->validar_dni($_POST['cliente_numero'])){
                    //Código 5: DNI duplicado
                    $result = 5;
                    $message = "Ya existe un cliente con este DNI registrado";
                } else {
                    $microtime = microtime(true);
                    $model->id_tipodocumento = $_POST['id_tipodocumento'];
                    $model->cliente_razonsocial = $_POST['cliente_razonsocial'];
                    $model->cliente_nombre = $_POST['cliente_nombre'];
                    //$model->cliente_apellido_paterno = $_POST['cliente_apellido_paterno'];
                    //$model->cliente_apellido_materno = $_POST['cliente_apellido_materno'];
                    $model->cliente_numero = $_POST['cliente_numero'];
                    $model->cliente_correo = $_POST['cliente_correo'];
                    $model->cliente_direccion = $_POST['cliente_direccion'];
                    $model->cliente_direccion_2 = $_POST['cliente_direccion_2'];
                    $model->cliente_telefono = $_POST['cliente_telefono'];
                    if(empty($_POST['cliente_fecha_nacimiento'])){
                        $model->cliente_fecha_nacimiento = null;
                    } else {
                        $model->cliente_fecha_nacimiento = $_POST['cliente_fecha_nacimiento'];
                    }
                    $model->cliente_codigo = $microtime;
                    $model->cliente_estado = 1;
                    $result = $this->cliente->guardar_cliente($model);
                }

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

    //PARA DELIVERY
    public function guardar_cliente_nuevo(){
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
                $model = new Cliente();

                if($this->cliente->validar_dni($_POST['cliente_numero'])){
                    //Código 5: DNI duplicado
                    $result = 5;
                    $message = "Ya existe un cliente con este DNI registrado";
                } else {
                    $microtime = microtime(true);
                    $model->id_tipodocumento = $_POST['id_tipodocumento'];
                    $model->cliente_razonsocial = $_POST['cliente_razonsocial'];
                    $model->cliente_nombre = $_POST['cliente_nombre'];
                    $model->cliente_numero = $_POST['cliente_numero'];
                    $model->cliente_correo = $_POST['cliente_correo'];
                    $model->cliente_direccion = $_POST['cliente_direccion'];
                    $model->cliente_direccion_2 = $_POST['cliente_direccion_2'];
                    $model->cliente_telefono = $_POST['cliente_telefono'];
                    $model->cliente_codigo = $microtime;
                    $model->cliente_estado = 1;
                    $result = $this->cliente->guardar_cliente($model);
                }

                if($result == 1){
                   $dato_ultimo_cliente = $this->cliente->jalar_ultimo_cliente();
                }

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


    public function guardar_edicion_cliente(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            //$ok_data = $this->validar->validar_parametro('cliente_nombre_e', 'POST',true,$ok_data,200,'texto',0);
            $ok_data = $this->validar->validar_parametro('cliente_numero_e', 'POST',true,$ok_data,15,'numero',0);
            $ok_data = $this->validar->validar_parametro('id_tipodocumento_e', 'POST',true,$ok_data,11,'numero',0);

            $ok_data = $this->validar->validar_parametro('id_cliente', 'POST',true,$ok_data,11,'numero',0);

            //Validacion de datos
            if($ok_data){
                $model = new Cliente();
                $clientito = $this->cliente->listar_cliente_id($_POST['id_cliente']);
                $model->id_cliente = $_POST['id_cliente'];
                $model->id_tipodocumento = $_POST['id_tipodocumento_e'];
                $model->cliente_razonsocial = $_POST['cliente_razonsocial_e'];
                $model->cliente_nombre = $_POST['cliente_nombre_e'];
                $model->cliente_apellido_paterno = $_POST['cliente_apellido_paterno_e'];
                $model->cliente_apellido_materno = $_POST['cliente_apellido_materno_e'];
                $model->cliente_numero = $_POST['cliente_numero_e'];
                $model->cliente_correo = $_POST['cliente_correo_e'];
                $model->cliente_direccion = $_POST['cliente_direccion_e'];
                $model->cliente_direccion_2 = $_POST['cliente_direccion_2_e'];
                $model->cliente_telefono = $_POST['cliente_telefono_e'];
                if(empty($_POST['cliente_fecha_nacimiento_e'])){
                    $model->cliente_fecha_nacimiento = null;
                } else {
                    $model->cliente_fecha_nacimiento = $_POST['cliente_fecha_nacimiento_e'];
                }
                $model->cliente_estado = $_POST['cliente_estado_e'];

                if ($_FILES['cliente_foto']['tmp_name'] != null) {
                    //Procesar Nombre Archivo
                    $info = pathinfo($_FILES['cliente_foto']['name']);
                    $ext = $info['extension']; // Estraemos la extención del archivo
                    $docum_nombre = date('Y_m_d_H_i_s'). "_" . $_POST['id_cliente'] . "." . $ext;
                    $directorio = "media/persona/";
                    $ruta = $directorio . $docum_nombre;
                    if (move_uploaded_file($_FILES['cliente_foto']['tmp_name'], $ruta)) {
                        $model->cliente_foto = $ruta;
                    } else {
                        $model->cliente_foto = $clientito->cliente_foto;
                    }
                }
                $result = $this->cliente->guardar_cliente($model);
            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    //Funcion para Eliminar cliente
    public function eliminar_cliente()
    {
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
            //Validacion de datos
            if ($ok_data) {
                //Eliminamos el cliente (solo se cambia de estado)

                $result = $this->cliente->eliminar_cliente_cambio_estado($_POST['id_cliente']);
                //$result = $this->cliente->eliminar_cliente($_POST['id_cliente']);
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

    public function obtener_datos_x_dni(){
        //Array donde vamos a recetar los cambios, en caso hagamos alguno
        $cliente = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        $datos = [];
        try {
            $dni = $_POST['numero_dni'];
            $buscar_cliente = $this->cliente->listar_cliente_x_numero($_POST['numero_dni']);
            if(isset($buscar_cliente->id_cliente)){
                $dni	= $buscar_cliente->cliente_numero;
                $nombre = $buscar_cliente->cliente_nombre;
                $paterno = "";
                $materno = "";
            } else {
                /*$ws = "https://dni.optimizeperu.com/api/persons/$dni?format=json";
                $header = array();

                $ch = curl_init();
                curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,1);
                curl_setopt($ch,CURLOPT_URL,$ws);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                curl_setopt($ch,CURLOPT_HTTPAUTH,CURLAUTH_ANY);
                curl_setopt($ch,CURLOPT_TIMEOUT,30);
                curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
                //para ejecutar los procesos de forma local en windows
                //enlace de descarga del cacert.pem https://curl.haxx.se/docs/caextract.html
                curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__)."/../models/cacert.pem");

                $datos = curl_exec($ch);
                curl_close($ch);
                $datos = json_decode($datos);*/
                $result = json_decode(file_get_contents('https://consultaruc.win/api/dni/'.$dni),true);

                //var_dump($result);

                $dni	= $result['result']['DNI'];
                $nombre = $result['result']['Nombre'];
                $paterno = $result['result']['Paterno'];
                $materno = $result['result']['Materno'];
                //echo $result['result']['estado'];
            }

            $datos = array(
                'dni' => $dni,
                'name' => $nombre,
                'first_name' => $paterno,
                'last_name' => $materno,
            );

            //$datos = json_decode($datos);

        } catch (Exception $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => $datos));
    }

    public function obtener_datos_suscripcion(){
        //Array donde vamos a recetar los cambios, en caso hagamos alguno
        $cliente = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        try {
            $ok_data = true;
            $cliente = $this->cliente->listar_cliente_x_numero($_POST['numero_dni']);
            $suscripcion = $this->cliente->buscar_ultima_suscripcion_cliente($cliente->id_cliente);
            if(isset($suscripcion->suscripcion_fin_actual)){
                $campo_fecha = "<input class=\"form-control\" type=\"date\" id=\"membresia_inicio\" name=\"membresia_inicio\" value=\"".date('Y-m-d', strtotime($suscripcion->suscripcion_fin_actual . ' + 1 days'))."\">";
                $datos = array(
                    'ultima_fecha' => $suscripcion->suscripcion_fin_actual,
                    'nueva_fecha' => date('Y-m-d', strtotime($suscripcion->suscripcion_fin_actual . ' + 1 days')),
                    'nueva_fecha_campo' => $campo_fecha,
                    'horario' => date('h:i a', strtotime($suscripcion->horario_inicio)) . ' - ' . date('h:i a', strtotime($suscripcion->horario_fin)),
                    'id_horario' => $suscripcion->id_horario
                );
            } else {
                $campo_fecha = "<input class=\"form-control\" type=\"date\" id=\"membresia_inicio\" name=\"membresia_inicio\" value=\"".date('Y-m-d')."\">";
                $datos = array(
                    'ultima_fecha' => "PRIMERA VEZ",
                    'nueva_fecha' => date('Y-m-d'),
                    'nueva_fecha_campo' => $campo_fecha,
                    'horario' => "PRIMERA VEZ",
                    'id_horario' => "1"
                );
            }
            $result = 1;
            //$datos = json_decode($datos);

        } catch (Exception $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
        }
        //Retornamos el json
        echo json_encode(array("result" => $result, "datos" => $datos));
    }
    public function obtener_datos_x_ruc(){
        //Array donde vamos a recetar los cambios, en caso hagamos alguno
        $cliente = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            $ruc = $_POST['numero_ruc'];
            $result = json_decode(file_get_contents('https://consultaruc.win/api/ruc/'.$ruc),true);
            $datos = array(
                'razon_social' => $result['result']['razon_social'],
                'estado' => $result['result']['estado'],
                'condicion' => $result['result']['condicion'],
            );

        } catch (Exception $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
            $result= [];
        }
        //Retornamos el json
        echo json_encode(array("result" => $datos));
    }

}


