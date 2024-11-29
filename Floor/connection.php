<?php
$sname = "db";
$uname = "root";
$password = "";
mysqli_connect(hostname: 'db', username: 'root', password: '');
$conn = mysqli_connect(hostname: $sname, username: $uname, password: $password, database: 'DMS');
?>
<!-- if(!$conn)
{
    echo "Connection failed!";
} -->