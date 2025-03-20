<?php
session_start();
include '../Model/configServer.php';
include '../Model/consulSQL.php';

$query = ejecutarSQL::consultar("SELECT numeroCalle, numeroAvenida, numeroZona, nombre FROM Interseccion");
$resultados = array();

while ($row = mysqli_fetch_assoc($query)) {
    $resultados[] = array(
        'calle' => $row['numeroCalle'],
        'avenida' => $row['numeroAvenida'],
        'zona' => $row['numeroZona'],
        'nombre' => $row['nombre']
    );
}

echo json_encode($resultados);
?>