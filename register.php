<?php
include 'includes/db.php';

$msg = "";

if(isset($_POST['register'])){

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];   // ✅ NEW

// check already user exists
$check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

if(mysqli_num_rows($check) > 0){
    $msg = "User already exists! Please login.";
}
else{
  $phone = $_POST['phone']; // ✅ add this line

mysqli_query($conn,
"INSERT INTO users(name,email,password,phone,role)
VALUES('$name','$email','$password','$phone','$role')");
    $msg = "Registration Successful! Now login.";
}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register - GlobeTrek</title>

<style>

body{
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;

    background:linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.6)),
    url('https://images.unsplash.com/photo-1501785888041-af3ef285b470')
    center/cover;
    font-family:Segoe UI;
}

.box{
    width:380px;
    padding:30px;
    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(15px);
    border-radius:15px;
    color:white;
    text-align:center;
}

input,select{
    width:100%;
    padding:12px;
    margin-top:12px;
    border-radius:8px;
    border:none;
    outline:none;
}

button{
    width:100%;
    padding:12px;
    margin-top:15px;
    border:none;
    border-radius:8px;
    background:linear-gradient(45deg,#00c853,#64dd17);
    color:white;
    font-weight:bold;
    cursor:pointer;
}

p{
    margin-top:10px;
    color:#ffcc80;
}

a{
    color:#00e5ff;
    text-decoration:none;
}

</style>

</head>

<body>

<div class="box">

<h2>🌍 Create Account</h2>

<form method="POST">

<input type="email" name="email" placeholder="Email Address" required>


<input type="text" name="phone" placeholder="Phone Number" required>

<input type="password" name="password" placeholder="Password" required>

<!-- ✅ ROLE SELECT -->
<select name="role" required>
    <option value="">Select Role</option>
    <option value="customer">Customer</option>
<option value="staff">Staff</option>
<option value="admin">Admin</option>
</select>

<button type="submit" name="register">Register</button>

</form>

<p><?php echo $msg; ?></p>

<a href="login.php">Already have an account? Login</a>

</div>

</body>
</html>