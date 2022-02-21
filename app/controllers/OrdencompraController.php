<?php
require 'app/models/Ordencompra.php';
require 'app/models/Archivo.php';
require 'app/models/Usuario.php';
require 'app/models/Rol.php';
require 'app/models/Recursos.php';
require 'app/models/Cliente.php';
class OrdencompraController
{
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $archivo;
    private $usuario;
    private $rol;

    private $ordencompra;
    private $recursos;
    private $cliente;

    public function __construct()
    {
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
        $this->archivo = new Archivo();

        $this->usuario = new Usuario();
        $this->rol = new Rol();

        $this->ordencompra = new Ordencompra();
        $this->recursos = new Recursos();
        $this->cliente = new Cliente();

    }

    public function orden_compra(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);

            $sucursal = $this->ordencompra->listar_sucursal($id_usuario);

            $proveedor = $this->ordencompra->listar_proveedor($id_usuario);
            $negocio = $this->recursos->listar_negocios($id_usuario);
            $tipos_documento = $this->cliente->listar_tipos_documentos();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ordencompra/orden_compra.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function orden_pendiente(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            $orden = $this->ordencompra->listar_info();

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ordencompra/orden_pendiente.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function orden_aprobada(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $datos = false;
            if(isset($_GET['id'])){
                $exp = explode('020',$_GET['id']);
                $param="";
                for ($i=0;$i<count($exp);$i++){
                    ($i==count($exp)-1)?$param.=$exp[$i]:$param.=$exp[$i]." ";
                }
                $orden_aprobada = $this->ordencompra->listar_aprobados($param);
                $parametro = $param;
                $datos = true;
            }else{
                $parametro = "";
                $orden_aprobada = $this->ordencompra->listar_aprobados_();
                $datos = true;
            }
            //$orden_aprobada = $this->ordencompra->listar_aprobados();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ordencompra/orden_aprobada.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function ver_facturas(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $datos = false;
            if(isset($_POST['parametro'])){
                $facturas = $this->ordencompra->datos_facturas($_POST['parametro']);
                $parametro = $_POST['parametro'];
                $datos = true;
            } else {
                $facturas = $this->ordencompra->datos_facturas_todo();
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ordencompra/ver_facturas.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function facturas_sin_oc(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            $proveedor = $this->ordencompra->listar_proveedores();
            $recurso = $this->ordencompra->listar_recursos();
            $tipo_pago = $this->ordencompra->listar_tipo_pago();
            $negocio = $this->recursos->listar_negocios_();
            $tipos_documento = $this->cliente->listar_tipos_documentos();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ordencompra/facturas_sin_oc.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function detalle_orden_compra(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            } else {
                throw new Exception('ID NO DECLARADO');
            }
            $datos = $this->ordencompra->listar_datos($id);

            $listar_total = $this->ordencompra->total($id);

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ordencompra/detalle_orden_compra.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function orden_editar(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            } else {
                throw new Exception('ID NO DECLARADO');
            }
            $datos = $this->ordencompra->listar_datos($id);
            $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);

            $sucursal = $this->ordencompra->listar_sucursal($id_usuario);

            $proveedor = $this->ordencompra->listar_proveedor($id_usuario);
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ordencompra/orden_editar.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }


    public function recepcion_orden(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            } else {
                throw new Exception('ID NO DECLARADO');
            }
            $datos = $this->ordencompra->listar_datos($id);
            $tipo_pago = $this->ordencompra->listar_tipo_pago();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ordencompra/recepcion_orden.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }


    //FUNCIONES
    public function listar_recursos_x_sucursal(){
        try{
            $id_sucursal = $_POST['id_sucursal'];
            $result = $this->ordencompra->listar_recursos_sucursal($id_sucursal);

        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        $data = array("result" => $result);
        echo json_encode($data);
    }


    public function guardar_orden(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validacion de datos
            $ok_data = $this->validar->validar_parametro('orden_compra_titulo', 'POST',true,$ok_data,200,'texto',0);
            if($ok_data) {
                $model = new Ordencompra();
                $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                $microtime = microtime(true);
                $fecha = date('Y-m-d H:i:s');
                $model->id_solicitante = $id_usuario;
                $model->id_aprobacion = 0;
                $model->orden_compra_fecha_aprob = "";
                $model->orden_compra_activo = 0;
                $model->orden_compra_titulo = $_POST['orden_compra_titulo'];
                $model->id_proveedor = $_POST['id_proveedor'];
                $model->id_sucursal = $_POST['id_sucursal'];
                $model->orden_compra_codigo = $microtime;
                $model->orden_compra_fecha = $fecha;
                $model->orden_compra_estado = 0;
                $model->orden_compra_numero = 0;
                $result = $this->ordencompra->guardar_orden_compra($model);

                if($result == 1){
                    $contenido = $_POST['contenido'];
                    if(count_chars($contenido)>0){
                        $filas=explode('/./.',$contenido);
                        $datos_orden = $this->ordencompra->listar_orden_por_mt($microtime);
                        if(count($filas)>0){
                            for ($i=0;$i<count($filas)-1;$i++){
                                $modelDSI=new Ordencompra();
                                $celdas=explode('-.-.',$filas[$i]);
                                $modelDSI->id_orden_compra = $datos_orden->id_orden_compra;
                                $modelDSI->id_recurso_sede = $celdas[0];
                                $modelDSI->detalle_compra_cantidad = $celdas[2];
                                $modelDSI->detalle_compra_precio_compra = $celdas[3];
                                $modelDSI->detalle_compra_total_pedido = $celdas[4];
                                $modelDSI->detalle_compra_estado = 0;
                                $result = $this->ordencompra->guardar_detalle_compra($modelDSI);
                            }
                        }
                    }
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

    public function guardar_compra_rapida(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('orden_compra_doc_adjuntado', 'FILES',false,$ok_data,40,['jpg','png','pdf','word','excel'],['jpg','png','pdf','word','excel']);
            if($ok_data) {
                $model = new Ordencompra();
                if($this->ordencompra->validar_numero_factura($_POST['orden_compra_numero_doc'])){
                    $result = 5;
                }else{
                    $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                    $microtime = microtime(true);
                    $fecha = date('Y-m-d H:i:s');
                    $model->id_solicitante = $id_usuario;
                    $model->id_aprobacion = $id_usuario;
                    $model->id_sucursal = 4;
                    $model->orden_compra_fecha_aprob = $fecha;
                    $model->orden_compra_activo = 0;
                    $model->orden_compra_titulo = "Generado por Compra Rapida";
                    $model->id_proveedor = $_POST['id_proveedor'];

                    $numero_orden = $this->ordencompra->listar_orden_numero();
                    if(isset($numero_orden->id_orden_compra)){
                        $model->orden_compra_numero = $numero_orden->orden_compra_numero + 1;
                    }else{
                        $model->orden_compra_numero = 100001;
                    }
                    $model->orden_compra_estado = 1;
                    $model->orden_compra_fecha = $fecha;
                    //LO QUE FALTABA
                    $model->id_tipo_pago = $_POST['id_tipo_pago'];
                    $model->orden_compra_observacion = "---";
                    $model->orden_compra_tipo_doc = $_POST['orden_compra_tipo_doc'];
                    $model->orden_compra_numero_doc = $_POST['orden_compra_numero_doc'];

                    if($_FILES['orden_compra_doc_adjuntado']['name'] != null) {
                        //Conseguimos la extension del archivo y especificamos la ruta
                        $ext = pathinfo($_FILES['orden_compra_doc_adjuntado']['name'], PATHINFO_EXTENSION);
                        $file_path = "media/documentos/" . '_' .date('dmYHis') . "." . $ext;
                        //Para subir archivos en general o imagenes sin comprimir
                        //if(move_uploaded_file($_FILES['usuario_imagenp']['tmp_name'], $file_path)){
                        //Para subir imagenes comprimidas
                        if($this->archivo->subir_imagen_comprimida($_FILES['orden_compra_doc_adjuntado']['tmp_name'], $file_path,false)){
                            $model->orden_compra_doc_adjuntado = $file_path;
                        } else {
                            $model->orden_compra_doc_adjuntado = 'media/documentos/sin_foto.jpg';
                        }
                    }else {
                        $model->orden_compra_doc_adjuntado = 'media/documentos/sin_foto.jpg';
                    }
                    $model->orden_compra_fecha_emision_doc = $_POST['orden_compra_fecha_emision_doc'];
                    $model->orden_compra_doc_cuotas = $_POST['orden_compra_doc_cuotas'];
                    $model->orden_compra_fecha_recibida = $fecha;
                    $model->orden_compra_usuario_recibido = $id_usuario;
                    $model->orden_compra_codigo = $microtime;
                    $result = $this->ordencompra->guardar_orden_compra_rapida($model);

                    if($result == 1){
                        $contenido = $_POST['contenido'];
                        if(count_chars($contenido)>0){
                            $filas=explode('/./.',$contenido);
                            $datos_orden = $this->ordencompra->listar_orden_por_mt($microtime);
                            if(count($filas)>0){
                                for ($i=0;$i<count($filas)-1;$i++){
                                    $modelDSI=new Ordencompra();
                                    $celdas=explode('-.-.',$filas[$i]);
                                    $id_recurso_sede = $celdas[0];
                                    $recurso_sede_precio = $celdas[3];
                                    $detalle_compra_cantidad_recibida = $celdas[2];
                                    $modelDSI->id_orden_compra = $datos_orden->id_orden_compra;
                                    $modelDSI->id_recurso_sede = $id_recurso_sede;
                                    $modelDSI->detalle_compra_cantidad = $celdas[2];
                                    $modelDSI->detalle_compra_cantidad_recibida = $celdas[2];
                                    $modelDSI->detalle_compra_precio_compra = $celdas[3];
                                    $modelDSI->detalle_compra_total_pedido = $celdas[4];

                                    $modelDSI->detalle_compra_tipo_moneda = "";
                                    $modelDSI->detalle_compra_tipo_cambio = "";
                                    $modelDSI->detalle_compra_total_dolares = "";
                                    $modelDSI->detalle_compra_total_pagado = $celdas[4];

                                    $modelDSI->detalle_compra_estado = 1;

                                    $result = $this->ordencompra->guardar_detalle_compra($modelDSI);
                                    $this->ordencompra->actualizar_precio_recurso($id_recurso_sede,$recurso_sede_precio);
                                    $this->ordencompra->sumar_stock($detalle_compra_cantidad_recibida, $id_recurso_sede);

                                }
                            }
                        }
                    }
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

    public function editar_orden(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validacion de datos
            $ok_data = $this->validar->validar_parametro('orden_compra_titulo', 'POST',true,$ok_data,200,'texto',0);
            if($ok_data) {
                $model = new Ordencompra();
                $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);

                $model->id_solicitante = $id_usuario;
                $model->orden_compra_titulo = $_POST['orden_compra_titulo'];
                $model->id_sucursal = $_POST['id_sucursal'];
                $model->id_proveedor = $_POST['id_proveedor'];
                $id_orden_compra = $_POST['id_orden_compra'];
                $model->id_orden_compra = $id_orden_compra;
                $result = $this->ordencompra->guardar_orden_compra($model);

                if($result == 1){
                    $contenido = $_POST['contenido'];
                    if(count_chars($contenido)>0){
                        $filas=explode('/./.',$contenido);
                        $this->ordencompra->eliminar_detalle_compra($id_orden_compra);
                        if(count($filas)>0){
                            for ($i=0;$i<count($filas)-1;$i++){
                                $modelDSI=new Ordencompra();
                                $celdas=explode('-.-.',$filas[$i]);
                                $modelDSI->id_orden_compra = $id_orden_compra;
                                $modelDSI->id_recurso_sede = $celdas[0];
                                $modelDSI->detalle_compra_cantidad = $celdas[2];
                                $modelDSI->detalle_compra_precio_compra = $celdas[3];
                                $modelDSI->detalle_compra_total_pedido = $celdas[4];
                                $modelDSI->detalle_compra_estado = 0;
                                $result = $this->ordencompra->guardar_detalle_compra($modelDSI);
                            }
                        }
                    }
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

    public function aprobar_orden(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
            $id_orden_compra = $_POST['id_orden_compra'];
            $ind = $_POST['ind'];

            $numero_orden = $this->ordencompra->listar_orden_numero();
            if(isset($numero_orden->id_orden_compra)){
                $numero = $numero_orden->orden_compra_numero + 1;
            }else{
                $numero = 100001;
            }
            $result = $this->ordencompra->aprobar_orden($id_usuario,$ind,$numero,$id_orden_compra);
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function eliminar_orden(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_orden_compra', 'POST',true,$ok_data,11,'numero',0);
            if($ok_data) {
                $id_orden_compra = $_POST['id_orden_compra'];
                $result = $this->ordencompra->eliminar_detalle_compra($id_orden_compra);
                if($result == 1){
                    $result = $this->ordencompra->eliminar_orden($id_orden_compra);
                }
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function actualizar_recepcion(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('orden_compra_doc_adjuntado', 'FILES',false,$ok_data,40,['jpg','png','pdf','word','excel'],['jpg','png','pdf','word','excel']);
            if($ok_data) {
                if($this->ordencompra->validar_numero_factura($_POST['orden_compra_numero_doc'])){
                    //5 ES EL ERROR DE NUMERO DE FACTURA DUPLICADO
                    $result = 5;
                }else{
                    $fecha = date('Y-m-d H:i:s');
                    $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                    $id_orden_compra = $_POST['id_orden_compra'];
                    $id_tipo_pago = $_POST['id_tipo_pago'];
                    $orden_compra_observacion = $_POST['orden_compra_observacion'];
                    $orden_compra_tipo_doc = $_POST['orden_compra_tipo_doc'];
                    $orden_compra_numero_doc = $_POST['orden_compra_numero_doc'];
                    $orden_compra_fecha_emision_doc = $_POST['orden_compra_fecha_emision_doc'];
                    $orden_compra_doc_cuotas = $_POST['orden_compra_doc_cuotas'];
                    $orden_compra_fecha_recibida = $fecha;
                    $orden_compra_usuario_recibido = $id_usuario;

                    if($_FILES['orden_compra_doc_adjuntado']['name'] != null) {
                        //Conseguimos la extension del archivo y especificamos la ruta
                        $ext = pathinfo($_FILES['orden_compra_doc_adjuntado']['name'], PATHINFO_EXTENSION);
                        $file_path = "media/documentos/" . '_' .date('dmYHis') . "." . $ext;
                        //Para subir archivos en general o imagenes sin comprimir
                        //if(move_uploaded_file($_FILES['usuario_imagenp']['tmp_name'], $file_path)){
                        //Para subir imagenes comprimidas
                        if($this->archivo->subir_imagen_comprimida($_FILES['orden_compra_doc_adjuntado']['tmp_name'], $file_path,false)){
                            $orden_compra_doc_adjuntado = $file_path;
                        } else {
                            $orden_compra_doc_adjuntado = 'media/documentos/sin_foto.jpg';
                        }
                    }else {
                        $orden_compra_doc_adjuntado = 'media/documentos/sin_foto.jpg';
                    }
                    $result = $this->ordencompra->guardar_recepcion($id_tipo_pago,$orden_compra_observacion,$orden_compra_tipo_doc,$orden_compra_numero_doc,$orden_compra_fecha_recibida,$orden_compra_usuario_recibido,$orden_compra_doc_adjuntado,$orden_compra_fecha_emision_doc,$orden_compra_doc_cuotas, $id_orden_compra);
                    if($result == 1){
                        $datos_ = $_POST['datos'];
                        $datos = explode('---,',$datos_);
                        for($i=0; $i<count($datos); $i++){
                            $datitos = explode('-.-.',$datos[$i]);
                            $id_detalle_compra = $datitos[0];
                            $detalle_compra_cantidad_recibida = $datitos[1];

                            $detalle_compra_tipo_moneda = $datitos[2];
                            $detalle_compra_total_dolares = $datitos[3];

                            $detalle_compra_total_pagado = $datitos[4];

                            $detalle_compra_tipo_cambio = $datitos[6];

                            //$jalar_monto = $this->ordencompra->jalar_precio($id_detalle_compra);
                            //$precio = $jalar_monto->detalle_compra_precio_compra;

                            $jalar_detalle = $this->ordencompra->jalar_detalle($id_detalle_compra);
                            $id_recurso_sede = $jalar_detalle->id_recurso_sede;
                            $recurso_sede_precio = $datitos[5];
                            //$recurso_sede_precio = $jalar_detalle->detalle_compra_precio_compra;
                            $this->ordencompra->actualizar_precio_recurso($id_recurso_sede,$recurso_sede_precio);
                            $result = $this->ordencompra->actualizar_cantidad($detalle_compra_cantidad_recibida,$detalle_compra_tipo_moneda,$detalle_compra_tipo_cambio,$detalle_compra_total_dolares,$detalle_compra_total_pagado,$id_detalle_compra);
                            $this->ordencompra->sumar_stock($detalle_compra_cantidad_recibida,$id_recurso_sede);
                        }
                    }
                }
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }




}