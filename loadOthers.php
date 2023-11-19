<?php

$user_id = $_GET["u"];

$conection = new mysqli("localhost", "root", "123456", "chatfox");
$result = $conection->query("SELECT * FROM `friend` WHERE (`me`= $user_id) OR (`friend`= $user_id) ");

$allfriendId = array();

for ($x = 0; $x < $result->num_rows; $x++) {
    $result_data = $result->fetch_assoc();
    $friendId = 0;

    if ($result_data["me"] != $user_id) {
        $friendId = $result_data["me"];
        // echo "friend ".$friendId.", ";

    } else {
        $friendId = $result_data["friend"];
        // echo "me ".$friendId.", ";
    }

    array_push($allfriendId, $friendId);
    array_push($allfriendId, $user_id);
}

$str = implode(',', $allfriendId);
$query;

if(empty($str)){
$query = "SELECT * FROM `user` WHERE `user_id` != $user_id ";

}else{
$query = "SELECT * FROM `user` WHERE `user_id` NOT IN ( $str )";

}

// echo $query;

$result2 = $conection->query($query);
$others = array();
for ($i = 0; $i < $result2->num_rows; $i++) {
    $php_object = new stdClass();


    $other_data = $result2->fetch_assoc();
    $php_object->id = $other_data["user_id"];
    $php_object->name = $other_data["user_name"];
    $php_object->image = $other_data["user_image"];
    $php_object->type = "ADD";

    $result3 = $conection->query("SELECT * FROM `request` WHERE (`user_to`=" . $user_id . " AND `user_from`='" . $php_object->id . "') OR (`user_to`='" . $php_object->id . "' AND `user_from`=" . $user_id . ")");
    if ($result3->num_rows == 1) {
        $php_object->type = "Pending";
    }

    array_push($others, $php_object);
}

$json = json_encode($others);
echo ($json);

?>