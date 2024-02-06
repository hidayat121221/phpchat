<?php  
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

if (isset($_SESSION['username'])) {
	
	include '../db.conn.php';

	$id = $_SESSION['id'];

	$sql = "UPDATE users
	        SET last_seen = NOW() 
	        WHERE user_id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);

}else {
	header("Location: ../../index.php");
	exit;
}