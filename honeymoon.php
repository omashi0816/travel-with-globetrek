<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Honeymoon Packages</title>

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
    url('https://images.unsplash.com/photo-1526779259212-939e64788e3c?q=80&w=1974&auto=format&fit=crop')
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

/* HEADER */
.header{
    height:280px;
    display:flex;
    justify-content:center;
    align-items:center;
    text-align:center;
    font-size:40px;
    font-weight:bold;
}

/* GRID */
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
    box-shadow:0 10px 30px rgba(0,0,0,0.4);
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
    margin-bottom:8px;
    color:#ffcc80;
}

p{
    font-size:14px;
    line-height:1.6;
}

/* PRICE */
.price{
    margin-top:8px;
    color:#00e676;
    font-weight:bold;
}

/* BUTTON */
.btn{
    display:block;
    margin-top:12px;
    padding:10px;
    text-align:center;
    background:linear-gradient(45deg,#e91e63,#ad1457);
    color:white;
    border-radius:8px;
    text-decoration:none;
    font-weight:bold;
    transition:0.3s;
}
.btn:hover{
    transform:scale(1.05);
}

</style>

</head>

<body>

<a class="back" href="packages.php">⬅ Back</a>

<div class="header">
    💕 Honeymoon Packages Sri Lanka 🇱🇰
</div>

<div class="container">

<?php
$result = mysqli_query($conn, "SELECT * FROM packages WHERE region='Honeymoon' ORDER BY id DESC");
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