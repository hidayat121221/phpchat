<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

if (isset($_SESSION['username'])) {
    if (isset($_POST['message']) && isset($_POST['to_id'])) {

        include '../db.conn.php';

        $message = $_POST['message'];
        $to_id = $_POST['to_id'];
		
        $from_id = $_SESSION['user_id'];
		
        // Check if $from_id is not NULL
        if (empty($from_id)) {
            echo "Error: 'from_id' is NULL in the session.";
            exit;
        }

        // Use prepared statement to prevent SQL injection
        $sql = "INSERT INTO chats (from_id, to_id, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            echo "Error preparing statement: " . $conn->error;
            exit;
        }

        $res = $stmt->execute([$from_id, $to_id, $message]);

        if ($res) {
            $sql2 = "SELECT * FROM conversations
                     WHERE (user_1=? AND user_2=?)
                     OR    (user_2=? AND user_1=?)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute([$from_id, $to_id, $from_id, $to_id]);

            define('TIMEZONE', 'Africa/Addis_Ababa');
            date_default_timezone_set(TIMEZONE);
            $time = date("h:i:s a");

            $result = $stmt2->fetch();

            if (!$result) {
                $sql3 = "INSERT INTO conversations(user_1, user_2) VALUES (?,?)";
                $stmt3 = $conn->prepare($sql3);

                if (!$stmt3) {
                    echo "Error preparing statement: " . $conn->error;
                    exit;
                }

                $stmt3->execute([$from_id, $to_id]);
            }
            ?>

            <p class="rtext align-self-end border rounded p-2 mb-1">
                <?=$message?>
                <small class="d-block"><?=$time?></small>
            </p>
        <?php
        } else {
            echo "Error executing statement: " . $stmt->error;
        }
    }
} else {
    header("Location: ../../index.php");
    exit;
}
?>
