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
    <link rel="stylesheet" href="style.css"> 
</head>

<body>
    <?php include 'sidebar.php'; ?>

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