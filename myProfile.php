<?php

$user = json_decode($_GET["u"]);

$conection = new mysqli("localhost", "root", "123456", "chatfox");
$result = $conection->query("SELECT * FROM `user` WHERE `user_id`='".$user."' ");

$array = array();

$php_object = new stdClass();
$result_data = $result->fetch_assoc();

$php_object->name = $result_data["user_name"];
$php_object->about = $result_data["user_about"];
$php_object->mobile = $result_data["user_mobile"];
$php_object->image = $result_data["user_image"];



// array_push($array, $php_object);

$json = json_encode($php_object);
echo($json);

?>
