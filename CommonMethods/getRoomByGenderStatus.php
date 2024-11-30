<?php
include_once 'connection.php';

if (isset($_GET['Gender'])) {
    $Gender = $_GET['Gender'];

    $sql = "SELECT R_ID, R_Name FROM room WHERE Gender = '$Gender' ORDER BY R_Name";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<option value='" . $row['R_ID'] . "'>" . $row['R_Name'] . "</option>";
        }
    } else {
        echo "<option value=''>Không có tầng</option>";
    }
}
?>