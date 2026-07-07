<?php
include "process_pages/classes/Db.php";

class Utilities extends Db
{
    private $dbconn;

    public function __construct(){
        $this->dbconn = $this->connect();
    }

    public function validate_email($email){
        $sql = "SELECT * FROM agentprofile WHERE email = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$email]);
        $rsp = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = count($rsp);
        if($count != 0){
            return "Email not available";
        }
        else{
            return "Email is available";
        }

    }

    public function $check_user_detail($email, $password){
        $sql = "SELECT * FROM agentprofile WHERE email = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if($data){
            $stored_hash = $data['password'];
            $check = password_verify($password, $stored_hash);
            if($check == false){
                return "Password is not correct";
            }
            else{
                return $data['Agent_id'];
            }
        }
        else{
            return "Invalid Email is incorrect";
            exit;
        }


        
    }

}

$pro = new Utilities;
echo $pro->("fajumoe@gmail.com", );