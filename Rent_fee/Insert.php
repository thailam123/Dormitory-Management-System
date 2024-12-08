<?php
include_once '../CommonMethods/connection.php';

if (count($_POST) > 0) {
    $result = mysqli_query($conn, "INSERT INTO rent_fee (ID, R_ID, Period, Room_Bill, Elec_Bill, Internet_Bill,Water_Bill,Status) 
                         VALUES ('" . $_POST['ID'] . "', '" . $_POST['R_ID'] . "', '" . $_POST['Period'] . "', '" . $_POST['Room_Bill'] . "', '" . $_POST['Elec_Bill'] . "', '" . $_POST['Internet_Bill'] . "', '" . $_POST['Water_Bill'] . "', '" . $_POST['Status'] . "')");

    if ($result) {
        header("Location: DispRentFee.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Thêm Chi phí</title>
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
        <h2>Thêm thông tin chi phí</h2>
        <form name="frmAddRoom" method="post" action="" onsubmit="return confirmAdd();">
            <label for="R_Name">Tên phòng:</label>
            <select name="R_ID" id="R_ID" required>
                <option value="">Chọn phòng</option>
                <?php
                $sql = "SELECT R_ID, R_Name FROM room";
                $result = mysqli_query(mysql: $conn, query: $sql);
                if (!$result) {
                    echo "Lỗi truy vấn: " . mysqli_error(mysql: $conn);
                    exit;
                }

                while ($row = mysqli_fetch_array(result: $result)) {
                    echo "<option value='" . $row['R_ID'] . "'>" . $row['R_Name'] . "</option>";
                }
                ?>
            </select>

            <label for="Period">Kỳ hạn:</label>
            <input type="text" name="Period" required>

            <label for="Room_Bill">Giá tiền phòng(VND):</label>
            <input type="number" step="any" name="Room_Bill" required>

            <label for="Elec_Bill">Giá tiền điện(VND):</label>
            <input type="number" step="any" name="Elec_Bill" required>

            <label for="Internet_Bill">Giá tiền mạng(VND):</label>
            <input type="number" step="any" name="Internet_Bill" required>

            <label for="Water_Bill">Giá tiền nước(VND):</label>
            <input type="number" step="any" name="Water_Bill" required>

            <label for="Status">Trạng thái:</label>
            <select name="Status" required>
                <option value="1">Đã thanh toán</option>
                <option value="0">Chưa thanh toán</option>
            </select>

            <input type="submit" name="submit" value="Thêm chi phí">
        </form>

        <div class="button-container">
            <a href="DispRentFee.php">Trở về danh sách chi phí</a>
        </div>
    </div>

    <script>
        function confirmAdd() {
            return confirm("Bạn có chắc chắn muốn thêm phòng?");
        }
    </script>
</body>

</html>