<?php

class DB {
    static $instance; 
    private $conn; 

    public function __construct(){
        $this->conn = new mysqli(
            DB_HOST,
            DB_USER,
            DB_PASS,
            DB_NAME,
            DB_PORT
        );

        if($this->conn->connect_error){
            die('failed to connection');
        }

        $this->conn->set_charset(DB_CHAR);
    }
    
    static function getInstance(){
        if(self::$instance){
            return self::$instance; 
        }

        self::$instance = new DB();
        return self::$instance; 
    }

    public function query($sql, $return_type = ''){
        $result = $this->conn->query($sql);

        if(is_bool($result)){
            return $result;
        }

        $rows = array(); 
        $fetch = $return_type === 'array' || $return_type === 'assoc' 
                    ? 'fetch_assoc'
                    : 'fetch_object';
        while($row = $result->{$fetch}()){
            $rows[] = $row;
        }
        return $rows; 
    }

    public function prepare($data){
        $new_data = array();
        foreach ($data as $k => $v){
                $new_data[$k] = $this->quote($this->realEscape($v));
        }
        return $new_data;
    }

    public function quote($str){
        return '\''.$this->escape($str).'\'';
    }

    public function unescape($str){
        // $str = nl2br(stripslashes($str));
        return htmlspecialchars_decode($str);
    }

    public function escape($str){
        return htmlspecialchars($str);
    }

    public function realEscape($str){
        return $this->escape($this->conn->real_escape_string($str));
    }

    static function esc($str){
        return htmlspecialchars($str); 
    }

    static function unesc($str){
        return htmlspecialchars_decode($str);
    }

    static function entity($entity){
        return html_entity_decode($entity);
    }
}