<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $id = intval($_POST['id']);
        
        if ($_POST['action'] === 'delete_order') {
            $stmt = $conn->prepare('DELETE FROM orders WHERE id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            header('Location: dashboard.php?deleted=order');
            exit;
        }
        
        if ($_POST['action'] === 'delete_message') {
            $stmt = $conn->prepare('DELETE FROM messages WHERE id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            header('Location: dashboard.php?deleted=message');
            exit;
        }
        
        if ($_POST['action'] === 'update_order') {
            $fullname = trim($_POST['fullname']);
            $menu = trim($_POST['menu']);
            $orderDate = trim($_POST['order_date']);
            $stmt = $conn->prepare('UPDATE orders SET fullname = ?, menu = ?, order_date = ? WHERE id = ?');
            $stmt->bind_param('sssi', $fullname, $menu, $orderDate, $id);
            $stmt->execute();
            header('Location: dashboard.php?updated=order');
            exit;
        }
        
        if ($_POST['action'] === 'update_message') {
            $fullname = trim($_POST['fullname']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $location = trim($_POST['location']);
            $message = trim($_POST['message']);
            $stmt = $conn->prepare('UPDATE messages SET fullname = ?, email = ?, phone = ?, location = ?, message = ? WHERE id = ?');
            $stmt->bind_param('sssssi', $fullname, $email, $phone, $location, $message, $id);
            $stmt->execute();
            header('Location: dashboard.php?updated=message');
            exit;
        }
    }
}

$orders = $conn->query('SELECT * FROM orders ORDER BY id DESC');
$messages = $conn->query('SELECT * FROM messages ORDER BY id DESC');
$editOrder = isset($_GET['edit_order']) ? $conn->query('SELECT * FROM orders WHERE id = ' . intval($_GET['edit_order']))->fetch_assoc() : null;
$editMessage = isset($_GET['edit_message']) ? $conn->query('SELECT * FROM messages WHERE id = ' . intval($_GET['edit_message']))->fetch_assoc() : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        :root {
            --bg: #f5efe4;
            --surface: rgba(255, 251, 245, 0.88);
            --brand: #8b4d2f;
            --brand-strong: #5c2c18;
            --text: #25170f;
            --muted: #705a49;
            --line: rgba(102, 67, 39, 0.14);
            --success: #2e7d32;
            --danger: #c62828;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 28px 20px;
            font-family: Georgia, "Times New Roman", serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(215, 162, 79, 0.28), transparent 34%),
                linear-gradient(180deg, #fbf5eb 0%, var(--bg) 100%);
        }

        .card {
            max-width: 1200px;
            margin: 0 auto;
            padding: 28px;
            border-radius: 28px;
            background: var(--surface);
            border: 1px solid rgba(255, 255, 255, 0.65);
            box-shadow: 0 24px 50px rgba(67, 39, 18, 0.14);
            backdrop-filter: blur(14px);
        }

        h2 { margin: 0; font-size: 2rem; }
        h3 { margin: 0 0 4px; font-size: 1.2rem; }

        .subtext { margin: 8px 0 0; color: var(--muted); }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        .notice {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .notice.success {
            background: rgba(46, 125, 50, 0.15);
            color: var(--success);
            border: 1px solid rgba(46, 125, 50, 0.3);
        }

        .notice.danger {
            background: rgba(198, 40, 40, 0.15);
            color: var(--danger);
            border: 1px solid rgba(198, 40, 40, 0.3);
        }

        .dashboard-grid {
            display: grid;
            gap: 24px;
        }

        .panel {
            padding: 22px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.55);
        }

        .panel-copy { margin: 0 0 14px; color: var(--muted); }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th {
            padding: 10px 12px;
            text-align: left;
            color: var(--brand);
            font-size: 0.82rem;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            background: rgba(139, 77, 47, 0.08);
            border-bottom: 2px solid var(--brand);
        }

        td {
            padding: 12px;
            border-bottom: 1px solid var(--line);
            vertical-align: top;
        }

        tr:hover td { background: rgba(255, 255, 255, 0.5); }

        .actions { white-space: nowrap; }

        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            margin-right: 6px;
            transition: transform 0.15s, box-shadow 0.15s;
        }

        .btn:hover { transform: translateY(-1px); }

        .btn-edit {
            background: #1976d2;
            color: white;
        }

        .btn-delete {
            background: #d32f2f;
            color: white;
        }

        .btn-save {
            background: var(--success);
            color: white;
        }

        .btn-cancel {
            background: #757575;
            color: white;
        }

        .edit-form {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 16px;
            margin-top: 16px;
            border: 2px solid var(--brand);
        }

        .edit-form h4 {
            margin: 0 0 16px;
            color: var(--brand);
        }

        .edit-form input,
        .edit-form select,
        .edit-form textarea {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 12px;
            border: 1px solid var(--line);
            border-radius: 10px;
            font-family: inherit;
            font-size: 0.95rem;
            box-sizing: border-box;
        }

        .edit-form textarea { min-height: 80px; resize: vertical; }

        .home-link {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background: var(--brand);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700;
        }

        .home-link:hover { background: var(--brand-strong); }

        @media (max-width: 768px) {
            table { display: block; overflow-x: auto; }
            .card { padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="topbar">
            <div>
                <h2>Dashboard</h2>
                <p class="subtext">Manage all guest orders and contact messages.</p>
            </div>
            <a href="index.php" class="home-link">Back to Home</a>
        </div>

        <?php if (isset($_GET['deleted'])): ?>
            <div class="notice success">Record deleted successfully!</div>
        <?php endif; ?>
        <?php if (isset($_GET['updated'])): ?>
            <div class="notice success">Record updated successfully!</div>
        <?php endif; ?>

        <div class="dashboard-grid">
            <div class="panel">
                <h3>Food Orders</h3>
                <p class="panel-copy">View, edit or delete guest food orders.</p>

                <?php if ($editOrder): ?>
                <div class="edit-form">
                    <h4>Edit Order #<?= htmlspecialchars($editOrder['id']) ?></h4>
                    <form method="POST">
                        <input type="hidden" name="action" value="update_order">
                        <input type="hidden" name="id" value="<?= $editOrder['id'] ?>">
                        <input type="text" name="fullname" value="<?= htmlspecialchars($editOrder['fullname']) ?>" required>
                        <select name="menu" required>
                            <option value="Fish" <?= $editOrder['menu'] === 'Fish' ? 'selected' : '' ?>>Fish</option>
                            <option value="Drink" <?= $editOrder['menu'] === 'Drink' ? 'selected' : '' ?>>Drink</option>
                            <option value="Fresh Juice" <?= $editOrder['menu'] === 'Fresh Juice' ? 'selected' : '' ?>>Fresh Juice</option>
                        </select>
                        <input type="date" name="order_date" value="<?= htmlspecialchars($editOrder['order_date']) ?>" required>
                        <button type="submit" class="btn btn-save">Save Changes</button>
                        <a href="dashboard.php" class="btn btn-cancel">Cancel</a>
                    </form>
                </div>
                <?php endif; ?>

                <table>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Menu</th>
                        <th>Address</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                    <?php if ($orders && $orders->num_rows > 0): ?>
                        <?php while ($row = $orders->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['fullname']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['phone']) ?></td>
                                <td><?= htmlspecialchars($row['menu']) ?></td>
                                <td><?= htmlspecialchars($row['address']) ?></td>
                                <td><?= htmlspecialchars($row['order_date']) ?></td>
                                <td class="actions">
                                    <a href="?edit_order=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                                    <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this order?');">
                                        <input type="hidden" name="action" value="delete_order">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <button type="submit" class="btn btn-delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="8">No orders found.</td></tr>
                    <?php endif; ?>
                </table>
            </div>

            <div class="panel">
                <h3>Contact Messages</h3>
                <p class="panel-copy">View, edit or delete contact messages from guests.</p>

                <?php if ($editMessage): ?>
                <div class="edit-form">
                    <h4>Edit Message #<?= htmlspecialchars($editMessage['id']) ?></h4>
                    <form method="POST">
                        <input type="hidden" name="action" value="update_message">
                        <input type="hidden" name="id" value="<?= $editMessage['id'] ?>">
                        <input type="text" name="fullname" value="<?= htmlspecialchars($editMessage['fullname']) ?>" required>
                        <input type="email" name="email" value="<?= htmlspecialchars($editMessage['email']) ?>" required>
                        <input type="text" name="phone" value="<?= htmlspecialchars($editMessage['phone']) ?>" required>
                        <input type="text" name="location" value="<?= htmlspecialchars($editMessage['location']) ?>" required>
                        <textarea name="message" required><?= htmlspecialchars($editMessage['message']) ?></textarea>
                        <button type="submit" class="btn btn-save">Save Changes</button>
                        <a href="dashboard.php" class="btn btn-cancel">Cancel</a>
                    </form>
                </div>
                <?php endif; ?>

                <table>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Location</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                    <?php if ($messages && $messages->num_rows > 0): ?>
                        <?php while ($row = $messages->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['fullname']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['phone']) ?></td>
                                <td><?= htmlspecialchars($row['location']) ?></td>
                                <td><?= htmlspecialchars($row['message']) ?></td>
                                <td class="actions">
                                    <a href="?edit_message=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                                    <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this message?');">
                                        <input type="hidden" name="action" value="delete_message">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <button type="submit" class="btn btn-delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="7">No contact messages found.</td></tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>
