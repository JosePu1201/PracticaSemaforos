<?php
session_start();
include '../Model/configServer.php';
include '../Model/consulSQL.php';

$query = ejecutarSQL::consultar("SELECT id_usuario AS id,  nombre, correo, id_rol AS rol FROM Usuario");
$resultados = array();

while ($row = mysqli_fetch_assoc($query)) {
    if($row['rol']!= 1){
        $resultados[] = array(
        'id' => $row['id'],
        'usuario' => $row['usuario'],
        'nombre' => $row['nombre'],
        'correo' => $row['correo'],
        'rol' => $row['rol'] == 2 ? 'Monitor' : 'Supervisor'
    );
    }
    
}

echo json_encode($resultados);
?>