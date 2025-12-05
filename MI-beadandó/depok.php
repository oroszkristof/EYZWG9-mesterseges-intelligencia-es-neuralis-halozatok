<?php
header('Content-Type: application/json; charset=utf-8');


require_once 'kapcsolat.php'; 


$sql = "SELECT id, nev, x, y, aktualis, cel FROM depok";
$result = $conn->query($sql);


$depok = [];


if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $depok[] = $row;
    }
   
    echo json_encode($depok, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} else {
    
    echo json_encode(["error" => "Nem található adat a depok táblában."]);
}

$conn->close();
?>
