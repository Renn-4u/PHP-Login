<?php

$hostname = "localhost";
$dbUser = "root";
$dbpassword = "";
$dbName = "user";

$conn = mysqli_connect($hostname,$dbUser,$dbpassword,$dbName);

if (!$conn) {
    die("something wrong");
}
?>