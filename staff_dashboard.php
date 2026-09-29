<?php
session_start();
include 'includes/db.php';

/* =========================
   LOGIN CHECK
========================= */
if(!isset($_SESSION['user']) || $_SESSION['role'] != 'staff'){
    header("Location: login.php");
    exit();
}

/* =========================
   UPDATE BOOKING STATUS
========================= */
if(isset($_GET['action']) && isset($_GET['id'])){

    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if($action == "approve"){
        mysqli_query($conn,"UPDATE bookings SET status='Confirmed' WHERE id=$id");
    }

    if($action == "reject"){
        mysqli_query($conn,"UPDATE bookings SET status='Cancelled' WHERE id=$id");
    }

    header("Location: staff_dashboard.php");
    exit();
}

/* =========================
   SAFE COUNT FUNCTION
========================= */
function countData($conn, $query){
    $result = mysqli_query($conn,$query);
    return ($result) ? mysqli_num_rows($result) : 0;
}

/* =========================
   DASHBOARD DATA
========================= */
$bookings  = countData($conn,"SELECT * FROM bookings");
$customers  = countData($conn,"SELECT * FROM users WHERE role='customer'");
$pending    = countData($conn,"SELECT * FROM bookings WHERE status='Pending'");
$confirmed  = countData($conn,"SELECT * FROM bookings WHERE status='Confirmed'");
$cancelled  = countData($conn,"SELECT * FROM bookings WHERE status='Cancelled'");
$messages   = countData($conn,"SELECT * FROM messages");
$packages   = countData($conn,"SELECT * FROM packages");

?>

<!DOCTYPE html>
<html>
<head>
<title>Staff Dashboard</title>

<style>

*{
    margin:0;
    padding:0;
    font-family:Segoe UI;
    box-sizing:border-box;
}

body{
    display:flex;
    background:#0f172a;
    color:white;
}

/* SIDEBAR */
.sidebar{
    width:250px;
    height:100vh;
    background:#111827;
    padding:20px;
    position:fixed;
}

.sidebar h2{
    color:#38bdf8;
    margin-bottom:20px;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:12px;
    margin:5px 0;
    border-radius:6px;
}

.sidebar a:hover{
    background:#1e293b;
    color:#38bdf8;
}

/* MAIN */
.main{
    margin-left:260px;
    padding:20px;
    width:100%;
}

/* CARDS */
.cards{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:15px;
}

.card{
    background:#1e293b;
    padding:20px;
    border-radius:10px;
    text-align:center;
}

.card h3{
    color:#38bdf8;
}

/* TABLE */
table{
    width:100%;
    margin-top:20px;
    border-collapse:collapse;
    background:#1e293b;
    border-radius:10px;
    overflow:hidden;
}

th,td{
    padding:12px;
    border-bottom:1px solid #334155;
}

th{
    background:#0f172a;
}

/* BUTTONS */
.btn{
    padding:6px 10px;
    border:none;
    border-radius:5px;
    text-decoration:none;
    color:white;
    margin-right:5px;
}

.approve{background:green;}
.reject{background:red;}

</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>🌍 Staff Panel</h2>

    <a href="staff_dashboard.php">Dashboard</a>
    <a href="sbookings.php">Bookings</a>
    <a href="scustomers.php">Customers</a>
    <a href="spackages.php">Packages</a>
    <a href="spayments.php">Payments</a>
    <a href="smessages.php">Messages</a>
    <a href="sreports.php">Reports</a>
    <a href="logout.php">Logout</a>
</div>

<!-- MAIN -->
<div class="main">

<h1>Dashboard Overview</h1>

<!-- CARDS -->
<div class="cards">

<div class="card">
<h3><?php echo $bookings; ?></h3>
<p>Total Bookings</p>
</div>

<div class="card">
<h3><?php echo $pending; ?></h3>
<p>Pending</p>
</div>

<div class="card">
<h3><?php echo $confirmed; ?></h3>
<p>Confirmed</p>
</div>

<div class="card">
<h3><?php echo $customers; ?></h3>
<p>Customers</p>
</div>

</div>

<div class="cards" style="margin-top:15px;">

<div class="card">
<h3><?php echo $packages; ?></h3>
<p>Packages</p>
</div>

<div class="card">
<h3><?php echo $messages; ?></h3>
<p>Messages</p>
</div>

<div class="card">
<h3><?php echo $cancelled; ?></h3>
<p>Cancelled</p>
</div>

<div class="card">
<h3>Staff</h3>
<p>Active Panel</p>
</div>

</div>

<!-- BOOKINGS TABLE -->
<h2 style="margin-top:30px;">Recent Bookings</h2>

<table>
<tr>
<th>Customer</th>
<th>Travel Date</th>
<th>Travelers</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php
$result = mysqli_query($conn,"SELECT * FROM bookings ORDER BY id DESC LIMIT 10");

while($row = mysqli_fetch_assoc($result)){
?>

<tr>
<td><?php echo $row['customer_name']; ?></td>
<td><?php echo $row['travel_date']; ?></td>
<td><?php echo $row['travelers']; ?></td>
<td><?php echo $row['status']; ?></td>

<td>
<a class="btn approve" href="?action=approve&id=<?php echo $row['id']; ?>">Approve</a>
<a class="btn reject" href="?action=reject&id=<?php echo $row['id']; ?>">Reject</a>
</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>