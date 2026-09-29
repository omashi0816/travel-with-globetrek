<?php
session_start();
include __DIR__ . '/../includes/db.php';

/* ADMIN SECURITY */
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit();
}

/* DELETE STAFF */
if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    mysqli_query($conn,
    "DELETE FROM users 
    WHERE id='$id' 
    AND role='staff'");

    header("Location: staff.php");
}

/* BLOCK STAFF */
if(isset($_GET['block'])){

    $id = $_GET['block'];

    mysqli_query($conn,
    "UPDATE users 
    SET status='blocked'
    WHERE id='$id'");

    header("Location: staff.php");
}

/* UNBLOCK STAFF */
if(isset($_GET['unblock'])){

    $id = $_GET['unblock'];

    mysqli_query($conn,
    "UPDATE users 
    SET status='active'
    WHERE id='$id'");

    header("Location: staff.php");
}

/* SEARCH */
$search = "";

if(isset($_GET['search'])){
    $search = $_GET['search'];
}

/* GET STAFF */
$result = mysqli_query($conn,
"SELECT * FROM users
WHERE role='staff'
AND (
name LIKE '%$search%'
OR email LIKE '%$search%'
)
ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>

<title>Advanced Staff Management</title>

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

/* TOP AREA */
.top-area{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

/* SEARCH */
.search-box input{
    padding:10px;
    width:250px;
    border:none;
    border-radius:8px;
    outline:none;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

/* ADD BUTTON */
.add-btn{
    background:#0c0c97;
    color:white;
    padding:10px 18px;
    border-radius:8px;
    text-decoration:none;
    transition:0.3s;
}

.add-btn:hover{
    background:#ff9800;
}

/* CARD */
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
    background:#0c0c97;
    color:white;
    padding:14px;
    font-size:14px;
}

/* ROW */
td{
    padding:14px;
    text-align:center;
    border-bottom:1px solid #eee;
}

tr:hover{
    background:#f5f8ff;
}

/* ROLE */
.role{
    background:#03a9f4;
    color:white;
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
    font-weight:bold;
}

/* STATUS */
.status{
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
    font-weight:bold;
}

.active{
    background:#4caf50;
    color:white;
}

.blocked{
    background:red;
    color:white;
}

/* BUTTONS */
.btn{
    padding:6px 10px;
    border-radius:6px;
    color:white;
    text-decoration:none;
    font-size:12px;
    margin:2px;
    display:inline-block;
}

.delete{
    background:red;
}

.block{
    background:#ff9800;
}

.unblock{
    background:#4caf50;
}

.edit{
    background:#03a9f4;
}

.btn:hover{
    opacity:0.8;
}

</style>

</head>

<body>

<div class="main">

<div class="header">
<h2>👨‍💼 Advanced Staff Management</h2>
</div>

<div class="top-area">

<!-- SEARCH -->
<form class="search-box" method="GET">

<input type="text"
name="search"
placeholder="Search staff..."
value="<?php echo $search; ?>">

</form>

<!-- ADD -->
<a class="add-btn" href="add_staff.php">
<i class="fas fa-plus"></i> Add Staff
</a>

</div>

<div class="card">

<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Status</th>
<th>Role</th>
<th>Actions</th>
</tr>

<?php
while($row = mysqli_fetch_assoc($result)){
?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo $row['phone']; ?></td>

<?php
$status = isset($row['status']) ? $row['status'] : 'active';
$statusClass = strtolower($status);
?>
<td>
<span class="status <?php echo htmlspecialchars($statusClass); ?>">
<?php echo htmlspecialchars(ucfirst($status)); ?>
</span>
</td>

<td>
<span class="role">
<?php echo htmlspecialchars($row['role']); ?>
</span>
</td>

<td>

<a class="btn edit"
href="edit_staff.php?id=<?php echo $row['id']; ?>">
<i class="fas fa-edit"></i>
Edit
</a>

<?php if(isset($row['status'])){ ?>
    <?php if($row['status']=="active"){ ?>

    <a class="btn block"
    href="staff.php?block=<?php echo $row['id']; ?>">
    <i class="fas fa-ban"></i>
    Block
    </a>

    <?php } else { ?>

    <a class="btn unblock"
    href="staff.php?unblock=<?php echo $row['id']; ?>">
    <i class="fas fa-check"></i>
    Unblock
    </a>

    <?php } ?>
<?php } ?>

<a class="btn delete"
href="staff.php?delete=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this staff member?')">

<i class="fas fa-trash"></i>
Delete

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>