<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "MI_Beadando";


$conn = new mysqli($servername, $username, $password, $dbname);


$conn->set_charset("utf8mb4");


if ($conn->connect_error) {
    die("Adatbázis kapcsolat sikertelen: " . $conn->connect_error);
}
?>
