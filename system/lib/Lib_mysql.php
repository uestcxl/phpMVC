<?php
/**
 * Created by PhpStorm.
 * User: xl
 * Date: 15-3-17
 * Time: 下午7:21
 */

final class Mysql {
    private $dbHost;
    private $dbUser;
    private $dbPwd;
    private $dbName;
    private $dbCoding;

    private $conn;
    private $result;
    private $sql;

    /**
     * @param $dbHost
     * @param $dbName
     * @param $dbUser
     * @param $dbPwd
     * @param $dbCoding
     */
    public function init($dbHost,$dbName,$dbUser,$dbPwd,$dbCoding){
        $this->dbHost=$dbHost;
        $this->dbName=$dbName;
        $this->dbUser=$dbUser;
        $this->dbCoding=$dbCoding;
        $this->dbPwd=$dbPwd;

        $this->connect();
    }


    public function connect(){
        $this->conn=mysql_connect($this->dbHost,$this->dbUser,$this->dbPwd);

        if(!mysql_select_db($this->dbName,$this->conn)){
            $this->showError('数据库连接错误',$this->dbName);
        }
        mysql_query("SET NAMES $this->dbCoding");
    }

    /**
     * @param $sql
     * @return resource
     */
    public function query($sql){
        if($sql==''){
            $this->showError('sql语句错误','sql语句不能为空');
        }
        else{
            $this->sql=$sql;

            $result=mysql_query($this->sql,$this->conn);

            if(!$result){
                $this->showError('sql语句错误','sql语句执行错误');
            }
            else{
                $this->result=$result;
            }
        }
        return $this->result;
    }

    public function fetchObject() {
        return mysql_fetch_object($this->result);
    }

    public function fetchArray() {
        return mysql_fetch_array($this->result);
    }

    public function findAll($table) {
        $this->query("SELECT * FROM $table");
    }

    public function select($table, $columnName = "*", $condition = '', $debug = '') {
        $condition = $condition ? ' Where ' . $condition : NULL;
        if ($debug) {
            echo "SELECT $columnName FROM $table $condition";
        } else {
            $this->query("SELECT $columnName FROM $table $condition");
        }
    }

    //简化删除del
    public function delete($table, $condition, $url = '') {
        if ($this->query("DELETE FROM $table WHERE $condition")) {
            if (!empty ($url))
                $this->Get_admin_msg($url, '删除成功！');
        }
    }
    //简化插入insert
    public function insert($table, $columnName, $value, $url = '') {
        if ($this->query("INSERT INTO $table ($columnName) VALUES ($value)")) {
            if (!empty ($url))
                $this->Get_admin_msg($url, '添加成功！');
        }
    }
    //简化修改update
    public function update($table, $mod_content, $condition, $url = '') {
        //echo "UPDATE $table SET $mod_content WHERE $condition"; exit();
        if ($this->query("UPDATE $table SET $mod_content WHERE $condition")) {
            if (!empty ($url))
                $this->Get_admin_msg($url);
        }
    }

    /**
     * @param $errorInfo
     * @param $dbName
     */
    public function showError($errorInfo,$errorReason){
        echo $errorInfo.':'.$errorReason;
    }
}