<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$email = $_SESSION['user'];

$user = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM users WHERE email='$email'")
);
?>

<!DOCTYPE html>
<html>
<head>
<title>Profile - GlobeTrek</title>

<style>

/* RESET */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

/* BACKGROUND */
body{
    min-height:100vh;

    background:
    linear-gradient(rgba(0,0,0,0.65),rgba(0,0,0,0.65)),
    url('https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=1974&auto=format&fit=crop')
    no-repeat center center/cover;

    color:white;
}

/* BACK BUTTON */
.back{
    position:fixed;
    top:20px;
    left:20px;

    padding:10px 15px;
    background:rgba(255,255,255,0.15);
    backdrop-filter:blur(10px);

    border-radius:8px;
    color:white;
    text-decoration:none;
    transition:0.3s;
}

.back:hover{
    background:#ff9800;
}

/* LOGOUT */
.logout{
    position:fixed;
    bottom:20px;
    right:20px;

    padding:12px 18px;
    background:linear-gradient(45deg,#ff1744,#d50000);

    color:white;
    text-decoration:none;
    border-radius:50px;

    font-weight:bold;
    transition:0.3s;
}

.logout:hover{
    transform:scale(1.1);
}

/* PROFILE BOX */
.box{
    width:800px;
    margin:80px auto;

    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(15px);

    border-radius:20px;
    padding:30px;

    text-align:center;
}

/* PROFILE IMAGE */
.profile-img{
    width:140px;
    height:140px;
    border-radius:50%;
    object-fit:cover;

    border:4px solid #ff9800;
    margin-top:10px;
}

/* INFO */
.info{
    margin-top:15px;
    background:rgba(255,255,255,0.1);
    padding:15px;
    border-radius:12px;
    line-height:2;
}

/* MENU GRID */
.menu{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:15px;
    margin-top:25px;
}

/* CARD */
.card{
    padding:20px;
    border-radius:15px;
    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,0.2);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-8px);
}

/* COLORS */
.blue{background:linear-gradient(45deg,#2196f3,#21cbf3);}
.green{background:linear-gradient(45deg,#00c853,#64dd17);}
.orange{background:linear-gradient(45deg,#ff9800,#ff5722);}

/* BUTTON */
.nav-btn{
    display:inline-block;
    margin-top:10px;
    padding:10px 15px;
    color:white;
    text-decoration:none;
    border-radius:8px;
    font-weight:bold;
    background:rgba(0,0,0,0.2);
}

/* ANIMATION */
.box{
    animation:fadeIn 1s ease;
}

@keyframes fadeIn{
    from{transform:translateY(30px);opacity:0;}
    to{transform:translateY(0);opacity:1;}
}

/* RESPONSIVE */
@media(max-width:800px){
    .box{width:90%;}
}

</style>

</head>

<body>

<a class="back" href="index.php">⬅ Home</a>

<div class="box">

<h2>🌍 My Profile</h2>

<!-- PROFILE IMAGE -->
<?php if(!empty($user['image'])) { ?>
    <img class="profile-img" src="uploads/<?php echo $user['image']; ?>">
<?php } else { ?>
    <img class="profile-img" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e">
<?php } ?>

<!-- USER INFO -->
<div class="info">
    <p><b>Name:</b> <?php echo $user['name']; ?></p>
    <p><b>Email:</b> <?php echo $user['email']; ?></p>
    <p><b>Phone:</b> <?php echo $user['phone']; ?></p>
</div>

<p style="margin-top:15px;">Welcome to GlobeTrek Travel Dashboard ✈️</p>

<!-- DASHBOARD MENU -->
<div class="menu">

    <div class="card blue">
        <h3>My Bookings</h3>
        <p>View all your tour bookings</p>
        <a class="nav-btn" href="mybookings.php">Open</a>
    </div>

    <div class="card green">
        <h3>Payment History</h3>
        <p>Check all payments</p>
        <a class="nav-btn" href="payments.php">Open</a>
    </div>

    <div class="card orange">
        <h3>Submit Query</h3>
        <p>Ask support team</p>
        <a class="nav-btn" href="query.php">Open</a>
    </div>

    <div class="card orange">
        <h3>Travel Guidelines</h3>
        <p>Ask support team</p>
        <a class="nav-btn" href="guidelines.php">Open</a>
    </div>

    <div class="card blue">
        <h3>Tour Packages</h3>
        <p>Explore available tours</p>
        <a class="nav-btn" href="packages.php">Open</a>
    </div>

    <div class="card green">
        <h3>Booking Now</h3>
        <p>Book your dream tour</p>
        <a class="nav-btn" href="booking.php">Book</a>
    </div>

</div>

</div>

<a class="logout" href="login.php">Logout</a>

</body>
</html>