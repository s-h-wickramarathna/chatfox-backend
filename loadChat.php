<?php

$user_me = json_decode($_GET["u"]);
$user_friend = $_GET["f"];

// echo($user_me." , ".$user_friend);

$conection = new mysqli("localhost", "root", "123456", "chatfox");
$result = $conection->query("SELECT * FROM `chat` WHERE (`user_from`='$user_me' AND `user_to`='$user_friend') OR (`user_from`='$user_friend' AND `user_to`='$user_me') ORDER BY date_time ASC ");

$array = array();

for ($x=0; $x < $result->num_rows; $x++) { 
    $php_object = new stdClass();
    $result_data = $result->fetch_assoc();

    if($result_data["user_from"] == $user_me){
        $php_object->side = "Right";
        $php_object->view = "Sent";

    }else if($result_data["user_to"] == $user_me){
        $php_object->side = "Left";
        $php_object->view = "Seen";
    }

    $php_object->message = $result_data["message"];
    $phpDateTimeObject = strtotime($result_data["date_time"]);
    $timeStr = date("h:i a", $phpDateTimeObject);
    $php_object->time = $timeStr;

    array_push($array,$php_object);

}

$json = json_encode($array);
echo($json);

?>