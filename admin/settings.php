<?php
session_start();

// Protect admin access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login_form.php');
    exit();
}

include('../include/db_connect.php'); // should come after session check

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_map_link = $_POST['map_embed_link'];
    $conn->query("UPDATE site_settings SET map_embed_link = '$new_map_link' WHERE id = 1");
}

// Fetch current link
$result = $conn->query("SELECT map_embed_link FROM site_settings WHERE id = 1");
$current = $result->fetch_assoc();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Admin - Update Map</title>
    <style>
        body {
            font-family: Arial;
            padding: 40px;
            background: #f0f4ff;
        }

        textarea {
            width: 100%;
            height: 150px;
            padding: 10px;
            font-size: 14px;
        }

        button {
            padding: 10px 20px;
            background: #4a63ff;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        h2 {
            color: #333;
        }
    </style>
</head>
<body>
    <h2>Update Google Map Embed Code</h2>
    <form method="post">
        <textarea name="map_embed_link" required><?= htmlspecialchars($current['map_embed_link']) ?></textarea>
        <br>
        <button type="submit">Save Map</button>
    </form>
</body>
</html>
