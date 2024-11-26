<?php
include_once 'connection.php';

if (isset($_GET["ID"])) {
    $ID = $_GET["ID"];

    $sql = "DELETE FROM facility_problem WHERE ID = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $ID); 
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: DispFP.php");
            exit();
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing the query: " . mysqli_error($conn);
    }

} else {
    echo "No Problem ID specified. " .$ID;
}
mysqli_close($conn);
?>
