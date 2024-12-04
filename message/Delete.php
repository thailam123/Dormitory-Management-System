<?php
include_once '../CommonMethods/connection.php';

if (isset($_GET["ID"])) {
    $ID = $_GET["ID"];

    $sql = "DELETE FROM message_table WHERE ID = ?";

    if ($stmt = mysqli_prepare(mysql: $conn, query: $sql)) {
        mysqli_stmt_bind_param(statement: $stmt, types: "s", var: $ID);

        if (mysqli_stmt_execute(statement: $stmt)) {
            header(header: "Location: DispMessage.php");
            exit();
        } else {
            echo "Error deleting record: " . mysqli_error(mysql: $conn);
        }

        mysqli_stmt_close(statement: $stmt);
    } else {
        echo "Error preparing the query: " . mysqli_error(mysql: $conn);
    }

} else {
    echo "No Message ID specified. " . $ID;
}
mysqli_close(mysql: $conn);