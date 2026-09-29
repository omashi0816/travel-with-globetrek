<?php
session_start();
include __DIR__ . '/../includes/db.php';

/* ADMIN SECURITY */
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit();
}

$msg = "";

/* UPDATE SETTINGS */
if(isset($_POST['save'])){

    $site_name = $_POST['site_name'];
    $admin_email = $_POST['admin_email'];
    $currency = $_POST['currency'];
    $theme = $_POST['theme'];

    /* CHECK SETTINGS EXISTS */
    $check = mysqli_query($conn,"SELECT * FROM settings");

    if(mysqli_num_rows($check) > 0){

        mysqli_query($conn,
        "UPDATE settings SET
        site_name='$site_name',
        admin_email='$admin_email',
        currency='$currency',
        theme='$theme'");

    }
    else{

        mysqli_query($conn,
        "INSERT INTO settings
        (site_name,admin_email,currency,theme)
        VALUES
        ('$site_name','$admin_email','$currency','$theme')");
    }

    $msg = "✅ Settings Updated Successfully!";
}

/* GET SETTINGS */
$data = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT * FROM settings LIMIT 1")
);
?>

<!DOCTYPE html>
<html>
<head>

<title>System Settings</title>

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
    margin-bottom:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.header h2{
    margin:0;
    color:#0c0c97;
}

/* CARD */
.card{
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    width:500px;
}

/* INPUTS */
.input-box{
    margin-bottom:18px;
}

.input-box label{
    display:block;
    margin-bottom:6px;
    font-weight:bold;
    color:#333;
}

.input-box input,
.input-box select{
    width:100%;
    padding:12px;
    border:none;
    border-radius:8px;
    background:#f1f1f1;
    outline:none;
}

/* BUTTON */
button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:8px;
    background:#0c0c97;
    color:white;
    font-size:15px;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#ff9800;
}

/* MESSAGE */
.msg{
    background:#d4edda;
    color:green;
    padding:12px;
    border-radius:8px;
    margin-bottom:15px;
}

</style>

</head>

<body>

<div class="main">

<div class="header">
<h2>⚙️ System Settings</h2>
</div>

<div class="card">

<?php if($msg!=""){ ?>
<div class="msg">
<?php echo $msg; ?>
</div>
<?php } ?>

<form method="POST">

<div class="input-box">
<label>Website Name</label>

<input type="text"
name="site_name"
value="<?php echo $data['site_name'] ?? ''; ?>"
required>
</div>

<div class="input-box">
<label>Admin Email</label>

<input type="email"
name="admin_email"
value="<?php echo $data['admin_email'] ?? ''; ?>"
required>
</div>

<div class="input-box">
<label>Currency</label>

<select name="currency">

<option value="LKR"
<?php if(($data['currency'] ?? '')=="LKR") echo "selected"; ?>>
LKR
</option>

<option value="USD"
<?php if(($data['currency'] ?? '')=="USD") echo "selected"; ?>>
USD
</option>

</select>
</div>

<div class="input-box">
<label>Theme</label>

<select name="theme">

<option value="Light"
<?php if(($data['theme'] ?? '')=="Light") echo "selected"; ?>>
Light
</option>

<option value="Dark"
<?php if(($data['theme'] ?? '')=="Dark") echo "selected"; ?>>
Dark
</option>

</select>

</div>

<button type="submit" name="save">
<i class="fas fa-save"></i>
Save Settings
</button>

</form>

</div>

</div>

</body>
</html>