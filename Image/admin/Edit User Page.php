<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"] !== "admin") {
    header("Location: admin_login.php");
    exit();
}

require_once "database.php";

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = '$userId'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fullName = $_POST['fullname'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        // Update user information
        $updateSql = "UPDATE users SET full_name = ?, email = ?, role = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $updateSql);
        mysqli_stmt_bind_param($stmt, "sssi", $fullName, $email, $role, $userId);
        mysqli_stmt_execute($stmt);
        
        header("Location: admin_dashboard.php");
        exit();
    }
} else {
    echo "User not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Edit User</h2>
        <form action="edit_user.php?id=<?= $user['id'] ?>" method="post">
            <div class="form-group">
                <input type="text" name="fullname" value="<?= $user['full_name'] ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" value="<?= $user['email'] ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <select name="role" class="form-control" required>
                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
            <div class="form-btn">
                <input type="submit" value="Update" class="btn btn-primary">
            </div>
        </form>
    </div>
</body>
</html>
