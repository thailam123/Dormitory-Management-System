<?php
session_start();

// Check if the user is logged in and is a student
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student' || !isset($_SESSION['student_id'])) {
    $response = ['success' => false, 'message' => 'User not logged in.'];
    sendJsonResponse($response);
}

$student_id = $_SESSION['student_id'];
$student_email = $_SESSION['username'];
include '../CommonMethods/connection.php';

$response = ['success' => false, 'message' => ''];

if (isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['confirm_new_password'])) {
    $old_password = $_POST['old_password']; // No need to escape here, we'll use prepared statements
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    // Check if new password and confirm new password match
    if ($new_password !== $confirm_new_password) {
        $response['message'] = "New password and confirm new password do not match.";
        sendJsonResponse($response);
    }

    // Check if old password is correct using prepared statement
    $check_password_sql = "SELECT password FROM login WHERE username = ?";
    $stmt = mysqli_prepare($conn, $check_password_sql);
    mysqli_stmt_bind_param($stmt, "s", $student_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // **Verify password (with check for plain text)**
        if (password_verify($old_password, $row['password']) || $old_password == $row['password']) { 
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the new password using prepared statement
            $update_password_sql = "UPDATE login SET password = ? WHERE username = ?";
            $stmt = mysqli_prepare($conn, $update_password_sql);
            mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $student_email);

            if (mysqli_stmt_execute($stmt)) {
                $response['success'] = true;
                $response['message'] = 'Mật khẩu đã được thay đổi thành công!';
            } else {
                $response['message'] = "Error updating password: " . mysqli_error($conn);
            }
        } else {
            $response['message'] = "Incorrect old password.";
        }
    } else {
        $response['message'] = "Error fetching user data.";
    }
} else {
    $response['message'] = "Incomplete form data submitted.";
}

// Function to send JSON response
function sendJsonResponse($response) {
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

sendJsonResponse($response);
?>