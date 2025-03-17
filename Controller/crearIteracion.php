<?php
session_start();
include '../Model/configServer.php';
include '../Model/consulSQL.php';

// Establecer la zona horaria predeterminada a "America/Guatemala"
date_default_timezone_set('America/Guatemala');

$inicio = consultasSQL::clean_string($_POST['inicio']);
$fin = consultasSQL::clean_string($_POST['fin']);
$usuario = consultasSQL::clean_string($_POST['usuario']);
$comentario = consultasSQL::clean_string($_POST['comentario']);

// Convertir las cadenas de fecha y hora en formato DateTime de SQL
$inicioDateTime = date('Y-m-d H:i:s', strtotime($inicio));
$finDateTime = date('Y-m-d H:i:s', strtotime($fin));

if (consultasSQL::InsertSQL("Iteracion", "monitor,inicio,fin,comentario", "'$usuario','$inicioDateTime','$finDateTime','$comentario'")) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>