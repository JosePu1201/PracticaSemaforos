<?php
    session_start();
    include '../Model/configServer.php';
    include '../Model/consulSQL.php';
    date_default_timezone_set('America/Guatemala');
    // Recuperar datos de sesión antes de destruirla
    $usuario = isset($_SESSION['user']) ? $_SESSION['user'] : '';
    $login_time = isset($_SESSION['login_time']) ? $_SESSION['login_time'] : '';
    $logout_time = date('Y-m-d H:i:s'); // Hora actual de cierre de sesión
    
    // Si tenemos los datos necesarios, insertar en la tabla logSesion

       
        if (consultasSQL::InsertSQL("LogSesion", "usuario, inicio, fin", "'$usuario', '$login_time', '$logout_time'")) {
            // Log insertado correctamente
        } else {
            // Error al insertar log
        }
    
    
    // Destruir la sesión
    session_unset();
    session_destroy();
    
    // Redirigir al usuario
    header("Location: ../index.php");
?>