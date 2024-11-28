<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"] !== "admin") {
    header("Location: admin_login.php");
    exit();
}

require_once "database.php";

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $sql = "DELETE FROM users WHERE id = '$userId'";
    if (mysqli_query($conn, $sql)) {
        header("Location: admin_dashboard.php");
    } else {
        echo "Error deleting user.";
    }
}
?>
