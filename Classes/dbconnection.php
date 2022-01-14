<?php

class DBConnection{

    private static $connection;

    private $host = "localhost";
    private $user = 'fred';
    private $pwd = 'zap';
    private $dbname = "e_pharm";
    private $port = "3306";
    
    private  function __construct()
    {
    }

    public static function getInstance(){
        if((self::$connection==null)){
            self::$connection = new DBConnection();
        }
        return self::$connection;
    }

    public function connect(){
        try {
            $pdo=new PDO('mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->dbname,
            $this->user, $this->pwd);
            
            return $pdo;
            
            
        }catch(PDOException $e){
            print "Error!: ".$e->getMessage()."<br/>";
            die();
        }
    }
}