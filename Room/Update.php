<?php
include_once 'connection.php';
if (count($_POST) > 0) {
  $result = mysqli_query($conn, "UPDATE room 
                     SET R_Name='" . $_POST['R_Name'] . "',
                         Num_of_Table='" . $_POST['Num_of_Table'] . "',
                         Num_of_Bed='" . $_POST['Num_of_Bed'] . "',
                         Gender='" . $_POST['Gender'] . "',
                         Status='" . $_POST['rStatus'] . "'
                     WHERE R_ID='" . $_POST['R_ID'] . "'");

  if ($result) {
    header("Location: DispRoom.php");
    exit;
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}

$result = mysqli_query($conn, "SELECT R_ID, R_Name, f.Floor_Number, h.H_Name, Num_of_Table, Num_of_Bed,
                                      CASE 
                                         WHEN Gender = 1 THEN 'Nam' 
                                         WHEN Gender = 0 THEN 'Nữ' 
                                          ELSE 'Không xác định' 
                                      END AS Gender,
                                      CASE 
                                         WHEN r.Status = 1 THEN 'Mở' 
                                         WHEN r.Status = 0 THEN 'Đóng' 
                                          ELSE 'Không xác định' 
                                      END AS rStatus
                              FROM room r
                              INNER JOIN floor f ON r.F_ID = f.F_ID
                              INNER JOIN hall h ON f.H_ID = h.H_ID
                              WHERE r.R_ID='" . $_GET['R_ID'] . "'");
$row = mysqli_fetch_array($result);
?>

<html>

<head>
  <title>Cập nhật thông tin phòng</title>
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
      <input type="hidden" name="R_ID" value="<?php echo $row['R_ID']; ?>">

      <label for="R_Name">Tên phòng:</label>
      <input type="text" name="R_Name" value="<?php echo $row['R_Name']; ?>" required>

      <label for="Floor_Number">Tầng:</label>
      <input type="text" name="Floor_Number" value="<?php echo $row['Floor_Number']; ?>" readonly>

      <label for="H_Name">Tòa nhà:</label>
      <input type="text" name="H_Name" value="<?php echo $row['H_Name']; ?>" readonly>

      <label for="Gender">Giới tính:</label>
      <select name="Gender" required>
        <option value="1" <?php if ($row['Gender'] == 'Nam') echo 'selected'; ?>>Nam</option>
        <option value="0" <?php if ($row['Gender'] == 'Nữ') echo 'selected'; ?>>Nữ</option>
      </select>

      <label for="Num_of_Table">Số bàn:</label>
      <input type="number" name="Num_of_Table" value="<?php echo $row['Num_of_Table']; ?>" required>

      <label for="Num_of_Bed">Số giường:</label>
      <input type="number" name="Num_of_Bed" value="<?php echo $row['Num_of_Bed']; ?>" required>

      <label for="rStatus">Trạng thái:</label>
      <select name="rStatus" required>
        <option value="1" <?php if ($row['rStatus'] == 'Mở') echo 'selected'; ?>>Mở</option>
        <option value="0" <?php if ($row['rStatus'] == 'Đóng') echo 'selected'; ?>>Đóng</option>
      </select>

      <input type="submit" name="submit" value="Cập nhật">
    </form>

    <div class="button-container">
      <a href="DispRoom.php">Trở về danh sách phòng</a>
    </div>
  </div>

  <script>
    function confirmUpdate() {
      return confirm("Bạn có chắc chắn muốn cập nhật?");
    }
  </script>
</body>

</html>