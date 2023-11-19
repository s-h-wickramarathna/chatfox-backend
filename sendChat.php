<?php

$user = json_decode($_GET["u"]);
$friend = $_GET["f"];
$text = $_GET["t"];

if(strlen($text) != 0){
    $conection = new mysqli("localhost", "root", "123456", "chatfox");
    $conection->query("INSERT INTO `chat` (`user_from`,`user_to`,`message`,`date_time`,`status_status_id`) 
    VALUES ('".$user."','".$friend."','".$text."','".date("Y-m-d H:i:s")."','1') ");

    echo(json_encode(1));
}


?>