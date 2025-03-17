<?php
session_start();
include '../Model/configServer.php';
include '../Model/consulSQL.php';

try {
    $interseccionId = consultasSQL::clean_string($_POST['interseccionId']);
    $numeroVehiculos = 10; // Número de vehículos aleatorios a generar

    $tiposVehiculos = [1, 2, 3, 4];
    $direcciones = ['N', 'S', 'E', 'O'];
    $colores = ['rojo', 'verde', 'blanco', 'gris', 'azul'];

    for ($i = 0; $i < $numeroVehiculos; $i++) {
        $tipo = $tiposVehiculos[array_rand($tiposVehiculos)];
        $direccion = $direcciones[array_rand($direcciones)];
        $placa = strtoupper(substr(md5(rand()), 0, 5)); // Generar una placa aleatoria de 5 caracteres
        $velocidad = rand(1, 30); // Generar una velocidad aleatoria entre 1 y 30
        $modelo = rand(1980, 2025); // Generar un modelo aleatorio entre 1980 y 2025
        $color = $colores[array_rand($colores)]; // Seleccionar un color aleatorio

        $insert = consultasSQL::InsertSQL("Vehiculo", "tipo, placa, direccion, interseccion, velocidad, modelo, color", "'$tipo', '$placa', '$direccion', '$interseccionId', '$velocidad', '$modelo', '$color'");
        if (!$insert) {
            throw new Exception("Error al insertar vehículo: " . mysqli_error($conn));
        }
    }

    echo json_encode(['status' => 'success', 'message' => 'Vehículos aleatorios generados exitosamente']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>