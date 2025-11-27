<?php
header('Content-Type: application/json; charset=utf-8');

// Betöltöm az adatbázis-kapcsolatot a kapcsolat.php fájlból.
require_once 'kapcsolat.php'; 

// Lekérdezem az összes depót az adatbázisból a szükséges mezőkkel.
$sql = "SELECT id, nev, x, y, aktualis, cel FROM depok";
$result = $conn->query($sql);

// Egy üres tömböt hozok létre, amibe a lekérdezett adatokat fogom eltárolni.
$depok = [];

// Ha a lekérdezés sikeres és van eredmény, bejárom a sorokat és beleteszem a tömbbe.
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $depok[] = $row;
    }
    // A PHP tömböt JSON formátumba alakítom és visszaküldöm a kliensnek.
    echo json_encode($depok, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} else {
    // Ha nincs adat, hibaüzenetet küldök JSON formátumban.
    echo json_encode(["error" => "Nem található adat a depok táblában."]);
}

// A kapcsolatot lezárom, hogy ne foglalja tovább az erőforrásokat.
$conn->close();
?>
