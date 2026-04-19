<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

require_once 'db.php';

$fullname = trim($_POST['fullname'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$location = trim($_POST['location'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($fullname === '' || $email === '' || $phone === '' || $location === '' || $message === '') {
    header('Location: index.php?status=error#contact');
    exit;
}

$stmt = $conn->prepare('INSERT INTO messages (fullname, email, phone, location, message) VALUES (?, ?, ?, ?, ?)');

if (!$stmt) {
    header('Location: index.php?status=error#contact');
    exit;
}

$stmt->bind_param('sssss', $fullname, $email, $phone, $location, $message);
$success = $stmt->execute();
$stmt->close();
$conn->close();

header('Location: index.php?status=' . ($success ? 'contact-success' : 'error') . '#contact');
exit;
?>
