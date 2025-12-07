<?php
header('Content-Type: application/json; charset=utf-8');


require_once 'kapcsolat.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    
    $sql = "SELECT id, nev FROM depok";
    $result = $conn->query($sql);

    $depok = [];

    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $depok[] = $row;
        }
        
        echo json_encode($depok, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    } else {
        
        echo json_encode(["error" => "Nincs elérhető depó az adatbázisban."]);
    }
}

elseif ($method === 'POST') {
   
    
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

   
    if (!isset($data['depo'], $data['aktualis'], $data['ido'])) {
        echo json_encode(["error" => "Hiányzó adatok a kérésben."]);
        exit;
    }

    
    $depo = $conn->real_escape_string($data['depo']);
    $aktualis = intval($data['aktualis']);
    $ido = $conn->real_escape_string($data['ido']);

    
    
    $sql = "UPDATE depok SET aktualis = $aktualis WHERE nev = '$depo'";

    
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => "A(z) $depo depó aktuális készlete frissítve: $aktualis db."]);
    } else {
        
        echo json_encode(["error" => "Hiba a frissítés során: " . $conn->error]);
    }
}


$conn->close();
?>

