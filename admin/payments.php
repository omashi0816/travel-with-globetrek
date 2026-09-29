<?php
session_start();
include '../includes/db.php';

/* SECURITY */
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: login.php");
    exit();
}

/* GET PAYMENTS */
$result = mysqli_query($conn, "SELECT * FROM payments ORDER BY id DESC");

/* TOTAL REVENUE */
$total = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT SUM(amount) as total FROM payments WHERE status='Paid'"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Payments Management</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

/* BODY */
body{
    margin:0;
    font-family:Segoe UI;
    background:linear-gradient(135deg,#e0eafc,#cfdef3);
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

/* REVENUE CARD */
.revenue{
    background:linear-gradient(90deg,#0c0c97,#1a237e);
    color:white;
    padding:15px;
    border-radius:12px;
    margin-bottom:20px;
    font-size:18px;
    font-weight:bold;
}

/* TABLE CARD */
.card{
    background:white;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
}

/* HEADER */
th{
    background:linear-gradient(90deg,#0c0c97,#1a237e);
    color:white;
    padding:14px;
    font-size:13px;
    text-transform:uppercase;
}

/* ROW */
td{
    text-align:center;
    padding:14px;
    border-bottom:1px solid #eee;
}

/* HOVER */
tr:hover{
    background:#f1f5ff;
}

/* STATUS */
.status{
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
    font-weight:bold;
}

.paid{background:green;color:white;}
.pending{background:orange;color:white;}

/* METHOD TAG */
.method{
    background:#03a9f4;
    color:white;
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
}

/* ICON */
i{
    margin-right:5px;
}

</style>

</head>

<body>

<div class="main">

<!-- HEADER -->
<div class="header">
<h2>💳 Payment Management</h2>
</div>

<!-- REVENUE -->
<div class="revenue">
💰 Total Revenue: Rs. <?php echo $total['total']; ?>
</div>

<!-- TABLE -->
<div class="card">

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

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['id']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['booking_id']; ?></td>
<td>Rs. <?php echo $row['amount']; ?></td>

<td>
<span class="status <?php echo strtolower($row['status']); ?>">
<?php echo $row['status']; ?>
</span>
</td>

<td>
<span class="method">
<?php echo $row['method']; ?>
</span>
</td>

<td><?php echo $row['payment_date']; ?></td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>