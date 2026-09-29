<?php
session_start();
include 'includes/db.php';

/* STAFF LOGIN CHECK */
if(!isset($_SESSION['user']) || $_SESSION['role'] !== 'staff'){
    header('Location: login.php');
    exit();
}

$bookings = mysqli_query($conn, "SELECT COUNT(*) AS total FROM bookings");
$bookings = $bookings ? mysqli_fetch_assoc($bookings)['total'] : 0;
$pendingBookings = mysqli_query($conn, "SELECT COUNT(*) AS total FROM bookings WHERE status='Pending'");
$pendingBookings = $pendingBookings ? mysqli_fetch_assoc($pendingBookings)['total'] : 0;
$confirmedBookings = mysqli_query($conn, "SELECT COUNT(*) AS total FROM bookings WHERE status='Confirmed'");
$confirmedBookings = $confirmedBookings ? mysqli_fetch_assoc($confirmedBookings)['total'] : 0;
$cancelledBookings = mysqli_query($conn, "SELECT COUNT(*) AS total FROM bookings WHERE status='Cancelled'");
$cancelledBookings = $cancelledBookings ? mysqli_fetch_assoc($cancelledBookings)['total'] : 0;
$customers = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='customer'");
$customers = $customers ? mysqli_fetch_assoc($customers)['total'] : 0;
$packages = mysqli_query($conn, "SELECT COUNT(*) AS total FROM packages");
$packages = $packages ? mysqli_fetch_assoc($packages)['total'] : 0;
$messages = mysqli_query($conn, "SELECT COUNT(*) AS total FROM messages");
$messages = $messages ? mysqli_fetch_assoc($messages)['total'] : 0;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Reports - GlobeTrek</title>
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
        .cards {
            display: grid;
            gap: 18px;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            margin-bottom: 28px;
        }
        .card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 18px;
            padding: 22px;
            box-shadow: 0 20px 40px rgba(15, 23, 42, .35);
        }
        .card h3 {
            font-size: 20px;
            margin-bottom: 8px;
            color: #cbd5e1;
        }
        .card p {
            font-size: 32px;
            font-weight: 700;
            color: #fff;
        }
        .card.small {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card.small span {
            font-size: 14px;
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
            min-width: 680px;
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
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
        }
        .status-pending { background: #f59e0b; color: #ffedd5; }
        .status-confirmed { background: #16a34a; color: #dcfce7; }
        .status-cancelled { background: #dc2626; color: #fee2e2; }
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
        <a href="spayments.php">Payments</a>
        <a href="smessages.php">Messages</a>
        <a href="sreports.php" class="active">Reports</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="main">
        <div class="page-header">
            <h1>Reports</h1>
            <p>Staff overview of bookings, customers, packages, and messages.</p>
        </div>
        <div class="cards">
            <div class="card">
                <h3>Total Bookings</h3>
                <p><?php echo htmlspecialchars($bookings); ?></p>
            </div>
            <div class="card">
                <h3>Total Customers</h3>
                <p><?php echo htmlspecialchars($customers); ?></p>
            </div>
            <div class="card">
                <h3>Total Packages</h3>
                <p><?php echo htmlspecialchars($packages); ?></p>
            </div>
            <div class="card">
                <h3>Total Messages</h3>
                <p><?php echo htmlspecialchars($messages); ?></p>
            </div>
        </div>
        <div class="cards">
            <div class="card small">
                <div>
                    <h3>Pending</h3>
                    <p><?php echo htmlspecialchars($pendingBookings); ?></p>
                </div>
                <span>Status</span>
            </div>
            <div class="card small">
                <div>
                    <h3>Confirmed</h3>
                    <p><?php echo htmlspecialchars($confirmedBookings); ?></p>
                </div>
                <span>Status</span>
            </div>
            <div class="card small">
                <div>
                    <h3>Cancelled</h3>
                    <p><?php echo htmlspecialchars($cancelledBookings); ?></p>
                </div>
                <span>Status</span>
            </div>
        </div>
        <div class="table-wrapper">
            <table>
                <tr>
                    <th>Metric</th>
                    <th>Count</th>
                </tr>
                <tr>
                    <td>Bookings</td>
                    <td><?php echo htmlspecialchars($bookings); ?></td>
                </tr>
                <tr>
                    <td>Customers</td>
                    <td><?php echo htmlspecialchars($customers); ?></td>
                </tr>
                <tr>
                    <td>Packages</td>
                    <td><?php echo htmlspecialchars($packages); ?></td>
                </tr>
                <tr>
                    <td>Messages</td>
                    <td><?php echo htmlspecialchars($messages); ?></td>
                </tr>
            </table>
        </div>
        <a class="back-btn" href="staff_dashboard.php">⬅ Back to Dashboard</a>
    </div>
</body>
</html>