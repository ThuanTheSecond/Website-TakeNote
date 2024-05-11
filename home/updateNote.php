<?php
session_start();
include("..\utils\utils.php");
include("..\db\dbhelper.php");
if (isset($_POST['title'])) {
    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $nid = $_POST['nid'];
    $userid = $_SESSION['id'];
    $sql = "update note
            set N_title = '$title', N_descritption= '$desc'
            where N_id = $nid && acc_id = '$userid';";
    $result = executeQuery($sql);
}
