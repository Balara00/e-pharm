<?php

  class DBConn
  {

    private static $connection;

    private $host = "localhost";
    private $user = 'fred';
    private $pwd = 'zap';
    private $dbname = "e_pharm";
    private $port = "3306";


    private function __construct()
    {

    }

    public function connect(){
      $pdo=new PDO('mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->dbname,
           $this->user, $this->pwd);
      return $pdo;
    }

    public static function getConnection(){
      if(self::$connection == null){
        self::$connection = new DBConn();
      }
      return self::$connection;
    }
  }

 ?>
