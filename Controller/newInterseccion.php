<?php
session_start();
include '../Model/configServer.php';
include '../Model/consulSQL.php';

// Definir la función antes de usarla
function numeroAOrdinal($numero)
{
    $numeronuevo = (int)$numero;
    $formatter = new NumberFormatter('es', NumberFormatter::ORDINAL);
    return $formatter->format($numeronuevo);
}

$calle = consultasSQL::clean_string($_POST['calle']);
$avenida = consultasSQL::clean_string($_POST['numAv']);
$zona = consultasSQL::clean_string($_POST['numZona']);

$existe = ejecutarSQL::consultar("SELECT * FROM Interseccion WHERE numeroCalle = '$calle' AND numeroAvenida = '$avenida' AND numeroZona = '$zona'");
$verdadero = mysqli_num_rows($existe);
if ($verdadero <= 0) {
    $formatoCalle = numeroAOrdinal($calle);
    $formatoAvenida = numeroAOrdinal($avenida);
    $nombreFinal = $formatoCalle . ' Calle y ' . $formatoAvenida . ' Avenida de la Zona ' . $zona;
    if (consultasSQL::InsertSQL("Interseccion", "numeroCalle,numeroAvenida,numeroZona,nombre", "'$calle','$avenida','$zona','$nombreFinal'")) {
        echo '<script>';
        echo 'alert("Interseccion creada con exito")';
        echo '</script>';
    } else {
        echo '<script>';
        echo 'alert("ocurrio un error")';
        echo '</script>';
    }
} else {
    echo '<script>';
    echo 'alert("Estos datos ya estan en una interseccion creada, verifica para no tener intersecciones duplicadas")';
    echo '</script>';
}

echo '<script> location.href="../View/admin.php"; </script>';
//echo 'Error nombre o contraseña inválido';
echo '<script>';
echo 'console.log(' . json_encode($_SESSION) . ');';
echo '</script>';
?>