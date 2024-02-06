<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

if (isset($_SESSION['username'])) {
   
if (isset($_POST['key'])) {
    include '../db.conn.php';

    $key = $_POST['key'];
    $key = "%{$key}%";

    $sql = "SELECT * FROM users
            WHERE username LIKE ? OR name LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $key, $key);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($user = $result->fetch_assoc()) {
            // Check if 'id' key exists in the $user array
            if (isset($user['username']) && $user['username'] == $_SESSION['username']) continue;
?>
            <li class="list-group-item">
                <a href="chat.php?user=<?= $user['username'] ?>"
                   class="d-flex justify-content-between align-items-center p-2">
                    <div class="d-flex align-items-center">
                        <img src="uploads/<?= $user['p_p'] ?>" class="w-10 rounded-circle">
                        <h3 class="fs-xs m-2">
                            <?= $user['name'] ?>
                        </h3>
                    </div>
                </a>
            </li>
<?php
        }
    } else {
?>
        <div class="alert alert-info text-center">
            <i class="fa fa-user-times d-block fs-big"></i>
            The user "<?= htmlspecialchars($_POST['key']) ?>" is not found.
        </div>
<?php
    }
    $stmt->close();
}

		include '../db.conn.php';
	
		$key = $_POST['key'];
		$key = "%{$key}%";
	
		$sql = "SELECT * FROM users
				WHERE username LIKE ? OR name LIKE ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ss", $key, $key);
		$stmt->execute();
		$result = $stmt->get_result();
	

	

}else {
	header("Location: ../../index.php");
	exit;
}
?>
