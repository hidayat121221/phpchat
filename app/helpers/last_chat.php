<?php 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

function lastChat($id_1, $id_2, $conn){
    $conversations = [];
    $result = '';
    $sql = "SELECT * FROM chats
           WHERE (from_id=? AND to_id=?)
           OR    (to_id=? AND from_id=?)
           ORDER BY chat_id DESC LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $id_1, $id_2, $id_1, $id_2);
$stmt->execute();

$result = $stmt->get_result();

    if ($stmt->rowCount() > 0) {
    	$conversations = $result->fetch_all(MYSQLI_ASSOC);
    	return $conversations['message'];
    }else {
    	$conversations = '';
    	return $conversations;
    }

}