<?php
session_start();
include 'include/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login_form.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];

    // Handle photo upload
    if (!empty($_FILES['profile_photo']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir); // Create dir if not exists
        $file_name = basename($_FILES["profile_photo"]["name"]);
        $target_file = $target_dir . time() . "_" . $file_name;
        move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file);

        // Update with photo
        $sql = "UPDATE users SET name='$name', email='$email', weight='$weight', height='$height', profile_photo='$target_file' WHERE id=$user_id";
    } else {
        // Update without photo
        $sql = "UPDATE users SET name='$name', email='$email', weight='$weight', height='$height' WHERE id=$user_id";
    }

    if ($conn->query($sql) === TRUE) {
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Update failed: " . $conn->error;
    }
}

// Get current user data
$result = $conn->query("SELECT * FROM users WHERE id = $user_id");
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: 
                linear-gradient(rgba(27, 4, 50, 0.6), rgba(26, 91, 109, 0.6)),
                url('images/m-2.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.15);
            padding: 40px;
            border-radius: 20px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            color: #fff;
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 500px;
        }

        h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 30px;
        }

        label {
            font-weight: 500;
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
        }

        input[type="file"] {
            background: #fff;
            color: #333;
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(to right, #8e2de2, #4a00e0);
            border: none;
            border-radius: 50px;
            color: #fff;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        button:hover {
            transform: scale(1.03);
            background: linear-gradient(to right, #4a00e0, #8e2de2);
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Edit My Profile</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Weight (kg)</label>
        <input type="number" name="weight" value="<?= $user['weight'] ?>" required>

        <label>Height (cm)</label>
        <input type="number" name="height" value="<?= $user['height'] ?>" required>

        <label>Profile Photo</label>
        <input type="file" name="profile_photo">

        <button type="submit">Save Changes</button>
    </form>
</div>

</body>
</html>
