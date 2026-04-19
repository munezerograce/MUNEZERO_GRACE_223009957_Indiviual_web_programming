<?php
$conn = new mysqli("localhost", "root", "", "student_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Auto-fix: Add missing columns if they don't exist
$columns_to_add = [
    "dob" => "DATE AFTER last_name",
    "email" => "VARCHAR(100)",
    "mobile" => "VARCHAR(20)",
    "gender" => "VARCHAR(10)",
    "address" => "TEXT",
    "city" => "VARCHAR(50)",
    "pin_code" => "VARCHAR(20)",
    "state" => "VARCHAR(50)",
    "country" => "VARCHAR(50)",
    "hobbies" => "VARCHAR(255)",
    "course" => "VARCHAR(50)"
];

$result = $conn->query("DESCRIBE students");
$existing_columns = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $existing_columns[] = $row['Field'];
    }
}

foreach ($columns_to_add as $column => $definition) {
    if (!in_array($column, $existing_columns)) {
        $conn->query("ALTER TABLE students ADD COLUMN $column $definition");
    }
}

// Get form data
$first = $conn->real_escape_string($_POST['first_name']);
$last = $conn->real_escape_string($_POST['last_name']);

$day = intval($_POST['day']);
$month = intval($_POST['month']);
$year = intval($_POST['year']);
$dob = sprintf("%04d-%02d-%02d", $year, $month, $day);

$email = $conn->real_escape_string($_POST['email']);
$mobile = $conn->real_escape_string($_POST['mobile']);
$gender = isset($_POST['gender']) ? $conn->real_escape_string($_POST['gender']) : '';
$address = $conn->real_escape_string($_POST['address']);
$city = $conn->real_escape_string($_POST['city']);
$pin = $conn->real_escape_string($_POST['pin']);
$state = $conn->real_escape_string($_POST['state']);
$country = $conn->real_escape_string($_POST['country']);
$hobbies = isset($_POST['hobbies']) ? $conn->real_escape_string(implode(", ", $_POST['hobbies'])) : "";
$course = isset($_POST['course']) ? $conn->real_escape_string($_POST['course']) : '';

$sql = "INSERT INTO students 
(first_name, last_name, dob, email, mobile, gender, address, city, pin_code, state, country, hobbies, course)
VALUES 
('$first', '$last', '$dob', '$email', '$mobile', '$gender', '$address', '$city', '$pin', '$state', '$country', '$hobbies', '$course')";

if ($conn->query($sql) === TRUE) {
    header("Location: view.php?success=1");
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
            <div class='error'>Error: " . $conn->error . "</div>
            <a href='index.php'>Go Back</a>
        </div>
    </body>
    </html>";
}

$conn->close();
?>
