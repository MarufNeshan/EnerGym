<?php
session_start();
include 'include/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login_form.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);
$users = $result->fetch_assoc();

$weight = $users['weight'];
$height = $users['height'] / 100;
$bmi = ($height > 0) ? $weight / ($height * $height) : 0;


// Handle progress form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitProgress'])) {
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    if ($weight > 0 && $height > 0) {
        $bmi = $weight / pow(($height / 100), 2);
        $stmt = $conn->prepare("INSERT INTO progress_log (user_id, weight, height, bmi) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iddd", $user_id, $weight, $height, $bmi);
        $stmt->execute();
        $stmt->close();
    }
}

$progress = $conn->query("SELECT entry_date, weight, bmi FROM progress_log WHERE user_id = $user_id ORDER BY entry_date ASC");
$dates = [];
$weights = [];
$bmis = [];

while ($row = $progress->fetch_assoc()) {
    $dates[] = $row['entry_date'];
    $weights[] = $row['weight'];
    $bmis[] = round($row['bmi'], 2);
}


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
<?php
$photo = !empty($users['profile_photo']) ? $users['profile_photo'] : 'images/default-avatar.jpg';
?>
<div class="profile-photo">
    <img src="<?= $photo ?>" alt="Profile Photo">
</div>



<div class="dashboard-wrapper">

    <div class="section welcome">
        <h2>Welcome, <?= htmlspecialchars($users['name']); ?> 👋</h2>
        <p>We're glad to have you on your fitness journey!</p>
    </div>
    <?php if (isset($_SESSION['message'])): ?>
    <div class="section center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
<?php endif; ?>

<div class="section center">
    <form action="mark_attendance.php" method="post">
        <button type="submit" class="logout-btn">Mark Attendance</button>
    </form>
</div>

<div class="section center">
    <a href="attendance_history.php" class="logout-btn" style="background: linear-gradient(to right, #00c6ff, #0072ff); margin-top: 10px;">
        View Attendance History
    </a>
</div>

    <div class="section">
        <h3>Your Health Information</h3>
        <p><strong>Weight:</strong> <?= $weight; ?> kg</p>
        <p><strong>Height:</strong> <?= $users['height']; ?> cm</p>
        <p><strong>BMI:</strong> <?= number_format($bmi, 2); ?></p>
    </div>
    <div class="section">
    <h3>Fitness Progress Tracker</h3>

    <!-- Log Progress Button -->
    <button onclick="toggleForm()" style="padding: 10px 20px; background: #28a745; color: #fff; border: none; border-radius: 6px; font-weight: bold;">
        Log Progress
    </button>

    <!-- Hidden Form -->
    <div id="logForm" style="display: none; margin-top: 20px;">
        <p><strong>Fill your today's information:</strong></p>
        <form method="POST">
            <input type="number" name="weight" step="0.1" placeholder="Your weight (kg)" required>
            <input type="number" name="height" step="0.1" placeholder="Your height (cm)" required>
            <button type="submit" name="submitProgress" style="margin-top: 10px;">Submit</button>
        </form>
    </div>

    <!-- Chart Canvas -->
    <div style="margin-top: 40px;">
        <canvas id="progressChart" width="400" height="200"></canvas>
    </div>
</div>

    <div class="section">
        <h3>Admin Notifications</h3>
        <ul class="notification">
        <?php
        $notices = $conn->query("SELECT * FROM notifications ORDER BY created_at DESC");
        if ($notices && $notices->num_rows > 0):
            while ($n = $notices->fetch_assoc()):
        ?>
            <li>
                <strong><?= htmlspecialchars($n['subject']) ?></strong><br>
                <br>
                <em><?= htmlspecialchars($n['message']) ?></em><br>
                <br>
                <small>Sent on <?= $n['created_at'] ?></small>
            </li>
        <?php
            endwhile;
        else:
            echo "<p>No notifications yet.</p>";
        endif;
        ?>
        </ul>
    </div>

    <div class="center">
        <a href="auth/logout.php" class="logout-btn">Logout</a>
        <a href="edit_profile.php" class="logout-btn" style="background: #28a745; margin-top: 10px;">Edit My Profile</a>

    </div>

</div>
<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Toggle form visibility -->
<script>
function toggleForm() {
    const form = document.getElementById('logForm');
    form.style.display = (form.style.display === 'none') ? 'block' : 'none';
}
</script>

<script>
const ctx = document.getElementById('progressChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($dates); ?>,
        datasets: [
            {
                label: 'Weight (kg)',
                data: <?= json_encode($weights); ?>,
                borderColor: '#00ffff',
                backgroundColor: 'rgba(27, 186, 186, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 4
            },
            {
                label: 'BMI',
                data: <?= json_encode($bmis); ?>,
                borderColor: '#ff6bd6',
                backgroundColor: 'rgba(208, 23, 152, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 4
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                labels: {
                    color: '#ffffff',
                    font: { size: 14 }
                }
            }
        },
        scales: {
            x: {
                ticks: { color: '#ffffff' },
                grid: { color: 'rgba(255,255,255,0.1)' }
            },
            y: {
                ticks: { color: '#ffffff' },
                grid: { color: 'rgba(255,255,255,0.1)' },
                beginAtZero: false
            }
        }
    }
});
</script>


</body>
</html>
