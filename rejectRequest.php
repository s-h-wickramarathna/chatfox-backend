<?php

$request = $_GET["r"];

$conection = new mysqli("localhost", "root", "123456", "chatfox");
$conection->query("DELETE FROM `request` WHERE `request_id`='".$request."'");

echo(json_encode(1));


?>