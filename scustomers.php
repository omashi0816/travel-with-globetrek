<?php
include 'includes/db.php';

$result = mysqli_query($conn,"SELECT * FROM users WHERE role='customer'");
?>

<!DOCTYPE html>
<html>
<head>
<title>Customers</title>

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

/* BADGE */
.badge{
    padding:5px 10px;
    border-radius:20px;
    color:white;
    font-size:12px;
}

.customer{
    background:green;
}

</style>
</head>

<body>

<h2>👥 Registered Customers</h2>

<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Role</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>
<td>#CU<?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['phone']; ?></td>

<td>
<span class="badge customer">
<?php echo $row['role']; ?>
</span>
</td>

</tr>

<?php } ?>

</table>

</body>
</html>