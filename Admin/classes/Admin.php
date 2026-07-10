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
            $sql = "SELECT * FROM tenant WHERE  tenant_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            $tenant = $stmt->fetch(PDO::FETCH_ASSOC);
            return $tenant;
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

    //get agent by id
    public function get_agents_byid($status){
       try{
            $sql = "SELECT * FROM agentprofile WHERE verification_status = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$status]);
            $agents = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $agents;
       }catch(PDOExtension $e){
            $e->getMessage();
       }
    }


    //update agent status
    public function update_agent_status($status, $id){
        try{
            $sql = "UPDATE agentprofile SET verification_status = ? WHERE Agent_id = ?";
            $stmt = $this->conn->prepare($sql);
            $res = $stmt->execute([$status, $id]);
            return $res;
        }catch(PDOException $e){
            return $e->getMessage();
        }
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

    //fetch listing details by id
        public function fetch_property_detail($property_id){
            try{
                $sql = "SELECT properties.*, lga.LGA_name, property_type.name, state.state, agentprofile.first_name, agentprofile.last_name  FROM properties JOIN Property_type ON properties.property_type = property_type.property_typeid JOIN lga ON properties.LGA = lga.LgA_id JOIN state ON properties.state = state.state_id JOIN agentprofile ON properties.agent_id = agentprofile.Agent_id WHERE property_id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$property_id]);
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                return $res;
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

    public function login($username, $password){
        $sql = "SELECT * FROM admin WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if($data){
            $stored_hash = $data['password'];
            $check = password_verify($password, $stored_hash);
            if($check == false){
                return false;
                
            }
            else{
                return $data['admin_id'];
                
            }
        }
        else{
            return false;
            
        }

    }

    public function logout(){
        unset($_SESSION['admin_online']);
        session_destroy();
    }

    public function get_all_listing_bystatus($status){
        try{
                $sql = "SELECT * FROM properties WHERE verification_status = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$status]);
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $res;
        }catch(PDOException $e){
                return $e->getMessage();
        }
    }

    //update agent status
    public function update_property_status($status, $id){
        $sql = "UPDATE properties SET verification_status = ? WHERE property_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$status, $id]);
        return true;
    }
}
// $update = new Admin();
// $res = ($update->update_agent_status('verified', 2));
// echo $res;

