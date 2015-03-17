<?php
/**
 * Created by PhpStorm.
 * User: xl
 * Date: 15-3-17
 * Time: 下午5:24
 */

class Model {
    protected $db = null;

    final public function __construct(){
        header('Content-type=text/html;charset=utf-8');
        $this->db=$this->load('mysql');
        $configDB=$this->config('DB');
        $this->db->init(
            $configDB['DB_HOST'],
            $configDB['DB_USER'],
            $configDB['DB_PWD'],
            $configDB['DB_NAME'],
            $configDB['DB_TABLE_PRE'],
            $configDB['DB_CHARSET']
        );
    }

    /**
     * @param $lib
     * @param bool $my
     * @return mixed
     */
    final protected function load($lib,$my = FALSE){
        if(empty($lib)){
            trigger_error('加载类库名不能为空');
        }elseif($my === FALSE){
            return Application::$_lib[$lib];
        }elseif($my === TRUE){
            return  Application::loadUserlib($lib);
        }
    }

    /**
     * @param string $config
     * @return mixed
     */
    final   protected function config($config=''){
        return Application::$_config[$config];
    }
}