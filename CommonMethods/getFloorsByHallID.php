<?php
include_once 'connection.php';

if (isset($_GET['H_ID'])) {
    $H_ID = $_GET['H_ID'];

    $sql = "SELECT F_ID, Floor_Number FROM floor WHERE H_ID = '$H_ID'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<option value='" . $row['F_ID'] . "'>" . $row['Floor_Number'] . "</option>";
        }
    } else {
        echo "<option value=''>Không có tầng</option>";
    }
}
?>
