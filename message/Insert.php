<?php
include_once '../CommonMethods/connection.php';

if (count($_POST) > 0) {
    $stu_id = $_POST['Stu_id'];
    $message = $_POST['Message'];

    // Truy vấn để lấy Name và Room Name dựa trên Stu_id
    $sqlGetDetails = "SELECT s.Name, r.R_Name 
                      FROM Student s
                      INNER JOIN room r ON s.R_ID = r.R_ID
                      WHERE s.Stu_id = '$stu_id'";
    $resultGetDetails = mysqli_query($conn, $sqlGetDetails);

    if ($resultGetDetails && mysqli_num_rows($resultGetDetails) > 0) {
        $details = mysqli_fetch_assoc($resultGetDetails);
        $studentName = $details['Name'];
        $roomName = $details['R_Name'];

        // Thực hiện thêm vào bảng Message với đủ thông tin
        $sqlInsertMessage = "INSERT INTO message_table (ID_student, Name, R_Name, Messages) 
                             VALUES ('$stu_id', '$studentName', '$roomName', '$message')";

        $resultInsert = mysqli_query($conn, $sqlInsertMessage);

        if ($resultInsert) {
            header("Location: DispMessage.php"); // Redirect đến trang hiển thị danh sách message
            exit;
        } else {
            echo "Error while inserting message: " . mysqli_error($conn);
        }
    } else {
        echo "Lỗi: Không tìm thấy thông tin sinh viên.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Thêm Message Sinh viên</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
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
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

        input[readonly] {
            background-color: #e9e9e9;
        }
    </style>
    <script>
        function loadStudentDetails(studentId) {
            if (!studentId) {
                document.getElementById('studentName').value = '';
                document.getElementById('roomName').value = '';
                return;
            }

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var response = JSON.parse(this.responseText);
                    document.getElementById('studentName').value = response.Name;
                    document.getElementById('roomName').value = response.R_Name;
                }
            };
            xhttp.open("GET", "../CommonMethods/getStudentDetailsWithRoom.php?Stu_id=" + studentId, true);
            xhttp.send();
        }
    </script>
</head>

<body>
    <div class="form-container">
        <h2>Thêm Message Sinh viên</h2>
        <form name="frmAddMessage" method="post" action="">
            <label for="Stu_id">Chọn mã sinh viên:</label>
            <select name="Stu_id" id="Stu_id" onchange="loadStudentDetails(this.value)" required>
                <option value="">Chọn sinh viên</option>
                <?php
                $sql = "SELECT Stu_id FROM Student";
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    echo "Lỗi truy vấn: " . mysqli_error($conn);
                    exit;
                }

                while ($row = mysqli_fetch_array($result)) {
                    echo "<option value='" . $row['Stu_id'] . "'>" . $row['Stu_id'] . "</option>";
                }
                ?>
            </select>

            <label for="studentName">Tên sinh viên:</label>
            <input type="text" id="studentName" readonly>

            <label for="roomName">Tên phòng:</label>
            <input type="text" id="roomName" readonly>

            <label for="Message">Nội dung:</label>
            <input type="text" name="Message" required>

            <input type="submit" name="submit" value="Thêm">
        </form>
    </div>
</body>

</html>