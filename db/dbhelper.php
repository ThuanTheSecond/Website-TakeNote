<?php
require_once("config.php");
//  excute sql statment such as: insert, update, delete 
function connect_DB(){
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
    mysqli_set_charset($conn,'utf8');
    if($conn->connect_error){
        var_dump($conn->connect_error);
        die();
    }
    return $conn;
}
function close_DB($conn){
    $conn->close();
}
function executeQuery($sql){
    $conn = connect_DB();
    $result = mysqli_query($conn, $sql);
    close_DB($conn);
    return $result;
}
function executeSelect($sql, $isSingleLine = false){
    $conn = connect_DB();
    $dataList = null;
    $resultset = mysqli_query($conn, $sql);
    switch ($isSingleLine){
        case true:
            $dataList = mysqli_fetch_array($resultset,1);
            break;
        case false:
            $dataList = array();
            while(($row = mysqli_fetch_array($resultset,1)) != null){
                $datList[] = $row;
            } 
    }
    close_DB($conn);
    return $dataList;
}