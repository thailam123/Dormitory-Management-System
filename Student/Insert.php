<?php
include_once '../CommonMethods/connection.php';

if (count($_POST) > 0) {
    // Insert into student table
    $studentInsert = mysqli_query($conn, "INSERT INTO student (Stu_id, Name, DOB, Phone_number, Email, R_ID, Gender) 
                         VALUES ('" . $_POST['Stu_id'] . "', '" . $_POST['Name'] . "', '" . $_POST['DOB'] . "', '" . $_POST['Phone_number'] . "', '" . $_POST['Email'] . "', '" . $_POST['R_ID'] . "', '" . $_POST['Gender'] . "')");

    if ($studentInsert) {
        // Generate a random password
        $randomPassword = bin2hex(random_bytes(4)); // Generates an 8-character random string

        // Insert into login table
        $loginInsert = mysqli_query($conn, "INSERT INTO login (username, password) 
                            VALUES ('" . $_POST['Email'] . "', '$randomPassword')");

        if ($loginInsert) {
            // Redirect to student display page
            header("Location: DispStudent.php");
            exit;
        } else {
            echo "Error inserting into login table: " . mysqli_error($conn);
        }
    } else {
        echo "Error inserting into student table: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Thêm Sinh viên</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            width: 45%;
            max-width: 800px;
            max-height: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: auto;
            margin-right: 10px;
        }

        .form-container h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            margin: 10px 0;
            color: #34495e;
            font-weight: bold;
        }

        .form-container input,
        .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
            font-size: 16px;
        }

        .form-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .form-container input[readonly],
        .form-container select[readonly] {
            background-color: #e9e9e9;
        }

        .button-container {
            text-align: center;
        }

        .button-container a {
            text-decoration: none;
            color: white;
            background-color: #1abc9c;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 10px;
            display: inline-block;
            text-align: center;
        }

        .button-container a:hover {
            background-color: #16a085;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Thêm thông tin Sinh viên</h2>
        <form name="frmAddRoom" method="post" action="" onsubmit="return confirmAdd();">

            <label for="Stu_id">Mã số sinh viên:</label>
            <input type="number" name="Stu_id" required>

            <label for="Name">Tên Sinh viên:</label>
            <input type="text" name="Name" required>

            <label for="DOB">DOB:</label>
            <input type="date" name="DOB" required>

            <label for="Phone_number">Số điện thoại:</label>
            <input type="text" name="Phone_number" required>

            <label for="Email">Email:</label>
            <input type="text" name="Email" required>

            <label for="Gender">Giới tính:</label>
            <select name="Gender" required onchange="loadFloors(this.value)">
                <option value="">Chọn giới tính</option>
                <option value="1">Nam</option>
                <option value="0">Nữ</option>
            </select>

            <label for="R_Name">Tên phòng:</label>
            <select name="R_ID" id="R_ID" required>
                <option value="">Chọn phòng</option>
            </select>

            <script>
                function loadFloors(genderStatus) {
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("R_ID").innerHTML = this.responseText;
                        }
                    };
                    xhttp.open("GET", "../CommonMethods/getRoomByGenderStatus.php?Gender=" + genderStatus, true);
                    xhttp.send();
                }
            </script>

            <input type="submit" name="submit" value="Thêm sinh viên">
        </form>

        <div class="button-container">
            <a href="DispStudent.php">Trở về danh sách sinh viên</a>
        </div>
    </div>

    <script>
        function confirmAdd() {
            return confirm("Bạn có chắc chắn muốn thêm sinh viên?");
        }
    </script>
</body>

</html>