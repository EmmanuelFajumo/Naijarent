<?php
session_start();

    // if(isset($_POST['view'])){
    //     $agent_id = $_POST['Agent_id'];
    //     header("location: ../Admin/agent_profile.php?agent_id=$agent_id");
    //     exit;
    // }
    if(isset($_POST['verify'])){
        $agent_id = $_POST['agent_id'];
 
        require_once "classes/Admin.php";
        $sta = new Admin();
        $verify = $sta->update_agent_status("verified", $agent_id);
        echo "$agent_id";

        if($verify){
            $_SESSION['successmsg'] = "Agent has been verified successfully.";
            header("location: ../admin/admin_dashboard_manage_agents.php");
            
            exit;
        }
    }
    elseif(isset($_POST['suspend'])){
        $agent_id = $_POST['agent_id'];

        require_once "classes/Admin.php";
        $sta = new Admin();
        $verify = $sta->update_agent_status("suspended", $agent_id);
        if($verify){
            header("location: ../admin/admin_dashboard_manage_agents.php");
            exit;
        }        

    }

