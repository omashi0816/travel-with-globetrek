<?php
session_start();
include __DIR__ . '/../includes/db.php';

/* ADMIN SECURITY */
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header('Location: ../login.php');
    exit();
}

$msg = '';
if(isset($_POST['save'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $exists = mysqli_query($conn, "SELECT id FROM users WHERE email='$email' LIMIT 1");
    if($exists && mysqli_num_rows($exists) > 0){
        $msg = 'Email already in use.';
    } else {
        mysqli_query($conn, "INSERT INTO users (name,email,phone,password,role,status) VALUES ('$name','$email','$phone','$password','staff','$status')");
        $msg = 'Staff member added successfully.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Staff Member</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body{margin:0;font-family:Segoe UI;background:linear-gradient(135deg,#e0eafc,#cfdef3);}
.main{margin-left:260px;padding:25px;}
.card{background:white;padding:25px;border-radius:15px;box-shadow:0 10px 25px rgba(0,0,0,0.1);max-width:600px;}
.header{background:white;padding:18px;border-radius:12px;box-shadow:0 5px 15px rgba(0,0,0,0.1);margin-bottom:20px;}
.header h2{margin:0;color:#0c0c97;}
.input-box{margin-bottom:18px;}
.input-box label{display:block;margin-bottom:6px;font-weight:bold;color:#333;}
.input-box input, .input-box select{width:100%;padding:12px;border:none;border-radius:8px;background:#f1f1f1;outline:none;}
button{width:100%;padding:12px;border:none;border-radius:8px;background:#0c0c97;color:white;font-size:15px;cursor:pointer;transition:.3s;}
button:hover{background:#1a237e;}
.msg{background:#d4edda;color:#0f5132;padding:12px;border-radius:8px;margin-bottom:15px;}
.back{display:inline-block;margin-bottom:20px;color:#0c0c97;text-decoration:none;}
</style>
</head>
<body>
<div class="main">
<div class="header"><h2>➕ Add New Staff</h2></div>
<div class="card">
<?php if($msg): ?>
<div class="msg"><?php echo htmlspecialchars($msg); ?></div>
<?php endif; ?>
<a class="back" href="staff.php"><i class="fas fa-arrow-left"></i> Back to Staff Dashboard</a>
<form method="post">
    <div class="input-box"><label>Name</label><input type="text" name="name" required></div>
    <div class="input-box"><label>Email</label><input type="email" name="email" required></div>
    <div class="input-box"><label>Phone</label><input type="text" name="phone" required></div>
    <div class="input-box"><label>Password</label><input type="password" name="password" required></div>
    <div class="input-box"><label>Status</label><select name="status"><option value="active">Active</option><option value="blocked">Blocked</option></select></div>
    <button type="submit" name="save"><i class="fas fa-save"></i> Save Staff</button>
</form>
</div>
</div>
</body>
</html>
