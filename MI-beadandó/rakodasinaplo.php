<?php
header('Content-Type: application/json; charset=utf-8');

// Betöltöm az adatbázis kapcsolatot tartalmazó fájlt.
require_once 'kapcsolat.php';

$method = $_SERVER['REQUEST_METHOD'];

// GET metódussal érkezik a kérés, akkor lekérem a depók listáját az adatbázisból.
if ($method === 'GET') {
    // A depók nevét és azonosítóját kérem le, hogy a lenyíló lista feltölthető legyen.
    $sql = "SELECT id, nev FROM depok";
    $result = $conn->query($sql);

    $depok = [];

    // Ha van találat, akkor minden sort beolvasok és egy tömbbe gyűjtök.
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $depok[] = $row;
        }
        // A találatokat JSON formátumban visszaküldöm a kliensnek.
        echo json_encode($depok, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    } else {
        // Ha nincs adat, akkor hibaüzenetet küldök.
        echo json_encode(["error" => "Nincs elérhető depó az adatbázisban."]);
    }
}

// Ha POST metódus érkezik, akkor az aktuális készletet frissítem a depók táblában.
elseif ($method === 'POST') {
    // A beérkező nyers JSON adat beolvasása.
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    // Ellenőrzöm, hogy a szükséges adatok megvannak-e.
    if (!isset($data['depo'], $data['aktualis'], $data['ido'])) {
        echo json_encode(["error" => "Hiányzó adatok a kérésben."]);
        exit;
    }

    // Az adatok biztonságos feldolgozása az SQL injection elkerülése érdekében.
    $depo = $conn->real_escape_string($data['depo']);
    $aktualis = intval($data['aktualis']);
    $ido = $conn->real_escape_string($data['ido']);

    // A depó aktuális készletének frissítése az adatbázisban.
    $sql = "UPDATE depok SET aktualis = $aktualis WHERE nev = '$depo'";

    // Ha sikeres a frissítés, sikerüzenetet küldök.
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => "A(z) $depo depó aktuális készlete frissítve: $aktualis db."]);
    } else {
        // Ha hiba történik, hibaüzenetet küldök.
        echo json_encode(["error" => "Hiba a frissítés során: " . $conn->error]);
    }
}

// Az adatbázis kapcsolat lezárása.
$conn->close();
?>
