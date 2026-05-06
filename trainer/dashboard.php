

<?php
session_start();

if (!isset($_SESSION['trainer_id']) || $_SESSION['role'] !== 'trainer') {
    header('Location: ../auth/login_form.php');
    exit();
}

$trainer_name = $_SESSION['trainer_name'];
?>


 
<!DOCTYPE html>
<html>
<head>
    <title>Trainer Dashboard</title>
    <link rel="stylesheet" href="styles/style.css">
    <style>
        body {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)),
                        url('../images/m-2.jpg');
            background-size: cover;
            color: #fff;
            font-family: 'Poppins', sans-serif;
        }

        .dashboard-box {
            max-width: 850px;
            margin: 50px auto;
            padding: 35px;
            background: rgba(255,255,255,0.12);
            border-radius: 18px;
            backdrop-filter: blur(10px);
        }

        .menu {
            display: flex;
            gap: 20px;
            margin-top: 30px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .menu a {
            padding: 18px 30px;
            background: rgba(223, 225, 221, 0.95);
            border-radius: 12px;
            color: #000;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            transition: 0.3s;
        }

        .menu a:hover {
            background: rgba(19, 212, 161, 0.51);
        }
    </style>
</head>

<body>

<div class="dashboard-box">
    <h1 style="text-align:center;">👋 Welcome, Trainer <?php echo $trainer_name; ?> </h1>

    <div class="menu">
        <a href="trainer/students.php">👥 My Students</a>
        <a href="trainer/advice.php">💬 Give Advice</a>
        <a href="trainer/routine.php">📅 Daily Routine</a>
        <a href="trainer/nutrition.php">🥗 Nutrition Plan</a>
    </div>
</div>

</body>
</html>
