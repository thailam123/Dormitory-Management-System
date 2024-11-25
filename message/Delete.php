<?php
include_once 'connection.php';
$sql = "DELETE FROM message_table WHERE Stu_ID='" . $_GET["Stu_ID"] . "'";
if (mysqli_query(mysql: $conn, query: $sql)) {
    include 'disp.php';
} else {
    echo "Error deleting record: " . mysqli_error(mysql: $conn);
}
mysqli_close(mysql: $conn);