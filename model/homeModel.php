<?php
/**
 * Created by PhpStorm.
 * User: xl
 * Date: 15-3-17
 * Time: 下午7:57
 */

class homeModel extends Model{
    function test(){
        echo "this is homeModel";
    }

    function testResult(){
        $this->db->showDatabases();
    }
}