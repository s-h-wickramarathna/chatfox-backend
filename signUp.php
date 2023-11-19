<?php


$name = $_POST["userName"];
$password = $_POST["newPassword"];
$confirm_Password = $_POST["confirmPassword"];
$mobile = $_POST["userMobile"];
$city = $_POST["userCity"];
// echo($name." , ".$city." , ".$password." , ".$confirm_Password." , ".$mobile." , ".$_FILES["profileimage"]["tmp_name"]);
$profileImage = $_FILES["profileimage"]["tmp_name"];

if (strlen($name) > 45 || strlen($name) < 1) {
    echo ("Invalid User Name");
} else if (strlen($password) > 20 || strlen($password) < 5) {
    echo ('Invalid User Password');
} else if ($password != $confirm_Password) {
    echo ("Password Dosen't Match");
} else if (empty($city)) {
    echo ('Please Select Your City');
} else if (strlen($mobile) != 10 || !preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $mobile)) {
    echo ('Invalid User Mobile Number');
} else {

    $conection = new mysqli("localhost", "root", "123456", "chatfox","3306");
    $result = $conection->query("SELECT * FROM `city` WHERE `city_name`='" . $city . "' ");
    $city_data = $result->fetch_assoc();

    $conection->query("INSERT INTO `user`(`user_name`,`user_mobile`,`user_password`,`user_image`,`user_about`,`city_city_id`)
                       VALUES ('" . $name . "','" . $mobile . "','" . $password . "','null','','" . $city_data["city_id"] . "') ");

    if ($profileImage != "") {
        $conection->query("UPDATE `user` SET `user_image`='" . "chatfox/uploads/" . $mobile . ".jpeg" . "' WHERE `user_mobile`='".$mobile."' ");
        move_uploaded_file($profileImage, "./uploads/" . $mobile . ".jpeg");
    }


    echo ("1");
}
