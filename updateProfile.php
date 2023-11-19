<?php

$name = $_POST["name"];
$mobile = $_POST["mobile"];
$about = $_POST["about"];
$id = $_POST["id"];
$profileImage = $_FILES["image"]["tmp_name"];
$basename = basename($_FILES['image']['name']);

// echo($name." ");
// echo($mobile." ");
// echo($about." ");
// echo($basename);
echo($profileImage);

$conection = new mysqli("localhost", "root", "123456", "chatfox");
$result = $conection->query("UPDATE `user` SET `user_name`='" . $name. "',
 `user_about`='" . $about. "',
 `user_image`='" . "chatfox/uploads/". $mobile . ".jpeg" . "'
 WHERE `user_id`='".$id."' ");

move_uploaded_file($profileImage, "./uploads/" . $mobile . ".jpeg");

echo(json_encode(1));
?>
