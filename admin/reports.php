<?php
session_start();
include __DIR__ . '/../includes/db.php';

/* ADMIN SECURITY CHECK */
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit();
}

/* METRICS */
function fetch_count($conn, $query) {
    $result = mysqli_query($conn, $query);
    return $result ? mysqli_fetch_assoc($result)['total'] : 0;
}

$bookings = fetch_count($conn, "SELECT COUNT(*) AS total FROM bookings");
$pendingBookings = fetch_count($conn, "SELECT COUNT(*) AS total FROM bookings WHERE status='Pending'");
$confirmedBookings = fetch_count($conn, "SELECT COUNT(*) AS total FROM bookings WHERE status='Confirmed'");
$cancelledBookings = fetch_count($conn, "SELECT COUNT(*) AS total FROM bookings WHERE status='Cancelled'");
$customers = fetch_count($conn, "SELECT COUNT(*) AS total FROM users WHERE role='customer'");
$packages = fetch_count($conn, "SELECT COUNT(*) AS total FROM packages");
$messages = fetch_count($conn, "SELECT COUNT(*) AS total FROM messages");
$payments = fetch_count($conn, "SELECT COUNT(*) AS total FROM payments");

$revenueResult = mysqli_query($conn, "SELECT IFNULL(SUM(amount), 0) AS total FROM payments WHERE status='Paid'");
$revenue = $revenueResult ? mysqli_fetch_assoc($revenueResult)['total'] : 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Reports</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
    margin:0;
    font-family:Segoe UI;
    background:linear-gradient(135deg,#e0eafc,#cfdef3);
}

.main{
    margin-left:260px;
    padding:25px;
}

.header{
    background:white;
    padding:18px 20px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    margin-bottom:22px;
}

.header h2{
    margin:0;
    color:#0c0c97;
}

.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
}

.card{
    background:white;
    border-radius:15px;
    padding:22px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-4px);
}

.card h3{
    margin:0;
    color:#0c0c97;
    font-size:16px;
}

.card p{
    margin:14px 0 0;
    font-size:30px;
    font-weight:700;
    color:#111;
}

.small-cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:20px;
    margin-top:18px;
}

.small-card{
    background:white;
    border-radius:15px;
    padding:18px;
    border:1px solid #e2e8f0;
}

.small-card h4{
    margin:0;
    color:#334155;
    font-size:14px;
}

.small-card p{
    margin:12px 0 0;
    font-size:26px;
    font-weight:700;
    color:#0c0c97;
}

.table-wrapper{
    margin-top:24px;
    background:white;
    border-radius:16px;
    padding:18px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

table{
    width:100%;
    border-collapse:collapse;
}

th, td{
    padding:14px 12px;
    text-align:left;
    border-bottom:1px solid #e2e8f0;
}

th{
    background:#0c0c97;
    color:white;
    text-transform:uppercase;
    letter-spacing:0.03em;
    font-size:13px;
}

td{
    color:#334155;
}

.back-btn{
    display:inline-block;
    margin-top:18px;
    padding:12px 18px;
    background:#0c0c97;
    color:white;
    text-decoration:none;
    border-radius:10px;
}

.logout-btn{
    display:inline-block;
    margin-top:18px;
    margin-left:10px;
    padding:12px 18px;
    background:#dc3545;
    color:white;
    text-decoration:none;
    border-radius:10px;
}

</style>
</head>

<body>

<div class="main">

<div class="header">
<h2>📊 Admin Reports</h2>
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
    <div class="card">
        <h3>Total Payments</h3>
        <p><?php echo htmlspecialchars($payments); ?></p>
    </div>
    <div class="card">
        <h3>Revenue</h3>
        <p>Rs. <?php echo htmlspecialchars($revenue); ?></p>
    </div>
</div>

<div class="small-cards">
    <div class="small-card">
        <h4>Pending Bookings</h4>
        <p><?php echo htmlspecialchars($pendingBookings); ?></p>
    </div>
    <div class="small-card">
        <h4>Confirmed Bookings</h4>
        <p><?php echo htmlspecialchars($confirmedBookings); ?></p>
    </div>
    <div class="small-card">
        <h4>Cancelled Bookings</h4>
        <p><?php echo htmlspecialchars($cancelledBookings); ?></p>
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
        <tr>
            <td>Payments</td>
            <td><?php echo htmlspecialchars($payments); ?></td>
        </tr>
        <tr>
            <td>Revenue</td>
            <td>Rs. <?php echo htmlspecialchars($revenue); ?></td>
        </tr>
    </table>
</div>

<a class="back-btn" href="admin_dashboard.php">⬅ Back to Dashboard</a>
<a class="logout-btn" href="../logout.php">🚪 Logout</a>

</div>

</body>
</html>
