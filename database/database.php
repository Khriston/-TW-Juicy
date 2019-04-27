<?php

class DB{
    private static $conn;

    private function _constructor(){}

    public static function getConnection ($host, $db_name, $username, $password){
        if(!self::$conn){
            self::$conn = mysqli_connect($host, $username, $password, $db_name);
        }
        return self::$conn;
    }

    public static function close(){
        return self::$conn ? self::$conn->close() : true;
    }

}