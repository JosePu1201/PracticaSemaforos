<?php
session_start();
include '../Model/configServer.php';
include '../Model/consulSQL.php';

try {
    $interseccionId = consultasSQL::clean_string($_POST['interseccionId']);
    $direccion = consultasSQL::clean_string($_POST['direccion']);
    $tiempoVerde = consultasSQL::clean_string($_POST['tiempoVerde']);
    $tiempoAmarillo = consultasSQL::clean_string($_POST['tiempoAmarillo']);
    $tiempoRojo = consultasSQL::clean_string($_POST['tiempoRojo']);

    $update = consultasSQL::UpdateSQL(
        "Semaforo",
        "tiempoVerde='$tiempoVerde', tiempoAmarillo='$tiempoAmarillo', tiempoRojo='$tiempoRojo'",
        "interseccion='$interseccionId' AND direccion='$direccion'"
    );

    if ($update) {
        echo json_encode(['status' => 'success', 'message' => 'Tiempos actualizados correctamente']);
    } else {
        throw new Exception("Error al actualizar los tiempos");
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>