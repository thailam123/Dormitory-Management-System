<?php
session_start();

// Check if the user is logged in and is a student
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student' || !isset($_SESSION['student_id'])) {
    header("Location: ../login.php"); // Redirect to the main login page
    exit();
}

// Student ID
$student_id = $_SESSION['student_id'];
include '../CommonMethods/connection.php';

// Fetch student information
$sql = "SELECT s.*, r.R_Name, f.Floor_Number, h.H_Name 
        FROM student s
        INNER JOIN room r ON s.R_ID = r.R_ID
        INNER JOIN floor f ON r.F_ID = f.F_ID
        INNER JOIN hall h ON f.H_ID = h.H_ID
        WHERE s.Stu_id = '$student_id'";

$result = mysqli_query($conn, $sql);

// Check if student exists
if (!$result || mysqli_num_rows($result) == 0) {
    echo "Student information not found.";
    exit();
}

$student = mysqli_fetch_assoc($result);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ Sinh viên</title>
    <link rel="shortcut icon" href="https://juniv.edu/images/favicon.ico">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

    <!-- Inline CSS Styles -->
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            padding: 0;
            box-sizing: border-box;
            display: flex;
        }

        .sidebar {
            width: 20%;
            height: 100vh;
            position: fixed;
            background-color: #2c3e50;
            padding-top: 20px;
            top: 0;
            left: 0;
            z-index: 100;
            color: #ecf0f1;
        }

        .sidebar header {
            padding: 30px 10px;
            text-align: center;
            font-size: 30px;
            font-weight: bolder;
            color: #ecf0f1;
        }

        .sidebar header span {
            font-size: 50px;
            color: #1abc9c;
        }

        .sidebar ul {
            padding: 0;
            list-style: none;
            margin: 0;
        }

        .sidebar ul li {
            padding: 15px;
            font-size: 18px;
            font-weight: bolder;
            color: #ecf0f1;
            margin-bottom: 5px;
            border-left: 5px solid transparent;
            transition: 0.3s;
        }

        .sidebar ul li:hover {
            background-color: #1abc9c;
            border-left: 5px solid #ecf0f1;
        }

        .sidebar ul li.active {
            background-color: #1abc9c;
            border-left: 5px solid #ecf0f1;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: inherit;
            display: flex;
            align-items: center;
        }

        .sidebar ul li a i {
            margin-right: 10px;
        }

        .main-content {
            margin-left: 20%;
            padding: 20px;
            width: 80%;
        }

        .info-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .info-card h2 {
            color: #1abc9c;
            margin-bottom: 15px;
            font-size: 24px;
            font-weight: 700;
        }

        .info-card p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .info-card .label {
            font-weight: 700;
            color: #333;
        }

        .logout-container {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            text-align: center;
        }

        .logout {
            font-family: 'Roboto', sans-serif;
            font-weight: 700;
            font-size: 16px;
            color: #fff;
            background-color: #8e44ad;
            padding: 15px 30px;
            border-radius: 30px;
            transition: all 0.3s ease;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            text-decoration: none;
            display: inline-block;
        }

        .logout:hover {
            transform: scale(1.1);
            background-color: #9b59b6;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3);
        }

        .welcome-message {
            font-size: 24px;
            color: #1abc9c;
            margin-bottom: 20px;
            text-align: center;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .info-item {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .info-item h3 {
            color: #1abc9c;
            margin-bottom: 10px;
            font-size: 20px;
        }

        .info-item p {
            font-size: 16px;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="welcome-message">
            Chào mừng,
            <?php echo $student['Name']; ?>!
        </div>

        <div class="info-grid">
            <div class="info-item">
                <h3>Thông Tin Cá Nhân</h3>
                <p><span class="label">Mã số sinh viên:</span>
                    <?php echo $student['Stu_id']; ?>
                </p>
                <p><span class="label">Họ và tên:</span>
                    <?php echo $student['Name']; ?>
                </p>
                <p><span class="label">Ngày sinh:</span>
                    <?php echo date("d/m/Y", strtotime($student['DOB'])); ?>
                </p>
                <p><span class="label">Giới tính:</span>
                    <?php echo ($student['Gender'] == 1) ? "Nam" : "Nữ"; ?>
                </p>
                <p><span class="label">Số điện thoại:</span>
                    <?php echo $student['Phone_number']; ?>
                </p>
                <p><span class="label">Email:</span>
                    <?php echo $student['Email']; ?>
                </p>
            </div>

            <div class="info-item">
                <h3>Thông Tin Phòng</h3>
                <p><span class="label">Tên phòng:</span>
                    <?php echo $student['R_Name']; ?>
                </p>
                <p><span class="label">Tòa nhà:</span>
                    <?php echo $student['H_Name']; ?>
                </p>
                <p><span class="label">Tầng:</span>
                    <?php echo $student['Floor_Number']; ?>
                </p>
            </div>
        </div>
    </div>
</body>

</html>