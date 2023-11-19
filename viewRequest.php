<?php

$user_id = $_GET["u"];

$conection = new mysqli("localhost", "root", "123456", "chatfox");
// echo("SELECT * FROM `request` INNER JOIN `user` ON `user`.`user_id`=`request`.`user_to` WHERE `user_from`=".$user_id." ");
$result = $conection->query("SELECT * FROM `request` INNER JOIN `user` ON `user`.`user_id`=`request`.`user_to` WHERE `user_from`=".$user_id." ");

$array = array();

if($result->num_rows != 0){
    for ($x=0; $x < $result->num_rows; $x++) { 
        $php_object = new stdClass();
        $result_data = $result->fetch_assoc();

        $php_object->image = $result_data["user_image"];
        $php_object->name = $result_data["user_name"];
        $php_object->rid = $result_data["request_id"];

        array_push($array,$php_object);

    }
    
}

$json = json_encode($array);
echo($json);

?>