<?php

$user_id = $_GET["u"];
$friend_id = $_GET["f"];


$conection = new mysqli("localhost", "root", "123456", "chatfox");
$result = $conection->query("INSERT INTO `request`(`user_to`,`user_from`) VALUES ('".$user_id."','".$friend_id."') ");

echo(json_encode(1));

?>