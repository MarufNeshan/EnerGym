<?php
session_start();
include 'include/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login_form.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Get filter values
$month = isset($_GET['month']) ? (int)$_GET['month'] : null;
$year = isset($_GET['year']) ? (int)$_GET['year'] : null;

// Build query with optional filters
$query = "SELECT * FROM attendance WHERE user_id = $user_id";

if ($month && $year) {
    $query .= " AND MONTH(date) = $month AND YEAR(date) = $year";
} elseif ($month) {
    $query .= " AND MONTH(date) = $month";
} elseif ($year) {
    $query .= " AND YEAR(date) = $year";
}

$query .= " ORDER BY date DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance History</title>
    <link rel="stylesheet" href="styles/style.css"> <!-- Your main CSS -->
    <style>
        body {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
                        url('images/attendance-bg.jpg');
            background-size: cover;
            background-attachment: fixed;
            color: #fff;
            font-family: 'Poppins', sans-serif;
        }

        .dashboard-wrapper {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            backdrop-filter: blur(15px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
        }

        .filter-form {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            justify-content: center;
        }

        .filter-form select,
        .filter-form button {
            padding: 10px;
            border-radius: 10px;
            border: none;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        th {
            background-color: rgba(255, 255, 255, 0.15);
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="dashboard-wrapper">
    <h2 style="text-align:center;">Attendance History 📅</h2>

    <!-- Filter Form -->
    <form method="GET" class="filter-form">
        <select name="month">
            <option value="">Month</option>
            <?php for ($m = 1; $m <= 12; $m++): ?>
                <option value="<?= $m ?>" <?= ($month == $m) ? 'selected' : '' ?>>
                    <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                </option>
            <?php endfor; ?>
        </select>

        <select name="year">
            <option value="">Year</option>
            <?php
            $currentYear = date('Y');
            for ($y = $currentYear; $y >= $currentYear - 5; $y--): ?>
                <option value="<?= $y ?>" <?= ($year == $y) ? 'selected' : '' ?>><?= $y ?></option>
            <?php endfor; ?>
        </select>

        <button type="submit">Filter</button>
    </form>

    <!-- Attendance Table -->
    <table>
        <tr>
            <th>Date</th>
            <th>Status</th>
        </tr>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['date']) ?></td>
                    <td>✅ Present</td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="2">No records found for selected period.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
