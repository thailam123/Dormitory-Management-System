<?php
session_start();

// Check if the user is logged in and is a student
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student' || !isset($_SESSION['student_id'])) {
    header("Location: ../login.php"); // Redirect to the main login page
    exit();
}

$student_id = $_SESSION['student_id'];
include '../CommonMethods/connection.php';

// Fetch student information
$student_sql = "SELECT Name, R_ID FROM student WHERE Stu_id = '$student_id'";
$student_result = mysqli_query($conn, $student_sql);

if (!$student_result || mysqli_num_rows($student_result) == 0) {
    echo "Student information not found.";
    exit();
}

$student = mysqli_fetch_assoc($student_result);
$student_name = $student['Name'];
$room_id = $student['R_ID'];

// Fetch room name
$room_sql = "SELECT R_Name FROM room WHERE R_ID = '$room_id'";
$room_result = mysqli_query($conn, $room_sql);
$room_name = ($room_result && mysqli_num_rows($room_result) > 0) ? mysqli_fetch_assoc($room_result)['R_Name'] : "Unknown Room";

// Handle message submission
$message_sent = false;
if (isset($_POST['send_message'])) {
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert message into the database
    $insert_sql = "INSERT INTO message_table (ID_student, Name, R_Name, Messages) VALUES ('$student_id', '$student_name', '$room_name', '$message')";
    if (mysqli_query($conn, $insert_sql)) {
        $message_sent = true;
    } else {
        echo "Error sending message: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gửi Tin Nhắn</title>
    <link rel="shortcut icon" href="https://juniv.edu/images/favicon.ico">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

    <!-- Include your external CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<script>
    const messageTextarea = document.getElementById('message');
    const charCount = document.getElementById('charCount');
    const maxChars = 500; 

    messageTextarea.addEventListener('input', function() {
        const currentLength = messageTextarea.value.length;
        charCount.textContent = currentLength + '/' + maxChars;

        if (currentLength > maxChars) {
            charCount.style.color = 'red'; 
        } else {
            charCount.style.color = 'inherit';
        }
    });
</script>

<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <h1>Gửi Tin Nhắn</h1>

        <div class="message-form-container">
            <?php if ($message_sent) : ?>
                <div class="success-message">Tin nhắn đã được gửi thành công!</div>
            <?php else : ?>
                <form method="post">
                    <div class="form-group">
                        <label for="message">Nội dung tin nhắn:</label>
                        <textarea id="message" name="message" rows="5" placeholder="Nhập nội dung tin nhắn..." required></textarea>
                    </div>
                    <button type="submit" name="send_message" class="send-button">Gửi Tin Nhắn</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>