<?php
session_start();
include '../Model/configServer.php';
include '../Model/consulSQL.php';

$interseccionId = consultasSQL::clean_string($_POST['interseccionId']);
$query = ejecutarSQL::consultar("SELECT * FROM Semaforo ORDER BY interseccion");
$semaforos = [];

while ($semaforo = mysqli_fetch_array($query)) {
    $semaforos[] = [
        'interseccion' => $semaforo['interseccion'],
        'direccion' => $semaforo['direccion'],
        'tiempoVerde' => $semaforo['tiempoVerde'],
        'tiempoAmarillo' => $semaforo['tiempoAmarillo'],
        'tiempoRojo' => $semaforo['tiempoRojo']
    ];
}

echo json_encode($semaforos);
/*
Direccion  Tiempo Verde  Tiempo Amarillo  
N           10              5
S           9               4
E           8               3
O           7               2
*/
?>
