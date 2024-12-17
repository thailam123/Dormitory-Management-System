<?php
include('database connection.php');

if (isset($_POST['register'])) {
    $student_id = mysqli_real_escape_string($con, $_POST['student_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $dob = mysqli_real_escape_string($con, $_POST['dob']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $phone_number = mysqli_real_escape_string($con, $_POST['phone_number']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);
    $room_id = mysqli_real_escape_string($con, $_POST['room']);

    // Validate input (ensure required fields are filled, email is valid, etc.)
    if (empty($student_id) || empty($name) || empty($dob) || empty($gender) || empty($phone_number) || empty($email) || empty($password) || empty($confirm_password) || empty($room_id)) {
        echo "<script type='text/javascript'>alert('Please fill in all fields!');
              document.location='register.php'</script>";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script type='text/javascript'>alert('Invalid email format!');
              document.location='register.php'</script>";
        exit();
    }

    if ($password !== $confirm_password) {
        echo "<script type='text/javascript'>alert('Passwords do not match!');
              document.location='register.php'</script>";
        exit();
    }

    // Check if student ID or email already exists
    $check_duplicate_sql = "SELECT Stu_id FROM student WHERE Stu_id = '$student_id' OR Email = '$email'";
    $duplicate_result = mysqli_query($con, $check_duplicate_sql);

    if (mysqli_num_rows($duplicate_result) > 0) {
        echo "<script type='text/javascript'>alert('Student ID or Email already exists!');
              document.location='register.php'</script>";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into `student` table
    $insert_student_sql = "INSERT INTO student (Stu_id, Name, DOB, Phone_number, Email, Gender, R_ID) 
                           VALUES ('$student_id', '$name', '$dob', '$phone_number', '$email', '$gender', '$room_id')";

    if (mysqli_query($con, $insert_student_sql)) {
        // Insert into `login` table
        $insert_login_sql = "INSERT INTO login (username, password) VALUES ('$email', '$hashed_password')"; // Use email as username
        if (mysqli_query($con, $insert_login_sql)) {
            echo "<script type='text/javascript'>alert('Registration successful! You can now login.');
                  document.location='login.php'</script>";
        } else {
            echo "Error creating login account: " . mysqli_error($con);
        }
    } else {
        echo "Error creating student account: " . mysqli_error($con);
    }
}
?>