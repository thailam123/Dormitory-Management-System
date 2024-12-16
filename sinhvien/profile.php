<?php
session_start();

// Check if the user is logged in and is a student
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student' || !isset($_SESSION['student_id'])) {
    header("Location: ../login.php"); // Redirect to the main login page
    exit();
}

$student_id = $_SESSION['student_id'];
include '../CommonMethods/connection.php';

// Fetch student information along with room, floor, and hall details
$sql = "SELECT s.*, r.R_Name, r.Num_of_Bed, r.Num_of_Table, f.Floor_Number, h.H_Name 
        FROM student s
        INNER JOIN room r ON s.R_ID = r.R_ID
        INNER JOIN floor f ON r.F_ID = f.F_ID
        INNER JOIN hall h ON f.H_ID = h.H_ID
        WHERE s.Stu_id = '$student_id'";

$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Student information not found.";
    exit();
}

$student = mysqli_fetch_assoc($result);

// Fetch messages for the student
$messages_sql = "SELECT Messages, Name FROM message_table WHERE ID_student = '$student_id'";
$messages_result = mysqli_query($conn, $messages_sql);

// Fetch rent fee information for the student
$rent_sql = "SELECT rf.* 
             FROM rent_fee rf
             INNER JOIN room r ON rf.R_ID = r.R_ID
             INNER JOIN student s ON r.R_ID = s.R_ID
             WHERE s.Stu_id = '$student_id'";
$rent_result = mysqli_query($conn, $rent_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
    <link rel="shortcut icon" href="https://juniv.edu/images/favicon.ico">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

    <!-- Inline CSS Styles -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
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

        h1 {
            color: #1abc9c;
            margin-bottom: 20px;
        }

        .profile-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .info-label {
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .info-value {
            margin-bottom: 15px;
            font-size: 16px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .info-section {
            margin-bottom: 20px;
        }

        .info-section h3 {
            color: #1abc9c;
            margin-bottom: 10px;
            font-size: 20px;
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
        .messages-section {
            margin-top: 30px;
        }

        .messages-section h3 {
            color: #1abc9c;
            margin-bottom: 10px;
            font-size: 20px;
        }

        .message-item {
            background-color: #fafafa;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .rent-section {
            margin-top: 30px;
        }

        .rent-section h3 {
            color: #1abc9c;
            margin-bottom: 10px;
            font-size: 20px;
        }

        .rent-table {
            width: 100%;
            border-collapse: collapse;
        }

        .rent-table th,
        .rent-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .rent-table th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <header>
            <span><i class="fas fa-user-graduate"></i></span>
            SINH VIÊN
        </header>
        <ul>
            <li><a href="login.php"><i class="fas fa-home"></i> Trang chủ</a></li>
            <li class="active"><a href="profile.php"><i class="fas fa-user"></i> Thông tin cá nhân</a></li>
            <li><a href="change_password.php"><i class="fas fa-key"></i> Đổi mật khẩu</a></li>
            <li><a href="view_bill.php"><i class="fas fa-file-invoice-dollar"></i> Xem chi phí</a></li>
            <li><a href="send_message.php"><i class="fas fa-envelope"></i> Gửi tin nhắn</a></li>
            <li><a href="report_issue.php"><i class="fas fa-exclamation-triangle"></i> Báo cáo vấn đề</a></li>
        </ul>
        <div class="logout-container">
            <a href="logout.php" class="logout">Đăng xuất</a>
        </div>
    </div>

    <div class="main-content">
        <h1>Thông tin cá nhân</h1>

        <div class="profile-container">
            <div class="info-grid">
                <div class="info-section">
                    <h3>Thông tin sinh viên</h3>
                    <p class="info-label">Mã số sinh viên:</p>
                    <p class="info-value">
                        <?php echo $student['Stu_id']; ?>
                    </p>

                    <p class="info-label">Họ và tên:</p>
                    <p class="info-value">
                        <?php echo $student['Name']; ?>
                    </p>

                    <p class="info-label">Ngày sinh:</p>
                    <p class="info-value">
                        <?php echo date("d/m/Y", strtotime($student['DOB'])); ?>
                    </p>

                    <p class="info-label">Giới tính:</p>
                    <p class="info-value">
                        <?php echo ($student['Gender'] == 1) ? "Nam" : "Nữ"; ?>
                    </p>

                    <p class="info-label">Số điện thoại:</p>
                    <p class="info-value">
                        <?php echo $student['Phone_number']; ?>
                    </p>

                    <p class="info-label">Email:</p>
                    <p class="info-value">
                        <?php echo $student['Email']; ?>
                    </p>
                </div>

                <div class="info-section">
                    <h3>Thông tin phòng</h3>
                    <p class="info-label">Tên phòng:</p>
                    <p class="info-value">
                        <?php echo $student['R_Name']; ?>
                    </p>

                    <p class="info-label">Tòa nhà:</p>
                    <p class="info-value">
                        <?php echo $student['H_Name']; ?>
                    </p>

                    <p class="info-label">Tầng:</p>
                    <p class="info-value">
                        <?php echo $student['Floor_Number']; ?>
                    </p>
                    <p class="info-label">Số giường:</p>
                    <p class="info-value">
                        <?php echo $student['Num_of_Bed']; ?>
                    </p>
                    <p class="info-label">Số bàn:</p>
                    <p class="info-value">
                        <?php echo $student['Num_of_Table']; ?>
                    </p>
                </div>
            </div>

            <!-- Messages Section -->
            <div class="messages-section">
                <h3>Tin nhắn đã gửi</h3>
                <?php if (mysqli_num_rows($messages_result) > 0) : ?>
                    <?php while ($message = mysqli_fetch_assoc($messages_result)) : ?>
                        <div class="message-item">
                            <p>
                                <?php echo $message['Messages']; ?>
                            </p>
                            <p style="font-size: smaller; text-align: right; margin-top: 5px;">
                                <em>- <?php echo $message['Name']; ?></em>
                            </p>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p>Không có tin nhắn nào.</p>
                <?php endif; ?>
            </div>

            <!-- Rent Fee Section -->
            <div class="rent-section">
                <h3>Thông tin hóa đơn (Phòng <?php echo $student['R_Name']; ?>)</h3>
                    <?php if (mysqli_num_rows($rent_result) > 0) : ?>
                    <table class="rent-table">
                        <thead>
                            <tr>
                                <th>Kỳ Thanh Toán</th>
                                <th>Tiền Phòng</th>
                                <th>Tiền Điện</th>
                                <th>Tiền Internet</th>
                                <th>Tiền Nước</th>
                                <th>Trạng Thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($rent = mysqli_fetch_assoc($rent_result)) : ?>
                                <tr>
                                    <td>
                                        <?php echo $rent['Period']; ?>
                                    </td>
                                    <td>
                                        <?php echo number_format($rent['Room_Bill']); ?>
                                    </td>
                                    <td>
                                        <?php echo number_format($rent['Elec_Bill']); ?>
                                    </td>
                                    <td>
                                        <?php echo number_format($rent['Internet_Bill']); ?>
                                    </td>
                                    <td>
                                        <?php echo number_format($rent['Water_Bill']); ?>
                                    </td>
                                    <td>
                                        <?php echo ($rent['Status'] == 1) ? "Đã thanh toán" : "Chưa thanh toán"; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p>Không có thông tin hóa đơn.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>