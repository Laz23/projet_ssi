<?php
class ConnectionToBD{
    private static $name  = null; 
    private static $password = null; 
    private static $db = null; 
    private static $role  =  null ;
    private static $connection = null ; 

    private function __construct ($name , $password, $db){
       // echo "<br>".$name . " " . $password ; 
        try{
            self::$connection = new PDO("mysql:host=localhost;dbname=".$db.";charset=utf8", $name, $password);

        }catch(Exception $e){
            die("error : ".$e->getMessage());
        }

    }

    public static function initialization(){
        if(self::$connection == null){
            //echo "<br>hello world<br>";
            //echo self::$name ." " . self::$password;
            new ConnectionToBD(self::$name,self::$password , self::$db);
        }
        return self::$connection; 
    }

    public static function setNamePassword($name , $password , $db, $role) {
        self::$name = $name ; 
        self::$password = $password;
        self::$db = $db;
        self::$role = $role ; 
        self::$connection = null;
       // echo $name ." " . $password;
    } 

    public static function getName(){
        return self::$name; 
    }

    public static function getPassWord(){
        return self::$password ; 
    }

    public static function getRole(){
        return self::$role;
    }
}