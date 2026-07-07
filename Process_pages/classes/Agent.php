<?php
include_once 'Db.php';

class Agent extends Db
{
    private $conn;
    public function __construct(){
        $this->conn = $this->connect();
    }

    public function update_agent_profile($firstname, $lastname, $agent_bio, $years_of_experience, $agency, $phone, $id_type, $id_file, $poa_filetype, $poa_file, $cac_number, $cac_file, $esvarbon_number, $esvarbon_file, $about_agency, $agency_location, $agent_id){
        $sql = "UPDATE agentprofile SET first_name =?, last_name = ?, agent_bio = ?, years_of_experience = ?, agency = ?, phone = ?, ID_type = ?, id_file = ?, proof_of_address_filetype = ?, proof_of_address_file = ?, cac_number = ?, cac_file = ?, ESVARBON_number = ?, ESVARBON_file = ?, about_agency = ?, agency_Location = ? WHERE agent_id = ?";

        $stmt = $this->conn->prepare($sql);
        $res = $stmt->execute([$firstname, $lastname, $agent_bio, $years_of_experience, $agency, $phone, $id_type, $id_file, $poa_filetype, $poa_file, $cac_number, $cac_file, $esvarbon_number, $esvarbon_file, $about_agency, $agency_location, $agent_id]);

        return $res;
    }

    public function update_agent_profile_picture($profile_picture, $agent_id){
        $sql = "UPDATE agentprofile SET profile_picture = ? WHERE Agent_id = ?";

        $stmt = $this->conn->prepare($sql);
        $res = $stmt->execute([$profile_picture, $agent_id]);

        return $res;
    }

     public function register_agent($firstname, $lastname, $email, $password, $phone){
         $hash = password_hash($password, PASSWORD_DEFAULT);
        try{
            $sql = "INSERT INTO agentprofile(first_name, last_name, email, password, phone) VALUES(?, ?, ?, ?, ?)" ;
            $stmt = $this->conn->prepare($sql);
            $response = $stmt->execute([$firstname, $lastname, $email, $hash, $phone]);
            return $response;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }

     public function check_email($email){
        try{
            $sql = "SELECT * FROM Agentprofile WHERE email = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$email]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if($data){
                return "<span class='text-danger'> Email has been used</span>";
            }
            else{
                return "<span class='text-success'> Email is available </span>";
            }

        }
        catch(PDOException $e){
            //return $e->getMessage();
           return false;
        }
    }

    public function login($email, $password){
        $sql = "SELECT * FROM agentprofile WHERE email = ?";
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
                return $data['Agent_id'];
                
            }
        }
        else{
            return false;
            
        }

    }

    public function logout(){
        unset($_SESSION['agent_online']);
        session_destroy();
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

    public function create_listing($agentid, $property_type, $title, $description, $price, $payment_flexibility, $full_address, $lga ,$state,  $bedrooms, $bathrooms, $toilets, $furnishing, $parking_space, $electricity_supply, $water_supply, $security, $pop_ceiling, $tiled_floor, $prepaid_meter, $image1){
        try{
            $sql = "INSERT INTO properties(agent_id, Property_type, title, description, price, payment_flexibility, address, LGA, state, bedrooms, bathrooms, toilet, furnished_status, parking_space, electricity_supply, water_supply, security, pop_ceiling, tiled_floor, prepaid_meter, image1) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)" ;
            $stmt = $this->conn->prepare($sql);
            $response = $stmt->execute([$agentid, $property_type, $title, $description, $price, $payment_flexibility, $full_address, $lga, $state, $bedrooms, $bathrooms, $toilets, $furnishing, $parking_space, $electricity_supply, $water_supply, $security, $pop_ceiling, $tiled_floor, $prepaid_meter, $image1]);
            return $response;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

     public function update_listing($property_type, $title, $description, $price, $payment_flexibility, $full_address, $lga ,$state,  $bedrooms, $bathrooms, $toilets, $furnishing, $parking_space, $electricity_supply, $water_supply, $security, $pop_ceiling, $tiled_floor, $prepaid_meter, $image1, $property_id){
        try{
            $sql = "UPDATE properties SET Property_type =?, title =?, description =?, price =?, payment_flexibility =?, address =?, LGA =?, state =?, bedrooms =?, bathrooms =?, toilet =?, furnished_status =?, parking_space =?, electricity_supply =?, water_supply =?, security =?, pop_ceiling =?, tiled_floor =?, prepaid_meter = ?, image1 =? WHERE property_id = ?";
            $stmt = $this->conn->prepare($sql);
            $response = $stmt->execute([$property_type, $title, $description, $price, $payment_flexibility, $full_address, $lga ,$state,  $bedrooms, $bathrooms, $toilets, $furnishing, $parking_space, $electricity_supply, $water_supply, $security, $pop_ceiling, $tiled_floor, $prepaid_meter, $image1, $property_id]);
            return $response && $stmt->rowCount() > 0;
        }catch(PDOException $e){
            return false;
        }
    }

    public function insert_property_media($property_id, $photo1){
        try{
            $sql = "INSERT INTO property_media(property , image1) VALUES(?,?)";
            $stmt = $this->conn->prepare($sql);
            $res = $stmt->execute([$property_id, $photo1]);
            return $res;
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function fetch_agent_details($id){
       try{
            $sql = "SELECT * FROM agentprofile WHERE Agent_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            $agent_det = $stmt->fetch(PDO::FETCH_ASSOC);
            return $agent_det;
       }
       catch(PDOException $e){
           return $e->getMessage();
       }
       
    } 
    
    public function fetch_All_listings($agent_id){
       try{
            $sql = "SELECT * FROM properties WHERE Agent_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$agent_id]);
            $agent_det = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $agent_det;
       }
       catch(PDOException $e){
           return $e->getMessage();
       }
       
    } 
}
// $hey = new Agent();
// $res = $hey->update_agent_profile_picture("rhefjskjdfnskfnsdfgs", 6);

//     echo "<pre>";
//      print_r($res);
//     echo "</pre>";

