<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$email = $_SESSION['user'];
$msg = "";

/* SUBMIT QUERY */
if(isset($_POST['send'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    /* INSERT QUERY INTO EXISTING MESSAGES TABLE */
    $insert_msg = "INSERT INTO messages(sender_type, sender_email, subject, message, created_at)
                   VALUES('customer','$email','$subject','$message',NOW())";

    if(mysqli_query($conn, $insert_msg)){
        
        /* CREATE NOTIFICATION FOR ADMIN */
        $notification = "INSERT INTO notifications(type, message, user_id, created_at, is_read)
                         VALUES('query','New query from $name: $subject', 1, NOW(), 0)";
        mysqli_query($conn, $notification);
        
        $msg = "✅ Your query has been sent successfully!";
    }else{
        $msg = "❌ Error sending query: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Submit Query - GlobeTrek</title>

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
    url('https://images.unsplash.com/photo-1526772662000-3f88f10405ff?q=80&w=2070&auto=format&fit=crop')
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

/* CONTAINER */
.container{
    width:450px;
    margin:100px auto;

    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(15px);

    border-radius:15px;
    padding:25px;

    text-align:center;
    box-shadow:0 10px 40px rgba(0,0,0,0.5);
}

/* TITLE */
h2{
    margin-bottom:15px;
}

/* INPUTS */
input, textarea{
    width:100%;
    padding:12px;
    margin-top:10px;

    border:none;
    outline:none;

    border-radius:8px;

    background:rgba(255,255,255,0.2);
    color:white;
}

textarea{
    resize:none;
    height:120px;
}

input::placeholder, textarea::placeholder{
    color:#ddd;
}

/* BUTTON */
button{
    width:100%;
    padding:12px;
    margin-top:15px;

    border:none;
    border-radius:8px;

    background:linear-gradient(45deg,#ff9800,#ff5722);
    color:white;

    font-weight:bold;
    cursor:pointer;

    transition:0.3s;
}

button:hover{
    transform:scale(1.05);
}

/* MESSAGE */
.msg{
    margin-top:10px;
    color:#00e676;
    font-weight:bold;
}

/* RESPONSIVE */
@media(max-width:500px){
    .container{
        width:90%;
    }
}

</style>

</head>

<body>

<a class="back" href="profile.php">⬅ Back</a>

<div class="container">

<h2>📩 Submit Your Query</h2>

<form method="POST">

<input type="text" name="name" placeholder="Your Name" required>

<input type="text" name="subject" placeholder="Subject" required>

<textarea name="message" placeholder="Your Message" required></textarea>

<button type="submit" name="send">Send Message</button>

</form>

<div class="msg">
    <?php echo $msg; ?>
</div>

</div>

</body>
</html>