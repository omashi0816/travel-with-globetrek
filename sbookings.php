<?php
include 'includes/db.php';

$result = mysqli_query($conn,"SELECT * FROM bookings ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Staff Dashboard</title>

<style>
body{
    font-family: Arial;
    background:#f4f6f9;
    margin:0;
    padding:20px;
}

h2{
    text-align:center;
    color:#0c0c97;
    margin-bottom:20px;
}

/* TABLE STYLE */
table{
    width:100%;
    border-collapse:collapse;
    background:white;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

th{
    background:#0c0c97;
    color:white;
    padding:12px;
    text-align:center;
}

td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

tr:hover{
    background:#f1f1f1;
}

/* STATUS STYLE */
.status{
    padding:5px 10px;
    border-radius:20px;
    color:white;
    font-size:12px;
}

.pending{
    background:orange;
}

.confirmed{
    background:green;
}

.cancelled{
    background:red;
}

</style>
</head>

<body>

<h2>📋 All Bookings</h2>

<table>

<tr>
<th>ID</th>
<th>Customer</th>
<th>Date</th>
<th>Travelers</th>
<th>Package</th>
<th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['customer_name']; ?></td>
<td><?php echo $row['travel_date']; ?></td>
<td><?php echo $row['travelers']; ?></td>
<td><?php echo $row['package']; ?></td>

<td>
<span class="status <?php echo strtolower($row['status']); ?>">
<?php echo $row['status']; ?>
</span>
</td>

</tr>

<?php } ?>

</table>

</body>
</html>