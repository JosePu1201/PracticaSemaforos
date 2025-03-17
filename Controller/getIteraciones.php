<?php
session_start();
include '../Model/configServer.php';
include '../Model/consulSQL.php';

$query = ejecutarSQL::consultar("SELECT * FROM Iteracion ORDER BY inicio DESC");
$resultados = [];

while ($row = mysqli_fetch_assoc($query)) {
    $resultados[] = [
        'id' => $row['id'],
        'monitor' => $row['monitor'],
        'inicio' => $row['inicio'],
        'fin' => $row['fin'],
        'comentario' => $row['comentario']
    ];
}

echo json_encode($resultados);
?>