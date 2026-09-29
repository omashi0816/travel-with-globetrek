<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$email = $_SESSION['user'];

/* SAMPLE QUERY (replace with real bookings table if you have) */
$result = mysqli_query($conn,"SELECT * FROM bookings WHERE email='$email' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>My Bookings</title>

<style>
body{
    margin:0;
    font-family:'Segoe UI';
    background:
    linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.6)),
    url('https://images.unsplash.com/photo-1500530855697-b586d89ba3ee')
    no-repeat center center/cover;
    color:white;
}

.container{
    width:80%;
    margin:100px auto;
}

.card{
    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(10px);
    padding:15px;
    margin:15px 0;
    border-radius:12px;
    border:1px solid rgba(255,255,255,0.2);
}

h1{text-align:center;}

.back{
    position:fixed;
    top:20px;
    left:20px;
    color:white;
    text-decoration:none;
    background:#ff9800;
    padding:10px 15px;
    border-radius:8px;
}
</style>

</head>

<body>

<a class="back" href="profile.php">⬅ Back</a>

<div class="container">

<h1>My Bookings</h1>

<?php
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        echo "<div class='card'>";
        echo "<h3>Package: ".htmlspecialchars($row['package'])."</h3>";
        echo "<p>Date: ".htmlspecialchars($row['travel_date'])."</p>";
        echo "<p>Travelers: ".htmlspecialchars($row['travelers'])."</p>";
        echo "</div>";
    }
}else{
    echo "<p>No bookings found.</p>";
}
?>

</div>

</body>
</html>