<?php
session_start();
include 'includes/db.php';

$msg = "";

if(isset($_POST['login'])){

$email = $_POST['email'];
$password = $_POST['password'];

/* GET USER */
$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = mysqli_query($conn,$sql);

if($result && mysqli_num_rows($result) > 0){

$user = mysqli_fetch_assoc($result);

$_SESSION['user'] = $email;
$_SESSION['role'] = $user['role'];

/* ROLE BASED REDIRECT */
if($user['role'] == 'admin'){
    header("Location: admin/admin_dashboard.php");
    exit();
}
elseif($user['role'] == 'staff'){
    header("Location: staff_dashboard.php");
    exit();
}
else{
    header("Location: profile.php");
    exit();
}

}else{
$msg = "Invalid login OR user not registered!";
}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login - GlobeTrek</title>

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
    url('https://images.unsplash.com/photo-1501785888041-af3ef285b470?q=80&w=1974&auto=format&fit=crop')
    no-repeat center center/cover;
}

/* NAVBAR */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:18px 60px;
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(15px);
    position:fixed;
    width:100%;
    top:0;
    left:0;
    z-index:1000;
    border-bottom:1px solid rgba(255,255,255,0.15);
}

.logo{
    color:white;
    font-size:28px;
    font-weight:bold;
}

nav{
    display:flex;
    gap:25px;
}

nav a{
    color:white;
    text-decoration:none;
    font-size:17px;
    position:relative;
}

nav a::after{
    content:'';
    position:absolute;
    left:0;
    bottom:-4px;
    width:0%;
    height:2px;
    background:linear-gradient(45deg,#ff9800,#ffd54f);
    transition:0.4s;
}

nav a:hover::after{
    width:100%;
}

nav a:hover{
    color:#ff9800;
}

/* LOGIN BOX */
.box{
    width:380px;
    padding:40px;
    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(15px);
    border:1px solid rgba(255,255,255,0.2);
    border-radius:15px;
    text-align:center;
    color:white;
    position:absolute;
    top:55%;
    left:50%;
    transform:translate(-50%,-50%);
    box-shadow:0 10px 40px rgba(0,0,0,0.5);
}

/* INPUT */
input{
    width:100%;
    padding:14px;
    margin-top:12px;
    border:none;
    border-radius:8px;
    background:rgba(255,255,255,0.2);
    color:white;
}

input::placeholder{
    color:#ddd;
}

/* BUTTON */
button{
    width:100%;
    padding:14px;
    margin-top:18px;
    border:none;
    border-radius:8px;
    background:linear-gradient(45deg,#ff9800,#ff5722);
    color:white;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
}

button:hover{
    transform:scale(1.05);
}

/* ERROR */
.msg{
    margin-top:10px;
    color:#ff4d4d;
}

/* LINK */
a{
    display:block;
    margin-top:15px;
    color:#00e5ff;
    text-decoration:none;
}

</style>

</head>

<body>

<!-- NAVBAR -->
<div class="navbar">

    <div class="logo">🌍 GlobeTrek</div>

    <nav>
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
        <a href="contact.php">Contact</a>
        <a href="about.php">About</a>
        <a href="review.php">Review</a>
    </nav>

</div>

<!-- LOGIN BOX -->
<div class="box">

<h2>Login</h2>
<p style="color:#ccc;">Welcome back traveler ✈️</p>

<form method="POST">

<input type="email" name="email" placeholder="Enter Email" required>

<input type="password" name="password" placeholder="Enter Password" required>

<button type="submit" name="login">Login</button>

</form>

<p class="msg"><?php echo $msg; ?></p>

<a href="register.php">Create new account</a>

</div>

</body>
</html>