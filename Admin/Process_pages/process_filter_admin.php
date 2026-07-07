<?php

if(isset($_GET['search'])){
    $keyword = $_GET['search'];
    include_once 'classes/User.php';
    $user = new User();
    $resp = $user->search_user($keyword);
    if($resp == false){
        echo "No user found with the keyword: " . $keyword;
    }
    else{
        echo "<pre>";
        print_r($resp);
        echo "</pre>";
    }
}
else{
    echo "No search keyword provided.";
}
