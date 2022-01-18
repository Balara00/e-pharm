<?php

  class DBConnection
  {

    private static $connection;

    private $host = "localhost";
    private $user = 'fred';
    private $pwd = 'zap';
    private $dbname = "e_pharm";
    private $port = "3306";
    private $pdo;


    private function __construct()
    {

    }

    public static function getInstance()
    {
        if ((self::$connection == null)) {
            self::$connection = new DBConnection();
            self::$connection->connect();
        }
        return self::$connection;
    }

    private function connect()
    {
        try {
            $pdo = new PDO(
                'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbname,
                $this->user,
                $this->pwd
            );

            $this->pdo = $pdo;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
    public function getPDO()
    {
        return $this->pdo;
    }

    // public function connect(){
    //   $pdo=new PDO('mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->dbname,
    //        $this->user, $this->pwd);
    //   return $pdo;
    // }

    // public static function getConnection(){
    //   if(self::$connection == null){
    //     self::$connection = new DBConn();
    //   }
    //   return self::$connection;
    // }
  }

 ?>
