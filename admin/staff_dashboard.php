<?php
session_start();
include 'includes/db.php';

/* SECURITY */
if(!isset($_SESSION['role']) || $_SESSION['role'] != "staff"){
    header("Location: staff_login.php");
    exit();
}

/* DATA */
$booking_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bookings"));
$payment_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM payments"));

$pending = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bookings WHERE status='pending'"));
$approved = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bookings WHERE status='approved'"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Staff Dashboard</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

/* BODY */
body{
    margin:0;
    font-family:Segoe UI;
    background:linear-gradient(135deg,#eef2f3,#8e9eab);
}

/* MAIN */
.main{
    margin-left:260px;
    padding:25px;
}

/* HEADER */
.header{
    background:white;
    padding:15px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    margin-bottom:20px;
}

.header h2{
    margin:0;
    color:#0c0c97;
}

/* CARDS */
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
}

/* CARD */
.card{
    background:white;
    padding:20px;
    border-radius:15px;
    text-align:center;
    box-shadow:0 10px 20px rgba(0,0,0,0.1);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

/* ICON */
.card i{
    font-size:30px;
    margin-bottom:10px;
    color:#0c0c97;
}

/* NUM */
.num{
    font-size:24px;
    font-weight:bold;
}

/* COLORS */
.pending{color:orange;}
.approved{color:green;}
.payments{color:#03a9f4;}

</style>

</head>

<body>

<div class="main">

<!-- HEADER -->
<div class="header">
<h2>👨‍💼 Staff Dashboard</h2>
</div>

<!-- CARDS -->
<div class="cards">

<div class="card">
<i class="fas fa-calendar"></i>
<h3>Total Bookings</h3>
<div class="num"><?php echo $booking_count; ?></div>
</div>

<div class="card">
<i class="fas fa-clock"></i>
<h3>Pending Bookings</h3>
<div class="num pending"><?php echo $pending; ?></div>
</div>

<div class="card">
<i class="fas fa-check-circle"></i>
<h3>Approved Bookings</h3>
<div class="num approved"><?php echo $approved; ?></div>
</div>

<div class="card">
<i class="fas fa-credit-card"></i>
<h3>Payments</h3>
<div class="num payments"><?php echo $payment_count; ?></div>
</div>

</div>

</div>

</body>
</html>