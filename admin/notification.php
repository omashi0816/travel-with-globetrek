<?php
session_start();
include __DIR__ . '/../includes/db.php';

/* SECURITY */
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit();
}

/* DELETE MESSAGE */
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM messages WHERE id=$id");
    header("Location: notification.php");
    exit();
}

/* MARK AS READ */
if(isset($_GET['read'])){
    $id = intval($_GET['read']);
    mysqli_query($conn, "UPDATE messages SET is_read=1 WHERE id=$id");
    header("Location: notification.php");
    exit();
}

/* GET MESSAGES */
$result = mysqli_query($conn, "SELECT * FROM messages ORDER BY created_at DESC");
$errorMsg = '';
if($result === false){
    $errorMsg = mysqli_error($conn);
}

/* GET UNREAD COUNT */
$unread_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM messages WHERE is_read=0");
$unread_count = 0;
if($unread_result){
    $unread_row = mysqli_fetch_assoc($unread_result);
    $unread_count = $unread_row['count'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Notifications</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

/* BODY */
body{
    margin:0;
    font-family:Segoe UI;
    background:linear-gradient(135deg,#e0eafc,#cfdef3);
}

/* MAIN */
.main{
    margin-left:260px;
    padding:25px;
}

/* HEADER */
.header{
    background:white;
    padding:15px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    margin-bottom:20px;
}

.header h2{
    margin:0;
    color:#0c0c97;
}

/* TABLE CARD */
.card{
    background:white;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
}

/* HEADER */
th{
    background:linear-gradient(90deg,#0c0c97,#1a237e);
    color:white;
    padding:14px;
    text-transform:uppercase;
    font-size:13px;
}

/* ROW */
td{
    text-align:left;
    padding:14px;
    border-bottom:1px solid #eee;
}

/* HOVER */
tr:hover{
    background:#f1f5ff;
}

/* DELETE BUTTON */
.delete{
    background:#ff3d00;
    color:white;
    padding:6px 12px;
    border-radius:6px;
    text-decoration:none;
    font-size:13px;
    transition:0.3s;
    display:inline-block;
    margin:0 3px;
}

.delete:hover{
    background:#d32f2f;
}

.mark-read{
    background:#4caf50;
    color:white;
    padding:6px 12px;
    border-radius:6px;
    text-decoration:none;
    font-size:13px;
    transition:0.3s;
    display:inline-block;
    margin:0 3px;
}

.mark-read:hover{
    background:#388e3c;
}

.action-btn{
    margin: 2px;
}

</style>

</head>

<body>

<div class="main">

<!-- HEADER -->
<div class="header">
<h2>🔔 Notifications (<?php echo $unread_count; ?> Unread)</h2>
<?php if($errorMsg): ?>
<p style="color:red; margin-top:10px;">Error: <?php echo htmlspecialchars($errorMsg); ?></p>
<?php endif; ?>
</div>

<!-- TABLE -->
<div class="card">

<table>

<tr>
<th>ID</th>
<th>From</th>
<th>Email</th>
<th>Subject</th>
<th>Message</th>
<th>Date</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php if($result && mysqli_num_rows($result) > 0): ?>

<?php while($row = mysqli_fetch_assoc($result)){ 
    $is_unread = $row['is_read'] == 0 ? 'unread' : 'read';
    $badge_style = $row['is_read'] == 0 ? 'background: #ff6b6b; color: white;' : 'background: #e9ecef; color: #666;';
?>

<tr style="background: <?php echo $row['is_read'] == 0 ? '#fff9e6' : 'white'; ?>;">

<td><?php echo htmlspecialchars($row['id']); ?></td>
<td><strong><?php echo htmlspecialchars($row['sender_type']); ?></strong></td>
<td><?php echo htmlspecialchars($row['sender_email']); ?></td>
<td><?php echo htmlspecialchars($row['subject']); ?></td>
<td><?php echo substr(htmlspecialchars($row['message']), 0, 50) . (strlen($row['message']) > 50 ? '...' : ''); ?></td>
<td><?php echo date('M d, Y h:i A', strtotime($row['created_at'])); ?></td>

<td>
<span style="padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: bold; <?php echo $badge_style; ?>">
<?php echo $row['is_read'] == 0 ? 'Unread' : 'Read'; ?>
</span>
</td>

<td>
<?php if($row['is_read'] == 0): ?>
<a class="action-btn mark-read" href="notification.php?read=<?php echo $row['id']; ?>" title="Mark as read">
<i class="fas fa-check"></i>
</a>
<?php endif; ?>
<a class="action-btn delete" href="notification.php?delete=<?php echo $row['id']; ?>" 
onclick="return confirm('Delete this message?')" title="Delete">
<i class="fas fa-trash"></i>
</a>
</td>

</tr>

<?php } ?>

<?php else: ?>

<tr>
<td colspan="8" style="text-align:center; padding:40px; color:#666;">
<i class="fas fa-inbox" style="font-size:40px; margin-bottom:10px; display:block; opacity:0.5;"></i>
No notifications found.
</td>
</tr>

<?php endif; ?>

</table>

</div>

</div>

</body>
</html>