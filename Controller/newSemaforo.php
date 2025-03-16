<?php
session_start();
include '../Model/configServer.php';
include '../Model/consulSQL.php';

$interseccion = consultasSQL::clean_string($_POST['interseccion']);
$tiempoVerde = consultasSQL::clean_string($_POST['timeGreen']);
$tiempoAmarillo = consultasSQL::clean_string($_POST['timeYellow']);
$tiempoRojo = consultasSQL::clean_string($_POST['timeRed']);
$direccion = consultasSQL::clean_string($_POST['direccion']);
$direccionFinal = '';
switch ($direccion) {
    case 'norte':
        $direccionFinal = 'N';
        break;
    case 'sur':
        $direccionFinal = 'S';
        break;
    case 'este':
        $direccionFinal = 'E';
        break;
    case 'oeste':
        $direccionFinal = 'O';
        break;
    default:
        # code...
        break;
}

// Verificar si la intersección existe
$interseccionExiste = ejecutarSQL::consultar("SELECT * FROM Interseccion WHERE id = '$interseccion'");
if (mysqli_num_rows($interseccionExiste) <= 0) {
    echo '<script>';
    echo 'alert("La intersección no existe")';
    echo '</script>';
    echo '<script> location.href="../View/admin.php"; </script>';
    exit();
}

$existe = ejecutarSQL::consultar("SELECT * FROM Semaforo WHERE interseccion = '$interseccion' AND direccion = '$direccionFinal'");
$verdadero = mysqli_num_rows($existe);
if ($verdadero <= 0) {
    if (consultasSQL::InsertSQL("Semaforo", "interseccion,tiempoVerde,tiempoAmarillo,tiempoRojo,direccion", "'$interseccion','$tiempoVerde','$tiempoAmarillo','$tiempoRojo','$direccionFinal'")) {
        echo '<script>';
        echo 'alert("Semaforo creado con exito")';
        echo '</script>';
    } else {
        echo '<script>';
        echo 'alert("ocurrio un error")';
        echo '</script>';
    }
} else {
    echo '<script>';
    echo 'alert("Este semaforo ya existe en esta interseccion")';
    echo '</script>';
}

echo '<script> location.href="../View/admin.php"; </script>';
echo '<script>';
echo 'console.log(' . json_encode($_SESSION) . ');';
echo '</script>';
?>