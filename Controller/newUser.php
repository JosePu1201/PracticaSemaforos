<?php
session_start();
include '../Model/configServer.php';
include '../Model/consulSQL.php';
$usuario = consultasSQL::clean_string($_POST['usuarioNuevo']);
$nombre = consultasSQL::clean_string($_POST['nombreUserNuevo']);
$clave = consultasSQL::clean_string($_POST['newPass']);
$email = consultasSQL::clean_string($_POST['emailNuevo']);
$rol = consultasSQL::clean_string($_POST['rolNuevo']);

$existe = ejecutarSQL::consultar("SELECT * FROM Usuario WHERE id_usuario = '$usuario'");
$verdadero = mysqli_num_rows($existe);
if ($verdadero <= 0) {
    if ($rol == "monitor") {
        $nuevoRol = 2;
        if (consultasSQL::InsertSQL("Usuario", "id_usuario,nombre,correo,pass,id_rol", "'$usuario','$nombre','$email','$clave','$nuevoRol'")) {
            echo '<script>';
            echo 'alert("usuario creado con exito");';
            echo '</script>';
        }else{
            echo '<script>';
            echo 'alert("algo salio mal");';
            echo '</script>';
        }
    } else if ($rol == "supervisor") {
        $nuevoRol = 3;
        if (consultasSQL::InsertSQL("Usuario", "id_usuario,nombre,correo,pass,id_rol", "'$usuario','$nombre','$email','$clave','$nuevoRol'")) {
            echo '<script>';
            echo 'alert("usuario creado con exito");';
            echo '</script>';
        }else{
            echo '<script>';
            echo 'alert("algo salio mal");';
            echo '</script>';
        }
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
