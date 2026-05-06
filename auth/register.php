<?php
include('../include/db_connect.php');

$success = false;
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $weight   = $_POST['weight'];
    $height   = $_POST['height'];

    $sql = "INSERT INTO users (name, email, password, weight, height) 
            VALUES ('$name', '$email', '$password', '$weight', '$height')";

    if ($conn->query($sql) === TRUE) {
        $success = true;
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration Status</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      height: 100vh;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(rgba(64, 49, 64, 0.5), rgba(47, 50, 63, 0.5)),
        url('../images/m-1.jpg') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
    }

    .message-box {
      background: rgba(83, 84, 80, 0.84);
      padding: 50px;
      border-radius: 16px;
      text-align: center;
      max-width: 500px;
      box-shadow: 0 8px 25px rgba(75, 68, 68, 0.3);
    }

    .message-box h2 {
      font-size: 30px;
      margin-bottom: 20px;
      color: #fff;
      text-shadow: 1px 1px 2px #000;
    }

    .message-box p {
      font-size: 16px;
      margin-bottom: 30px;
    }

    .message-box a {
      text-decoration: none;
      background: #fff;
      color: #4a63ff;
      padding: 12px 20px;
      border-radius: 8px;
      font-weight: bold;
      transition: background 0.3s;
    }

    .message-box a:hover {
      background: #eee;
    }
  </style>
</head>
<body>

<div class="message-box">
  <?php if ($success): ?>
    <h2>🎉 Registration Successful!</h2>
    <p>Your account has been created. You can now log in to your dashboard.</p>
    <a href="../login_form.php">Login Now</a>
  <?php else: ?>
    <h2>❌ Registration Failed</h2>
    <p><?= htmlspecialchars($error); ?></p>
    <a href="javascript:history.back()">Go Back</a>
  <?php endif; ?>
</div>

</body>
</html>
