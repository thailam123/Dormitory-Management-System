<?php
include_once 'connection.php';

if (isset($_GET['F_ID'])) {
    $F_ID = $_GET['F_ID'];

    $sql = "SELECT R_ID, R_Name FROM room WHERE F_ID = '$F_ID' ORDER BY R_Name";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<option value='" . $row['R_ID'] . "'>" . $row['R_Name'] . "</option>";
        }
    } else {
        echo "<option value=''>Không có phòng nào</option>";
    }
}
?>
