<?php
require_once 'Db.php';

class User extends Db
{
    private $conn;

    public function __construct(){
        $this->conn = $this->connect();
    }
    
    public function register_user($first_name, $last_name, $email, $password, $phone_number, $role, $profile_photo){
        try{
            $sql = "INSERT INTO users(first_name, last_name, email , password, phone_number, role, profile_photo) VALUES(?, ?, ?, ?, ?, ?, ?)" ;

            $stmt = $this->conn->prepare($sql);
            $response = $stmt->execute([$first_name, $last_name, $email, $password, $phone_number, $role, $profile_photo]);
            return $response;
        }catch(PDOException $e){
            $e->getMessage();
        }

    } 


    //to fetch all users
    public function get_all_users(){
        $sql = "SELECT * FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $customers = $stmt->fetchALL(PDO::FETCH_ASSOC);
        return $customers;
    }

    //verify user
    public function verify_user($user_id){
        $sql = "UPDATE users SET status = 'verified' WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $response = $stmt->execute([$user_id]);
        return $response;
    }

    //search user wiith keyword
    public function search_user($keyword){
        $sql = "SELECT * FROM users WHERE first_name LIKE ? OR last_name LIKE ? OR status LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(["%$keyword%", "%$keyword%", "%$keyword%"]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return   $res;

    }

    public function view_listings(){
        
    }
}

// $test = new User();
// $res = $test->search_user("dan");

// echo "<pre>";
// print_r($res);
// echo "</pre>";