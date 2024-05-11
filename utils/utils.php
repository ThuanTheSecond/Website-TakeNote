<?php
function fixSqlInject($sql){
    $sql = str_replace('\\', '\\\\', $sql);
    $sql = str_replace('\'', '\\\'', $sql);
    return $sql;
}
function getPost($key){
    $value ='';
    if(isset($_POST[$key])){
        $value = $_POST[$key];
        $value = fixSqlInject($value);
    }
    return $value;
}
function getCookie($key){
    $value ='';
    if(isset($_COOKIE[$key])){
        $value = $_COOKIE[$key];
        $value = fixSqlInject($value);
    }
    return $value;
}
