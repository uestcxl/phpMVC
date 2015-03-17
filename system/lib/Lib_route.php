<?php
/**
 * Created by PhpStorm.
 * User: xl
 * Date: 15-3-17
 * Time: 下午4:24
 */

class Route {
    private $url_query;
    private $route_url=array();

    public function __construct(){
        $this->url_query = parse_url($_SERVER['REQUEST_URL']);
    }

    /**
     * @return array
     */
    public function getUrlArray(){
        $this->makeUrl();
        return $this->route_url;
    }

    public function makeUrl(){
        $params=!empty($this->url_query['query']) ? explode('&', $this->url_query['query']) : array();
        $array = $tmp =array();
        if(count($params) > 0){
            foreach($params as $items){
                $tmp=explode('=',$items);
                $array[$tmp[0]]=$tmp[1];
            }
            if(isset($array['app'])){
                $this->route_url['appName']=$array['app'];
            }
            if(isset($array['controller'])){
                $this->route_url['controller']=$array['controller'];
            }
            if(isset($array['controller'])){
                $this->route_url['controller']=$array['controller'];
            }
            if(count($array) > 0){
                $this->route_url['params'] = $array;
            }
            unset($array);
        }
        else{
            $this->route_url;
        }
    }
}