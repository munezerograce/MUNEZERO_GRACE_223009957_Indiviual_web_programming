<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

require_once 'db.php';

$fullname = trim($_POST['fullname'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$menu = trim($_POST['menu'] ?? '');
$address = trim($_POST['address'] ?? '');
$orderDate = trim($_POST['date'] ?? '');

if ($fullname === '' || $email === '' || $phone === '' || $menu === '' || $address === '' || $orderDate === '') {
    header('Location: index.php?status=error#order');
    exit;
}

$stmt = $conn->prepare('INSERT INTO orders (fullname, email, phone, menu, address, order_date) VALUES (?, ?, ?, ?, ?, ?)');

if (!$stmt) {
    header('Location: index.php?status=error#order');
    exit;
}

$stmt->bind_param('ssssss', $fullname, $email, $phone, $menu, $address, $orderDate);
$success = $stmt->execute();
$stmt->close();
$conn->close();

header('Location: index.php?status=' . ($success ? 'order-success' : 'error') . '#order');
exit;
?>
