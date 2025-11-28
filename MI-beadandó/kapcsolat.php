<?php
// Megadom az adatbázis-kapcsolat beállításához szükséges adatok megadása.
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "MI_Beadando";

// Létrehozom a kapcsolatot a MySQL adatbázissal a mysqli osztály segítségével.
$conn = new mysqli($servername, $username, $password, $dbname);


$conn->set_charset("utf8mb4");

// Ellenőrzöm, hogy sikerült-e a kapcsolat.
if ($conn->connect_error) {
    die("Adatbázis kapcsolat sikertelen: " . $conn->connect_error);
}
?>
