<?php
session_start();
include __DIR__ . '/../includes/db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header('Location: ../login.php');
    exit();
}

$message = '';

if(isset($_POST['submit_package'])){
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $description = trim($_POST['description']);
    $imageName = '';

    if(!empty($_FILES['image']['name'])){
        $imageName = basename($_FILES['image']['name']);
        $targetDir = __DIR__ . '/../uploads/';
        if(!is_dir($targetDir)){
            mkdir($targetDir, 0755, true);
        }
        $targetFile = $targetDir . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO packages (name, price, description, image) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'sdss', $name, $price, $description, $imageName);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $message = 'Package added successfully.';
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Package - Admin</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
        body{background:#f4f6fb;color:#111;}
        .container{width:100%;max-width:600px;margin:40px auto;padding:24px;background:#fff;border-radius:16px;box-shadow:0 20px 40px rgba(0,0,0,0.08);}
        h1{margin-bottom:18px;color:#0c0c97;}
        label{display:block;margin-top:14px;font-weight:600;color:#334155;}
        input,textarea{width:100%;padding:12px;margin-top:8px;border:1px solid #cbd5e1;border-radius:10px;font-size:15px;}
        textarea{min-height:140px;resize:vertical;}
        .actions{margin-top:20px;display:flex;gap:12px;align-items:center;}
        button{background:#0c0c97;color:#fff;border:none;padding:12px 18px;border-radius:10px;cursor:pointer;font-size:15px;}
        .back{color:#0c0c97;text-decoration:none;font-weight:600;}
        .message{margin-top:14px;color:#15803d;}
    </style>
</head>
<body>
    <div class="container">
        <h1>Add New Package</h1>

        <?php if($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <label for="name">Package Name</label>
            <input type="text" id="name" name="name" required>

            <label for="price">Price</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" required></textarea>

            <label for="image">Image</label>
            <input type="file" id="image" name="image" accept="image/*">

            <div class="actions">
                <button type="submit" name="submit_package">Save Package</button>
                <a class="back" href="packages.php">Back to Packages</a>
            </div>
        </form>
    </div>
</body>
</html>
