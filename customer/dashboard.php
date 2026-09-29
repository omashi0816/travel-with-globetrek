<?php
session_start();
include '../includes/db.php';

if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit();
}

$email = $_SESSION['user'];

/* GET CUSTOMER INFO */
$user_result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
$user_data = mysqli_fetch_assoc($user_result);

/* GET STATS */
$bookings_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM bookings WHERE email='$email'");
$bookings_count = mysqli_fetch_assoc($bookings_result)['count'];

$payments_result = mysqli_query($conn, "SELECT SUM(amount) as total FROM payments WHERE email='$email' AND status='Paid'");
$payments_total = mysqli_fetch_assoc($payments_result)['total'] ?? 0;

/* GET RECENT BOOKINGS */
$recent_bookings = mysqli_query($conn, "SELECT * FROM bookings WHERE email='$email' ORDER BY id DESC LIMIT 3");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Customer Dashboard - GlobeTrek</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    background: #0f172a;
    color: #e2e8f0;
    min-height: 100vh;
}

.navbar {
    background: linear-gradient(135deg, #1e3a8a 0%, #0c0c97 100%);
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

.navbar-brand {
    font-size: 24px;
    font-weight: bold;
    color: white;
}

.navbar-user {
    display: flex;
    align-items: center;
    gap: 15px;
}

.navbar-user p {
    color: #e2e8f0;
}

.logout-btn {
    background: #ff3d00;
    color: white;
    padding: 8px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 13px;
    transition: 0.3s;
}

.logout-btn:hover {
    background: #d32f2f;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 30px 20px;
}

.welcome-section {
    background: linear-gradient(135deg, #1e3a8a 0%, #0c0c97 100%);
    padding: 30px;
    border-radius: 12px;
    margin-bottom: 30px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

.welcome-section h2 {
    font-size: 32px;
    margin-bottom: 10px;
}

.welcome-section p {
    color: #b0c4de;
    font-size: 16px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    text-align: center;
    transition: transform 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-icon {
    font-size: 40px;
    margin-bottom: 15px;
}

.stat-number {
    font-size: 32px;
    font-weight: bold;
    margin-bottom: 10px;
}

.stat-label {
    color: #b0c4de;
    font-size: 14px;
}

.section-title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    color: white;
    display: flex;
    align-items: center;
    gap: 10px;
}

.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.menu-card {
    background: linear-gradient(135deg, #1a365d 0%, #2d3748 100%);
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    text-align: center;
    transition: all 0.3s;
    border-left: 5px solid #667eea;
}

.menu-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    border-left-color: #764ba2;
}

.menu-icon {
    font-size: 50px;
    margin-bottom: 15px;
}

.menu-title {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 10px;
}

.menu-desc {
    color: #b0c4de;
    font-size: 14px;
    margin-bottom: 20px;
}

.menu-btn {
    display: inline-block;
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    padding: 12px 30px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
}

.menu-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.recent-bookings {
    background: linear-gradient(135deg, #1a365d 0%, #2d3748 100%);
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    margin-top: 30px;
}

.booking-item {
    background: rgba(255,255,255,0.05);
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-left: 3px solid #667eea;
}

.booking-info {
    flex: 1;
}

.booking-package {
    font-weight: bold;
    color: white;
    margin-bottom: 5px;
}

.booking-details {
    font-size: 12px;
    color: #b0c4de;
}

.booking-status {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 5px;
    font-size: 12px;
    font-weight: bold;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-paid {
    background: #d4edda;
    color: #155724;
}

.no-bookings {
    text-align: center;
    padding: 40px;
    color: #b0c4de;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="navbar-brand">🌍 GlobeTrek</div>
    <div class="navbar-user">
        <p>Welcome, <?php echo htmlspecialchars($user_data['name'] ?? 'User'); ?>!</p>
        <a href="../logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="container">
    
    <!-- WELCOME SECTION -->
    <div class="welcome-section">
        <h2>Welcome to Your Dashboard</h2>
        <p>Manage your bookings, payments, and profile all in one place</p>
    </div>

    <!-- STATS -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📅</div>
            <div class="stat-number"><?php echo $bookings_count; ?></div>
            <div class="stat-label">Total Bookings</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">💳</div>
            <div class="stat-number">Rs. <?php echo number_format($payments_total, 0); ?></div>
            <div class="stat-label">Amount Paid</div>
        </div>
    </div>

    <!-- MENU -->
    <h3 class="section-title">📋 Quick Actions</h3>
    <div class="menu-grid">
        <div class="menu-card">
            <div class="menu-icon">📅</div>
            <div class="menu-title">Book a Tour</div>
            <div class="menu-desc">Fill booking details and proceed to payment instantly</div>
            <a href="../booking.php" class="menu-btn">Book Now</a>
        </div>
        <div class="menu-card">
            <div class="menu-icon">💳</div>
            <div class="menu-title">Payment History</div>
            <div class="menu-desc">Check your payment transactions</div>
            <a href="payment-history.php" class="menu-btn">View History</a>
        </div>
        <div class="menu-card">
            <div class="menu-icon">👤</div>
            <div class="menu-title">My Profile</div>
            <div class="menu-desc">Update your personal information</div>
            <a href="profile.php" class="menu-btn">Edit Profile</a>
        </div>
    </div>

    <!-- RECENT BOOKINGS -->
    <div class="recent-bookings">
        <h3 class="section-title">🎫 Recent Bookings</h3>
        <?php
        if(mysqli_num_rows($recent_bookings) > 0) {
            while($booking = mysqli_fetch_assoc($recent_bookings)) {
                $status_class = 'status-' . strtolower($booking['status']);
                echo '
                <div class="booking-item">
                    <div class="booking-info">
                        <div class="booking-package">' . htmlspecialchars($booking['package']) . '</div>
                        <div class="booking-details">
                            Travel Date: ' . date('M d, Y', strtotime($booking['travel_date'])) . ' | 
                            ' . $booking['travelers'] . ' travelers
                        </div>
                    </div>
                    <span class="booking-status ' . $status_class . '">' . $booking['status'] . '</span>
                </div>
                ';
            }
        } else {
            echo '<div class="no-bookings">No bookings yet. <a href="../packages.php" style="color: #667eea;">Browse packages</a></div>';
        }
        ?>
    </div>

</div>

</body>
</html>
