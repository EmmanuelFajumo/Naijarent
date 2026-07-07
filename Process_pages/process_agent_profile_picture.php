<?php
    session_start();
    header('Content-Type: application/json');

    // Check if file is uploaded
    if (!isset($_FILES['profile_picture']) || $_FILES['profile_picture']['error'] != UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'No file uploaded or upload error occurred']);
        exit;
    }

    $profile_picture_tmp_name = $_FILES['profile_picture']['tmp_name'];
    $profile_picture_name = $_FILES['profile_picture']['name'];
    $profile_picture_size = $_FILES['profile_picture']['size'];
    $profile_picture_error = $_FILES['profile_picture']['error'];

    // Validate file type
    $allowed_extensions = ['jpg', 'jpeg', 'png'];
    $file_extension = strtolower(pathinfo($profile_picture_name, PATHINFO_EXTENSION));

    if (!in_array($file_extension, $allowed_extensions)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid profile picture format. Only JPG, JPEG, and PNG are allowed']);
        exit;
    }

    // Validate file size (max 5MB)
    if ($profile_picture_size > 5 * 1024 * 1024) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'File size must be less than 5MB']);
        exit;
    }

    // Create upload directory if it doesn't exist
    $upload_directory = "../media/profile_pictures/";
    if (!is_dir($upload_directory)) {
        mkdir($upload_directory, 0755, true);
    }

    // Rename the profile picture
    $unique_profile_picture_name = uniqid("NR_agent_").time()."_". $profile_picture_name;
    
    require_once "classes/Agent.php";
    $update_profile = new Agent();
    
    // Update database first
    $res = $update_profile->update_agent_profile_picture($unique_profile_picture_name, $_SESSION['agent_online']);
    
    if((int)$res > 0 ){
        // Move file after database update succeeds
        if(move_uploaded_file($profile_picture_tmp_name, $upload_directory . $unique_profile_picture_name)){
            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'Profile picture updated successfully', 'filename' => $unique_profile_picture_name]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file']);
            exit;
        }
    }
    else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error updating profile picture in database']);
        exit;
    }
?>