<?php
session_start();
include __DIR__ . '/../includes/db.php';

/* ADMIN SECURITY CHECK */
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit();
}

$logs = [];
$errorMsg = '';
$result = mysqli_query($conn, "SELECT * FROM logs ORDER BY id DESC LIMIT 100");
if($result){
    while($row = mysqli_fetch_assoc($result)){
        $logs[] = $row;
    }
} else {
    $errorMsg = mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>System Logs</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body{
    margin:0;
    font-family:Segoe UI;
    background:linear-gradient(135deg,#e0eafc,#cfdef3);
}
.main{
    margin-left:260px;
    padding:25px;
}
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
.card{
    background:white;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}
table{
    width:100%;
    border-collapse:collapse;
}
th{
    background:linear-gradient(90deg,#0c0c97,#1a237e);
    color:white;
    padding:14px;
    text-transform:uppercase;
    font-size:13px;
}
td{
    padding:14px;
    border-bottom:1px solid #eee;
    color:#334155;
}
tr:hover{
    background:#f5f8ff;
}
.error{
    background:#fee2e2;
    color:#991b1b;
    padding:14px;
    border-radius:12px;
    margin-bottom:20px;
}
.empty{
    padding:20px;
    text-align:center;
    color:#666;
}
</style>
</head>
<body>
<div class="main">
<div class="header">
<h2>📄 System Logs</h2>
</div>
<?php if($errorMsg): ?>
<div class="error">Database error: <?php echo htmlspecialchars($errorMsg); ?></div>
<?php endif; ?>
<div class="card">
<table>
<tr>
<th>ID</th>
<th>Action</th>
<th>User</th>
<th>Created At</th>
</tr>
<?php if(!empty($logs)): ?>
    <?php foreach($logs as $row): ?>
    <tr>
        <td><?php echo htmlspecialchars($row['id']); ?></td>
        <td><?php echo htmlspecialchars($row['action'] ?? 'N/A'); ?></td>
        <td><?php echo htmlspecialchars($row['user'] ?? 'System'); ?></td>
        <td><?php echo htmlspecialchars($row['created_at'] ?? 'Unknown'); ?></td>
    </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="4" class="empty">No logs found. Create a <code>logs</code> table or enable auditing.</td>
    </tr>
<?php endif; ?>
</table>
</div>
</div>
</body>
</html>
