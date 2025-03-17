<?php
session_start();
include '../Model/configServer.php';
include '../Model/consulSQL.php';

$interseccionId = consultasSQL::clean_string($_POST['interseccionId']);
$query = ejecutarSQL::consultar("SELECT * FROM Semaforo WHERE interseccion = '$interseccionId'");
$semaforos = [];

while ($semaforo = mysqli_fetch_array($query)) {
    $semaforos[] = [
        'direccion' => $semaforo['direccion'],
        'tiempoVerde' => $semaforo['tiempoVerde'],
        'tiempoAmarillo' => $semaforo['tiempoAmarillo'],
        'tiempoRojo' => $semaforo['tiempoRojo']
    ];
}

echo json_encode($semaforos);
?>