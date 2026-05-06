<?php
session_start();
include('../include/db_connect.php');

// Allow only admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login_form.php');
    exit();
}

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO notifications (subject, message) VALUES (?, ?)");
    $stmt->bind_param("ss", $subject, $message);

    if ($stmt->execute()) {
        $success = "Notification saved successfully.";
    } else {
        $error = "Failed to save message.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Send Notification</title>
    <style>
        body { font-family: Arial; padding: 40px; background: #f5f7ff; }
        textarea, input { width: 100%; padding: 12px; margin-bottom: 15px; font-size: 15px; }
        button { padding: 12px 20px; background: #4a63ff; color: white; border: none; font-size: 16px; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>

    <h2>Send Notification to Users</h2>

    <?php if ($success) echo "<p class='success'>$success</p>"; ?>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <label>Subject:</label>
        <input type="text" name="subject" required>

        <label>Message:</label>
        <textarea name="message" rows="6" required></textarea>

        <button type="submit">Save Notification</button>
    </form>

</body>
</html>
