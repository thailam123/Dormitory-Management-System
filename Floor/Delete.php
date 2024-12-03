<?php
include_once '../CommonMethods/connection.php';

if (isset($_GET["F_ID"])) {
    $R_ID = $_GET["F_ID"];

    $sql = "DELETE FROM floor WHERE F_ID = ?";

    if ($stmt = mysqli_prepare(mysql: $conn, query: $sql)) {
        mysqli_stmt_bind_param(statement: $stmt, types: "s", var: $R_ID);

        if (mysqli_stmt_execute(statement: $stmt)) {
            header(header: "Location: DispFloor.php");
            exit();
        } else {
            echo "Error deleting record: " . mysqli_error(mysql: $conn);
        }

        mysqli_stmt_close(statement: $stmt);
    } else {
        echo "Error preparing the query: " . mysqli_error(mysql: $conn);
    }

} else {
    echo "No Floor ID specified. $R_ID";
}
mysqli_close(mysql: $conn);