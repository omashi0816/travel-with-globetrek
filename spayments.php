<?php

session_start();
include 'includes/db.php';

/* STAFF LOGIN CHECK */
if(!isset($_SESSION['user']) || $_SESSION['role'] !== 'staff'){
    header('Location: login.php');
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM payments ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Payments - GlobeTrek</title>
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
        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
        }
        .status-paid { background: #16a34a; color: #dcfce7; }
        .status-pending { background: #f59e0b; color: #ffedd5; }
        .status-failed { background: #dc2626; color: #fee2e2; }
        .back-btn {
            display: inline-block;
            margin-top: 18px;
            padding: 12px 20px;
            background: #0c0c97;
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
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
        <a href="spayments.php" class="active">Payments</a>
        <a href="smessages.php">Messages</a>
        <a href="sreports.php">Reports</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="main">
        <div class="page-header">
            <h1>Payments</h1>
            <p>Manage all customer payments from the GlobeTrek staff portal.</p>
        </div>
        <div class="table-wrapper">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Booking ID</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Method</th>
                    <th>Date</th>
                </tr>
                <?php if(mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <?php
                        $status = strtolower(trim($row['status']));
                        $statusClass = 'status-pending';
                        if($status === 'paid') { $statusClass = 'status-paid'; }
                        if($status === 'failed' || $status === 'cancelled') { $statusClass = 'status-failed'; }
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['booking_id']); ?></td>
                            <td>Rs. <?php echo htmlspecialchars($row['amount']); ?></td>
                            <td><span class="status <?php echo $statusClass; ?>"><?php echo htmlspecialchars(ucfirst($status)); ?></span></td>
                            <td><?php echo htmlspecialchars($row['method']); ?></td>
                            <td><?php echo htmlspecialchars($row['payment_date']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No payments found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
        <a class="back-btn" href="staff_dashboard.php">⬅ Back to Dashboard</a>
    </div>
</body>
</html>
