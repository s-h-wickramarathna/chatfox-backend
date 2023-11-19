<?php

$user_id = json_decode($_GET["u"]);
// echo $user_id;
$text = " ";
if (isset($_GET["t"])) {
    $text = $_GET["t"];
}

$conection = new mysqli("localhost", "root", "123456", "chatfox");
$result = $conection->query("SELECT * FROM `friend`
INNER JOIN `user` ON `friend`.`friend`=`user`.`user_id`
WHERE (`me`=$user_id OR `friend`=$user_id) OR (`user_name` LIKE '%" . $text . "%')");

// echo "SELECT * FROM `friend`
// INNER JOIN `user` ON `friend`.`friend`=`user`.`user_id`
// WHERE (`me`=$user_id OR `friend`=$user_id) OR (`user_name` LIKE '%" . $text . "%')";

$result_num = $result->num_rows;
if ($result_num == 0) {
    echo (json_encode("No Friends You Have Yet ....."));
} else {
    $array = array();

    for ($x = 0; $x < $result_num; $x++) {
        $phpObject = new stdClass();
        $phpObject->id = null;
        $phpObject->name = null;
        $phpObject->mobile = null;
        $phpObject->image = null;
        $unreadCount = 0;

        $result_data = $result->fetch_assoc();


        if ($result_data["me"] == $user_id && $result_data["friend"] != $user_id) {
            $phpObject->id = $result_data["friend"];

        } else {
            $phpObject->id = $result_data["me"];
            
        }

        // echo $phpObject->id;

        $resultFriend = $conection->query("SELECT * FROM `user` WHERE `user_id`='$phpObject->id' ");
        $resultFriend_num = $resultFriend->num_rows;

        if ($resultFriend_num > 0) {
            $resultFriend_data = $resultFriend->fetch_assoc();
            $phpObject->name = $resultFriend_data["user_name"];
            $phpObject->mobile = $resultFriend_data["user_mobile"];
            $phpObject->image = $resultFriend_data["user_image"];
        }

        $result2 = $conection->query("SELECT * FROM `chat` WHERE (`user_from`=$user_id AND `user_to`='$phpObject->id') OR (`user_from`='$phpObject->id' AND `user_to`=$user_id) ORDER BY `date_time` DESC");
        $result2_num = $result2->num_rows;

        // echo "SELECT * FROM `chat` WHERE (`user_from`=$user_id AND `user_to`='$phpObject->id') OR (`user_from`='$phpObject->id' AND `user_to`=$user_id) ORDER BY `date_time` DESC";

        $result2_data = $result2->fetch_assoc();
        $phpObject->message = $result2_data["message"];

        if ($result2_data["status_status_id"] == 2) {
            $unreadCount++;
            $phpObject->view = "Unseen";
        }

        $phpDateTimeObject = strtotime($result2_data["date_time"]);
        $timeStr = date("h:i a", $phpDateTimeObject);

        $phpObject->time = $timeStr;

        for ($i = 1; $i < $result2_num; $i++) {
            $other_data = $result2->fetch_assoc();

            if ($other_data["status_status_id"] == 2) {
                $unreadCount++;
            }
        }

        $phpObject->count = $unreadCount;
        array_push($array, $phpObject);
    }

    $json = json_encode($array);
    echo ($json);
}
