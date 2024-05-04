<?php

class Config {
    static $setting = array();

    static function get($key){
        return self::$setting[$key] || null;
    }

    static function set($key, $value){
        self::$setting[$key] = $value; 
    }
}