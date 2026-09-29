<?php
session_start();
include __DIR__ . '/../includes/db.php';

/* ADMIN SECURITY */
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header('Location: ../login.php');
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if(!$id){
    header('Location: staff.php');
    exit();
}

$msg = '';
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$id AND role='staff' LIMIT 1"));
if(!$data){
    header('Location: staff.php');
    exit();
}

if(isset($_POST['save'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    mysqli_query($conn, "UPDATE users SET name='$name', email='$email', phone='$phone', status='$status' WHERE id=$id AND role='staff'");
    $msg = 'Staff member updated successfully.';
    $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$id AND role='staff' LIMIT 1"));
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Staff Member</title>
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
<div class="header"><h2>✏️ Edit Staff Member</h2></div>
<div class="card">
<?php if($msg): ?>
<div class="msg"><?php echo htmlspecialchars($msg); ?></div>
<?php endif; ?>
<a class="back" href="staff.php"><i class="fas fa-arrow-left"></i> Back to Staff Dashboard</a>
<form method="post">
    <div class="input-box"><label>Name</label><input type="text" name="name" value="<?php echo htmlspecialchars($data['name']); ?>" required></div>
    <div class="input-box"><label>Email</label><input type="email" name="email" value="<?php echo htmlspecialchars($data['email']); ?>" required></div>
    <div class="input-box"><label>Phone</label><input type="text" name="phone" value="<?php echo htmlspecialchars($data['phone']); ?>" required></div>
    <div class="input-box"><label>Status</label><select name="status"><option value="active" <?php if($data['status']=='active') echo 'selected'; ?>>Active</option><option value="blocked" <?php if($data['status']=='blocked') echo 'selected'; ?>>Blocked</option></select></div>
    <button type="submit" name="save"><i class="fas fa-save"></i> Update Staff</button>
</form>
</div>
</div>
</body>
</html>
