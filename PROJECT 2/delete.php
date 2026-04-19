<?php
$conn = new mysqli("localhost", "root", "", "student_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: view.php?deleted=1");
    exit();
} else {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Error</title>
        <style>
            * { box-sizing: border-box; }
            body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
            .container { max-width: 500px; margin: 100px auto; background: #fff; padding: 30px; border-radius: 8px; text-align: center; }
            .error { color: #f44336; padding: 15px; background: #ffebee; border-radius: 4px; margin-bottom: 20px; }
            a { color: #4CAF50; text-decoration: none; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='error'>Error deleting record: " . $conn->error . "</div>
            <a href='view.php'>Go Back</a>
        </div>
    </body>
    </html>";
}

$stmt->close();
$conn->close();
?>
