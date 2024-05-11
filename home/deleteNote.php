<?php
    session_start();
    include("..\utils\utils.php");
    include("..\db\dbhelper.php");
    if(isset($_POST['nid'])){
        $nid = $_POST['nid'];
        $userid = $_SESSION['id'];
        $sql= "delete from Note where N_id= '$nid' && acc_id= '$userid';";
        $data = executeQuery($sql);
    }  
?>