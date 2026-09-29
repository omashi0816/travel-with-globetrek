<?php
session_start();
include __DIR__ . '/../includes/db.php';

/* SECURITY */
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit();
}

/* APPROVE */
if(isset($_GET['approve'])){
    $id = $_GET['approve'];
    mysqli_query($conn, "UPDATE bookings SET status='approved' WHERE id='$id'");
    header("Location: bookings.php");
}

/* REJECT */
if(isset($_GET['reject'])){
    $id = $_GET['reject'];
    mysqli_query($conn, "UPDATE bookings SET status='rejected' WHERE id='$id'");
    header("Location: bookings.php");
}

/* GET BOOKINGS */
$result = mysqli_query($conn, "SELECT * FROM bookings ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Bookings Management</title>

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

.pending{background:orange;color:white;}
.approved{background:green;color:white;}
.rejected{background:red;color:white;}

/* BUTTONS */
.btn{
    padding:6px 10px;
    border-radius:6px;
    text-decoration:none;
    font-size:12px;
    color:white;
    margin:2px;
    display:inline-block;
}

.approve{background:#4caf50;}
.reject{background:#f44336;}

.approve:hover{background:#388e3c;}
.reject:hover{background:#d32f2f;}

</style>

</head>

<body>

<div class="main">

<!-- HEADER -->
<div class="header">
<h2>📅 Booking Management</h2>
</div>

<!-- TABLE -->
<div class="card">

<table>

<tr>
<th>ID</th>
<th>Customer</th>
<th>Date</th>
<th>Travelers</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['id']; ?></td>
<td><?php echo htmlspecialchars($row['customer_name']); ?></td>
<td><?php echo htmlspecialchars($row['travel_date']); ?></td>
<td><?php echo htmlspecialchars($row['travelers']); ?></td>

<td>
<span class="status <?php echo strtolower($row['status']); ?>">
<?php echo htmlspecialchars($row['status']); ?>
</span>
</td>

<td>

<a class="btn approve" href="bookings.php?approve=<?php echo $row['id']; ?>">
<i class="fas fa-check"></i> Approve
</a>

<a class="btn reject" href="bookings.php?reject=<?php echo $row['id']; ?>">
<i class="fas fa-times"></i> Reject
</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>