<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Western Province Tour</title>

<?php include 'includes/db.php'; ?>

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
    background:linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.6)),
    url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=1974&auto=format&fit=crop')
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
    z-index:1000;
}

.back:hover{
    background:#ff9800;
}

/* HEADER */
.header{
    height:280px;
    display:flex;
    justify-content:center;
    align-items:center;
    text-align:center;
    position:relative;
    background:url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e')
    center/cover;
}

.header::before{
    content:"";
    position:absolute;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.5);
}

.header h1{
    position:relative;
    font-size:40px;
}

/* CONTAINER */
.container{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:20px;
    padding:30px;
}

/* CARD */
.card{
    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(12px);
    border-radius:15px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,0.2);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-10px);
}

/* IMAGE */
.card img{
    width:100%;
    height:180px;
    object-fit:cover;
}

/* CONTENT */
.content{
    padding:15px;
}

h3{
    color:#ffcc80;
    margin-bottom:5px;
}

p{
    font-size:14px;
    line-height:1.6;
    color:#eee;
}

/* DETAILS */
.details{
    margin-top:8px;
    font-size:13px;
    color:#ddd;
    line-height:1.6;
}

/* HOTEL BOX */
.hotel-box{
    margin-top:10px;
    padding:10px;
    background:rgba(255,255,255,0.1);
    border-radius:8px;
    font-size:13px;
}

/* PRICE */
.price{
    margin-top:10px;
    font-weight:bold;
    color:#00e676;
    font-size:16px;
}

.price span{
    display:block;
    margin-top:3px;
    font-size:14px;
    color:#00e5ff;
}

/* BUTTON */
.btn{
    display:block;
    margin-top:12px;
    padding:10px;
    text-align:center;

    background:linear-gradient(45deg,#ff9800,#ff5722);
    color:white;

    border-radius:8px;
    text-decoration:none;
    font-weight:bold;
    transition:0.3s;
}

.btn:hover{
    transform:scale(1.05);
}

/* TAG */
.tag{
    display:inline-block;
    margin-top:5px;
    padding:3px 8px;
    background:rgba(255,255,255,0.2);
    border-radius:5px;
    font-size:12px;
}

</style>

</head>

<body>

<!-- BACK BUTTON -->
<a class="back" href="packages.php">⬅ Back</a>

<!-- HEADER -->
<div class="header">
    <h1>🌍 Western Province Tour Packages 🇱🇰</h1>
</div>

<div class="container">

<?php
$result = mysqli_query($conn, "SELECT * FROM packages WHERE region='Western' ORDER BY id DESC");
while($row = mysqli_fetch_assoc($result)) {
?>

<div class="card">
    <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['package_name']); ?>">

    <div class="content">
        <h3><?php echo htmlspecialchars($row['package_name']); ?></h3>
        <span class="tag"><?php echo htmlspecialchars($row['region']); ?></span>

        <p>📍 Duration: <?php echo htmlspecialchars($row['duration']); ?></p>

        <p class="price">Rs <?php echo number_format($row['price']); ?></p>

        <a class="btn" href="booking.php?package=<?php echo urlencode($row['package_name']); ?>&price=<?php echo urlencode($row['price']); ?>">Book Now</a>
    </div>
</div>

<?php } ?>

</div>

</body>
</html>