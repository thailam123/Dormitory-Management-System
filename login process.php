<?php
session_start();

include('database connection.php');

if (isset($_POST['login'])) {
    $user_unsafe = $_POST['username'];
    $pass_unsafe = $_POST['password'];

    $user = mysqli_real_escape_string($con, $user_unsafe);
    $pass = mysqli_real_escape_string($con, $pass_unsafe);

    // Use prepared statement to prevent SQL injection
    $stmt = mysqli_prepare($con, "SELECT * FROM login WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($query);

    if ($row) {
        $name = $row['username'];
        $db_password = $row['password']; // Hashed or plain text password from the database

        // Verify password (plain text or hashed)
        if ($pass === $db_password || password_verify($pass, $db_password)) {
            // Check if the user is an admin
            if ($name === "admin") {
                $_SESSION['user_type'] = 'admin';
                $_SESSION['id'] = $row['id']; // Assuming you have an 'id' column
                $_SESSION['username'] = $name;

                echo "<script type='text/javascript'>document.location='dashboard/home.php'</script>";
            } else {
                // Fetch student ID based on email (username) from student table
                $student_query = mysqli_prepare($con, "SELECT Stu_id FROM student WHERE Email = ?");
                mysqli_stmt_bind_param($student_query, "s", $user);
                mysqli_stmt_execute($student_query);
                $student_result = mysqli_stmt_get_result($student_query);

                if (mysqli_num_rows($student_result) > 0) {
                    $student_row = mysqli_fetch_array($student_result);
                    $student_id = $student_row['Stu_id'];

                    $_SESSION['user_type'] = 'student';
                    $_SESSION['student_id'] = $student_id;
                    $_SESSION['username'] = $name;

                    echo "<script type='text/javascript'>document.location='sinhvien/login.php'</script>";
                } else {
                    // Handle case where student email doesn't exist in student table
                    echo "<script type='text/javascript'>alert('Student account not found!');
                          document.location='login.php'</script>";
                }
            }
        } else {
            echo "<script type='text/javascript'>alert('Invalid Username or Password!');
                  document.location='login.php'</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('Invalid Username or Password!');
              document.location='login.php'</script>";
    }
}
?>