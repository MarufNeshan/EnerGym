<?php
session_start();
include 'include/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login_form.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$today = date("Y-m-d");

$sql = "INSERT IGNORE INTO attendance (user_id, date) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user_id, $today);

if ($stmt->execute()) {
    $_SESSION['message'] = "Attendance marked for today!";
} else {
    $_SESSION['message'] = "Error marking attendance.";
}

header("Location: dashboard.php");
exit();
?>
