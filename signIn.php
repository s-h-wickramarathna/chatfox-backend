<?php

$user_details = json_decode($_POST["signInDetails"]);

$mobile = $user_details->mobile;
$password = $user_details->password;

if(!empty($mobile) || !empty($password)){
    $conection = new mysqli("localhost", "root", "123456", "chatfox");
    $result = $conection->query("SELECT * FROM `user` WHERE `user_mobile`='".$mobile."' AND `user_password`='".$password."' ");
    
    
    if($result->num_rows == 1){
        $result_data = $result->fetch_assoc();
        echo(json_encode($result_data["user_id"]));
    
    }else{
        echo(json_encode('Invalid Login Details'));
    }
}




?>