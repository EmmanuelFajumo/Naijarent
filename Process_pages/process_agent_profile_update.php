<?php

session_start();
    if(isset($_POST['update_profile'])){
        //retrieve values

        //personal information
        $firstname = htmlentities($_POST['firstname']); 
        $lastname = htmlentities($_POST['lastname']);   
        $bio = htmlentities($_POST['bio']);   
        $address = htmlentities($_POST['address']);   
        $location = htmlentities($_POST['location']); 
        $phone = htmlentities($_POST['phone']);


       //professional Information
       $agency_name = htmlentities($_POST['agency_name']); 
       $years_of_experience = htmlentities($_POST['years_of_experience']); 
       $about_agency = htmlentities($_POST['about_agency']); 
       $agency_address = htmlentities($_POST['agency_address']); 
    

        //Government issued ID
        $id_type = htmlentities($_POST['id_type']); 
        $id_filename = $_FILES['id_file']['name'];
        $id_file_tmp_name = $_FILES['id_file']['tmp_name'];
        $id_file_size = $_FILES['id_file']['size'];
        $id_file_error= $_FILES['id_file']['error'];
        //proof of address
        $proof_of_address = htmlentities($_POST['proof_of_address']); 
        $poa_filename = $_FILES['proof_of_address']['name'];
        $poa_tmp_name = $_FILES['proof_of_address']['tmp_name'];
        $poa_size = $_FILES['proof_of_address']['size'];
        $poa_error= $_FILES['proof_of_address']['error'];

        //CAC Registration Number
        $cac = htmlentities($_POST['cac']);
        $cac_filename = $_FILES['cac_file']['name'];
        $cac_file_tmp_name = $_FILES['cac_file']['tmp_name'];
        $cac_file_size = $_FILES['cac_file']['size'];
        $cac_file_error = $_FILES['cac_file']['error'];
        //CAC Registration Number
        $ESVARBON_number = htmlentities($_POST['ESVARBON_number']); 
        $ESVARBON_filename = $_FILES['ESVARBON']['name'];
        $ESVARBON_file_tmp_name = $_FILES['ESVARBON']['tmp_name'];
        $ESVARBON_file_size = $_FILES['ESVARBON']['size'];
        $ESVARBON_file_error = $_FILES['ESVARBON']['error'];

        if(empty($cac) || empty($ESVARBON_number)){
            $_SESSION['errormsg'] = "Kindly submit your CAC number and ESVARBON";
            header("location:../agent/agent_profile.php");
            exit;
        }
        // check if there is error
        if($id_file_error !=0 || $poa_error != 0 || $ESVARBON_file_error !=0 ||  $cac_file_error != 0){
            $_SESSION['errormsg'] = "Kindly upload a real file";
            header("location:../agent/agent_profile.php");
            exit;
        }
        // validate the file size
        // if(($id_file_size > (1024 * 1024 * 4)) || ($poa_size > (1024 * 1024 * 4)) || ($cac_file_size > (1024 * 1024 * 4)) || ($ESVARBON_file_size > (1024 * 1024 * 4))){
        //     $_SESSION['errormsg'] = "File size too large. Maximum size must be 4mb";
        //     header("location:../agent/agent_profile.php");
        //     exit;
        // }

        // validate wrong file type
        $ESVARBON_file_extension = pathinfo($ESVARBON_filename, PATHINFO_EXTENSION);
        $ESVARBON_file_extension = strtolower($ESVARBON_file_extension);

        $cac_file_extension = pathinfo($cac_filename, PATHINFO_EXTENSION);
        $cac_file_extension = strtolower($cac_file_extension);

        $accepted = ['jpg', 'jpeg', 'png', 'doc', 'pdf', 'docx'];
        $id_file_extension = pathinfo($id_filename, PATHINFO_EXTENSION);
        $id_file_extension = strtolower($id_file_extension);

        $poa_file_extension = pathinfo($poa_filename, PATHINFO_EXTENSION);
        $poa_file_extension = strtolower($poa_file_extension);


        if(!in_array($id_file_extension, $accepted) || !in_array($poa_file_extension, $accepted) || !in_array($ESVARBON_file_extension, $accepted) || !in_array($cac_file_extension, $accepted)){
            $_SESSION['errormsg'] = "wrong file type. Upload an image wiht extension png or jpg or jpeg";
            header("location:../agent/agent_profile.php");
            exit;
        }
        

        //rename the ESVARBON_file
        $unique_ESVARBON_filename = uniqid("NR_user_").time()."_".$ESVARBON_filename;
        $rsp_ESVARBON = move_uploaded_file($ESVARBON_file_tmp_name, "../media/uploads/ESVARBON/$unique_ESVARBON_filename");

        //rename the cac_file
        $unique_cac_filename = uniqid("NR_user_").time()."_".$cac_filename;
        $rsp_cac = move_uploaded_file($cac_file_tmp_name, "../media/uploads/cac/$unique_cac_filename");

        //rename the id file
        $unique_id_filename = uniqid("NR_user_").time()."_".$id_filename;
        $rsp = move_uploaded_file($id_file_tmp_name, "../media/uploads/id/$unique_id_filename");


        //rename the proof of address file 
        $unique_poa_filename = uniqid("NR_user_").time()."_".$poa_filename;
        $res = move_uploaded_file($poa_tmp_name, "../media/uploads/poa/$unique_poa_filename");

        
            require_once "classes/Agent.php";
            $update_profile = new Agent();
            $update = $update_profile->update_agent_profile($firstname, $lastname, $bio, $years_of_experience, $agency_name, $phone, $id_type, $unique_id_filename, $proof_of_address, $unique_poa_filename, $cac_number, $unique_cac_filename, $ESVARBON_number, $unique_ESVARBON_filename, $about_agency, $location, $_SESSION['agent_online']);

           if($update){
                 $_SESSION['successmsg'] = "Profile Updated, we'll review and get back to you within 24/48 hours";
                header("location:../agent/agent_profile.php");
                exit;
           }
            else{
                $_SESSION['errormsg'] = "profile not updated";
                header("location:../agent/agent_profile.php");
                exit;
            }
    
   
    }
    else{
        "Page not found";
    }


?>