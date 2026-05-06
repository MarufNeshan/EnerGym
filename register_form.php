
<!-- register_form.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Gym Center</title>
    <link rel="stylesheet" href="css/auth.css"> <!-- Same CSS file -->
</head>
<body>

<div class="form-container">
    <h2>Registration</h2>
    <form action="auth/register.php" method="POST">
        <input type="text" name="name" placeholder="Enter your name" required>
        <input type="text" name="gender" placeholder="Enter your gender" required>
        <input type="number" name="age" placeholder="Enter your age" required>
        <input type="email" name="email" placeholder="Enter your email" required>
        <input type="password" name="password" placeholder="Enter your password" required>
        <input type="number" name="weight" placeholder="Enter your weight (kg)" required>
        <input type="number" name="height" placeholder="Enter your height (cm)" required>
        

        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login_form.php">Login Here</a></p>
</div>

</body>
</html>
