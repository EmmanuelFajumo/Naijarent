<?php
    require_once "Db.php";

    class Site extends Db
    {

        private $conn;

        public function __construct(){
            $this->conn = $this->connect();
        }
        public function get_all_listing_bystatus(){
            $sql = "SELECT * FROM properties WHERE verification_status = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['approved']);
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }

    }

    $c = new Site();
    $res = $c->get_all_listing_bystatus();

    echo "<pre>";
    print_r($res);
    echo "</pre>";