<!DOCTYPE html>
<html>
<head>
<title>Travel Guideline</title>

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
    background:linear-gradient(rgba(0,0,0,0.65),rgba(0,0,0,0.65)),
    url('https://images.unsplash.com/photo-1501785888041-af3ef285b470')
    center/cover fixed;
    color:white;
}

/* BACK BUTTON */
.back{
    position:fixed;
    top:20px;
    left:20px;
    padding:10px 15px;
    background:rgba(255,255,255,0.15);
    color:white;
    text-decoration:none;
    border-radius:10px;
    backdrop-filter:blur(10px);
    transition:0.3s;
}

.back:hover{
    background:#ff9800;
    transform:scale(1.05);
}

/* HEADER */
.header{
    text-align:center;
    padding:70px 20px 30px;
}

.header h1{
    font-size:45px;
    text-shadow:0 0 15px black;
    animation:fadeDown 1s ease-in-out;
}

.header p{
    margin-top:10px;
    color:#ddd;
    font-size:16px;
}

/* ANIMATION */
@keyframes fadeDown{
    from{opacity:0; transform:translateY(-30px);}
    to{opacity:1; transform:translateY(0);}
}

/* GRID */
.container{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:25px;
    padding:40px;
}

/* CARD */
.card{
    background:rgba(255,255,255,0.10);
    backdrop-filter:blur(15px);
    border:1px solid rgba(255,255,255,0.2);
    border-radius:15px;
    padding:20px;
    transition:0.4s;
    box-shadow:0 10px 30px rgba(0,0,0,0.3);
    position:relative;
    overflow:hidden;
}

/* CARD HOVER EFFECT */
.card:hover{
    transform:translateY(-12px);
    background:rgba(255,255,255,0.18);
    box-shadow:0 15px 40px rgba(0,0,0,0.5);
}

/* ICON */
.icon{
    font-size:30px;
    margin-bottom:10px;
}

/* TITLE */
.card h3{
    color:#ffcc80;
    margin-bottom:10px;
}

/* TEXT */
.card p{
    font-size:14px;
    line-height:1.6;
    color:#eee;
}

/* LIGHT EFFECT */
.card::before{
    content:"";
    position:absolute;
    top:-50%;
    left:-50%;
    width:200%;
    height:200%;
    background:linear-gradient(45deg,transparent,rgba(255,255,255,0.1),transparent);
    transform:rotate(25deg);
    transition:0.5s;
}

.card:hover::before{
    left:100%;
}

/* INFO BOX */
.note{
    margin:20px 40px;
    padding:15px;
    background:rgba(255,152,0,0.2);
    border-left:5px solid #ff9800;
    border-radius:10px;
    backdrop-filter:blur(10px);
}

</style>

</head>

<body>

<!-- BACK -->
<a href="profile.php" class="back">⬅ Back</a>

<!-- HEADER -->
<div class="header">
    <h1>🌍 Sri Lanka Travel Guideline ✈️</h1>
    <p>Plan your journey safely and smartly</p>
</div>

<!-- IMPORTANT NOTE -->
<div class="note">
    ⚠️ Follow these guidelines for a safe, enjoyable and professional travel experience in Sri Lanka.
</div>

<!-- CONTENT -->
<div class="container">

    <div class="card">
        <div class="icon">📄</div>
        <h3>Visa Information</h3>
        <p>Apply for ETA online before arrival. Some countries get visa on arrival.</p>
    </div>

    <div class="card">
        <div class="icon">☀️</div>
        <h3>Best Season</h3>
        <p>South/West: Dec–Mar<br>East: Apr–Sep<br>Hill Country: All year</p>
    </div>

    <div class="card">
        <div class="icon">🧳</div>
        <h3>Packing Tips</h3>
        <p>Light clothes, sunscreen, hat, shoes, swimwear & basic medicine.</p>
    </div>

    <div class="card">
        <div class="icon">🚖</div>
        <h3>Transport</h3>
        <p>Tuk-tuk, taxi, train and bus available. Always confirm price before ride.</p>
    </div>

    <div class="card">
        <div class="icon">🏥</div>
        <h3>Safety</h3>
        <p>Keep documents safe, avoid isolated places at night, follow local rules.</p>
    </div>

    <div class="card">
        <div class="icon">💧</div>
        <h3>Health</h3>
        <p>Drink bottled water and use mosquito repellent in forest areas.</p>
    </div>

    <div class="card">
        <div class="icon">📞</div>
        <h3>Emergency</h3>
        <p>Police: 119<br>Ambulance: 1990<br>Tourist Hotline: 1912</p>
    </div>

    <div class="card">
        <div class="icon">🕌</div>
        <h3>Culture</h3>
        <p>Respect temples, remove shoes, dress modestly in religious places.</p>
    </div>

</div>

</body>
</html>