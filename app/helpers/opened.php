<?php 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

function opened($id_1, $conn, $chats) {
    // echo "<pre>";
    // print_r($chats);

    // foreach ($chats as $chat) {
    //     $chat_id = $chat['chat_id'];
    //     if ($chat['opened'] == 0) {
    //         $opened = 1;

    //         $sql = "UPDATE chats
    //                 SET   opened = ?
    //                 WHERE from_id=? 
    //                 AND   chat_id = ?";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->execute([$opened, $id_1, $chat_id]);
    //     }
    // }
}