<?php
$companyName = "GlobeTrek Adventures";
$location = "Negombo, Sri Lanka";
$email = "globetrek@gmail.com";
$phone = "+94 77 123 4567";
$established = "2025";
?>

<!DOCTYPE html>
<html>
<head>
<title>About Us - GlobeTrek</title>

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
    url('https://images.unsplash.com/photo-1469474968028-56623f02e42e?q=80&w=1974&auto=format&fit=crop')
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
    padding:30px;
    font-size:38px;
    font-weight:bold;
    letter-spacing:2px;

    background:rgba(0,0,0,0.4);
    backdrop-filter:blur(10px);

    border-bottom:1px solid rgba(255,255,255,0.1);
}

/* CONTAINER */
.container{
    width:85%;
    margin:40px auto;

    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(12px);

    border:1px solid rgba(255,255,255,0.2);

    border-radius:20px;

    padding:30px;

    box-shadow:0 10px 40px rgba(0,0,0,0.4);
}

/* IMAGE */
.about-img{
    width:100%;
    height:420px;
    object-fit:cover;

    border-radius:15px;

    margin-bottom:20px;

    transition:0.4s;
}

.about-img:hover{
    transform:scale(1.02);
}

/* TITLES */
h2{
    margin-top:25px;
    font-size:26px;
    color:#ffd54f;
    text-shadow:0 0 10px rgba(255,213,79,0.5);
}

/* TEXT */
p{
    line-height:1.8;
    font-size:16px;
    margin-top:10px;
    color:#f1f1f1;
}

/* INFO BOX */
.info-box{
    margin-top:25px;
    padding:20px;

    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(10px);

    border:1px solid rgba(255,255,255,0.2);

    border-radius:15px;

    line-height:1.8;
}

/* HIGHLIGHT */
.highlight{
    margin-top:25px;
    padding:18px;

    text-align:center;

    font-size:18px;
    font-weight:bold;

    border-radius:12px;

    background:linear-gradient(45deg,#ff9800,#ff5722);

    box-shadow:0 5px 20px rgba(255,152,0,0.4);
}

/* ANIMATION */
.container{
    animation:fadeIn 1s ease;
}

@keyframes fadeIn{
    from{
        transform:translateY(30px);
        opacity:0;
    }
    to{
        transform:translateY(0);
        opacity:1;
    }
}

/* RESPONSIVE */
@media(max-width:900px){
    .container{
        width:95%;
        padding:20px;
    }

    header{
        font-size:28px;
    }

    .about-img{
        height:250px;
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
    <a href="contact.php">Contact</a>
</nav>

</div>

<header>
    About <?php echo $companyName; ?>
</header>

<div class="container">

    <!-- NEW TRAVEL IMAGE -->
    <img class="about-img"
    src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?q=80&w=1974&auto=format&fit=crop"
    alt="Travel Image">

    <h2>Who We Are</h2>
    <p>
        <?php echo $companyName; ?> is a professional travel company based in <?php echo $location; ?>,
        offering unforgettable travel experiences across Sri Lanka and worldwide.
        Established in <?php echo $established; ?>, we focus on safe, enjoyable and affordable tourism services.
    </p>

    <h2>Our Vision</h2>
    <p>
        To become the most trusted travel partner in Sri Lanka by delivering world-class tourism experiences.
    </p>

    <h2>Our Mission</h2>
    <p>
        We aim to provide high-quality travel packages, excellent customer service, and memorable journeys
        for every traveler.
    </p>

    <h2>What We Offer</h2>
    <p>
        ✔ Sri Lanka Tours<br>
        ✔ International Packages<br>
        ✔ Hotel Reservations<br>
        ✔ Transport Services<br>
        ✔ Customized Tours<br>
        ✔ 24/7 Support
    </p>

    <h2>Why Choose Us?</h2>
    <p>
        We focus on customer satisfaction, safety, and comfort. Our experienced team ensures
        every trip is smooth and enjoyable.
    </p>

    <!-- HIGHLIGHT -->
    <div class="highlight">
        🌍 Travel the world with confidence – GlobeTrek Adventures 🌍
    </div>

    <!-- INFO -->
    <h2>Contact Details</h2>

    <div class="info-box">
        <b>Company:</b> <?php echo $companyName; ?><br>
        <b>Location:</b> <?php echo $location; ?><br>
        <b>Email:</b> <?php echo $email; ?><br>
        <b>Phone:</b> <?php echo $phone; ?><br>
        <b>Established:</b> <?php echo $established; ?>
    </div>

</div>

</body>
</html>