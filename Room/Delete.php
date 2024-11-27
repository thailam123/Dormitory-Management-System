<?php
include_once '../CommonMethods/connection.php';

if (isset($_GET["R_ID"])) {
    $R_ID = $_GET["R_ID"];

    $sql = "DELETE FROM room WHERE R_ID = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $R_ID); 
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: DispRoom.php");
            exit();
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing the query: " . mysqli_error($conn);
    }

} else {
    echo "No Room ID specified. " .$R_ID;
}
mysqli_close($conn);
?>
