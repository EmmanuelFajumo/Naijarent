<?php
    
   require_once "classes/Utilities.php";
    if(isset($_GET['state_id'])){
        $a = new Utilities();
        $lgas =  $a->fecht_lga_by_state_id($_GET['state_id']);
        
        $lgass = "";

        foreach($lgas as $lga){
            $lgass = $lgass  ."<option value='".$lga['LGA_id']."'>".$lga['LGA_name']."</option>";
        }
       echo $lgass;
        
  }


?>