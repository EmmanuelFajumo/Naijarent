<?php
require_once "Db.php";

    class Utilities extends Db
    {
        private $conn;

        public function __construct(){
            $this->conn = $this->connect();
        }

        public function fetch_all_states(){
            $sql = "SELECT * FROM state";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }


        public function fecht_lga_by_state_id($stateid){
            $sql = "SELECT * FROM lga WHERE state_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$stateid]);
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }
    }


    // $a = new Utilities();
    // $rsp =  $a->fecht_lga_by_state_id(1);

    // echo "<pre>";
    //     print_r($rsp);
    // echo "</pre>";

?>