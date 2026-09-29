<?php

$message = "";

if(isset($_POST['booking']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $country = $_POST['country'];

    $message = "Welcome " . $name . "! Your booking request has been submitted successfully.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>GlobeTrek Adventures</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Times New Roman', sans-serif;
}

body{
    overflow-x:hidden;
    background:#111;
}

/* HERO SECTION */

.hero{
    height:100vh;

    background:
    linear-gradient(rgba(0,0,0,0.65),
    rgba(0,0,0,0.65)),

    url('https://images.unsplash.com/photo-1566296314736-6eaac1ca0cb9?q=80&w=1974&auto=format&fit=crop')
    no-repeat center center/cover;

    position:relative;
    overflow:hidden;
}

/* OVERLAY EFFECT */

.hero::before{
    content:'';
    position:absolute;
    width:100%;
    height:100%;

    background:
    radial-gradient(circle at top right,
    rgba(255,152,0,0.25),
    transparent 40%),

    radial-gradient(circle at bottom left,
    rgba(0,229,255,0.20),
    transparent 40%);
}

/* NAVBAR */

.navbar{
    width:100%;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px 80px;
    position:fixed;
    top:0;
    left:0;
    z-index:1000;
    background:rgba(0,0,0,0.3);
    backdrop-filter:blur(10px);
}

.logo{
    color:white;
    font-size:36px;
    font-weight:bold;
    letter-spacing:2px;
    text-shadow:0 0 10px rgba(255,255,255,0.5);
}

nav a{
    color:white;
    text-decoration:none;
    margin-left:30px;
    font-size:18px;
    position:relative;
    transition:0.4s;
}

nav a::after{
    content:'';
    width:0%;
    height:2px;
    background:#ff9800;
    position:absolute;
    left:0;
    bottom:-6px;
    transition:0.4s;
}

nav a:hover::after{
    width:100%;
}

nav a:hover{
    color:#ff9800;
}

/* HERO CONTENT */

.hero-content{
    height:100vh;
    display:flex;
    justify-content:flex-start;
    align-items:center;
    flex-direction:column;
    text-align:center;
    color:white;
    padding-top:180px;
    position:relative;
    z-index:2;
    margin-top:-50px;
}

.search-box {
    position: relative;
    width: 550px;
}

.search-box input{
    width:100%;
    padding:18px 30px;
    border-radius:40px;
    border:2px solid #ff9800;
    outline:none;
    font-size:18px;
    background:rgba(255,255,255,0.95);
    box-shadow:0 8px 25px rgba(255,152,0,0.4);
    transition:0.4s;
}

.search-box input:focus{
    background:white;
    box-shadow:0 12px 35px rgba(255,152,0,0.6);
    border-color:#ffd54f;
    transform:translateY(-3px);
}

.search-results{
    position:absolute;
    top:100%;
    left:0;
    right:0;
    background:white;
    border-radius:15px;
    margin-top:10px;
    box-shadow:0 8px 25px rgba(0,0,0,0.2);
    max-height:300px;
    overflow-y:auto;
    z-index:1001;
}

.search-results a{
    display:block;
    padding:12px 20px;
    text-decoration:none;
    color:#333;
    border-bottom:1px solid #eee;
    transition:0.3s;
}

.search-results a:first-child{
    border-radius:15px 15px 0 0;
}

.search-results a:last-child{
    border-radius:0 0 15px 15px;
    border-bottom:none;
}

.search-results a:hover{
    background:#ff9800;
    color:white;
    padding-left:25px;
}

/* SUB TITLE */

.sub-title{
    font-size:28px;
    color:#ffd180;
    letter-spacing:8px;
    text-transform:uppercase;
    margin-bottom:15px;
    animation:fadeDown 1.5s ease;
    text-shadow:0 0 15px rgba(255,193,7,0.8);

    border:1px solid rgba(255,255,255,0.2);
    padding:10px 25px;
    border-radius:50px;

    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(8px);
}

/* SEARCH AND BUTTON CONTAINER */

.search-button-container{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:25px;
    margin-bottom:40px;
    animation:fadeUp 2.5s ease;
    flex-wrap:wrap;
}

/* MAIN TITLE */

.main-title{
    font-size:95px;
    font-weight:900;
    margin-bottom:10px;
    text-transform:uppercase;
    line-height:1.1;
    letter-spacing:4px;

    animation:zoomIn 1.5s ease;

    text-shadow:
    0 0 10px rgba(255,255,255,0.3),
    0 0 20px rgba(255,152,0,0.5),
    0 0 40px rgba(255,152,0,0.3);
}

.main-title span{
    background:linear-gradient(45deg,#ff9800,#ffd54f,#fff176);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

/* SECOND TITLE */

.second-title{
    font-size:65px;
    font-weight:bold;
    margin-bottom:30px;

    animation:fadeUp 2s ease;

    text-shadow:0 0 15px rgba(0,0,0,0.5);
}

.second-title span{
    color:#00e5ff;

    text-shadow:
    0 0 10px rgba(0,229,255,0.8),
    0 0 20px rgba(0,229,255,0.6),
    0 0 40px rgba(0,229,255,0.4);
}

/* HERO TEXT */

.hero-text{
    font-size:23px;
    max-width:900px;
    line-height:2;
    margin-bottom:40px;
    color:#f5f5f5;
    padding:0 20px;

    animation:fadeUp 2.5s ease;

    text-shadow:0 0 8px rgba(0,0,0,0.5);
}

/* BUTTON */

.btn{
    display:inline-block;
    padding:15px 40px;

    background:linear-gradient(45deg,#ff9800,#ff5722);

    color:white;
    text-decoration:none;
    font-size:20px;
    font-weight:bold;

    border-radius:60px;

    transition:0.4s;

    box-shadow:
    0 0 15px rgba(255,152,0,0.5),
    0 0 30px rgba(255,87,34,0.4);

    animation:fadeUp 3s ease;

    position:relative;
    overflow:hidden;
}

.btn::before{
    content:'';
    position:absolute;
    top:0;
    left:-100%;
    width:100%;
    height:100%;
    background:rgba(255,255,255,0.2);
    transition:0.5s;
    
    
}

.btn:hover::before{
    left:100%;
}

.btn:hover{
    transform:translateY(-5px) scale(1.08);

    box-shadow:
    0 0 25px rgba(255,152,0,0.8),
    0 0 50px rgba(255,87,34,0.6);
}

/* FLOATING ICONS */

.float-icon{
    position:absolute;
    color:white;
    font-size:32px;
    opacity:0.7;
    animation:float 6s infinite ease-in-out;
    z-index:2;
}

.icon1{
    top:20%;
    left:10%;
}

.icon2{
    top:30%;
    right:12%;
    animation-delay:2s;
}

.icon3{
    bottom:18%;
    left:15%;
    animation-delay:4s;
}

/* GLASS CARD */

.info-card{
    position:absolute;
    bottom:35px;
    left:50%;
    transform:translateX(-50%);

    width:85%;
    max-width:1100px;

    background:rgba(255,255,255,0.12);

    backdrop-filter:blur(12px);

    border:1px solid rgba(255,255,255,0.2);

    border-radius:25px;

    padding:30px;

    display:flex;
    justify-content:space-around;
    align-items:center;

    color:white;

    box-shadow:0 8px 30px rgba(0,0,0,0.4);

    z-index:2;
}

.info-box{
    text-align:center;
    transition:0.4s;
}

.info-box:hover{
    transform:translateY(-8px);
}

.info-box h2{
    font-size:38px;
    color:#ffd54f;
    margin-bottom:10px;

    text-shadow:0 0 10px rgba(255,213,79,0.8);
}

.info-box p{
    font-size:18px;
    color:#f5f5f5;
}

/* SUCCESS MESSAGE */

.message{
    margin-top:20px;
    color:#00ff99;
    font-size:22px;
    font-weight:bold;
}

/* ANIMATIONS */

@keyframes zoomIn{

    from{
        transform:scale(0.5);
        opacity:0;
    }

    to{
        transform:scale(1);
        opacity:1;
    }

}

@keyframes fadeDown{

    from{
        transform:translateY(-50px);
        opacity:0;
    }

    to{
        transform:translateY(0);
        opacity:1;
    }

}

@keyframes fadeUp{

    from{
        transform:translateY(50px);
        opacity:0;
    }

    to{
        transform:translateY(0);
        opacity:1;
    }

}

@keyframes float{

    0%{
        transform:translateY(0px);
    }

    50%{
        transform:translateY(-20px);
    }

    100%{
        transform:translateY(0px);
    }

}

/* RESPONSIVE */

@media(max-width:900px){

    .navbar{
        padding:20px 30px;
        flex-direction:column;
    }

    nav{
        margin-top:15px;
    }

    nav a{
        margin:10px;
        display:inline-block;
    }

    .main-title{
        font-size:45px;
    }

    .second-title{
        font-size:35px;
    }

    .hero-text{
        font-size:18px;
    }

    .sub-title{
        font-size:18px;
    }

    .search-button-container{
        flex-direction:column;
        gap:15px;
    }

    .search-box{
        width:100%;
        max-width:500px;
    }

    .info-card{
        flex-direction:column;
        gap:20px;
        bottom:20px;
    }

}

</style>

</head>

<body>

<!-- HERO SECTION -->

<div class="hero">

    <!-- FLOATING ICONS -->

    <div class="float-icon icon1">✈</div>
    <div class="float-icon icon2">🌴</div>
    <div class="float-icon icon3">☀</div>

    <!-- NAVBAR -->

    <div class="navbar">

        <div class="logo">🌍 GlobeTrek</div>

        <nav>

            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="review.php">Review</a>
            <a href="contact.php">Contact</a>
            <a href="about.php">About</a>

        </nav>

    </div>

    <!-- HERO CONTENT -->

    <div class="hero-content">

        <h2 class="sub-title">
            Welcome To Sri Lanka
        </h2>

        <p class="hero-text">

        <h1 class="second-title">
            Travel With <span>GlobeTrek</span>
        </h1>

    
        <div class="search-button-container">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Search menu..." onkeyup="searchNav()">
                <!-- SEARCH RESULT BOX -->
                <div id="searchResults" class="search-results"></div>
            </div>

            <a href="login.php" class="btn">
                Book Your Tour
            </a>
        </div>

        <p class="hero-text">

            Experience the beauty of Sri Lanka with unforgettable adventures,
            luxury tours, cultural experiences, wildlife journeys,
            and amazing destinations around the ancient Sigiriya Rock Fortress.

        </p>

        <?php
        if($message != "")
        {
            echo "<div class='message'>$message</div>";
        }
        ?>

    </div>

    <!-- GLASS CARD -->

    <div class="info-card">

        <div class="info-box">
            <h2>50+</h2>
            <p>Tour Packages</p>
        </div>

        <div class="info-box">
            <h2>1000+</h2>
            <p>Happy Travelers</p>
        </div>

        <div class="info-box">
            <h2>24/7</h2>
            <p>Customer Support</p>
        </div>

        <div class="info-box">
            <h2>15+</h2>
            <p>Luxury Hotels</p>
        </div>

    </div>

</div>

<script>

function searchNav() {

    let input = document.getElementById("searchInput").value.toLowerCase();
    let navLinks = document.querySelectorAll("nav a");
    let resultBox = document.getElementById("searchResults");

    resultBox.innerHTML = "";

    if(input === ""){
        resultBox.style.display = "none";
        return;
    }

    let found = false;

    navLinks.forEach(link => {

        let text = link.textContent.toLowerCase();

        if(text.includes(input)){

            found = true;

            let a = document.createElement("a");
            a.href = link.href;
            a.textContent = link.textContent;

            resultBox.appendChild(a);
        }

    });

    resultBox.style.display = found ? "block" : "none";
}

</script>

</body>
</html>