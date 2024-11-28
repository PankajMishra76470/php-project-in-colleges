<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: dashboard.php");
}

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    require_once "database.php";
    $sql = "SELECT * FROM users WHERE email = '$email' AND role = 'admin'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user"] = "admin";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Invalid login credentials</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Admin Login</h2>
        <form action="admin_login.php" method="post">
            <div class="form-group">
                <input type="email" name="email" placeholder="Enter Email" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Enter Password" class="form-control" required>
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
    </div>
</body>
</html>
