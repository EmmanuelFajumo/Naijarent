<?php
    require_once "Db.php";

    class Site extends Db
    {

        private $conn;

        public function __construct(){
            $this->conn = $this->connect();
        }
        public function get_all_listing_bystatus($status){
            $sql = "SELECT * FROM properties WHERE verification_status = ?  ORDER BY RAND()";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$status]);
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }

        //fetch listing details by id
        public function fetch_property_detail($property_id){
            try{
                $sql = "SELECT properties.*, lga.LGA_name, property_type.name, state.state, agentprofile.Agent_id, agentprofile.first_name, agentprofile.last_name, agentprofile.profile_picture FROM properties JOIN Property_type ON properties.property_type = property_type.property_typeid JOIN lga ON properties.LGA = lga.LgA_id JOIN state ON properties.state = state.state_id JOIN agentprofile ON properties.agent_id = agentprofile.Agent_id WHERE property_id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$property_id]);
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                return $res;
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        public function fetch_featured_properties(){
            try{
                $sql = "SELECT payments.property_id, properties.*, lga.LGA_name, property_type.name, state.state, agentprofile.Agent_id, agentprofile.first_name, agentprofile.last_name, agentprofile.profile_picture FROM payments RIGHT JOIN properties ON payments.property_id = properties.property_id JOIN Property_type ON properties.property_type = property_type.property_typeid JOIN lga ON properties.LGA = lga.LgA_id JOIN state ON properties.state = state.state_id JOIN agentprofile ON properties.agent_id = agentprofile.Agent_id WHERE status= ? ORDER BY RAND()";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(['successful']);
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $res;
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        

    }

    // $c = new Site();
    // $res = $c->fetch_featured_properties();

    // echo "<pre>";
    // print_r($res);
    // echo "</pre>";