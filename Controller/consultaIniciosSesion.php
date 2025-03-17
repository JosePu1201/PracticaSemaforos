<?php
session_start();
include '../Model/configServer.php';
include '../Model/consulSQL.php';




$usuario = consultasSQL::clean_string($_POST['usuarioConsulta']);
$query = ejecutarSQL::consultar("SELECT usuario, inicio, fin, TIMESTAMPDIFF(SECOND, inicio, fin) AS tiempoTotal FROM LogSesion WHERE usuario = '$usuario' ORDER BY tiempoTotal DESC");


$resultados = array();

while ($row = mysqli_fetch_assoc($query)) {
   
    $resultados[] = array(
        'usuario' => $row['usuario'],
        'fechaInicio' => $row['inicio'],
        'fechaFinal' => $row['fin'],
        'tiempoTotal' => gmdate("H:i:s", $row['tiempoTotal'])
    );
}


echo json_encode($resultados);
?>