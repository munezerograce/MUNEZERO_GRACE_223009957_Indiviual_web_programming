<?php
$conn = new mysqli("localhost", "root", "", "student_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = intval($_POST['id']);
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

$sql = "UPDATE students SET 
    first_name = '$first',
    last_name = '$last',
    dob = '$dob',
    email = '$email',
    mobile = '$mobile',
    gender = '$gender',
    address = '$address',
    city = '$city',
    pin_code = '$pin',
    state = '$state',
    country = '$country',
    hobbies = '$hobbies',
    course = '$course'
WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: view.php?updated=1");
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
            <a href='view.php'>Go Back</a>
        </div>
    </body>
    </html>";
}

$conn->close();
?>
