<?php
require_once "Db.php";

class Tenant extends Db
{
    
    private $conn;

    public function __construct(){
        $this->conn = $this->connect();
    }
    
    public function register_tenant($first_name, $last_name, $email, $password, $phone_number,  $profile_photo){
        try{
            $sql = "INSERT INTO tenant(first_name, last_name, email , password, phone, profile_picture) VALUES(?, ?, ?, ?, ?, ?)" ;

            $stmt = $this->conn->prepare($sql);
            $response = $stmt->execute([$first_name, $last_name, $email, $password, $phone_number, $profile_photo]);
            return $response;
        }catch(PDOException $e){
            $e->getMessage();
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
// $res = $test->register_tenant('Ade', 'Faj', 'faj@gmail.com', '23234', '1234567890', 'wrerwerertertertetetre.png');
// echo $res;
