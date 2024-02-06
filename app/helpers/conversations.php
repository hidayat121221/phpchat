<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
function getConversation($user_id, $conn)
{
    $sql = "SELECT * FROM conversations WHERE user_1=? OR user_2=? ORDER BY conversation_id DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id, $user_id]);

    if ($stmt->num_rows() > 0) {
        $conversations = $stmt->fetchAll();
        $user_data = [];

        foreach ($conversations as $conversation) {
            $other_user_id = ($conversation['user_1'] == $user_id) ? $conversation['user_2'] : $conversation['user_1'];

            $sql2 = "SELECT name, username, p_p, last_seen FROM users WHERE user_id=?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute([$other_user_id]);
            $allconversations = $stmt2->fetchAll();

            array_push($user_data, $allconversations[0]);
        }

        return $user_data;
    } else {
        $conversations = [];
        return $conversations;
    }
}