<?php

$request = $_GET["r"];

$conection = new mysqli("localhost", "root", "123456", "chatfox");
$result = $conection->query("SELECT * FROM `request`WHERE `request_id`='".$request."' ");

$result_data = $result->fetch_assoc();

$conection->query("INSERT INTO `friend`(`me`,`friend`,`block_block_id`) VALUES('".$result_data["user_from"]."','".$result_data["user_to"]."','2') ");
$conection->query("INSERT INTO `chat`(`user_from`,`user_to`,`message`,`date_time`,`status_status_id`) 
VALUES('".$result_data["user_to"]."','".$result_data["user_from"]."','Hello Friend','".date("Y-m-d H:i:s")."','1') ");


$conection->query("DELETE FROM `request` WHERE `request_id`='".$request."'");

echo(json_encode(1));


?>