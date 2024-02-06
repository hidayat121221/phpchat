<?php 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

function getChats($id_1, $id_2, $conn) {
    $chats = [];
    $result = '';
    $sql = "SELECT * FROM chats
            WHERE (from_id=? AND to_id=?)
            OR    (to_id=? AND from_id=?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $id_1, $id_2, $id_1, $id_2);
    $stmt->execute();

    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $chats = $result->fetch_all(MYSQLI_ASSOC);
        return $chats;
    } else {
        $chats = [];
        return $chats;
    }
}

?>