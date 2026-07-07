<?php
session_start();

    if(isset($_POST['view'])){
        $agent_id = $_POST['agent_id'];
        $_SESSION["agent_id"] = $agent_id;
        header("location: ../Admin/view_profile/agent_profile.php");
        exit;
    }
    elseif(isset($_POST['verify'])){
        $agent_id = $_POST['agent_id'];

        require_once "classes/Admin.php";
        $sta = new Admin();
        $verify = $sta->update_agent_status("verified", $agent_id);
        if($verify){
            header("location: ../admin/admin_dashboard_manage_agents.php");
            exit;
        }

    }
    elseif(isset($_POST['banned'])){
        $agent_id = $_POST['agent_id'];

        require_once "classes/Admin.php";
        $sta = new Admin();
        $verify = $sta->update_agent_status("banned", $agent_id);
        if($verify){
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

