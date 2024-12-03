<?php
include_once '../CommonMethods/connection.php';
if (count(value: $_POST) > 0) {
    $result = mysqli_query(mysql: $conn, query: "UPDATE floor 
                     SET Floor_Number='" . $_POST['Floor_Number'] . "',
                         Num_of_Room='" . $_POST['Num_of_Room'] . "',
                         Status='" . $_POST['rStatus'] . "'
                     WHERE F_ID='" . $_POST['F_ID'] . "'");

    if ($result) {
        header(header: "Location: DispFloor.php");
        exit;
    } else {
        echo "Error: " . mysqli_error(mysql: $conn);
    }
}

$result = mysqli_query(mysql: $conn, query: "SELECT F_ID, Floor_Number, H_Name, Num_of_Room, 
                 CASE 
                    WHEN f.Status = 1 THEN 'Mở' 
                    WHEN f.Status = 0 THEN 'Đóng' 
                    ELSE 'Không xác định' 
                 END AS fStatus
        FROM floor f
        INNER JOIN hall h ON f.H_ID = h.H_ID
        WHERE f.F_ID='" . $_GET['F_ID'] . "'");
$row = mysqli_fetch_array(result: $result);
?>

<html>

<head>
    <title>Cập nhật thông tin tầng</title>
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
        <h2>Cập nhật thông tin phòng</h2>
        <form name="frmUser" method="post" action="" onsubmit="return confirmUpdate();">
            <input type="hidden" name="F_ID" value="<?php echo $row['F_ID']; ?>">

            <label for="Floor_Number">Tên phòng:</label>
            <input type="text" name="Floor_Number" value="<?php echo $row['Floor_Number']; ?>" required>

            <label for="H_Name">Tòa nhà:</label>
            <input type="text" name="H_Name" value="<?php echo $row['H_Name']; ?>" readonly>

            <label for="Num_of_Room">Số lượng phòng:</label>
            <input type="number" name="Num_of_Room" value="<?php echo $row['Num_of_Room']; ?>" required>

            <label for="fStatus">Trạng thái:</label>
            <select name="fStatus" required>
                <option value="1" <?php if ($row['fStatus'] == 'Mở')
                    echo 'selected'; ?>>Mở</option>
                <option value="0" <?php if ($row['fStatus'] == 'Đóng')
                    echo 'selected'; ?>>Đóng</option>
            </select>

            <input type="submit" name="submit" value="Cập nhật">
        </form>

        <div class="button-container">
            <a href="DispRoom.php">Trở về danh sách tầng</a>
        </div>
    </div>

    <script>
        function confirmUpdate() {
            return confirm("Bạn có chắc chắn muốn cập nhật?");
        }
    </script>
</body>

</html>