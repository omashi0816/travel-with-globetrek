<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$email = $_SESSION['user'];
$msg = "";
$payment_success = false;

/* BOOKING ID */
$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;

/* BOOKING DETAILS */
$booking = null;
$amount = 15000;
$package_name = '';

if($booking_id > 0){
    $booking_result = mysqli_query($conn,
        "SELECT * FROM bookings WHERE id='$booking_id' AND email='$email' LIMIT 1");

    if($booking_result && mysqli_num_rows($booking_result) === 1){
        $booking = mysqli_fetch_assoc($booking_result);
        $package_name = $booking['package'] ?? '';

        if(!empty($package_name)){
            $pkg_name_safe = mysqli_real_escape_string($conn, $package_name);
            $price_result = mysqli_query($conn,
                "SELECT price FROM packages WHERE package_name='$pkg_name_safe' LIMIT 1");
            if($price_result && mysqli_num_rows($price_result) === 1){
                $price_row = mysqli_fetch_assoc($price_result);
                $amount = floatval($price_row['price']);
            }
        }
    } else {
        header('Location: booking.php?error=invalid_booking');
        exit();
    }
} else {
    header('Location: booking.php?error=no_booking');
    exit();
}

/* PAYMENT */
if(isset($_POST['pay']) && $booking){

    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $bank   = mysqli_real_escape_string($conn, $_POST['bank']);
    $phone  = mysqli_real_escape_string($conn, $_POST['phone']);
    $card   = mysqli_real_escape_string($conn, $_POST['card_number']);
    $holder = mysqli_real_escape_string($conn, $_POST['holder']);
    $expiry = mysqli_real_escape_string($conn, $_POST['expiry']);
    $cvv    = mysqli_real_escape_string($conn, $_POST['cvv']);
    $amount = floatval($_POST['amount']);

    if(empty($method) || empty($bank) || empty($phone) || empty($card) || empty($holder) || empty($expiry) || empty($cvv)){
        $msg = "❌ Please complete all payment details.";
    } else {
        $safe_package_name = mysqli_real_escape_string($conn, $package_name);
        $sql = "INSERT INTO payments 
        (email, booking_id, amount, status, package_name, method, payment_date)
        VALUES
        ('$email','$booking_id','$amount','Paid','$safe_package_name','$method',NOW())";

        if(mysqli_query($conn, $sql)){
            mysqli_query($conn,
            "UPDATE bookings SET status='Confirmed' WHERE id='$booking_id'");
            $msg = "✅ Payment Successful! Your booking has been confirmed.";
            $payment_success = true;
        }
        else{
            $msg = "❌ Database Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Gateway - GlobeTrek</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body{
    background: linear-gradient(135deg, #0c0c97 0%, #000051 100%);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
}

.container {
    width: 100%;
    max-width: 500px;
}

.box{
    background: white;
    padding: 35px;
    border-radius: 15px;
    box-shadow: 0 15px 50px rgba(0,0,0,0.5);
}

h2{
    text-align: center;
    color: #0c0c97;
    margin-bottom: 10px;
    font-size: 28px;
}

.subtitle {
    text-align: center;
    color: #666;
    font-size: 14px;
    margin-bottom: 20px;
}

.msg{
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
    text-align: center;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.msg.success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.msg.error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.msg.warning {
    background: #fff3cd;
    color: #856404;
    border: 1px solid #ffeeba;
}

form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-weight: 600;
    color: #333;
    margin-bottom: 6px;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="tel"],
select {
    width: 100%;
    padding: 12px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s;
    background: #f9f9f9;
}

input:focus,
select:focus {
    outline: none;
    border-color: #0c0c97;
    background: white;
    box-shadow: 0 0 0 3px rgba(12, 12, 151, 0.1);
}

button{
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    color: white;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-pay {
    background: linear-gradient(45deg, #0c0c97, #2196f3);
}

.btn-pay:hover {
    background: linear-gradient(45deg, #06065f, #1976d2);
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(12, 12, 151, 0.4);
}

.btn-pay:disabled {
    background: #ccc;
    cursor: not-allowed;
    transform: none;
}

.payment-success-card {
    background: #e8f5e9;
    border: 1px solid #c8e6c9;
    padding: 25px;
    border-radius: 12px;
    text-align: center;
    color: #1b5e20;
}

.payment-success-card h3 {
    margin-bottom: 12px;
    font-size: 22px;
}

.payment-success-card p {
    margin: 10px 0;
}

.payment-success-card .back {
    display: inline-block;
    margin: 10px 8px 0;
    width: auto;
    background: #1b5e20;
    color: #fff;
}

.divider {
    text-align: center;
    margin: 20px 0;
    position: relative;
    color: #999;
    font-size: 12px;
}

.divider:before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: #e0e0e0;
}

.divider span {
    background: white;
    padding: 0 8px;
    position: relative;
}

.back{
    display: block;
    text-align: center;
    margin-top: 20px;
    text-decoration: none;
    background: #e0e0e0;
    padding: 12px;
    border-radius: 8px;
    color: #333;
    font-weight: 600;
    transition: 0.3s;
}

.back:hover {
    background: #d0d0d0;
}

.security-badge {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    margin-top: 20px;
    color: #999;
    font-size: 12px;
}

.security-badge i {
    color: #4caf50;
}

.two-column {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

@media (max-width: 600px) {
    .box {
        padding: 20px;
    }
    
    h2 {
        font-size: 22px;
    }
    
    .two-column {
        grid-template-columns: 1fr;
    }
}
</style>

</head>

<body>

<div class="container">
    <div class="box">

        <h2>💳 Secure Payment</h2>
        <p class="subtitle">GlobeTrek Tours - Booking Payment</p>

        <?php 
        if($msg != "") {
            if(strpos($msg, '✅') !== false) {
                $class = 'success';
            } elseif(strpos($msg, '❌') !== false) {
                $class = 'error';
            } else {
                $class = 'warning';
            }
        ?>
        <div class="msg <?php echo $class; ?>">
            <?php echo $msg; ?>
        </div>
        <?php } ?>

        <?php if(!$payment_success): ?>
        <form method="POST">
            <input type="hidden" name="amount" value="<?php echo htmlspecialchars($amount); ?>">

            <div class="form-group">
                <label>Booking Package</label>
                <input type="text" value="<?php echo htmlspecialchars($package_name ?: 'No booking selected'); ?>" disabled>
            </div>

            <div class="form-group">
                <label>Amount</label>
                <input type="text" value="Rs. <?php echo number_format($amount, 2); ?>" disabled>
            </div>

            <div class="form-group">
                <label>Phone Number *</label>
                <input type="tel" name="phone" placeholder="07XX XXX XXXX or 070XXXXXXX" required value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
            </div>

            <div class="divider"><span>PAYMENT DETAILS</span></div>

            <!-- PAYMENT METHOD -->
            <div class="form-group">
                <label>Payment Method *</label>
                <select name="method" required>
                    <option value="">Select Payment Method</option>
                    <option>Visa Card</option>
                    <option>Master Card</option>
                    <option>Debit / ATM Card</option>
                    <option>Bank Transfer</option>
                </select>
            </div>

            <!-- BANK SELECTION -->
            <div class="form-group">
                <label>Select Bank *</label>
                <select name="bank" required>
                    <option value="">Select Your Bank</option>
                    <option>Bank of Ceylon (BOC)</option>
                    <option>Hatton National Bank (HNB)</option>
                    <option>Sampath Bank</option>
                    <option>National Development Bank (NDB)</option>
                    <option>Commercial Bank</option>
                </select>
            </div>

            <!-- CARD DETAILS -->
            <div class="form-group">
                <label>Card Number *</label>
                <input type="text" name="card_number" placeholder="1234 5678 9012 3456" required>
            </div>

            <div class="form-group">
                <label>Card Holder Name *</label>
                <input type="text" name="holder" placeholder="John Doe" required>
            </div>

            <div class="two-column">
                <div class="form-group">
                    <label>Expiry Date *</label>
                    <input type="text" name="expiry" placeholder="MM/YY" required>
                </div>
                <div class="form-group">
                    <label>CVV *</label>
                    <input type="password" name="cvv" placeholder="123" maxlength="4" required>
                </div>
            </div>

            <!-- PAY BUTTON -->
            <button class="btn-pay" type="submit" name="pay" <?php echo $booking ? '' : 'disabled'; ?>>
                <i class="fas fa-lock"></i> Complete Payment - Rs. <?php echo number_format($amount, 2); ?>
            </button>

        </form>
        <?php else: ?>
        <div class="payment-success-card">
            <h3>🎉 Payment Confirmed</h3>
            <p>Your payment has been saved and your booking is now confirmed.</p>
            <p><strong>Booking ID:</strong> #<?php echo htmlspecialchars($booking_id); ?></p>
            <p><strong>Amount Paid:</strong> Rs. <?php echo number_format($amount, 2); ?></p>
            <a href="customer/payment-history.php" class="back">View Payment History</a>
            <a href="profile.php" class="back" style="margin-top: 10px;">Go to Dashboard</a>
        </div>
        <?php endif; ?>

        <a class="back" href="booking.php">
            <i class="fas fa-arrow-left"></i> Back to Booking
        </a>

        <div class="security-badge">
            <i class="fas fa-shield-alt"></i>
            <span>Secure & Encrypted Payment</span>
        </div>

    </div>
</div>

</body>
</html>
