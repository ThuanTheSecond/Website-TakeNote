<?php
    session_start();
    include("..\utils\utils.php");
    include("..\db\dbhelper.php");
    if(isset($_POST['title'])){
        $title = getPost("title");
        $desc = getPost("desc");
        $cateChoice = getPost("cateChoice");
        $userid = $_SESSION['id'];
        $sql= "select * from note where N_title = '$title' && acc_id='$userid'";
        $data = executeSelect($sql, isSingleLine:true);
        if($data == null && $title!=''){
            $sql = "insert into note (N_title, N_descritption, cate_id, acc_id) values ('$title','$desc',$cateChoice,$userid);";
            $result = executeQuery($sql);
            if($result){
                echo '1'; //success
            }else{
                echo '2'; //failed
            }
        }else{
            echo '3'; //category has already exist
        }
    }  
?>