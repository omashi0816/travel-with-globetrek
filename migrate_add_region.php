<?php
include 'includes/db.php';

// Add region column if it doesn't exist
$check = mysqli_query($conn, "SHOW COLUMNS FROM packages LIKE 'region'");

if(mysqli_num_rows($check) == 0) {
    $alter = mysqli_query($conn, "ALTER TABLE packages ADD COLUMN region VARCHAR(50) DEFAULT 'Northern'");

    if($alter) {
        echo "✅ Region column added successfully!";
    } else {
        echo "❌ Error adding region column: " . mysqli_error($conn);
    }
} else {
    echo "✅ Region column already exists!";
}

mysqli_close($conn);
?>
