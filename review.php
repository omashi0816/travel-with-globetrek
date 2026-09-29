<?php
$names = [
"John Smith","Emily Brown","Michael Johnson","Sophia Williams",
"Daniel Lee","Olivia Brown","James Wilson","Emma Taylor",
"Liam Anderson","Isabella Thomas"
];

$countries = [
"USA","United Kingdom","Canada","Australia","Germany",
"France","Italy","Japan","Spain","Netherlands"
];

$images = [
"https://images.unsplash.com/photo-1500648767791-00dcc994a43e",
"https://images.unsplash.com/photo-1506794778202-cad84cf45f1d",
"https://images.unsplash.com/photo-1544005313-94ddf0286df2",
"https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d",
"https://images.unsplash.com/photo-1502767089025-6572583495b4"
];

$reviewText = "GlobeTrek Adventures provided an outstanding travel experience in Sri Lanka. Everything was perfectly organized and the service was excellent.";
?>

<!DOCTYPE html>
<html>
<head>
<title>Reviews - GlobeTrek</title>

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

/* CONTAINER */
.container{
    padding-top:130px;
    text-align:center;
}

/* TITLE */
.container h1{
    font-size:42px;
    margin-bottom:30px;
    letter-spacing:2px;
    text-shadow:0 0 15px rgba(255,255,255,0.3);
}

/* CARD */
.card{
    display:inline-block;
    width:280px;

    margin:15px;
    padding:15px;

    border-radius:15px;

    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(12px);

    border:1px solid rgba(255,255,255,0.2);

    color:white;

    box-shadow:0 10px 25px rgba(0,0,0,0.4);

    transition:0.4s;
}

/* HOVER EFFECT */
.card:hover{
    transform:translateY(-10px) scale(1.03);
    box-shadow:0 15px 35px rgba(0,0,0,0.6);
}

/* IMAGE */
.card img{
    width:100%;
    height:180px;
    object-fit:cover;
    border-radius:12px;
}

/* TEXT */
.name{
    font-weight:bold;
    margin-top:10px;
    font-size:18px;
}

.country{
    color:#ffd54f;
    font-size:14px;
    margin-top:5px;
}

.review{
    font-size:14px;
    margin-top:10px;
    line-height:1.5;
    color:#f1f1f1;
}

/* ANIMATION */
@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(20px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

.card{
    animation:fadeIn 0.6s ease;
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
</nav>

</div>

<!-- CONTENT -->
<div class="container">

<h1>International Customer Reviews</h1>

<?php
for($i=1; $i<=30; $i++){

$name = $names[array_rand($names)];
$country = $countries[array_rand($countries)];
$image = $images[array_rand($images)];

echo "<div class='card'>";
echo "<img src='$image'>";
echo "<div class='name'>$name</div>";
echo "<div class='country'>$country</div>";
echo "<div class='review'>$reviewText</div>";
echo "</div>";
}
?>

</div>

</body>
</html>