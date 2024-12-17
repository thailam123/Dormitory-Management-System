<?php
session_start();

// Check if the user is logged in and is a student
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student' || !isset($_SESSION['student_id'])) {
    header("Location: ../login.php"); // Redirect to the main login page
    exit();
}

$student_id = $_SESSION['student_id'];
include '../CommonMethods/connection.php';

// Fetch student's room ID using prepared statement
$room_sql = "SELECT R_ID FROM student WHERE Stu_id = ?";
$stmt = mysqli_prepare($conn, $room_sql);
mysqli_stmt_bind_param($stmt, "i", $student_id);
mysqli_stmt_execute($stmt);
$room_result = mysqli_stmt_get_result($stmt);

if (!$room_result || mysqli_num_rows($room_result) == 0) {
    echo "Could not find room information for the student.";
    exit();
}

$room_row = mysqli_fetch_assoc($room_result);
$room_id = $room_row['R_ID'];

// Handle issue reporting
$issue_reported = false;
if (isset($_POST['report_issue'])) {
    $issue_content = $_POST['issue_content']; // Get the value, but don't escape it yet

    // Use prepared statement to insert the issue
    $insert_sql = "INSERT INTO facility_problem (R_ID, Content, Status) VALUES (?, ?, 0)";
    $stmt = mysqli_prepare($conn, $insert_sql);
    mysqli_stmt_bind_param($stmt, "is", $room_id, $issue_content); // Bind parameters

    if (mysqli_stmt_execute($stmt)) {
        $issue_reported = true;
    } else {
        echo "Error reporting issue: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo Cáo Vấn Đề</title>
    <link rel="shortcut icon" href="https://juniv.edu/images/favicon.ico">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

    <!-- Include your external CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <h1>Báo Cáo Vấn Đề</h1>

        <div class="report-form-container">
            <?php if ($issue_reported) : ?>
                <div class="success-message">Vấn đề đã được báo cáo thành công!</div>
            <?php else : ?>
                <form method="post">
                    <div class="form-group">
                        <label for="issue_content">Nội dung vấn đề:</label>
                        <textarea id="issue_content" name="issue_content" rows="5" placeholder="Nhập nội dung vấn đề..." required></textarea>
                    </div>
                    <button type="submit" name="report_issue" class="report-button">Báo Cáo Vấn Đề</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>