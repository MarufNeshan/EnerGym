<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login_form.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: 
        linear-gradient(rgba(27, 4, 50, 0.6), rgba(26, 91, 109, 0.6)),
        url('../images/m-2.jpg');
      color: #fff;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .dashboard-wrapper {
      background: rgba(255, 255, 255, 0.1);
      padding: 50px;
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
      max-width: 1000px;
      width: 90%;
    }

    .dashboard-header {
      text-align: center;
      margin-bottom: 40px;
    }

    .dashboard-header h1 {
      font-size: 36px;
      font-weight: bold;
      margin-bottom: 10px;
      color: #fff;
      text-shadow: 1px 1px 2px #000;
    }

    .dashboard-header p {
      font-size: 18px;
      opacity: 0.9;
    }

    .card-container {
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      justify-content: center;
    }

    .card {
      background: #ffffff;
      color: #333;
      padding: 25px;
      border-radius: 12px;
      width: 300px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
      transition: transform 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card h3 {
      margin-bottom: 10px;
      color: #4a63ff;
    }

    .card p {
      font-size: 15px;
      margin-bottom: 15px;
    }

    .card a {
      display: inline-block;
      padding: 10px 18px;
      background: #4a63ff;
      color: #fff;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
    }

    .card a:hover {
      background: #3b53d3;
    }

    .logout {
      text-align: center;
      margin-top: 40px;
    }

    .logout a {
      color: #ffdcdc;
      text-decoration: underline;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <div class="dashboard-wrapper">
    <div class="dashboard-header">
      <h1>Welcome Back, Admin 👑</h1>
      <p>Manage your gym's settings, locations, and communications</p>
    </div>

    <div class="card-container">

      <div class="card">
        <h3>Update Gym Location</h3>
        <p>Manage and update your gym's Google Map location shown on the homepage.</p>
        <a href="settings.php">Go to Location Settings</a>
      </div>

      <div class="card">
        <h3>Send Notification to Users</h3>
        <p>Send custom messages to all registered users right from the panel.</p>
        <a href="notify.php">Send Notification</a>
      </div>

    </div>

    <div class="logout">
      <p><a href="../auth/logout.php">Logout</a></p>
    </div>
  </div>

</body>
</html>
