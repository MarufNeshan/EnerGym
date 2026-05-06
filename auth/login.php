<?php
session_start();
include('../include/db_connect.php');

// Get form values
$role = $_POST['role'];
$email = $_POST['email'];
$password = $_POST['password'];

/* -------------------------------
   IF ROLE = ADMIN
-------------------------------- */
if ($role == 'admin') {
    $sql = "SELECT * FROM admins WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $admin_result = $stmt->get_result();

    if ($admin_result->num_rows == 1) {
        $admin = $admin_result->fetch_assoc();

        // Admin usually uses plain password (change if hashed)
        if ($password == $admin['password']) {

            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $trainer['name'];
            $_SESSION['role'] = 'admin';

            header("Location: ../admin/dashboard.php");
            exit();
        } else {
            echo "Invalid Admin Password.";
            exit();
        }
    } else {
        echo "Admin Not Found.";
        exit();
    }
}

/* -------------------------------
   IF ROLE = TRAINER
-------------------------------- */
if ($role == 'trainer') {

    $sql = "SELECT * FROM trainers WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $trainer_result = $stmt->get_result();

    if ($trainer_result->num_rows === 1) {

        $trainer = $trainer_result->fetch_assoc();

        // ✅ Plain text password check
        if ($password === $trainer['password']) {

            $_SESSION['trainer_id']   = $trainer['id'];
            $_SESSION['trainer_name'] = $trainer['name'];
            $_SESSION['role']         = 'trainer';

            header("Location: ../trainer/dashboard.php");
            exit();

        } else {
            echo "❌ Invalid Trainer Password";
            exit();
        }

    } else {
        echo "❌ Trainer Not Found";
        exit();
    }
}

/* -------------------------------
   IF ROLE = USER
-------------------------------- */
if ($role == 'user') {

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user_result = $stmt->get_result();

    if ($user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = 'user';

            header('Location: ../dashboard.php');
            exit();
        } else {
            echo "Invalid User Password.";
            exit();
        }
    } else {
        echo "User Not Found.";
        exit();
    }
}

?>
