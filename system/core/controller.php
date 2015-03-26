<?php
/**
 * Created by PhpStorm.
 * User: xl
 * Date: 15-3-17
 * Time: 下午4:52
 */

class Controller {
    public function __construct(){
        //设置http响应头信息
        header('Content-type:text/html;charset=utf-8');
    }

    /**
     * @param $model
     * @return string
     * @throws Exception
     */
    final protected function model($model){
        if(empty($model)){
            throw new Exception('该类不存在');
        }
        return new $model.'Model';
    }

    /**
     * @param $lib
     * @param bool $auto
     * @return mixed
     * @throws Exception
     */
    final protected function load($lib, $auto=TRUE){
        if(empty($lib)){
            throw new Exception('类库名不能为空');
        }
        elseif($auto === TRUE){
            return Application::$_lib[$lib];
        }
        elseif($auto === FALSE){
            return Application::loadUserlib($lib);
        }
    }

    /**
     * @param $config
     * @return mixed
     */
    final protected function config($config){
        return Application::$_config[$config];
    }

    final protected function showTemplate($path, $data=array()){
        $template=$this->load('template');
        $template->init($path,$data);
        $template->output();
    }
}
