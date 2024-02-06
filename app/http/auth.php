<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();
if (isset($_POST['username']) && isset($_POST['password'])) {

    include '../db.conn.php';

    $password = $_POST['password'];
    $username = $_POST['username'];

    if (empty($username)) {
        $em = "Username is required";
        header("Location: ../../index.php?error=$em");
    } else if (empty($password)) {
        $em = "Password is required";
        header("Location: ../../index.php?error=$em");
    } else {

        $sql = "SELECT * FROM `users` WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username); 
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if ($user['username'] === $username && password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['user_id'] = $user['id'];
                
                header("Location: ../../home.php");
            } else {
                $em = "Incorrect username or password";
                header("Location: ../../index.php?error=$em");
            }
        } else {
            $em = "Incorrect username or password";
            header("Location: ../../index.php?error=$em");
        }
    }
} else {
    header("Location: ../../index.php");
    exit;
}
