<?php
session_start();
include __DIR__ . '/../includes/db.php';

/* SECURITY */
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit();
}

/* DELETE USER */
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM users WHERE id='$id'");
    header("Location: users.php");
}

/* USERS */
$result = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Users Management</title>

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

/* TITLE CARD */
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
    text-transform:uppercase;
    font-size:13px;
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

/* DELETE BUTTON */
.delete{
    background:#ff3d00;
    color:white;
    padding:6px 12px;
    border-radius:6px;
    text-decoration:none;
    font-size:13px;
    transition:0.3s;
}

.delete:hover{
    background:#d32f2f;
}

/* ROLE BADGES */
.role{
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
    font-weight:bold;
}

.admin{background:#ff9800;color:black;}
.staff{background:#03a9f4;color:white;}
.customer{background:#4caf50;color:white;}

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
<h2>👤 Users Management</h2>
</div>

<!-- TABLE -->
<div class="card">

<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Role</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['phone']; ?></td>

<td>
<span class="role <?php echo $row['role']; ?>">
<?php echo $row['role']; ?>
</span>
</td>

<td>
<a class="delete" href="users.php?delete=<?php echo $row['id']; ?>"
onclick="return confirm('Are you sure?')">
<i class="fas fa-trash"></i> Delete
</a>
</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>