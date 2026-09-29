<?php
session_start();
include __DIR__ . '/../includes/db.php';

/* ADMIN SECURITY CHECK */
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit();
}

/* COUNTS */
$user_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
$booking_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bookings"));
$payment_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM payments"));

$total = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT SUM(amount) as total FROM payments WHERE status='Paid'"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Panel</title>

<style>

/* BODY */
body{
    margin:0;
    font-family:Segoe UI;
    background:#f4f6fb;
}

/* SIDEBAR */
.sidebar{
    width:240px;
    height:100vh;
    background:#0c0c97;
    position:fixed;
    top:0;
    left:0;
    padding-top:25px;
}

.sidebar h2{
    color:white;
    text-align:center;
    margin-bottom:30px;
}

.sidebar a{
    display:block;
    color:white;
    padding:14px 20px;
    text-decoration:none;
    transition:0.3s;
}

.sidebar a:hover{
    background:#ff9800;
    padding-left:30px;
}

/* MAIN */
.main{
    margin-left:240px;
    padding:20px;
}

/* HEADER */
.header{
    background:white;
    padding:15px;
    border-radius:10px;
    font-size:22px;
    font-weight:bold;
    color:#0c0c97;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

/* CARDS */
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(220px,1fr));
    gap:20px;
    margin-top:25px;
}

.card{
    background:white;
    padding:25px;
    border-radius:12px;
    text-align:center;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-8px);
}

.card h3{
    margin:0;
    color:#0c0c97;
}

.card p{
    font-size:22px;
    font-weight:bold;
    margin-top:10px;
}

.revenue{
    color:green;
}

</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

<h2>ADMIN</h2>

<a href="admin_dashboard.php" class="active"><i class="fas fa-home"></i> <span>Dashboard</span></a>
<a href="users.php"><i class="fas fa-users"></i> <span>Users</span></a>
<a href="bookings.php"><i class="fas fa-calendar"></i> <span>Bookings</span></a>
<a href="payments.php"><i class="fas fa-credit-card"></i> <span>Payments</span></a>
<a href="packages.php"><i class="fas fa-box"></i> <span>Packages</span></a>

<a href="staff.php"><i class="fas fa-user-tie"></i> <span>Staff</span></a>

<a href="reports.php"><i class="fas fa-chart-bar"></i> <span>Reports</span></a>
<a href="notification.php"><i class="fas fa-bell"></i> <span>Notifications</span></a>

<a href="search.php"><i class="fas fa-search"></i> <span>Search</span></a>

<a href="setting.php"><i class="fas fa-cog"></i> <span>Settings</span></a>

<a href="logs.php"><i class="fas fa-file-alt"></i> <span>Logs</span></a>

<a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>

</div>

<!-- MAIN -->
<div class="main">

<div class="header">
👨‍💼 Admin Dashboard
</div>

<div class="cards">

<div class="card">
<h3>Users</h3>
<p><?php echo $user_count; ?></p>
</div>

<div class="card">
<h3>Bookings</h3>
<p><?php echo $booking_count; ?></p>
</div>

<div class="card">
<h3>Payments</h3>
<p><?php echo $payment_count; ?></p>
</div>

<div class="card">
<h3>Revenue</h3>
<p class="revenue">Rs. <?php echo $total['total']; ?></p>
</div>

</div>

</div>

</body>
</html>