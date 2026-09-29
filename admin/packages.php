<?php
session_start();
include __DIR__ . '/../includes/db.php';

/* SECURITY */
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit();
}

/* DELETE PACKAGE */
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM packages WHERE id=$id");
    header("Location: packages.php");
    exit();
}

/* GET PACKAGES */
$result = mysqli_query($conn, "SELECT * FROM packages ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Packages Management</title>

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

/* GRID */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}

/* CARD */
.card{
    background:white;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

/* IMAGE */
.card img{
    width:100%;
    height:160px;
    object-fit:cover;
}

/* CONTENT */
.content{
    padding:15px;
}

.content h3{
    margin:0;
    color:#0c0c97;
}

.price{
    color:green;
    font-weight:bold;
    margin:8px 0;
}

.desc{
    font-size:13px;
    color:#555;
}

/* BUTTON */
.delete{
    display:inline-block;
    margin-top:10px;
    background:red;
    color:white;
    padding:6px 10px;
    border-radius:6px;
    text-decoration:none;
    font-size:12px;
}

.delete:hover{
    background:#c62828;
}

/* ADD BUTTON */
.add{
    display:inline-block;
    margin-bottom:20px;
    background:#0c0c97;
    color:white;
    padding:10px 15px;
    border-radius:8px;
    text-decoration:none;
}

</style>

</head>

<body>

<div class="main">

<!-- HEADER -->
<div class="header">
<h2>📦 Package Management</h2>
</div>

<!-- ADD BUTTON -->
<a class="add" href="add_package.php">
<i class="fas fa-plus"></i> Add New Package
</a>
    <a class="add" href="admin_dashboard.php" style="margin-left:10px; background:#555;">
    <i class="fas fa-arrow-left"></i> Dashboard
    </a>

<?php while($row = mysqli_fetch_assoc($result)){ 
    $packageName = isset($row['name']) ? $row['name'] : 'Unnamed package';
    $packagePrice = isset($row['price']) ? $row['price'] : '0';
    $packageDesc = isset($row['description']) ? $row['description'] : 'No description available.';
    $packageImage = isset($row['image']) ? $row['image'] : '';
    $packageId = isset($row['id']) ? $row['id'] : 0;
?>

<div class="card">

<!-- IMAGE -->
<img src="../uploads/<?php echo htmlspecialchars($packageImage); ?>" alt="Package image">

<!-- CONTENT -->
<div class="content">

<h3><?php echo htmlspecialchars($packageName); ?></h3>

<div class="price">
Rs. <?php echo htmlspecialchars($packagePrice); ?>
</div>

<div class="desc">
<?php echo htmlspecialchars($packageDesc); ?>
</div>

<a class="delete"
href="packages.php?delete=<?php echo htmlspecialchars($packageId); ?>"
onclick="return confirm('Delete this package?')">

<i class="fas fa-trash"></i> Delete
</a>

</div>

</div>

<?php } ?>

</div>

</div>

</body>
</html>