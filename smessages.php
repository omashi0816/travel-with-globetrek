<?php
session_start();
include 'includes/db.php';

/* STAFF LOGIN CHECK */
if(!isset($_SESSION['user']) || $_SESSION['role'] !== 'staff'){
    header('Location: login.php');
    exit();
}

$query = "SELECT * FROM messages ORDER BY id DESC";
$result = mysqli_query($conn, $query);
$errorMsg = '';
if($result === false){
    $errorMsg = mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Messages - GlobeTrek</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }
        body {
            display: flex;
            min-height: 100vh;
            background: #0f172a;
            color: #e2e8f0;
        }
        .sidebar {
            width: 240px;
            background: #111827;
            padding: 24px;
            position: fixed;
            height: 100%;
        }
        .sidebar h2 {
            color: #38bdf8;
            margin-bottom: 22px;
            font-size: 22px;
        }
        .sidebar a {
            display: block;
            color: #e2e8f0;
            text-decoration: none;
            padding: 10px 14px;
            margin-bottom: 8px;
            border-radius: 8px;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background: #1e293b;
            color: #38bdf8;
        }
        .main {
            margin-left: 260px;
            width: calc(100% - 260px);
            padding: 28px;
        }
        .page-header {
            margin-bottom: 24px;
        }
        .page-header h1 {
            font-size: 32px;
            margin-bottom: 8px;
        }
        .page-header p {
            color: #94a3b8;
        }
        .table-wrapper {
            overflow-x: auto;
            background: #1e293b;
            border-radius: 16px;
            padding: 18px;
            box-shadow: 0 20px 40px rgba(15, 23, 42, .35);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 720px;
        }
        th, td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid #334155;
        }
        th {
            background: #0f172a;
            color: #cbd5e1;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 13px;
        }
        td {
            color: #e2e8f0;
        }
        tr:hover td {
            background: #111827;
        }
        .message-cell {
            max-width: 520px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .back-btn {
            display: inline-block;
            margin-top: 18px;
            padding: 12px 20px;
            background: #0c0c97;
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
        }
        .no-data {
            padding: 22px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>🌍 Staff Panel</h2>
        <a href="staff_dashboard.php">Dashboard</a>
        <a href="sbookings.php">Bookings</a>
        <a href="scustomers.php">Customers</a>
        <a href="spackages.php">Packages</a>
        <a href="spayments.php">Payments</a>
        <a href="smessages.php" class="active">Messages</a>
        <a href="sreports.php">Reports</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="main">
        <div class="page-header">
            <h1>Messages</h1>
            <p>View customer messages sent through GlobeTrek.</p>
        </div>
        <div class="table-wrapper">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
                <?php if($errorMsg): ?>
                    <tr>
                        <td colspan="5" class="no-data">Database error: <?php echo htmlspecialchars($errorMsg); ?></td>
                    </tr>
                <?php elseif($result && mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td class="message-cell"><?php echo htmlspecialchars($row['message']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at'] ?? $row['submitted_at'] ?? ''); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="no-data">No messages found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
        <a class="back-btn" href="staff_dashboard.php">⬅ Back to Dashboard</a>
    </div>
</body>
</html>
