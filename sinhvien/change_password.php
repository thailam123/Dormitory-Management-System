<?php
session_start();

// Check if the user is logged in and is a student
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student' || !isset($_SESSION['student_id'])) {
    header("Location: ../login.php"); // Redirect to the main login page
    exit();
}

$student_id = $_SESSION['student_id'];
$student_email = $_SESSION['username'];
include '../CommonMethods/connection.php';

$response = ['success' => false, 'message' => ''];

if (isset($_POST['change_password'])) {
    $old_password = mysqli_real_escape_string($conn, $_POST['old_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_new_password = mysqli_real_escape_string($conn, $_POST['confirm_new_password']);

    // Check if old password is correct
    $check_password_sql = "SELECT password FROM login WHERE username = '$student_email'";
    $result = mysqli_query($conn, $check_password_sql);
    if ($row = mysqli_fetch_assoc($result)) {
        if ($old_password == $row['password']) {
            // Check if new password and confirm new password match
            if ($new_password == $confirm_new_password) {
                // Update the new password
                $update_password_sql = "UPDATE login SET password = '$new_password' WHERE username = '$student_email'";
                if (mysqli_query($conn, $update_password_sql)) {
                    $response['success'] = true;
                    $response['message'] = 'Mật khẩu đã được thay đổi thành công!';
                } else {
                    $response['message'] = "Error updating password: " . mysqli_error($conn);
                }
            } else {
                $response['message'] = "New password and confirm new password do not match.";
            }
        } else {
            $response['message'] = "Incorrect old password.";
        }
    } else {
        $response['message'] = "Error fetching user data.";
    }
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>