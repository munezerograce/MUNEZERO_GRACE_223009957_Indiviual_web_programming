<?php
$conn = new mysqli("localhost", "root", "", "student_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM students WHERE id = $id");

if ($result->num_rows === 0) {
    header("Location: view.php");
    exit();
}

$row = $result->fetch_assoc();

$dob = $row['dob'];
$dateParts = explode('-', $dob);
$year = isset($dateParts[0]) ? $dateParts[0] : 2000;
$month = isset($dateParts[1]) ? intval($dateParts[1]) : 1;
$day = isset($dateParts[2]) ? intval($dateParts[2]) : 1;

$hobbies = !empty($row['hobbies']) ? explode(", ", $row['hobbies']) : [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        h2 { text-align: center; color: #333; }
        .container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 10px; }
        label { font-weight: bold; color: #555; }
        input[type="text"], input[type="email"], select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #4CAF50; }
        .small { width: 32%; margin-right: 2%; }
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin: 5px;
        }
        .btn-update { background: #4CAF50; color: white; }
        .btn-update:hover { background: #45a049; }
        .btn-cancel { background: #9e9e9e; color: white; text-decoration: none; display: inline-block; }
        .btn-cancel:hover { background: #7d7d7d; }
        .btn-group { text-align: center; margin-top: 20px; }
        .radio-group, .checkbox-group { display: flex; gap: 15px; flex-wrap: wrap; }
        .radio-group label, .checkbox-group label { font-weight: normal; }
        .nav-link { text-align: center; margin-top: 20px; }
        .nav-link a { color: #4CAF50; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
    <h2>EDIT STUDENT</h2>

    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
        
        <table>
            <tr>
                <td><label>FIRST NAME</label></td>
                <td><input type="text" name="first_name" value="<?= htmlspecialchars($row['first_name']) ?>" required></td>
            </tr>
            <tr>
                <td><label>LAST NAME</label></td>
                <td><input type="text" name="last_name" value="<?= htmlspecialchars($row['last_name']) ?>" required></td>
            </tr>
            <tr>
                <td><label>DATE OF BIRTH</label></td>
                <td>
                    <select name="day" class="small" required>
                        <?php for($i=1; $i<=31; $i++): ?>
                            <option value="<?= $i ?>" <?= ($i == $day) ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                    <select name="month" class="small" required>
                        <?php $months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"]; ?>
                        <?php foreach($months as $k => $m): ?>
                            <option value="<?= $k+1 ?>" <?= (($k+1) == $month) ? 'selected' : '' ?>><?= $m ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="year" class="small" required>
                        <?php for($i=1990; $i<=2010; $i++): ?>
                            <option value="<?= $i ?>" <?= ($i == $year) ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label>EMAIL ID</label></td>
                <td><input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>"></td>
            </tr>
            <tr>
                <td><label>MOBILE NUMBER</label></td>
                <td><input type="text" name="mobile" value="<?= htmlspecialchars($row['mobile']) ?>"></td>
            </tr>
            <tr>
                <td><label>GENDER</label></td>
                <td>
                    <div class="radio-group">
                        <label><input type="radio" name="gender" value="Male" <?= ($row['gender'] == 'Male') ? 'checked' : '' ?>> Male</label>
                        <label><input type="radio" name="gender" value="Female" <?= ($row['gender'] == 'Female') ? 'checked' : '' ?>> Female</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label>ADDRESS</label></td>
                <td><textarea name="address" rows="3"><?= htmlspecialchars($row['address']) ?></textarea></td>
            </tr>
            <tr>
                <td><label>CITY</label></td>
                <td><input type="text" name="city" value="<?= htmlspecialchars($row['city']) ?>"></td>
            </tr>
            <tr>
                <td><label>PIN CODE</label></td>
                <td><input type="text" name="pin" value="<?= htmlspecialchars($row['pin_code']) ?>"></td>
            </tr>
            <tr>
                <td><label>STATE</label></td>
                <td><input type="text" name="state" value="<?= htmlspecialchars($row['state']) ?>"></td>
            </tr>
            <tr>
                <td><label>COUNTRY</label></td>
                <td>
                    <select name="country">
                        <?php 
                        $countries = ["Rwanda", "Kenya", "Uganda", "Tanzania", "India", "USA", "UK", "Canada"];
                        foreach($countries as $c): ?>
                            <option value="<?= $c ?>" <?= ($row['country'] == $c) ? 'selected' : '' ?>><?= $c ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label>HOBBIES</label></td>
                <td>
                    <div class="checkbox-group">
                        <label><input type="checkbox" name="hobbies[]" value="Drawing" <?= in_array("Drawing", $hobbies) ? 'checked' : '' ?>> Drawing</label>
                        <label><input type="checkbox" name="hobbies[]" value="Singing" <?= in_array("Singing", $hobbies) ? 'checked' : '' ?>> Singing</label>
                        <label><input type="checkbox" name="hobbies[]" value="Dancing" <?= in_array("Dancing", $hobbies) ? 'checked' : '' ?>> Dancing</label>
                        <label><input type="checkbox" name="hobbies[]" value="Sketching" <?= in_array("Sketching", $hobbies) ? 'checked' : '' ?>> Sketching</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label>COURSES</label></td>
                <td>
                    <div class="radio-group">
                        <label><input type="radio" name="course" value="BCA" <?= ($row['course'] == 'BCA') ? 'checked' : '' ?>> BCA</label>
                        <label><input type="radio" name="course" value="B.Com" <?= ($row['course'] == 'B.Com') ? 'checked' : '' ?>> B.Com</label>
                        <label><input type="radio" name="course" value="B.Sc" <?= ($row['course'] == 'B.Sc') ? 'checked' : '' ?>> B.Sc</label>
                        <label><input type="radio" name="course" value="B.A" <?= ($row['course'] == 'B.A') ? 'checked' : '' ?>> B.A</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="btn-group">
                    <input type="submit" value="Update" class="btn btn-update">
                    <a href="view.php" class="btn btn-cancel">Cancel</a>
                </td>
            </tr>
        </table>
    </form>

    <div class="nav-link">
        <a href="view.php">Back to Student List</a>
    </div>
</div>

</body>
</html>
