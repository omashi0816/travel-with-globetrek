<?php
$message = "";

if(isset($_POST['package_book']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $package = $_POST['package'];

    $message = "Thank You " . $name . "! Your " . $package . " booking request has been received.";
}

include 'includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Tour Packages - Sri Lanka</title>

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
    background:linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.6)),
    url('https://images.unsplash.com/photo-1501785888041-af3ef285b470?q=80&w=1974&auto=format&fit=crop')
    no-repeat center center/cover;

    color:white;
}

/* TITLE */
.title{
    text-align:center;
    margin:25px;
    font-size:45px;
    text-shadow:0 0 15px rgba(0,0,0,0.6);
}

/* GRID */
.menu {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    padding:20px;
}

/* CARD */
.card {
    width: 320px;
    height: 220px;

    color: white;
    text-decoration: none;
    font-size: 22px;
    font-weight: bold;

    display: flex;
    align-items: flex-end;
    padding: 15px;

    border-radius: 15px;

    background-size: cover;
    background-position: center;

    position: relative;
    overflow: hidden;

    transition: 0.4s;

    box-shadow:0 10px 25px rgba(0,0,0,0.4);
}

/* DARK OVERLAY */
.card::before {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.45);
    top: 0;
    left: 0;
}

/* TEXT */
.card span{
    position: relative;
    z-index: 1;
}

/* HOVER */
.card:hover {
    transform: scale(1.05);
}

/* ===================== SRI LANKA IMAGES ===================== */

.northern {
    background-image: url("https://images.unsplash.com/photo-1593698054376-88f2a1a3d2b2");
}

.southern {
    background-image: url("https://images.unsplash.com/photo-1507525428034-b723cf961d3e");
}

.western {
    background-image: url("https://images.unsplash.com/photo-1558980664-10c236b7c1b4");
}

.eastern {
    background-image: url("https://images.unsplash.com/photo-1596394516093-501ba68a0ba6");
}

.honeymoon {
    background-image: url("https://images.unsplash.com/photo-1493558103817-58b2924bce98");
}

/* FORM */
.booking-form{
    width:420px;
    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(15px);

    margin:40px auto;
    padding:25px;

    border-radius:15px;

    box-shadow:0 10px 40px rgba(0,0,0,0.5);
    color:white;
}

.booking-form h2{
    text-align:center;
    margin-bottom:20px;
}

.booking-form input,
.booking-form select{
    width:100%;
    padding:12px;
    margin-top:12px;

    border:none;
    outline:none;

    border-radius:8px;

    background:rgba(255,255,255,0.2);
    color:white;
}

.booking-form input::placeholder{
    color:#ddd;
}

.booking-form button{
    width:100%;
    margin-top:18px;
    padding:12px;

    background:linear-gradient(45deg,#ff9800,#ff5722);
    color:white;

    border:none;
    border-radius:8px;

    font-size:16px;
    font-weight:bold;

    cursor:pointer;
    transition:0.3s;
}

.booking-form button:hover{
    transform:scale(1.05);
}

/* MESSAGE */
.message{
    text-align:center;
    color:#00e676;
    font-size:18px;
    margin-top:15px;
    font-weight:bold;
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
}

.back:hover{
    background:#ff9800;
}

/* RESPONSIVE */
@media(max-width:768px){
    .card{
        width:90%;
    }

    .booking-form{
        width:90%;
    }
}

</style>

</head>

<body>

<a class="back" href="profile.php">⬅ Profile</a>

<h1 class="title">🌍 Explore Sri Lanka Tour Packages 🇱🇰</h1>

<div class="menu">

   <a href="northern.php" class="card northern">
      <span>Northern Beauty</span>
   </a>

   <a href="southern.php" class="card southern">
      <span>Southern Beach Paradise</span>
   </a>

   <a href="western.php" class="card western">
      <span>Western City Life</span>
   </a>

   <a href="eastern.php" class="card eastern">
      <span>Eastern Coast</span>
   </a>

   <a href="honeymoon.php" class="card honeymoon">
      <span>Honeymoon Special Sri Lanka</span>
   </a>

</div>

<!-- BOOKING FORM -->
<div class="booking-form">

    <h2>Book Your Dream Tour ✈️</h2>

    <form method="POST">

        <input type="text" name="name" placeholder="Your Name" required>

        <input type="email" name="email" placeholder="Your Email" required>

        <select name="package" required>
            <option value="">Select Package</option>
            <?php
            $pkg_result = mysqli_query($conn, "SELECT DISTINCT package_name, price FROM packages ORDER BY region, package_name");
            while($pkg = mysqli_fetch_assoc($pkg_result)) {
                echo "<option value=\"" . htmlspecialchars($pkg['package_name']) . "\">".htmlspecialchars($pkg['package_name'])."</option>";
            }
            ?>
        </select>

        <button type="submit" name="package_book">
            Submit Booking
        </button>

    </form>

    <div class="message">
        <?php echo $message; ?>
    </div>

</div>

</body>
</html>