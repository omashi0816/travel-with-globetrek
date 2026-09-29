<?php
session_start();
include '../includes/db.php';

if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit();
}

$email = $_SESSION['user'];

/* GET CUSTOMER PAYMENTS */
$result = mysqli_query($conn, 
"SELECT * FROM payments WHERE email='$email' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment History - GlobeTrek</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    min-height: 100vh;
    padding: 20px;
}

.container {
    max-width: 1000px;
    margin: 0 auto;
}

.header {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.header h2 {
    color: #333;
    margin-bottom: 5px;
}

.header p {
    color: #666;
}

.stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.stat-card {
    background: linear-gradient(135deg, #f093fb, #f5576c);
    color: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
}

.stat-label {
    font-size: 12px;
    opacity: 0.9;
    text-transform: uppercase;
}

.stat-value {
    font-size: 28px;
    font-weight: bold;
    margin-top: 10px;
}

.payments-table {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead {
    background: linear-gradient(135deg, #f093fb, #f5576c);
    color: white;
}

th {
    padding: 18px;
    text-align: left;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
}

td {
    padding: 15px 18px;
    border-bottom: 1px solid #eee;
}

tbody tr:hover {
    background: #f9f9f9;
}

.payment-id {
    color: #999;
    font-size: 12px;
}

.payment-method {
    display: inline-block;
    padding: 4px 10px;
    background: #f0f0f0;
    border-radius: 5px;
    font-size: 12px;
    font-weight: 600;
    color: #333;
}

.status-paid {
    display: inline-block;
    padding: 6px 12px;
    background: #d4edda;
    color: #155724;
    border-radius: 5px;
    font-size: 12px;
    font-weight: 600;
}

.status-pending {
    display: inline-block;
    padding: 6px 12px;
    background: #fff3cd;
    color: #856404;
    border-radius: 5px;
    font-size: 12px;
    font-weight: 600;
}

.amount {
    color: #f5576c;
    font-weight: bold;
    font-size: 16px;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: white;
}

.empty-state-icon {
    font-size: 60px;
    margin-bottom: 20px;
}

.empty-state h3 {
    font-size: 24px;
    margin-bottom: 10px;
}

.back-btn {
    display: inline-block;
    margin-top: 30px;
    padding: 12px 30px;
    background: white;
    color: #f5576c;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: 0.3s;
}

.back-btn:hover {
    background: #f0f0f0;
}

.table-scroll {
    overflow-x: auto;
}
</style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>💳 Payment History</h2>
        <p>View all your tour payment transactions</p>
        
        <?php
        if (mysqli_num_rows($result) > 0) {
            /* Reset result pointer */
            mysqli_data_seek($result, 0);
            
            $total_amount = 0;
            $paid_count = 0;
            
            while ($row = mysqli_fetch_assoc($result)) {
                $total_amount += $row['amount'];
                if ($row['status'] === 'Paid') {
                    $paid_count++;
                }
            }
            
            /* Reset result pointer again */
            mysqli_data_seek($result, 0);
            
            echo '
            <div class="stats">
                <div class="stat-card">
                    <div class="stat-label">Total Paid</div>
                    <div class="stat-value">Rs. ' . number_format($total_amount, 2) . '</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Successful Payments</div>
                    <div class="stat-value">' . $paid_count . '</div>
                </div>
            </div>
            ';
        }
        ?>
    </div>

    <?php
    if (mysqli_num_rows($result) > 0) {
        echo '
        <div class="payments-table">
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Payment ID</th>
                            <th>Booking ID</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
        ';
        
        while ($row = mysqli_fetch_assoc($result)) {
            $status_class = ($row['status'] === 'Paid') ? 'status-paid' : 'status-pending';
            
            echo '
                        <tr>
                            <td>
                                <div class="payment-id">#' . $row['id'] . '</div>
                            </td>
                            <td>#' . $row['booking_id'] . '</td>
                            <td><span class="amount">Rs. ' . number_format($row['amount'], 2) . '</span></td>
                            <td><span class="payment-method">' . ucfirst($row['method']) . '</span></td>
                            <td><span class="' . $status_class . '">' . $row['status'] . '</span></td>
                            <td>' . date('M d, Y h:i A', strtotime($row['payment_date'])) . '</td>
                        </tr>
            ';
        }
        
        echo '
                    </tbody>
                </table>
            </div>
        </div>
        ';
    } else {
        echo '
        <div class="empty-state">
            <div class="empty-state-icon">🎫</div>
            <h3>No payments yet</h3>
            <p>You haven\'t made any payments. Book a tour to get started!</p>
        </div>
        ';
    }
    ?>

    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
</div>

</body>
</html>
