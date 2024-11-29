<?php
include_once '../CommonMethods/connection.php';

if (isset($_GET["H_ID"])) {
    $H_ID = $_GET["H_ID"];

    $sql = "DELETE FROM hall WHERE H_ID = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $H_ID); 
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: DispHall.php");
            exit();
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing the query: " . mysqli_error($conn);
    }

} else {
    echo "No Hall ID specified. " .$ID;
}
mysqli_close($conn);
?>