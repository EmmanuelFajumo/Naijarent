<?php
include_once "Db.php";

class Admin extends Db
{

    private $conn;

    public function __construct(){
        $this->conn = $this->connect();
    }

    //get a single user by id
    public function get_user($id){
        try{
            $sql = "SELECT * FROM users WHERE  user_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        }
        catch(PDOExtension $e){
            return $e->getMessage();
       }
    }

    //to fetch all users
    public function get_all_tenants(){
       try{
            $sql = "SELECT * FROM tenant";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $tenants = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $tenants;
       }catch(PDOExtension $e){
            $e->getMessage();
       }
    }


    //fetch property type
    public function fetch_property_types(){
        try{
            $sql = "SELECT * FROM property_type";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }
        catch(PDOException $e){
            return $e->getmessage();
        }
    }

    //add property type
    public function insert_property_type($name, $description){
        $sql = "INSERT INTO property_type(name, description) VALUES(?, ?)";
        $stmt = $this->conn->prepare($sql);
        $response = $stmt->execute([$name, $description]);
        return $response;


    }

    //delete a property type
    public function delete_property_type($id){
        $sql = "DELETE FROM property_type WHERE property_typeid = ?";
        $stmt = $this->conn->prepare($sql);
        $res = $stmt->execute([$id]);
        return $res;

    }


    //fetch all Agents
    public function get_all_agents(){
       try{
            $sql = "SELECT * FROM agentprofile";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $agents = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $agents;
       }catch(PDOExtension $e){
            $e->getMessage();
       }
    }


    //update agent status
    public function update_agent_status($status, $id){
        $sql = "UPDATE agentprofile SET verification_status = ? WHERE Agent_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$status, $id]);
        return true;
    }



    //properties
    public function fetch_All_listings(){
       try{
            $sql = "SELECT * FROM properties";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $agent_det = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $agent_det;
       }
       catch(PDOException $e){
           return $e->getMessage();
       }
       
    } 
    
}
// $update = new Admin();
// echo "<pre>";
// print_r($update->fetch_All_listings());
// echo "</pre>";

