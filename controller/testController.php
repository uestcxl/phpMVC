<?php
/**
 * Created by PhpStorm.
 * User: xl
 * Date: 15-3-17
 * Time: 下午6:49
 */

class testController extends Controller{

    function __construct(){
        parent::__construct();
    }

    public function index(){
        echo "This is a testController.";
    }

    public function testDB(){
        $modeltest=$this->model('test');
        $database=$modeltest->testDatabases();
        print_r($database);
    }
}