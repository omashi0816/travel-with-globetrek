<?php
include 'includes/db.php';

/* ADD PACKAGE */
if(isset($_POST['add_package']))
{
    $package_name = mysqli_real_escape_string($conn, $_POST['package_name']);
    $duration     = mysqli_real_escape_string($conn, $_POST['duration']);
    $price        = mysqli_real_escape_string($conn, $_POST['price']);
    $region       = mysqli_real_escape_string($conn, $_POST['region']);

    $image = $_FILES['image']['name'] ?? '';
    $tmp   = $_FILES['image']['tmp_name'] ?? '';

    if($image != ""){
        move_uploaded_file($tmp, "uploads/" . $image);
    }

    mysqli_query($conn,
    "INSERT INTO packages(package_name, duration, price, image, region)
     VALUES('$package_name','$duration','$price','$image','$region')");
}

/* DELETE PACKAGE */
if(isset($_GET['delete']))
{
    $id = (int) $_GET['delete'];

    mysqli_query($conn,
    "DELETE FROM packages WHERE id=$id");
}

/* UPDATE PACKAGE */
if(isset($_POST['update_package']))
{
    $id = (int) $_POST['id'];

    $package_name = mysqli_real_escape_string($conn, $_POST['package_name']);
    $duration     = mysqli_real_escape_string($conn, $_POST['duration']);
    $price        = mysqli_real_escape_string($conn, $_POST['price']);
    $region       = mysqli_real_escape_string($conn, $_POST['region']);

    $image = $_FILES['image']['name'] ?? '';

    if($image != "")
    {
        $tmp = $_FILES['image']['tmp_name'];

        move_uploaded_file($tmp, "uploads/" . $image);

        mysqli_query($conn,
        "UPDATE packages SET
        package_name='$package_name',
        duration='$duration',
        price='$price',
        image='$image',
        region='$region'
        WHERE id=$id");
    }
    else
    {
        mysqli_query($conn,
        "UPDATE packages SET
        package_name='$package_name',
        duration='$duration',
        price='$price',
        region='$region'
        WHERE id=$id");
    }
}

/* EDIT DATA */
$edit = false;
$edit_row = null;

if(isset($_GET['edit']))
{
    $edit = true;
    $id = (int) $_GET['edit'];

    $res = mysqli_query($conn,
    "SELECT * FROM packages WHERE id=$id");

    $edit_row = mysqli_fetch_assoc($res);
}

/* SHOW PACKAGES */
$result = mysqli_query($conn,"SELECT * FROM packages");
?>

<!DOCTYPE html>
<html>
<head>
<title>Staff Package Management</title>

<style>

body{
    margin:0;
    padding:20px;
    font-family:Segoe UI;
    background:#f4f6f9;
}

h2{
    text-align:center;
    color:#0c0c97;
    margin-bottom:20px;
}

/* FORM */
.form-box{
    width:450px;
    background:white;
    margin:auto;
    padding:25px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
}

.form-box input{
    width:100%;
    padding:12px;
    margin-top:12px;
    border:1px solid #ccc;
    border-radius:8px;
}

.form-box select{
    width:100%;
    padding:12px;
    margin-top:12px;
    border:1px solid #ccc;
    border-radius:8px;
}

.form-box button{
    width:100%;
    padding:12px;
    margin-top:15px;
    border:none;
    border-radius:8px;
    color:white;
    font-size:16px;
    cursor:pointer;
}

.add-btn{
    background:#00c853;
}

.update-btn{
    background:#2196f3;
}

/* TABLE */
table{
    width:100%;
    margin-top:40px;
    border-collapse:collapse;
    background:white;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

th{
    background:#0c0c97;
    color:white;
    padding:14px;
}

td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

tr:hover{
    background:#f5f5f5;
}

/* IMAGE */
img{
    width:100px;
    height:70px;
    object-fit:cover;
    border-radius:8px;
}

/* ACTION BUTTONS */
.edit-link{
    background:#2196f3;
    color:white;
    padding:7px 12px;
    border-radius:6px;
    text-decoration:none;
}

.delete-link{
    background:#f44336;
    color:white;
    padding:7px 12px;
    border-radius:6px;
    text-decoration:none;
}

</style>

</head>

<body>

<h2>🌍 Staff Package Management</h2>

<!-- FORM -->

<div class="form-box">

<form method="POST" enctype="multipart/form-data">

<input type="hidden"
name="id"
value="<?php if($edit) echo $edit_row['id']; ?>">

<input type="text"
name="package_name"
placeholder="Package Name"
value="<?php if($edit) echo $edit_row['package_name']; ?>"
required>

<input type="text"
name="duration"
placeholder="Duration"
value="<?php if($edit) echo $edit_row['duration']; ?>"
required>

<input type="number"
name="price"
placeholder="Price"
value="<?php if($edit) echo $edit_row['price']; ?>"
required>

<select name="region" required>
<option value="">Select Region</option>
<option value="Northern" <?php if($edit && $edit_row['region']=='Northern') echo 'selected'; ?>>Northern</option>
<option value="Southern" <?php if($edit && $edit_row['region']=='Southern') echo 'selected'; ?>>Southern</option>
<option value="Western" <?php if($edit && $edit_row['region']=='Western') echo 'selected'; ?>>Western</option>
<option value="Eastern" <?php if($edit && $edit_row['region']=='Eastern') echo 'selected'; ?>>Eastern</option>
<option value="Honeymoon" <?php if($edit && $edit_row['region']=='Honeymoon') echo 'selected'; ?>>Honeymoon</option>
</select>

<input type="file" name="image">

<?php if($edit){ ?>

<button type="submit"
name="update_package"
class="update-btn">

✏ Update Package

</button>

<?php } else { ?>

<button type="submit"
name="add_package"
class="add-btn">

➕ Add Package

</button>

<?php } ?>

</form>

</div>

<!-- PACKAGE TABLE -->

<table>

<tr>
<th>ID</th>
<th>Package Name</th>
<th>Region</th>
<th>Duration</th>
<th>Price</th>
<th>Image</th>
<th>Actions</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>

<td>
<?php echo $row['id']; ?>
</td>

<td>
<?php echo $row['package_name']; ?>
</td>

<td>
<?php echo $row['region']; ?>
</td>

<td>
<?php echo $row['duration']; ?>
</td>

<td>
Rs. <?php echo $row['price']; ?>
</td>

<td>

<img src="uploads/<?php echo $row['image']; ?>">

</td>

<td>

<a class="edit-link"
href="?edit=<?php echo $row['id']; ?>">
Edit
</a>

<a class="delete-link"
href="?delete=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this package?')">

Delete

</a>

</td>

</tr>

<?php } ?>

</table>

</body>
</html>