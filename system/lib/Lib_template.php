<?php
/**
 * Created by PhpStorm.
 * User: xl
 * Date: 15-3-17
 * Time: 下午6:55
 */

class Template {
    public $templateName=null;
    public $data=array();
    public $outPut=null;

    /**
     * @param $templateName
     * @param array $data
     */
    public function init($templateName,$data=array()){
        $this->templateName=$templateName;
        $this->data=$data;
        $this->fetch();
    }

    public function fetch(){
        $viewFile = VIEW_PATH.'/'.$this->templateName.'.php';
        if(file_exists($viewFile)){
            extract($this->data);
            ob_start();
            include $viewFile;
            $content=ob_get_contents();
            ob_end_clean();
            $this->outPut=$content;
        }
        else{
            trigger_error('模板'.$viewFile.'不存在！');
        }
    }

    public function outPut(){
        echo $this->outPut;
    }
}