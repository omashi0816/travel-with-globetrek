<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$email = $_SESSION['user'];

/* JOIN BOOKINGS + PAYMENTS */
$sql = "
SELECT b.*, 
p.amount, 
p.method, 
p.status AS payment_status
FROM bookings b
LEFT JOIN payments p 
ON b.id = p.booking_id
WHERE b.email='$email'
ORDER BY b.id DESC
";

$result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Booking History</title>

<style>

body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background:linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.6)),
    url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e')
    center/cover;
}

/* HEADER */
.header{
    text-align:center;
    padding:25px;
    color:white;
    font-size:28px;
    font-weight:bold;
}

/* BACK */
.back{
    position:fixed;
    top:20px;
    left:20px;
    padding:10px 15px;
    background:rgba(255,255,255,0.2);
    color:white;
    text-decoration:none;
    border-radius:8px;
}

/* BOX */
.box{
    width:95%;
    margin:30px auto;
    background:rgba(255,255,255,0.95);
    padding:20px;
    border-radius:15px;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#0c0c97;
    color:white;
    padding:12px;
}

td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

tr:hover{
    background:#f1f1f1;
}

/* STATUS */
.paid{
    color:green;
    font-weight:bold;
}

.pending{
    color:red;
    font-weight:bold;
}

</style>

</head>

<body>

<a class="back" href="profile.php">⬅ Back</a>

<div class="header">📦 Booking History with Payments</div>

<div class="box">

<table>

<tr>
    <th>Booking ID</th>
    <th>Name</th>
    <th>Package</th>
    <th>Date</th>
    <th>People</th>
    <th>Payment Method</th>
    <th>Amount</th>
    <th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
    <td><?php echo htmlspecialchars($row['package']); ?></td>
    <td><?php echo htmlspecialchars($row['travel_date']); ?></td>
    <td><?php echo htmlspecialchars($row['travelers']); ?></td>
    <td><?php echo htmlspecialchars($row['method'] ?? 'Not Paid'); ?></td>
    <td>Rs <?php echo htmlspecialchars($row['amount'] ?? '0'); ?></td>
    <td class="<?php echo (strtolower($row['payment_status'] ?? '') === 'paid') ? 'paid' : 'pending'; ?>">
        <?php echo htmlspecialchars($row['payment_status'] ?? 'Pending'); ?>
    </td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>