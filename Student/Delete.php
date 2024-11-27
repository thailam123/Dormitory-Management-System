<?php
include_once '../CommonMethods/connection.php';

if (isset($_GET["Stu_id"])) {
    $Stu_id = $_GET["Stu_id"];

    $sql = "DELETE FROM student WHERE Stu_id = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $Stu_id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: DispStudent.php");
            exit();
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing the query: " . mysqli_error($conn);
    }

} else {
    echo "No student ID specified. " . $Stu_id;
}
mysqli_close($conn);
?>