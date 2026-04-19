<?php
session_start();
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['user'] ?? '');
    $password = trim($_POST['pass'] ?? '');

    $stmt = $conn->prepare('SELECT username FROM users WHERE username = ? AND password = ?');

    if ($stmt) {
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['user'] = $username;
            $stmt->close();
            $conn->close();
            header('Location: dashboard.php');
            exit;
        }

        $stmt->close();
    }

    $error = 'Invalid username or password.';
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        :root {
            --bg: #f5efe4;
            --surface: rgba(255, 251, 245, 0.86);
            --brand: #8b4d2f;
            --brand-strong: #5c2c18;
            --text: #25170f;
            --muted: #705a49;
            --line: rgba(102, 67, 39, 0.14);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
            font-family: Georgia, "Times New Roman", serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(215, 162, 79, 0.3), transparent 35%),
                linear-gradient(180deg, #fbf5eb 0%, var(--bg) 100%);
        }

        .card {
            width: min(100%, 460px);
            padding: 30px;
            border-radius: 26px;
            background: var(--surface);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.65);
            box-shadow: 0 24px 50px rgba(67, 39, 18, 0.14);
        }

        h2 {
            margin: 0 0 8px;
            font-size: 2rem;
        }

        .lead {
            margin: 0 0 20px;
            color: var(--muted);
            line-height: 1.7;
        }

        form { display: grid; gap: 12px; }

        input, button {
            padding: 14px 16px;
            border-radius: 14px;
            font: inherit;
        }

        input {
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.92);
            outline: none;
        }

        input:focus {
            border-color: rgba(139, 77, 47, 0.6);
            box-shadow: 0 0 0 4px rgba(215, 162, 79, 0.22);
        }

        button {
            border: 0;
            color: #fff8f0;
            cursor: pointer;
            font-weight: 700;
            background: linear-gradient(135deg, var(--brand), var(--brand-strong));
            box-shadow: 0 14px 28px rgba(92, 44, 24, 0.24);
        }

        .error {
            color: #8e1f1f;
            margin-bottom: 12px;
            padding: 12px 14px;
            border-radius: 14px;
            background: rgba(255, 233, 233, 0.9);
        }

        a {
            color: var(--brand);
            text-decoration: none;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Admin Login</h2>
        <p class="lead">Manage guest orders from a polished control area built for quick access.</p>
        <?php if ($error !== ''): ?>
            <p class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        <form method="post">
            <input name="user" placeholder="Username" required>
            <input type="password" name="pass" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <p><a href="index.php">Back to home</a></p>
    </div>
</body>
</html>
