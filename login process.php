<?php session_start();

include('database connection.php');

if (isset($_POST['login'])) {

    $user_unsafe = $_POST['username'];
    $pass_unsafe = $_POST['password'];

    $user = mysqli_real_escape_string($con, $user_unsafe);
    $pass = mysqli_real_escape_string($con, $pass_unsafe);

    $query = mysqli_query($con, "select * from login where username='$user' and password='$pass'") or die(mysqli_error($con));
    $row = mysqli_fetch_array($query);

    $name = $row['username'];
    $counter = mysqli_num_rows($query);
    
    // Check if user exists in login table
    if ($counter == 0) {
        echo "<script type='text/javascript'>alert('Invalid Username or Password!');
		  document.location='login.php'</script>";
    } else {
        // Check if the user is an admin
        if ($name === "admin") {
            $_SESSION['user_type'] = 'admin';
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $name;

            echo "<script type='text/javascript'>document.location='dashboard/home.php'</script>";
        } else {
            // Fetch student ID based on email (username) from student table
            $student_query = mysqli_query($con, "SELECT Stu_id FROM student WHERE Email='$user'") or die(mysqli_error($con));
            if (mysqli_num_rows($student_query) > 0) {
                $student_row = mysqli_fetch_array($student_query);
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
    }
}
?>