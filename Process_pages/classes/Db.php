<?php
require_once "config.php";
class Db
{

    private $dbhost = DB_HOST;
    private $dbname = DB_NAME;
    private $dbuser = DB_USER;
    private $dbpass = DB_PASS;

    public function connect(){
        $dsn = "mysql:host=".$this->dbhost.";dbname=".$this->dbname;
        $option = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        try{
            $pdo = new PDO($dsn, $this->dbuser, $this->dbpass, $option);
            return $pdo;
        }
        catch(PDOExtension $e){
            //    echo $e->getMessage();
            return false;
        }
        

    }

}