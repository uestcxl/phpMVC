<?php

    /**
     * 框架基类app.php
     * Created by PhpStorm.
     * User: xl
     * Date: 15-3-17
     * Time: 下午12:24
     */

    /*系统的绝对路径*/
    define('SYSTEM_PATH', dirname(__FILE__));
    /*应用根目录路径*/
    define('ROOT_PATH', substr(SYSTEM_PATH, 0,-7));

    /*加载系统和自定义类库*/
    define('SYSTEM_CORE_PATH', SYSTEM_PATH.'/core');
    define('SYSTEM_LIB_PATH', SYSTEM_PATH.'/lib');
    define('APP_LIB_PATH', ROOT_PATH.'/lib');

    /*MVC路径*/
    define('CTL_PATH', ROOT_PATH.'/controller');
    define('MODEL_PATH', ROOT_PATH.'/model');
    define('VIEW_PATH', ROOT_PATH.'/view');

    /*定义日志文件目录*/
    define('LOG_PATH', ROOT_PATH.'/log');

    /*Application基类的实现*/
    final class Application{

        public static $_lib = null;
        public static $_config = null;

        /*
         * 初始化创建应用
         * @access public
         * @param $CONFIG
         *
         * */
        public static function run($CONFIG){
            self::$_config=$CONFIG['SYSTEM'];
            self::init();
        }

        /*
         *  @access public
         *  @param
         *
         * */
        public static function init(){
            require SYSTEM_CORE_PATH.'/model.php';
            require SYSTEM_CORE_PATH.'/controller.php';

            //设置系统类库变量
            self::setSysLib();

            //初始化系统类库
            self::loadSyslib();

            //初始化路由
            self::initRoute();

        }

        /*
         * 设置系统类库
         * @access public
         */
        public static function setSysLib(){
            self::$_lib = array(
                'Route' => SYSTEM_LIB_PATH.'/Lib_route.php',
                'Mysql' => SYSTEM_LIB_PATH.'/Lib_mysql.php',
                'Cache' => SYSTEM_LIB_PATH.'/Lib_cache.php'
            );
        }

        /*
         * 初始化类库
         * @access public
         */
        public static function loadSyslib(){
            foreach (self::$_lib as $key => $libFile) {
                if (file_exists($libFile)) {
                    require $libFile;
                    self::$_lib[$key] = new $key;
                }
            }
        }

        /*
         * 初始化路由，开启路由分发
         * @access public
         */
        public static function initRoute(){
            $url_array=self::$_lib['Route']->getUrlArray();

            //分发控制

            $appName = '';
            $model= '';
            $controller = '';
            $action = '';
            $param = '';

            //以下一大段代码都是获得相关的文件名
            if (isset($url_array['appName'])) {
                $appName = $url_array['appName'];
            }

            if(isset($url_array['controller'])){
                $controller = $model = $url_array['controller'];
                if($appName){
                    $controller_file = CTL_PATH.'/'.$appName.'/'.$controller.'Controller.php';
                    $model_file = MODEL_PATH.'/'.$appName.'/'.$model.'Model.php';
                }
                else{
                    $controller_file = CTL_PATH.'/'.$controller.'Controller.php';
                    $model_file = MODEL_PATH.'/'.$model.'Model.php';
                }
            }
            else{
                $controller = $model = self::$_config['ROUTE']['DEFAULT_CTR'];
                if($appName){
                    $controller_file = CTL_PATH.'/'.$appName.'/'.$controller.'Controller.php';
                    $model_file = MODEL_PATH.'/'.$appName.'/'.$model.'Model.php';
                }
                else{
                    $controller_file = CTL_PATH.'/'.$controller.'Controller.php';
                    $model_file = MODEL_PATH.'/'.$model.'Model.php';
                }
            }

            if(isset($url_array['action'])){
                $action = $url_array['action'];
            }
            else{
                $action = self::$_config['ROUTE']['DEFAULT_ACTION'];
            }

            if(isset($url_array['param'])){
                $param = $url_array['param'];
            }

            if(file_exists($controller_file)){
                if(file_exists($model_file)){
                    require $model_file;
                }
                require $controller_file;
                $controller = $controller.'Controller';
                $controller = new $controller;
                if($action){
                    if(method_exists($controller, $action)){
                        isset($param) ? $controller->$action($param) : $controller->$action();
                    }
                    else{
                        throw new Exception('不存在该action',404);
                    }
                }
                else{
                    throw new Exception('不存在该action',404);
                }
            }
            else{
                throw new Exception('不存在该控制器',404);
            }
        }

        /**
         * @param $classname
         * @return mixed
         */
        public static function loadUserlib($classname){
            $appLib = '';
            $sysLib = '';

            $appLib = APP_LIB_PATH.'/'.self::$_config['LIB']['LIB_PRE'].'_'.$classname.'.php';
            $sysLib = SYSTEM_LIB_PATH.'/lib'.$classname.'.php';

            if(file_exists($appLib)){
                require($appLib);
                $classname=self::$_config['LIB']['LIB_PRE'].$classname;
                return new $classname;
            }
            else if(file_exists($sysLib)){
                require($sysLib);
                return self::$_lib["$classname"] = new $classname;
            }
            else{
                trigger_error($classname.'类不存在！');
            }
        }
    }
