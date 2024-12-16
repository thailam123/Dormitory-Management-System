<?php
session_start();

// Check if the user is logged in and is a student
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student' || !isset($_SESSION['student_id'])) {
    header("Location: ../login.php"); // Redirect to the main login page
    exit();
}

$student_id = $_SESSION['student_id'];
include '../CommonMethods/connection.php';

// Fetch the room ID associated with the student
$room_sql = "SELECT R_ID FROM student WHERE Stu_id = '$student_id'";
$room_result = mysqli_query($conn, $room_sql);

if (!$room_result || mysqli_num_rows($room_result) == 0) {
    echo "Could not find room information for the student.";
    exit();
}

$room_row = mysqli_fetch_assoc($room_result);
$room_id = $room_row['R_ID'];

// Fetch rent fee information for the room
$rent_sql = "SELECT * FROM rent_fee WHERE R_ID = '$room_id'";
$rent_result = mysqli_query($conn, $rent_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem Hóa Đơn</title>
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
        <h1>Xem Hóa Đơn</h1>

        <div class="rent-section">
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
                <p>Không có thông tin hóa đơn cho phòng này.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>