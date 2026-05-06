                        
<!-- login_form.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Gym Center</title>
    <link rel="stylesheet" href="css/auth.css"> <!-- Make sure this path is correct -->

    

</head>
<body>

<div class="form-container">
    <h2>Login</h2>
    <form action="auth/login.php" method="POST">

     <!-- Role Selection -->
<select name="role" required 
        style="width: 100%; padding: 14px 10px; margin-bottom: 20px;
               border: 1px solid #7c5c5c; border-radius: 8px; font-size: 16px;">
    <option value="" disabled selected>Select your role</option>
    <option value="admin">Admin</option>
    <option value="trainer">Trainer</option>
    <option value="user">User</option>
</select>

        <input type="email" name="email" placeholder="Enter your email" required>
        <input type="password" name="password" placeholder="Enter your password" required>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register_form.php">Register Here</a></p>
</div>

</body>
</html>
