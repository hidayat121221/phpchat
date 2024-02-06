<?php 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

if (isset($_SESSION['username'])) {

    if (isset($_POST['id_2'])) {
        include '../db.conn.php';

        $id_1  = $_SESSION['user_id'];
        $id_2  = $_POST['id_2'];
        $opened = 0;

        $sql = "SELECT * FROM chats
                WHERE (to_id=? AND from_id= ?) OR (from_id=? AND to_id= ?)
                ORDER BY chat_id ASC";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiii", $id_1, $id_2, $id_2, $id_1);
        $stmt->execute();
        $result = $stmt->get_result();
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            $chats = $result->fetch_all(MYSQLI_ASSOC);

            // Update each record individually
            foreach ($chats as $chat) {
                if ($chat['opened'] == 0) {
                    $opened = 1;

                    $sql2 = "UPDATE chats SET opened = 1 WHERE chat_id = ?";
                    $stmt2 = $conn->prepare($sql2);
                    $stmt2->bind_param("i", $chat['chat_id']);
                    $stmt2->execute();

                    ?>
                    <p class="ltext border rounded p-2 mb-1">
                        <?=$chat['message']?> 
                        <small class="d-block">
                            <?=$chat['created_at']?>
                        </small>      	
                    </p>        
                    <?php
                }
            }
        }
    }
} else {
    header("Location: ../../index.php");
    exit;
}
?>
