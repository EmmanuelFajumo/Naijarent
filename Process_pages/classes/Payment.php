<?php

require_once "Db.php";
require_once "config.php";

class Payment extends Db
{
    private $dbconn;

    public function __construct(){
        $this->dbconn = $this->connect();
    }

    //a method that generates unique Reference number
    public function generate_ref_code(){
        $ref = uniqid("naijarent_").time();
        return $ref;
    }

    //a method that inserts into the payment table
    public function add_payment_attempt($amount, $property_id, $reference, $user_name, $user_email,  $agent_id){
        $sql = "INSERT INTO payments(amount, property_id, reference, user_name, user_email, agent_id) VALUES(?, ?, ?, ?, ? ,?)";
        $stmt = $this->dbconn->prepare($sql);
        $res = $stmt->execute([$amount, $property_id, $reference, $user_name, $user_email, $agent_id]);
        return $res;
    }

    //a method that initializes Paystack
        public function initialize_paystack($email,$amount, $ref){
            $amount_in_kobo = $amount*100;
            try{
                $url = "https://api.paystack.co/transaction/initialize";

                $fields = [
                    'email' => "$email",
                    'amount' => "$amount_in_kobo",
                    'callback_url' => "http://localhost/RMS/Agent/payment_status.php",
                    'reference' => "$ref"
                    //'metadata' => ["cancel_action" => "https://your-cancel-url.com"]
                ];

                $fields_string = http_build_query($fields);

                //open connection
                $ch = curl_init();
                
                //set the url, number of POST vars, POST data
                curl_setopt($ch,CURLOPT_URL, $url);
                curl_setopt($ch,CURLOPT_POST, true);
                curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Authorization: Bearer ".PAYSTACK_SECRET_KEY,
                    "Cache-Control: no-cache",
                ));
                
                //So that curl_exec returns the contents of the cURL; rather than echoing it
                curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
                
                //execute post
                $result = curl_exec($ch);
                return $result;

            


            }catch(Exception $e){
                //log $e->getMessage in a log file
                //return $e->getMessage();
                return false;
            }
        }

    //a method that initializes paystack
    public function verify_payment($ref){
        try{
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.paystack.co/transaction/verify/$ref",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".PAYSTACK_SECRET_KEY,
                "Cache-Control: no-cache",
                ),
            ));
            
            $response = curl_exec($curl);
            $err = curl_error($curl);

            //curl_close($curl);
            
            if ($err) {
                //log the error message in a log file | send automated email to yourself as the developer
                return false;
            } else {
                return $response;
            }


        }catch(Exception $e){
            //log the error message in a log file
            return false;
        }
    }

    //fetch property_id by ref
    public function fetch_property_id($res){
        $sql = "SELECT amount FROM payments WHERE reference = ?";
        $stmt = $this->dbconn->prepare($sql);
        $amount = $stmt->execute([$res]);
        return $amount;
    }

     //a method that updates payment status
        public function update_payment_status($status, $time, $ref){
           try{
            $sql = "UPDATE payments SET status = ?, paid_at = ? WHERE reference = ?";
            $stmt = $this->dbconn->prepare($sql);
            $res = $stmt->execute([$status, $time, $ref]);
            return $res;
           }
           catch(PDOException $e){
                echo $e->getMessage();
           }

        }

}