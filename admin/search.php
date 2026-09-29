<?php
session_start();
include __DIR__ . '/../includes/db.php';

/* ADMIN SECURITY */
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit();
}

/* SEARCH VALUE */
$search = "";

if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

/* SEARCH USERS */
$users = mysqli_query($conn,
"SELECT * FROM users
WHERE
name LIKE '%$search%'
OR email LIKE '%$search%'
OR role LIKE '%$search%'");

/* SEARCH BOOKINGS */
$bookings = mysqli_query($conn,
"SELECT * FROM bookings
WHERE
status LIKE '%$search%'
OR user_id LIKE '%$search%'");

/* SEARCH PAYMENTS */
$payments = mysqli_query($conn,
"SELECT * FROM payments
WHERE
email LIKE '%$search%'
OR method LIKE '%$search%'
OR status LIKE '%$search%'");
?>

<!DOCTYPE html>
<html>
<head>

<title>Search System</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
    padding:18px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    margin-bottom:20px;
}

.header h2{
    margin:0;
    color:#0c0c97;
}

/* SEARCH BOX */
.search-box{
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    margin-bottom:20px;
}

.search-box form{
    display:flex;
    gap:10px;
}

.search-box input{
    flex:1;
    padding:12px;
    border:none;
    border-radius:8px;
    outline:none;
    background:#f1f1f1;
}

.search-box button{
    background:#0c0c97;
    color:white;
    border:none;
    padding:12px 20px;
    border-radius:8px;
    cursor:pointer;
}

/* SECTION */
.section{
    margin-bottom:25px;
}

/* TITLE */
.section h3{
    color:#0c0c97;
}

/* CARD */
.card{
    background:white;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
}

/* HEAD */
th{
    background:#0c0c97;
    color:white;
    padding:12px;
}

/* ROW */
td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #eee;
}

tr:hover{
    background:#f5f8ff;
}

/* BADGES */
.role{
    padding:5px 10px;
    border-radius:20px;
    color:white;
    font-size:12px;
}

.admin{
    background:#ff9800;
}

.staff{
    background:#03a9f4;
}

.customer{
    background:#4caf50;
}

.status{
    padding:5px 10px;
    border-radius:20px;
    color:white;
    font-size:12px;
}

.paid{
    background:green;
}

.pending{
    background:orange;
}

.approved{
    background:#4caf50;
}

.rejected{
    background:red;
}

</style>

</head>

<body>

<div class="main">

<!-- HEADER -->
<div class="header">
<h2>🔍 Search & Filter System</h2>
</div>

<!-- SEARCH -->
<div class="search-box">

<form method="GET">

<input type="text"
name="search"
placeholder="Search users, bookings, payments..."
value="<?php echo $search; ?>">

<button type="submit">
<i class="fas fa-search"></i> Search
</button>

</form>

</div>

<!-- USERS -->
<div class="section">

<h3>👤 Users</h3>

<div class="card">

<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Role</th>
</tr>

<?php if($users && mysqli_num_rows($users) > 0): ?>
<?php while($row = mysqli_fetch_assoc($users)){ ?>

<tr>

<td><?php echo htmlspecialchars($row['id']); ?></td>

<td><?php echo htmlspecialchars($row['name']); ?></td>

<td><?php echo htmlspecialchars($row['email']); ?></td>

<td>
<span class="role <?php echo htmlspecialchars($row['role']); ?>">
<?php echo htmlspecialchars($row['role']); ?>
</span>
</td>

</tr>

<?php } ?>
<?php else: ?>
<tr><td colspan="4" style="text-align:center; color:#666;">No users found.</td></tr>
<?php endif; ?>

</table>

</div>

</div>

<!-- BOOKINGS -->
<div class="section">

<h3>📅 Bookings</h3>

<div class="card">

<table>

<tr>
<th>ID</th>
<th>User ID</th>
<th>Status</th>
</tr>

<?php if($bookings && mysqli_num_rows($bookings) > 0): ?>
<?php while($row = mysqli_fetch_assoc($bookings)){ ?>

<tr>

<td><?php echo htmlspecialchars($row['id']); ?></td>

<td><?php echo htmlspecialchars($row['user_id']); ?></td>

<td>
<span class="status <?php echo htmlspecialchars(strtolower($row['status'])); ?>">
<?php echo htmlspecialchars($row['status']); ?>
</span>
</td>

</tr>

<?php } ?>
<?php else: ?>
<tr><td colspan="3" style="text-align:center; color:#666;">No bookings found.</td></tr>
<?php endif; ?>

</table>

</div>

</div>

<!-- PAYMENTS -->
<div class="section">

<h3>💳 Payments</h3>

<div class="card">

<table>

<tr>
<th>ID</th>
<th>Email</th>
<th>Method</th>
<th>Status</th>
</tr>

<?php if($payments && mysqli_num_rows($payments) > 0): ?>
<?php while($row = mysqli_fetch_assoc($payments)){ ?>

<tr>

<td><?php echo htmlspecialchars($row['id']); ?></td>

<td><?php echo htmlspecialchars($row['email']); ?></td>

<td><?php echo htmlspecialchars($row['method']); ?></td>

<td>
<span class="status <?php echo htmlspecialchars(strtolower($row['status'])); ?>">
<?php echo htmlspecialchars($row['status']); ?>
</span>
</td>

</tr>

<?php } ?>
<?php else: ?>
<tr><td colspan="4" style="text-align:center; color:#666;">No payments found.</td></tr>
<?php endif; ?>

</table>

</div>

</div>

</div>

</body>
</html>