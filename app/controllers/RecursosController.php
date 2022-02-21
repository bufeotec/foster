<?php
require 'app/models/Archivo.php';
require 'app/models/Recursos.php';
require 'app/models/Insumos.php';
require 'app/models/Categorias.php';
require 'app/models/Receta.php';
class RecursosController
{
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $archivo;
    private $recursos;
    private $insumos;
    private $categorias;
    private $receta;

    public function __construct()
    {
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
        $this->archivo = new Archivo();
        $this->recursos = new Recursos();
        $this->insumos = new Insumos();
        $this->categorias = new Categorias();
        $this->receta = new Receta();

    }


    public function categorias(){
        try{
            //Llamamos a la clase del Navbar, que sólo se usa
            // en funciones para llamar vistas y la instaciamos
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);

            $negocio = $this->recursos->listar_negocios($id_usuario);
            $categoria = $this->recursos->listar_categorias();
            $nego_cate = $this->recursos->listar_info();
            //Hacemos el require de los archivos a usar en las vistas
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'recursos/gestionar_categorias.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }


    public function recursos(){
        try{
            //Llamamos a la clase del Navbar, que sólo se usa
            // en funciones para llamar vistas y la instaciamos
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));

            $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);

            $sucursal = $this->recursos->listar_sucursales($id_usuario);

            $categoria = $this->recursos->listar_categorias();
            $recurso_sede = $this->recursos->listar_recursos_sede();
            $unidad_medida = $this->recursos->listar_unidad_medida();
            //Hacemos el require de los archivos a usar en las vistas
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'recursos/gestionar_recursos.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }


    //FUNCIONES
    public function guardar_categoria(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_negocio', 'POST',true,$ok_data,11,'texto',0);
            //Validacion de datos
            if($ok_data) {
                $model = new Recursos();
                $fecha = date('Y-m-d H:i:s');
                $model->categoria_nombre = $_POST['categoria_nombre'];
                $model->categoria_fecha_registro = $fecha;
                $model->categoria_estado = 1;

                $result = $this->categorias->guardar_categorias($model);

                if($result == 1){
                    $jalar_id_categoria = $this->recursos->jalar_id_ultima_categoria();
                    $id_categoria = $jalar_id_categoria->id_categoria;
                    $fecha = date('Y-m-d H:i:s');
                    $id_usuario_creacion = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                    $model->id_usuario_creacion = $id_usuario_creacion;
                    $model->id_negocio = $_POST['id_negocio'];
                    $model->id_categoria = $id_categoria;
                    $model->recurso_categoria_estado = 1;
                    $model->recurso_categoria_fecha = $fecha;

                    $result = $this->recursos->guardar_categoria($model);
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


    public function listar_categoria_por_id(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app

        try{
                $id_categoria = $_POST['id_categoria'];
                $result = $this->recursos->listar_recursos_categoria($id_categoria);
                $datos = "<select class='form-control' id='id_recurso' name='id_recurso'>";
            if(empty($result)){
                $datos = "<option value=''>No hay Registros</option>";
            }else{
                foreach($result as $c){
                    $datos.="<option value='". $c->id_recurso."'>". $c->recurso_nombre."</option>";
                }
            }
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode($datos);
    }


    public function jalar_categorias(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app

        try{
            $id_sucursal = $_POST['id_sucursal'];
            $result = $this->recursos->jalar_categorias($id_sucursal);

            $datos_categoria = "<select class='form-control' id='id_categoria' name='id_categoria'>";
            $datos_categoria.="<option value=''>Seleccionar</option>";
            foreach($result as $c){
                if($c->id_categoria==9){
                    $sele='selected';
                }else{
                    $sele='';
                }
                $datos_categoria.="<option value='". $c->id_categoria."' ".$sele." >". $c->categoria_nombre."</option>";
            }
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode($datos_categoria);
    }


    public function guardar_recursos(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_sucursal', 'POST',true,$ok_data,11,'texto',0);

            //Validacion de datos
            if($ok_data) {
                $model = new Recursos();
                $id_ne = 1;
                $id_categoria = $_POST['id_categoria'];
                $recurso_nombre = $_POST['recurso_nombre'];

                if($id_ne == 1){
                    $model = new Recursos();
                    $model->id_categoria = $id_categoria;
                    $model->recurso_nombre = $recurso_nombre;
                    $model->recurso_estado = 1;
                    $result = $this->insumos->guardar_insumos($model);
                    if($result == 1){
                        $ultomoid = $this->recursos->jalar_ultimo_id();
                        $model->id_recurso = $ultomoid->id_recurso;
                    }else{
                        $model->id_recurso = 0;
                    }
                }else{
                    $model->id_recurso = $_POST['id_recurso'];
                }
                if($model->id_recurso!=0){
                    $fecha = date('Y-m-d H:i:s');
                    $id_usuario_creacion = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                    $model->id_usuario_creacion = $id_usuario_creacion;
                    $model->id_sucursal = $_POST['id_sucursal'];
                    $model->id_medida = $_POST['id_medida'];
                    $model->recurso_sede_precio = $_POST['recurso_sede_precio'];
                    $model->recurso_sede_stock = $_POST['recurso_sede_stock'];
                    $model->recurso_sede_stock_minimo = $_POST['recurso_sede_stock_minimo'];
                    $model->recurso_sede_estado = 1;
                    $model->recurso_sede_fecha = $fecha;
                    $result = $this->recursos->guardar_recurso($model);
                    //INICIO - GUARDAR EN RECETA
                    if($id_categoria == 9 && $result==1){
                        $model = new Receta();
                        $microtime = microtime(true);
                        $model->receta_nombre = $recurso_nombre;
                        //$model->receta_fecha = $_POST['receta_fecha'];
                        $model->receta_estado = 1;
                        $model->id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                        $model->recetacodigo = $microtime;
                        //Guardamos el menú y recibimos el resultado
//                        $model->receta_estado = $_POST['receta_estado'];
                        $result = $this->receta->guardar_receta($model);
                        if($result == 1){
                            $listar_receta = $this->receta->listar_receta_x_mt($microtime);
                            $listar_recurso_sede = $this->recursos->listar_recurso_sede_x_fecha($fecha);
                            //Creamos el modelo y ingresamos los datos a guardar
                            $model = new Receta();
                            $model->id_receta = $listar_receta->id_receta;
                            $model->id_recursos_sede = $listar_recurso_sede->id_recurso_sede;
                            $model->detalle_receta_unidad_medida = null;
                            $model->detalle_receta_cantidad = 1;
                            $model->detalle_receta_precio = $listar_recurso_sede->recurso_sede_precio;
                            $model->detalle_receta_estado = 1;
                            $result = $this->receta->guardar_detalle_receta($model);
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



    public function cambiar_estado_recurso(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_recurso_sede', 'POST',true,$ok_data,11,'texto',0);
            $ok_data = $this->validar->validar_parametro('recurso_sede_estado', 'POST',true,$ok_data,11,'numero',0);

            //Validacion de datos
            if($ok_data) {

                $id_recurso_sede = $_POST['id_recurso_sede'];
                $recurso_sede_estado = $_POST['recurso_sede_estado'];

                $result = $this->recursos->cambiar_estado_recurso($id_recurso_sede, $recurso_sede_estado);

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


    public function cambiar_estado_categoria(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_categoria_negocio', 'POST',true,$ok_data,11,'texto',0);
            $ok_data = $this->validar->validar_parametro('recurso_categoria_estado', 'POST',true,$ok_data,11,'numero',0);

            //Validacion de datos
            if($ok_data) {

                $id_categoria_negocio = $_POST['id_categoria_negocio'];
                $recurso_categoria_estado = $_POST['recurso_categoria_estado'];

                $result = $this->recursos->cambiar_estado_categoria($id_categoria_negocio, $recurso_categoria_estado);

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


    public function editar_stock_minimo(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            if($ok_data) {
                $id_recurso_sede = $_POST['id_recurso_sede'];
                $recurso_sede_stock_minimo = $_POST['recurso_sede_stock_minimo_e'];

                $result = $this->recursos->editar_stock_minimo($id_recurso_sede, $recurso_sede_stock_minimo);
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