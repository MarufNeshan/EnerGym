<?php
session_start();
include 'include/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login_form.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $weight = $_POST['weight'];
    $height = $_POST['height'];

    if ($weight > 0 && $height > 0) {
        $height_m = $height / 100;
        $bmi = $weight / ($height_m * $height_m);

        $sql = "INSERT INTO progress_log (user_id, weight, height, bmi) 
                VALUES ($user_id, $weight, $height, $bmi)";

        if ($conn->query($sql) === TRUE) {
            $success = "Progress logged successfully!";
        } else {
            $error = "Failed to log progress: " . $conn->error;
        }
    } else {
        $error = "Invalid weight or height.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Log Fitness Progress</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(27, 4, 50, 0.6), rgba(26, 91, 109, 0.6)),
                        url('images/m-2.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .form-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            padding: 40px;
            border-radius: 16px;
            color: #fff;
            width: 400px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #4a63ff;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 10px;
        }

        .message {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
        }

        .success { color: #90ee90; }
        .error { color: #ff6b6b; }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Log Fitness Progress</h2>

    <?php if ($success): ?>
        <p class="message success"><?= $success ?></p>
    <?php endif; ?>
    <?php if ($error): ?>
        <p class="message error"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="weight">Weight (kg):</label>
        <input type="number" name="weight" step="0.1" required>

        <label for="height">Height (cm):</label>
        <input type="number" name="height" step="0.1" required>

        <button type="submit">Log Progress</button>
    </form>
</div>

</body>
</html>
