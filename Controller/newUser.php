<?php
session_start();
include '../Model/configServer.php';
include '../Model/consulSQL.php';

$nombre = consultasSQL::clean_string($_POST['nombreUserNuevo']);
$clave = consultasSQL::clean_string($_POST['newPass']);
$email = consultasSQL::clean_string($_POST['emailNuevo']);
$rol = consultasSQL::clean_string($_POST['rolNuevo']);

$existe = ejecutarSQL::consultar("SELECT * FROM Usuario WHERE id_usuario = '$nombre'");
$verdadero = mysqli_num_rows($existe);
if ($verdadero <= 0) {
    if ($rol == "monitor") {
    } else if ($rol == "supervisor") {
    }
} else {
    echo '<script>';
    echo 'alert("este usuario ya existe ")';
    echo '</script>';
}


echo '<script> location.href="../View/admin.php"; </script>';
//echo 'Error nombre o contraseña inválido';
echo '<script>';
echo 'console.log(' . json_encode($_SESSION) . ');';
echo '</script>';
