<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$email = $_SESSION['user'];
$error_msg = '';

if(isset($_GET['error'])){
    if($_GET['error'] === 'invalid_booking'){
        $error_msg = '⚠ Invalid booking selected. Please start a new booking.';
    } elseif($_GET['error'] === 'no_booking'){
        $error_msg = '⚠ No booking selected. Please start a booking first.';
    }
}

/* SUBMIT BOOKING */
$success = "";
$package = isset($_GET['package']) ? mysqli_real_escape_string($conn, $_GET['package']) : '';

if(isset($_POST['submit_booking'])){
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $email_u = $email; // Always use the logged-in user email
    $date    = mysqli_real_escape_string($conn, $_POST['date']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $people  = intval($_POST['people']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $package = mysqli_real_escape_string($conn, $_POST['package']);

    if(empty($package)){
        $success = "⚠ Please select a package first.";
    } elseif(empty($name) || empty($date) || empty($country) || $people < 1 || empty($contact)){
        $success = "❌ Please fill in all booking details.";
    } else {
        $columns = "customer_name, email, travel_date, travelers, package, status";
        $values = "'$name','$email_u','$date','$people','$package','Pending'";

        $hasCountry = mysqli_query($conn, "SHOW COLUMNS FROM bookings LIKE 'country'");
        if($hasCountry && mysqli_num_rows($hasCountry) === 1){
            $columns .= ", country";
            $values .= ", '$country'";
        }

        $hasContact = mysqli_query($conn, "SHOW COLUMNS FROM bookings LIKE 'contact'");
        if($hasContact && mysqli_num_rows($hasContact) === 1){
            $columns .= ", contact";
            $values .= ", '$contact'";
        }

        if(mysqli_query($conn,
        "INSERT INTO bookings($columns) VALUES($values)")){
            $new_booking_id = mysqli_insert_id($conn);
            header("Location: payment.php?booking_id=$new_booking_id");
            exit();
        } else {
            $success = "❌ Database Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Booking Form</title>

<style>

/* BACKGROUND */
body{
    margin:0;
    font-family:'Segoe UI', sans-serif;

    background:
    linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.6)),
    url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e')
    center/cover;
}

/* BOX */
.box{
    width:450px;
    margin:50px auto;
    background:rgba(255,255,255,0.95);
    padding:25px;
    border-radius:15px;
}

/* TITLE */
h2{
    text-align:center;
    color:#0c0c97;
}

/* INPUT */
input,select{
    width:100%;
    padding:10px;
    margin-top:10px;
    border-radius:8px;
    border:1px solid #ccc;
}

/* BUTTON */
button{
    width:100%;
    padding:12px;
    margin-top:15px;
    border:none;
    border-radius:8px;
    color:white;
    cursor:pointer;
    font-size:15px;
}

.submit-btn{
    background:linear-gradient(45deg,#0c0c97,#2196f3);
}

.submit-btn:hover{
    background:#06065f;
}

.payment-btn{
    background:linear-gradient(45deg,#ff9800,#ff5722);
}

.payment-btn:hover{
    background:#e65100;
}

/* BACK */
.back{
    display:block;
    text-align:center;
    margin-top:10px;
    padding:10px;
    background:#ddd;
    text-decoration:none;
    border-radius:8px;
    color:black;
}

/* SUCCESS MESSAGE */
.success{
    background:#d4edda;
    color:#155724;
    padding:10px;
    text-align:center;
    border-radius:8px;
    margin-bottom:10px;
}

.error{
    background:#fff3cd;
    color:#856404;
    padding:10px;
    text-align:center;
    border-radius:8px;
    margin-bottom:10px;
}

</style>

</head>

<body>

<div class="box">

<h2>🌍 Travel Booking Form</h2>

<!-- ERROR MESSAGE -->
<?php if($error_msg != ""){ ?>
    <div class="error"><?php echo htmlspecialchars($error_msg); ?></div>
<?php } ?>

<!-- SUCCESS MESSAGE -->
<?php if($success!=""){ ?>
    <div class="success"><?php echo $success; ?></div>
<?php } ?>

<form method="POST">

<div class="form-group">
    <label>Package</label>
    <input type="text" value="<?php echo htmlspecialchars($package ?: 'No package selected'); ?>" disabled>
</div>

<div class="form-group">
    <label>Full Name</label>
    <input type="text" name="name" placeholder="Full Name" required>
</div>

<div class="form-group">
    <label>Email Address</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
</div>

<div class="form-group">
    <label>Travel Date</label>
    <input type="date" name="date" required>
</div>

<div class="form-group">
    <label>Country</label>
    <input type="text" name="country" placeholder="Your Country" required>
</div>

<div class="form-group">
    <label>Number of People</label>
    <input type="number" name="people" placeholder="Number of People" min="1" value="1" required>
</div>

<div class="form-group">
    <label>Contact Number</label>
    <input type="text" name="contact" placeholder="Contact Number" required>
</div>

<?php if(empty($package)): ?>
<div class="form-group">
    <label>Select Package</label>
    <select name="package" required>
        <option value="">Select Package</option>
        <option>Colombo Tour</option>
        <option>Galle Tour</option>
        <option>Yala Safari</option>
        <option>Sigiriya Tour</option>
    </select>
</div>
<?php else: ?>
<input type="hidden" name="package" value="<?php echo htmlspecialchars($package); ?>">
<?php endif; ?>

<!-- SUBMIT -->
<button type="submit" name="submit_booking" class="submit-btn">
    📌 Submit Booking
</button>

</form>

<!-- PAYMENT BUTTON -->
<a href="customer/dashboard.php" style="text-decoration:none;">
    <button class="payment-btn">💳 Go to Dashboard</button>
</a>

<!-- BACK BUTTON -->
<a href="packages.php" class="back">⬅ Back</a>

</div>

</body>
</html>