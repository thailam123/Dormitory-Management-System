<?php
include_once '../CommonMethods/connection.php';

if (count($_POST) > 0) {
    $result = mysqli_query($conn, "INSERT INTO facility_problem (R_ID, Content, Status) 
                         VALUES ('" . $_POST['R_ID'] . "', '" . $_POST['Content'] . "', '" . $_POST['Status'] . "')");

    if ($result) {
        header("Location: DispFP.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Thêm phòng</title>
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
        <h2>Thêm vấn đề Cơ sở vật chất</h2>
        <form name="frmAddProblem" method="post" action="" onsubmit="return confirmAdd();">
            <label for="H_Name">Tòa nhà:</label>
            <select name="H_ID" id="H_ID" required onchange="loadFloors(this.value)">
                <option value="">Chọn tòa nhà</option>
                <?php
                $sql = "SELECT H_ID, H_Name FROM hall";
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    echo "Lỗi truy vấn: " . mysqli_error($conn);
                    exit;
                }

                while ($row = mysqli_fetch_array($result)) {
                    echo "<option value='" . $row['H_ID'] . "'>" . $row['H_Name'] . "</option>";
                }
                ?>
            </select>

            <label for="Floor_Number">Tầng:</label>
            <select name="F_ID" id="F_ID" required onchange="loadRooms(this.value)">
                <option value="">Chọn tầng</option>
            </select>

            <script>
                function loadFloors(hallId) {
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("F_ID").innerHTML = this.responseText;
                        }
                    };
                    xhttp.open("GET", "../CommonMethods/getFloorsByHallID.php?H_ID=" + hallId, true);
                    xhttp.send();
                }
            </script>


            <label for="R_Name">Phòng:</label>
            <select name="R_ID" id="R_ID" required>
                <option value="">Chọn phòng</option>
            </select>

            <script>
                function loadRooms(fId) {
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("R_ID").innerHTML = this.responseText;
                        }
                    };
                    xhttp.open("GET", "../CommonMethods/getRoomsByFloorID.php?F_ID=" + fId, true);
                    xhttp.send();
                }
            </script>

            <label for="Content">Nội dung:</label>
            <input type="text" name="Content" required>

            <label for="Status">Trạng thái:</label>
            <select name="Status" required>
                <option value="1">Đã xử lý</option>
                <option value="0">Chưa xử lý</option>
            </select>

            <input type="submit" name="submit" value="Thêm">
        </form>

        <div class="button-container">
            <a href="DispFP.php">Trở về trang trước</a>
        </div>
    </div>

    <script>
        function confirmAdd() {
            return confirm("Bạn có chắc chắn muốn thêm?");
        }
    </script>
</body>

</html>