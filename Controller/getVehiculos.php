<?php
session_start();
include '../Model/configServer.php';
include '../Model/consulSQL.php';

$interseccionId = consultasSQL::clean_string($_POST['interseccionId']);

$vehiculos = ejecutarSQL::consultar("SELECT * FROM Vehiculo WHERE interseccion = '$interseccionId'");
$vehiculosArray = array();

while ($vehiculo = mysqli_fetch_array($vehiculos)) {
    $vehiculosArray[] = array(
        'tipo' => $vehiculo['tipo'],
        'placa' => $vehiculo['placa'],
        'direccion' => $vehiculo['direccion'],
        'velocidad' => $vehiculo['velocidad'],
    );
}

echo json_encode($vehiculosArray);
?>