<?php
require_once "Db.php";

class Tenant extends Db
{
    
    private $conn;

    public function __construct(){
        $this->conn = $this->connect();
    }
    
    public function register_tenant($first_name, $last_name, $email, $password, $phone_number){
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        try{
            $sql = "INSERT INTO tenant(first_name, last_name, email , password, phone) VALUES(?, ?, ?, ?, ?)" ;

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$first_name, $last_name, $email, $password_hash, $phone_number]);
            $id = $this->conn->lastInsertId();
            return $id;
        }catch(PDOException $e){
           // retrun $e->getMessage();
           return false;
        }

    } 

    public function logout(){
        unset($_SESSION['useronline']);
        session_destroy();
    }

    public function login($email, $password){
        $sql = "SELECT * FROM tenant WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if($data){
            $stored_hash = $data['password'];
            $check = password_verify($password, $stored_hash);
            if($check == false){
                return false;               
            }
            else{
                return $data['tenant_id'];             
            }
        }
        else{
            return false;      
        }
    }

    public function fetch_user_detailby_id($id){
        try{
            $sql = "SELECT * FROM tenant WHERE tenant_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            return $res;

        }
        catch(PDOException $e){
            //$e->getMessage();
            return false;
        }
    }    

     //to fetch all users
    public function get_all_tenants(){
        $sql = "SELECT * FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $customers = $stmt->fetchALL(PDO::FETCH_ASSOC);
        return $customers;
    }

    public function save_to_file(){
        $res = file_put_contents('tenants.txt', "Firstname: ".$this->firstName." Lastname: ".$this->lastName." Email: ". $this->email." Password: ".$this->password."\n", FILE_APPEND);
        return $res;
    }
}


// $test = new Tenant();
// $res = $test->login("fajumoe@gmail.com", "123");
// echo $res;

// $res = $test->fetch_user_detailby_id(4);
// var_dump($res);