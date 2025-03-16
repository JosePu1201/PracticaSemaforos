<?php
session_start();
include '../Model/configServer.php';
include '../Model/consulSQL.php';

$nombre = $_SESSION["user"];
echo $nombre . 'Usuario';

//echo 'Error nombre o contraseña inválido';

?>