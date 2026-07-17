<?php
session_start();
require_once "../Agent/agentguard.php";

if(isset($_POST['create'])){

    // retrieve the data from the form

    //Sanitize the data
    //$agentid = intval($_POST['Agentid']);
    $title = htmlentities($_POST['title']);
    $property_type = htmlentities($_POST['property_type']);
    $listing_purpose = htmlentities($_POST['listing_purpose']);
    $payment_flexibility = htmlentities($_POST['payment_flexibility']);
    $description = htmlentities($_POST['description']);
    $price = intval($_POST['price']);
    $full_address = htmlentities($_POST['full_address']);
    $state = $_POST['state'];
    $lga = htmlentities($_POST['lga']);
    $state = htmlentities($_POST['state']);
    $bedrooms = intval($_POST['bedrooms']);
    $bathrooms = intval($_POST['bathrooms']);  
    $toilets = intval($_POST['toilets']);
    $furnishing = htmlentities($_POST['furnishing']);

        //amenities
        $parking_space = isset($_POST['parking_space']) ? 1 : 0;
        $electricity_supply = isset($_POST['electricity_supply']) ? 1 : 0;
        $water_supply = isset($_POST['water_supply']) ? 1 : 0;
        $security = isset($_POST['security']) ? 1 : 0;
        $wifi = isset($_POST['wifi']) ? 1 : 0;
        $ac = isset($_POST['ac']) ? 1 : 0;
        $gym = isset($_POST['gym']) ? 1 : 0;
        $bq = isset($_POST['bq']) ? 1 : 0;
        $prepaid_meter = isset($_POST['prepaid_meter']) ? 1 : 0;
        $pop_ceiling = isset($_POST['pop_ceiling']) ? 1 : 0;
        $tiled_floor = isset($_POST['tiled_floor']) ? 1 : 0;



        


        //Retrieve the uploaded files
        $property_photo1_name = $_FILES['property_photo1']['name'];
        $property_photo1_tmp_name = $_FILES['property_photo1']['tmp_name'];
        $property_photo1__error = $_FILES['property_photo1']['error'];
        $property_photo1__size = $_FILES['property_photo1']['size'];
        $walkthrough_videos_name = $_FILES['walkthrough_videos']['name'];
        $walkthrough_videos_tmp_name = $_FILES['walkthrough_videos']['tmp_name'];
        $walkthrough_videos__error = $_FILES['walkthrough_videos']['error'];
        $walkthrough_videos__size = $_FILES['walkthrough_videos']['size'];

        //validate wrong file type
        $accepted = ['jpg', 'jpeg', 'png']; //iamges: jpg, jpeg, pnh
        $picture_extension = pathinfo($property_photo1_name, PATHINFO_EXTENSION);
        $picture_extension =strtolower($picture_extension);
        if(!in_array( $picture_extension, $accepted)){
             //$error_message = urlencode("Oga, wrong file type. Upload an image wiht extension png or jpg or jpeg");  //urlencode - to carry a long text in the url
            $_SESSION['errormsg'] = "All fields are required. Kindly fill the form completely";
            header("location:../Agent/agent_dashboard_listings.php");
            exit;
        }    
    
        //validate the data
        if(empty($title) || empty($property_type) || empty($listing_purpose) || empty($payment_flexibility) || empty($description) || empty($price) || empty($full_address) || empty($lga) || empty($state) || empty($bedrooms) || empty($bathrooms) || empty($toilets) || empty($furnishing)){
            $_SESSION['errormsg'] = "All fields are required. Kindly fill the form completely";
            header("location:../Agent/agent_dashboard_listings.php");
            exit;
        } 
 

    //rename the file  
        $unique_filename = uniqid("NR").time()."_".$property_photo1_name;
        //$unique_filename = uniqueid("share_It").time().".".$user_extension;        

        $res = move_uploaded_file($property_photo1_tmp_name, "../uploads/property_pictures/$unique_filename");

        if(!$res){
            $_SESSION['errormsg'] = "Image not saved to server";
            header("location:../Agent/agent_dashboard_listings.php");
        exit;
        }
    //create an instance of the Agent class
    require_once 'classes/Agent.php';
    $agent = new Agent();

    //get the ID of the agent creatingg the new property
    //$_SESSION['email'] = $e
   // $agentdetails = $agent->fetch_agent_details($email);
    //call the create_listing method to save the listing to the database
    $response = $agent->create_listing($_SESSION['agent_online'],$property_type, $title, $description, $price, $payment_flexibility, $full_address, $lga, $state, $bedrooms, $bathrooms, $toilets, $furnishing, $parking_space, $electricity_supply, $water_supply, $security, $pop_ceiling, $tiled_floor, $prepaid_meter,  $unique_filename);

    //$testing = new Agent();
    //$res = $testing->insert_property_media($_SESSION['agent_id'], $unique_filename);

    if($response){
        $_SESSION['successmsg'] = "Listing created successfully";
       header("location:../Agent/agent_dashboard_create_listing.php");
        exit;
    } else{
        $_SESSION['errormsg'] = "An error occurred while creating the listing. Please try again.";
       header("location:../Agent/agent_dashboard_create_listing.php");
       exit;
    }

    exit;

}else{
    $_SESSION['errormsg'] = "What are you looking for?";
    header("location:../Agent/agent_dashboard_create_listing.php");
    exit;
}