<?php
include_once 'connection.php';

if (isset($_GET['Stu_id'])) {
    $id_student = $_GET['Stu_id'];

    $sql = "SELECT s.Name, r.R_Name 
            FROM Student s
            INNER JOIN room r ON s.R_ID = r.R_ID
            WHERE s.Stu_id = '$id_student'";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo json_encode(['Name' => '', 'R_Name' => '']);
    }
}
?>