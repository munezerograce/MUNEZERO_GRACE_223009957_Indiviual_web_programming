<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        h2 { text-align: center; color: #333; }
        .container {
            max-width: 1000px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #4CAF50; color: white; }
        tr:hover { background: #f5f5f5; }
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            text-decoration: none;
            display: inline-block;
            margin: 2px;
        }
        .btn-edit { background: #2196F3; color: white; }
        .btn-edit:hover { background: #0b7dda; }
        .btn-delete { background: #f44336; color: white; }
        .btn-delete:hover { background: #da190b; }
        .success {
            background: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 4px;
            text-align: center;
            margin-bottom: 20px;
        }
        .nav-link { text-align: center; margin-top: 20px; }
        .nav-link a {
            display: inline-block;
            padding: 12px 30px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .nav-link a:hover { background: #45a049; }
        .nav-link-secondary { text-align: center; margin-top: 10px; }
        .nav-link-secondary a { color: #4CAF50; text-decoration: none; font-size: 14px; }
        .empty { text-align: center; color: #999; padding: 40px; }
        .actions { white-space: nowrap; }
    </style>
</head>
<body>

<div class="container">
    <h2>STUDENT LIST</h2>

    <?php
    $conn = new mysqli("localhost", "root", "", "student_db");
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['success'])) {
        echo '<div class="success">Student registered successfully!</div>';
    } elseif (isset($_GET['updated'])) {
        echo '<div class="success">Student updated successfully!</div>';
    } elseif (isset($_GET['deleted'])) {
        echo '<div class="success">Student deleted successfully!</div>';
    }
    ?>

    <table>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>DOB</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Gender</th>
            <th>Course</th>
            <th>Actions</th>
        </tr>

        <?php 
        $result = $conn->query("SELECT * FROM students ORDER BY id DESC");
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) { 
        ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['first_name']) ?></td>
            <td><?= htmlspecialchars($row['last_name']) ?></td>
            <td><?= htmlspecialchars($row['dob']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['mobile']) ?></td>
            <td><?= htmlspecialchars($row['gender']) ?></td>
            <td><?= htmlspecialchars($row['course']) ?></td>
            <td class="actions">
                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
            </td>
        </tr>
        <?php 
            }
        } else {
            echo '<tr><td colspan="9" class="empty">No students found</td></tr>';
        }
        ?>

    </table>

    <div class="nav-link">
        <a href="index.php">Add New Student</a>
    </div>
</div>

</body>
</html>
