<?php
$message = "";

if(isset($_POST['send']))
{
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $msg = htmlspecialchars($_POST['message']);

    $message = "Thank you $name! Your message has been sent successfully.";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Contact - GlobeTrek</title>

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
    background:
    linear-gradient(rgba(0,0,0,0.65),rgba(0,0,0,0.65)),
    url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=1974&auto=format&fit=crop')
    no-repeat center center/cover;

    color:white;
}

/* NAVBAR */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:18px 70px;

    background:rgba(0,0,0,0.45);
    backdrop-filter:blur(12px);

    position:fixed;
    width:100%;
    top:0;
    left:0;

    z-index:1000;

    border-bottom:1px solid rgba(255,255,255,0.1);
}

.logo{
    font-size:28px;
    font-weight:bold;
}

nav a{
    color:white;
    text-decoration:none;
    margin-left:25px;
    transition:0.3s;
}

nav a:hover{
    color:#ff9800;
}

/* HEADER */
header{
    text-align:center;
    padding-top:120px;
    font-size:34px;
    font-weight:bold;
    letter-spacing:2px;
    text-shadow:0 0 15px rgba(255,255,255,0.3);
}

/* INFO BOX */
.info-box{
    width:85%;
    margin:30px auto;
    padding:25px;

    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(12px);

    border:1px solid rgba(255,255,255,0.2);

    border-radius:15px;

    text-align:center;

    box-shadow:0 10px 30px rgba(0,0,0,0.4);
}

/* STAFF SECTION */
.container{
    width:90%;
    margin:auto;
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:25px;
    padding:20px;
}

/* STAFF CARD */
.staff-card{
    width:260px;

    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(10px);

    border:1px solid rgba(255,255,255,0.2);

    border-radius:15px;

    text-align:center;

    padding:15px;

    transition:0.4s;

    box-shadow:0 8px 25px rgba(0,0,0,0.3);
}

.staff-card:hover{
    transform:translateY(-10px) scale(1.03);
}

.staff-card img{
    width:100%;
    height:200px;
    object-fit:cover;
    border-radius:12px;
}

.staff-card h3{
    margin-top:10px;
    font-size:18px;
}

.staff-card p{
    color:#ffd54f;
    font-size:14px;
}

/* FORM */
.contact-box{
    width:400px;
    margin:40px auto;

    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(15px);

    border:1px solid rgba(255,255,255,0.2);

    border-radius:15px;

    padding:25px;

    box-shadow:0 10px 35px rgba(0,0,0,0.4);
}

input, textarea{
    width:100%;
    padding:14px;
    margin-top:12px;

    border:none;
    outline:none;

    border-radius:8px;

    background:rgba(255,255,255,0.2);
    color:white;
}

input::placeholder, textarea::placeholder{
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

    transition:0.3s;
}

button:hover{
    transform:scale(1.05);
}

/* MESSAGE */
.message{
    text-align:center;
    color:#00ff99;
    margin-top:10px;
    font-weight:bold;
}

/* TITLE */
h2{
    text-align:center;
    margin-top:20px;
    font-size:28px;
}

/* RESPONSIVE */
@media(max-width:900px){

    .navbar{
        flex-direction:column;
        padding:15px;
    }

    nav{
        margin-top:10px;
    }

    .contact-box{
        width:90%;
    }

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
    <a href="review.php">Reviews</a>
    <a href="about.php">About</a>
</nav>

</div>

<!-- HEADER -->
<header>Contact GlobeTrek Adventures</header>

<!-- COMPANY INFO -->
<div class="info-box">

    <h2>Company Details</h2>

    <p>GlobeTrek Adventures - Sri Lanka Travel Agency</p>
    <p>Negombo, Sri Lanka</p>
    <p>globetrek@gmail.com</p>
    <p>+94 77 123 4567</p>

</div>

<!-- STAFF -->
<h2>Our Team</h2>

<div class="container">

<div class="staff-card">
    <img src="https://images.unsplash.com/photo-1607746882042-944635dfe10e">
    <h3>John Fernando</h3>
    <p>CEO</p>
</div>

<div class="staff-card">
    <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2">
    <h3>Sarah Perera</h3>
    <p>Manager</p>
</div>

<div class="staff-card">
    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e">
    <h3>David Silva</h3>
    <p>Support</p>
</div>

</div>

<!-- CONTACT FORM -->
<h2>Send Message</h2>

<div class="contact-box">

<form method="POST">

<input type="text" name="name" placeholder="Your Name" required>

<input type="email" name="email" placeholder="Your Email" required>

<input type="text" name="subject" placeholder="Subject" required>

<textarea name="message" rows="5" placeholder="Your Message" required></textarea>

<button type="submit" name="send">Send Message</button>

</form>

<div class="message">
<?php echo $message; ?>
</div>

</div>

</body>
</html>