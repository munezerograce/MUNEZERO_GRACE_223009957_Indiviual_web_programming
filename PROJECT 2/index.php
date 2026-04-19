<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration Form</title>
    <style>
        body {
            margin: 0;
            padding: 20px 40px;
            font-family: "Times New Roman", Times, serif;
            background-color: #ffffff;
            color: #000000;
        }

        .wrapper {
            max-width: 1250px;
            margin: 0 auto;
        }

        h1 {
            margin: 0 0 30px;
            text-align: right;
            font-size: 34px;
            font-weight: bold;
            text-transform: uppercase;
        }

        table.main-form {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 24px;
        }

        table.main-form td {
            vertical-align: top;
            font-size: 24px;
        }

        td.label-cell {
            width: 280px;
            padding-right: 25px;
            font-weight: bold;
            text-transform: uppercase;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea,
        select {
            border: 1px solid #777;
            font-family: "Times New Roman", Times, serif;
            font-size: 22px;
            padding: 6px 10px;
            box-sizing: border-box;
            background: #fff;
        }

        .text-input {
            width: 400px;
            height: 46px;
        }

        .dob-select {
            width: 135px;
            height: 42px;
            margin-right: 8px;
        }

        textarea {
            width: 550px;
            height: 140px;
            resize: vertical;
        }

        .radio-line,
        .checkbox-line,
        .course-line {
            font-size: 24px;
        }

        .radio-line label,
        .checkbox-line label,
        .course-line label {
            margin-right: 18px;
        }

        .radio-line input,
        .checkbox-line input,
        .course-line input {
            width: 22px;
            height: 22px;
            vertical-align: middle;
            margin-left: 8px;
            margin-right: 8px;
        }

        .other-input {
            width: 360px;
            height: 42px;
        }

        .qualification-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px 10px;
            font-size: 24px;
        }

        .qualification-table th {
            text-align: left;
            font-weight: bold;
            white-space: nowrap;
        }

        .qualification-table .q-input {
            width: 310px;
            height: 42px;
        }

        .qualification-note {
            font-size: 20px;
            text-align: center;
        }

        .button-row {
            text-align: center;
            padding-top: 18px;
        }

        .button-row button {
            font-family: "Times New Roman", Times, serif;
            font-size: 22px;
            padding: 4px 18px;
            margin: 0 4px;
        }

        .view-link {
            margin-top: 18px;
            text-align: center;
            font-size: 22px;
        }

        .view-link a {
            color: #0000ee;
        }

        @media (max-width: 900px) {
            body {
                padding: 20px;
            }

            h1 {
                text-align: center;
                font-size: 28px;
            }

            table.main-form,
            table.main-form tbody,
            table.main-form tr,
            table.main-form td {
                display: block;
                width: 100%;
            }

            td.label-cell {
                margin-bottom: 8px;
            }

            .text-input,
            textarea,
            .other-input {
                width: 100%;
            }

            .dob-select {
                width: 32%;
                margin-bottom: 8px;
            }

            .qualification-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h1>Student Registration Form</h1>

        <form action="insert.php" method="POST">
            <table class="main-form">
                <tr>
                    <td class="label-cell">First Name</td>
                    <td><input class="text-input" type="text" name="first_name" required></td>
                </tr>
                <tr>
                    <td class="label-cell">Last Name</td>
                    <td><input class="text-input" type="text" name="last_name" required></td>
                </tr>
                <tr>
                    <td class="label-cell">Date Of Birth</td>
                    <td>
                        <select class="dob-select" name="day" id="day" required>
                            <option value="">Day:</option>
                        </select>
                        <select class="dob-select" name="month" id="month" required>
                            <option value="">Month:</option>
                        </select>
                        <select class="dob-select" name="year" id="year" required>
                            <option value="">Year:</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">Email ID</td>
                    <td><input class="text-input" type="email" name="email" required></td>
                </tr>
                <tr>
                    <td class="label-cell">Mobile Number</td>
                    <td><input class="text-input" type="tel" name="mobile"></td>
                </tr>
                <tr>
                    <td class="label-cell">Gender</td>
                    <td class="radio-line">
                        <label>Male <input type="radio" name="gender" value="Male" required></label>
                        <label>Female <input type="radio" name="gender" value="Female"></label>
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">Address</td>
                    <td><textarea name="address"></textarea></td>
                </tr>
                <tr>
                    <td class="label-cell">City</td>
                    <td><input class="text-input" type="text" name="city"></td>
                </tr>
                <tr>
                    <td class="label-cell">Pin Code</td>
                    <td><input class="text-input" type="text" name="pin"></td>
                </tr>
                <tr>
                    <td class="label-cell">State</td>
                    <td><input class="text-input" type="text" name="state"></td>
                </tr>
                <tr>
                    <td class="label-cell">Country</td>
                    <td><input class="text-input" type="text" name="country" value="India"></td>
                </tr>
                <tr>
                    <td class="label-cell">Hobbies</td>
                    <td class="checkbox-line">
                        <label>Drawing <input type="checkbox" name="hobbies[]" value="Drawing"></label>
                        <label>Singing <input type="checkbox" name="hobbies[]" value="Singing"></label>
                        <label>Dancing <input type="checkbox" name="hobbies[]" value="Dancing"></label>
                        <label>Sketching <input type="checkbox" name="hobbies[]" value="Sketching"></label>
                        <br>
                        <label>Others <input type="checkbox" name="hobbies[]" value="Others"></label>
                        <input class="other-input" type="text" name="other_hobby">
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">Qualification</td>
                    <td>
                        <table class="qualification-table">
                            <tr>
                                <th>Sl.No.</th>
                                <th>Examination</th>
                                <th>Board</th>
                                <th>Percentage</th>
                                <th>Year of Passing</th>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Class X</td>
                                <td><input class="q-input" type="text" name="board_x"></td>
                                <td><input class="q-input" type="text" name="percent_x"></td>
                                <td><input class="q-input" type="text" name="year_x"></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Class XII</td>
                                <td><input class="q-input" type="text" name="board_xii"></td>
                                <td><input class="q-input" type="text" name="percent_xii"></td>
                                <td><input class="q-input" type="text" name="year_xii"></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Graduation</td>
                                <td><input class="q-input" type="text" name="board_grad"></td>
                                <td><input class="q-input" type="text" name="percent_grad"></td>
                                <td><input class="q-input" type="text" name="year_grad"></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Masters</td>
                                <td><input class="q-input" type="text" name="board_mast"></td>
                                <td><input class="q-input" type="text" name="percent_mast"></td>
                                <td><input class="q-input" type="text" name="year_mast"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="qualification-note">(10 char max)</td>
                                <td class="qualification-note">(upto 2 decimal)</td>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">Courses<br>Applied For</td>
                    <td class="course-line">
                        <label>BCA <input type="radio" name="course" value="BCA" required></label>
                        <label>B.Com <input type="radio" name="course" value="B.Com"></label>
                        <label>B.Sc <input type="radio" name="course" value="B.Sc"></label>
                        <label>B.A <input type="radio" name="course" value="B.A"></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="button-row">
                        <button type="submit">Submit</button>
                        <button type="reset">Reset</button>
                    </td>
                </tr>
            </table>
        </form>

        <div class="view-link">
            <a href="view.php">Go to student list</a>
        </div>
    </div>

    <script>
        const daySelect = document.getElementById("day");
        for (let i = 1; i <= 31; i++) {
            daySelect.innerHTML += `<option value="${i}">${i}</option>`;
        }

        const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        const monthSelect = document.getElementById("month");
        months.forEach((month, index) => {
            monthSelect.innerHTML += `<option value="${index + 1}">${month}</option>`;
        });

        const yearSelect = document.getElementById("year");
        const currentYear = new Date().getFullYear();
        for (let i = currentYear; i >= 1980; i--) {
            yearSelect.innerHTML += `<option value="${i}">${i}</option>`;
        }
    </script>
</body>
</html>
