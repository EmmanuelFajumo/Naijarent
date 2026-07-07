<?php
    session_start();
    require_once "../process_pages/classes/Agent.php";
    $agent = new Agent();
    $det = $agent->fetch_agent_details($_SESSION['agent_online']);
?>

<!DOCTYPE html>
<html lang="en"> 

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Profile</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../animate.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap"
        rel="stylesheet">


    <style>
        

        .inpt{
            border-radius: 30px;
            height: 45px;
            background-color: #f4f5f4;
            
           
        }
    </style>

</head>

<body>
    <!-- Navigation -->
    <?php //include 'nav.php'; ?>



    <div class="container-fluid " style="min-height: 500px; ">
        <div class="row">

            <!-- Sidebar (Profile and Navigation) -->
            <?PHP include 'agent_nav.php'; ?>
            <!-- Sidebar (Profile and Navigation) -->

            <!-- Main Content -->
            
            <div class="col-md-9 px-5 mt-3" >
                <div class="row" style=" justify-content: center; flex-wrap: wrap;">
                    <div class="col-md-4">
                        <div class=" p-4 shadow-sm">
                            <div class="card-body d-flex flex-column align-items-center">
                                <div class=" profile-pic d-flex justify-content-center align-items-center" style="width: 150px; height: 150px; background-color: #f1f1f1; border-radius: 50%; position: relative; overflow: hidden;">
                                    <img src="../media/profile_pictures/<?php echo $det['profile_picture']; ?>" alt="Profile Picture" class="box" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover;" id="profileImagePreview">
                                    <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-50 p-2 text-center" style="cursor: pointer;" onclick="document.getElementById('profilePictureInput').click();">
                                        <small class="text-white"><i class="fas fa-camera"></i></small>
                                    </div>
                                </div>
                                <form id="profilePictureForm" action="../process_pages/process_agent_profile_picture.php" method="post" enctype="multipart/form-data">
                                    <input type="file" id="profilePictureInput" name="profile_picture" accept="image/png, image/jpg, image/jpeg" style="display: none;">
                                    <small class="text-muted mt-2 text-center d-block">Click camera icon to update</small>
                                    <p id="profilePictureMessage"></p>
                                </form>

                                <div class="profile-menu mt-4 text-start">
                                    <a href="agent_dashbord.php" class="d-block py-3 px-5 w-100 text-dark box "><i class="px-2 fa-solid fa-house-user"></i> Personal Information</a>
                                    <a href="agent_listings.php" class="d-block py-3 px-5 w-100 text-dark box "> <i class="px-2 fa-solid fa-list"></i> Professional Information</a>
                                    <a href="agent_messages.php" class="d-block py-3 px-5 w-100 text-dark box "><i class="px-2 fa-regular fa-envelope"></i> Identity Verification</a>
                                    <a href="agent_messages.php" class="d-block py-3 px-5 w-100 text-dark box "><i class="px-2 fa-regular fa-envelope"></i> License Verification</a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-8 py-5">  
                        <?php
                                if(isset($_SESSION['errormsg'])){
                                ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert"><?php echo $_SESSION['errormsg'];  unset($_SESSION['errormsg']);?>
                                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php
                                    }
                                ?>

                                <?php
                                    if(isset($_SESSION['successmsg'])){
                                ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert"><?php echo $_SESSION['successmsg'];  unset($_SESSION['successmsg']);?>
                                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                                
                                </div>
                                <?php
                                    }
                                ?>          
                        <form action="../process_pages/process_agent_profile_update.php" method="post" id='personal_info_form' class="py-5" enctype='multipart/form-data'>
                            <!-- Personal Information -->
                            <div class="card p-4 d-block" id="personal_info">
                                <h2 class="mb-4">Personal Information</h2>
                                <div class="mb-3 d-flex gap-3">
                                    <div class="w-50">
                                        <label for="name" class="form-label text-muted">First Name</label>
                                        <input type="text" class="form-control inpt" name="firstname" value="<?php echo $det['first_name']; ?>" >
                                    </div>
                                    <div class="w-50">
                                        <label for="name" class="form-label text-muted">Last Name</label>
                                        <input type="text" class="form-control inpt" name='lastname' value="<?php echo $det['last_name']; ?>">
                                    </div>
                                </div>
                                <div class="my-3">
                                        <div class="mb-3">
                                            <label for="bio" class="form-label text-muted">Bio</label>
                                            <textarea class="form-control " id="bio" rows="4" name='bio' name="bio"><?php echo $det['agent_bio']; ?></textarea>
                                        </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label text-muted">Email Address</label>
                                    <input type="email" class="form-control inpt" id="email" value="<?php echo $det['email']; ?>">
                                </div>
                                <div class="mb-3 ">
                                        <label for="address" class="form-label text-muted">Address</label>
                                        <input type="text" class="form-control inpt"  value="123 Main St" name="address">
                                    </div>
                                <div class="mb-3 d-flex gap-3">
                                    <div class="w-50">
                                        <label for="phone" class="form-label text-muted">Phone Number</label>
                                        <input type="tel" class="form-control inpt" name='phone' value="+234 801 234 5678">
                                    </div>
                                    <div class="w-50">
                                        <label for="address" class="form-label text-muted">Date of Birth</label>
                                        <input type="date" class="form-control inpt" value="1990-01-01" name="dob">
                                    </div>
                                </div>
                                <div class="mb-3 d-flex gap-3">
                                    <div class="w-50">
                                        <label for="location" class="form-label text-muted">Location</label>
                                        <input type="text" class="form-control inpt" id="location" value="Lagos, Nigeria" name="location">
                                    </div>
                                    <div class="w-50">
                                        <label for="postal_code" class="form-label text-muted">Postal Code</label>
                                        <input type="text" class="form-control inpt" id="postal_code" value="100001" name="postal_code">
                                    </div>
                                </div>
                                
                                <div class="mb-3 d-flex  gap-3">
                                    <button class="btn btn-outline-primary w-50">Discard Changes</button>
                                    <button class="btn btn-primary w-50" id="save_personal_info" type='button'>Save Changes</button>
                                </div>
                            </div>

                            <!-- Professional Information -->
                             <div class="card p-4 d-none" id='professional_info'>
                                <h2 class="mb-4">Professional Information</h2>
                                <div class="mb-4">
                                    <label for="agency_name" class="form-label text-muted">Agency Name</label>
                                    <input type="text" class="form-control inpt" id="agency_name" value="ABC Real Estate Agency" name="agency_name">
                                </div>

                                <div class="mb-4 d-flex gap-3">
                                    <div class="w-50">
                                        <label for="years_of_experience" class="form-label text-muted">Years of Experience</label>
                                        <input type="number" class="form-control inpt" id="years_of_experience" value="10" name="years_of_experience">
                                    </div>
                                </div>
                                <div class="my-4">
                                        <div class="mb-3">
                                            <label for="about_agency" class="form-label text-muted">About Agency</label>
                                            <textarea class="form-control " id="about_agency" rows="4" name="about_agency">Experienced real estate agent with a passion for helping clients find their dream homes. With over 10 years in the industry, I specialize in residential properties and have a deep understanding of the local market.</textarea>
                                        </div>
                                </div>
                                
                                <div class="mb-3 ">
                                        <label for="agency_address" class="form-label text-muted">Agency Address</label>
                                        <input type="text" class="form-control inpt" id="agency_address" value="123 Main St" name="agency_address">
                                </div>
                                 <div class="mb-3 d-flex gap-3">
                                    <div class="w-50">
                                        <label for="agency_location" class="form-label text-muted">Location</label>
                                        <input type="text" class="form-control inpt" id="agency_location" value="Lagos, Nigeria" name="agency_location">
                                    </div>
                                    <div class="w-50">
                                        <label for="agency_postal_code" class="form-label text-muted">Postal Code</label>
                                        <input type="text" class="form-control inpt" id="agency_postal_code" value="100001" name="agency_postal_code">
                                    </div>
                                </div>
                                <div class="mb-3 d-flex  gap-3">
                                    <button class="btn btn-outline-primary w-50">Discard Changes</button>
                                    <button class="btn btn-primary w-50" id='save_professional_info' type='button'>Save Changes</button>
                                </div>

                            </div>

                            <!-- Identity Verificatiion -->
                             <div class="card p-4 d-none" id="identity_info">
                                    <h2 class="mb-4">Identity Verification</h2>
                                    <div class="mb-3 d-flex gap-3">
                                        <div class="w-50">
                                            <label for="agency_name" class="form-label text-muted">Government-issued ID</label>
                                            <select name="id_type" id="id_type" class="form-select inpt">
                                                <option value="">Select ID Type</option>
                                                <option value="passport">Passport</option>
                                                <option value="driver_license">Driver's License</option>
                                                <option value="national_id">National ID</option>
                                            </select>
                                        </div>
                                        <div class="w-50">
                                             <label for="government_issued_id_file" class="form-label text-muted">Upload Government-issued ID</label>
                                            <input type="file" value=''name="id_file" class='form-control inpt' accept='image/png, image/jpg, image/jpeg, .pdf,.doc,.docx'>
                                        </div>
                                    </div>

                                    <div class="mb-3 d-flex gap-3">
                                        <div class="w-50">
                                            <label for="proof_of_address" class="form-label text-muted">Proof of Address</label>
                                            <select name="proof_of_address" id="proof_of_address" class="form-select inpt">
                                                <option value="">Select Document Type</option>
                                                <option value="utility_bill">Utility Bill</option>
                                                <option value="bank_statement">Bank Statement</option>
                                            </select>
                                        </div>
                                        <div class="w-50">
                                             <label for="poa_file" class="form-label text-muted">Upload Proof of Address</label>
                                            <input type="file" value='proof_of_address_file' name='proof_of_address' class='form-control inpt' accept='image/png, image/jpg, image/jpeg, .pdf,.doc,.docx'>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-5">
                                            <label for="selfie_verification" class="form-label text-muted">Selfie Verification</label>
                                            <input type="file" class="form-control inpt" id="selfie_verification" value="123 Main St" name="selfie_verification" accept='image/png, image/jpg, image/jpeg'>
                                    </div>
                                   
                                    <div class="mb-3 d-flex  gap-3">
                                        <button class="btn btn-outline-primary w-50">Discard Changes</button>
                                        <button class="btn btn-primary w-50" type='button' id='save_identity_info'>Save Changes</button>
                                    </div>
                             </div>

                             <!-- License Verification -->
                              <div class="card p-4 d-none" id="licence_info">
                                    <h2 class="mb-4">License Verification</h2>
                                    <div class="mb-4 d-flex gap-3">
                                        <div class="w-50">
                                             <label for="" class="form-label text-muted">CAC  Registration Number</label>
                                            <input type="text" name='cac' value='' class='form-control inpt'>
                                        </div>
                                        <div class="w-50">
                                            <label for="agency_name" class="form-label text-muted">CAC Certificate of Registration</label>
                                            <input type="file" value='' name='cac_file' class='form-control inpt'>
                                        </div>
                                       
                                    </div>

                                    <div class="mb-4 d-flex gap-3">
                                        <div class="w-50">
                                             <label for="" class="form-label text-muted">ESVARBON Registration Number</label>
                                            <input type="text" name='ESVARBON_number' value='' class='form-control inpt'>
                                        </div>
                                        <div class="w-50">
                                            <label for="agency_name" class="form-label text-muted">ESVARBON Certificate of Registration</label>
                                            <input type="file" name='ESVARBON' value='' class='form-control inpt'>
                                        </div>
                                    </div>

                                    <div class="mb-4 d-flex gap-3">
                                        <div class="w-50">
                                             <label for="government_issued_id_file" class="form-label text-muted">NIESV Membership Membership Number</label>
                                            <input type="text" value='' class='form-control inpt'>
                                        </div>
                                        <div class="w-50">
                                            <label for="agency_name" class="form-label text-muted">NIESV Membership Certificate</label>
                                            <input type="file" value='' class='form-control inpt'>
                                        </div>
                                    </div>

                                    <div class="mb-4 d-flex gap-3">
                                        <div class="w-50">
                                             <label for="government_issued_id_file" class="form-label text-muted">NAEAN Membership Number</label>
                                            <input type="text" value='' class='form-control inpt'>
                                        </div>
                                        <div class="w-50">
                                            <label for="agency_name" class="form-label text-muted">NAEAN Membership Certificate</label>
                                            <input type="file" value='' class='form-control inpt'>
                                        </div>
                                    </div>
                                    
                                    
                                   
                                    <div class="mb-5 d-flex  gap-3">
                                        <button class="btn btn-outline-primary w-50">Discard Changes</button>
                                        <button class="btn btn-primary w-50" name="update_profile">Save Changes</button>
                                    </div>
                             </div>  
                        </form>                         
                    </div>
                </div>
            </div>

             <!-- Main Content End-->

        </div>
    </div>

      <!-- footer -->
        <?php // include '../footer.php'; ?>
      <!-- footer -->
    <script src="../jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // Preview profile image before upload
        function previewProfileImage(event) {
            const file = event.target.files[0];
            if (file) {
                // Validate file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    $('#profilePictureMessage').text('File size must be less than 5MB.').css('color', 'red');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profileImagePreview').src = e.target.result;
                };
                reader.readAsDataURL(file);

                // Upload the file
                uploadProfilePicture(file);
            }
        }

        function uploadProfilePicture(file) {
            const formData = new FormData();
            formData.append('profile_picture', file);

            $.ajax({
                url: '../process_pages/process_agent_profile_picture.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('Response:', response);
                    $('#profilePictureMessage').text('Profile picture updated successfully!').css('color', 'green');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#profilePictureMessage').text('Error updating profile picture. ' + xhr.responseText).css('color', 'red');
                }
            });
        }
        
        $(document).ready(function(){
            $('#profilePictureInput').on('change', function(e) {
                previewProfileImage(e);
            });

            $('#save_personal_info').click(function(){
                $('#personal_info').removeClass("d-block").addClass("d-none");
                $('#professional_info').removeClass('d-none').addClass('d-block');
                $('#identity_info').hide();
                $('#licence_info').hide();
            });

             $('#save_professional_info').click(function(){
             $('#personal_info').addClass("d-none");
             $('#professional_info').removeClass("d-block").addClass('d-none');
             $('#identity_info').removeClass('d-none').addClass('d-block').show();
             $('#licence_info').hide();
            });

            $('#save_identity_info').click(function(){
             $('#personal_info').addClass("d-none");
             $('#professional_info').addClass("d-none");
             $('#identity_info').removeClass("d-block").addClass("d-none");
             $('#licence_info').addClass("d-block").removeClass("d-none").show();
            });

            $('#save_licence_info').click(function(){
             $('#personal_info').addClass("d-none");
             $('#professional_info').addClass("d-none");
             $('#identity_info').removeClass("d-block").addCLass("d-none");
             $('#licence_info').addClass("d-block").removeClass("d-none");
            });
        });
    </script>
</body>

</html>