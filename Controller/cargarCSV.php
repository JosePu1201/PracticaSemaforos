<?php
session_start();
include '../Model/configServer.php';
include '../Model/consulSQL.php';

try {
    if (!isset($_FILES['csvFile']) || $_FILES['csvFile']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Error al subir el archivo');
    }

    $interseccionId = consultasSQL::clean_string($_POST['interseccionId']);
    $file = $_FILES['csvFile']['tmp_name'];
    
    if (($handle = fopen($file, "r")) !== FALSE) {
        // Saltar la primera línea (encabezados)
        fgetcsv($handle);
        
        while (($data = fgetcsv($handle)) !== FALSE) {
            $tipo = consultasSQL::clean_string($data[0]);
            $placa = consultasSQL::clean_string($data[1]);
            $direccion = consultasSQL::clean_string($data[2]);
            $velocidad = consultasSQL::clean_string($data[3]);
            $modelo = consultasSQL::clean_string($data[4]);
            $color = consultasSQL::clean_string($data[5]);

            $insert = consultasSQL::InsertSQL(
                "Vehiculo",
                "tipo, placa, direccion, interseccion, velocidad, modelo, color",
                "'$tipo', '$placa', '$direccion', '$interseccionId', '$velocidad', '$modelo', '$color'"
            );

            if (!$insert) {
                throw new Exception("Error al insertar vehículo");
            }
        }
        fclose($handle);
        
        echo json_encode(['status' => 'success', 'message' => 'Archivo CSV procesado correctamente']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>