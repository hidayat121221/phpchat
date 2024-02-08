<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

if(!isset($_SESSION['username'])){
   
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Php chat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="w-400 p-5 shadow rounded">
        <form method="post" action="app/http/auth.php">
            <div class="d-flex justify-content-center align-items-center flex-column">
                <img src="img/logo.png" class="w-25">
            <h3 class="display-4 fs-1 text-center">
                LOGIN
            </h3>
            </div>

        <?php if(isset($_GET['error'])) { ?>
        <div class="alert alert-warning" role="alert">
            <?php echo htmlspecialchars($_GET['error']);?>
            </div>
            <?php } ?>

        <?php if(isset($_GET['success'])) { ?>
            <div class="alert alert-success" role="alert">
                <?php echo htmlspecialchars($_GET['success']);?>
                </div>
                <?php } ?>

            <div class="col-md-12">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control">
            </div>

            <div class="col-md-12">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control">
            </div>
               
            <button type="submit" name="submit" class="btn btn-primary mt-3">Login</button>
            <a href="app/http/signup.php" class="btn btn-success mt-3">signup</a>
        </form>
    </div>
</body>
</html>
<?php
}else{
    header("Location:home.php");
    exit;
}
?>