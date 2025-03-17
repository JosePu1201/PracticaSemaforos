<?php
    session_start();
    include '../Model/configServer.php';
    include '../Model/consulSQL.php';

    $nombre=consultasSQL::clean_string($_POST['nombre']);
    $clave=consultasSQL::clean_string($_POST['clave']);
    date_default_timezone_set('America/Guatemala');
    if($nombre != "" && $clave != ""){
        $existe = ejecutarSQL::consultar("SELECT * FROM Usuario WHERE id_usuario='$nombre' AND pass='$clave'");
        $verdadero = mysqli_num_rows($existe);
        if($verdadero > 0){
            $filaU = mysqli_fetch_array($existe, MYSQLI_ASSOC);
            // Obtener el id del rol del usuario
            $idRol = $filaU['id_rol']; 
            // Ahora puedes usar $idRol según lo necesites, por ejemplo guardarlo en la sesión
            switch ($idRol) {
                case '1':
                    $_SESSION['user']=$nombre;
                    $_SESSION['pass']=$clave;
                    $_SESSION['UserType']="Admin";
                    $_SESSION['login_time'] = date('Y-m-d H:i:s');
                    $directorio_actual = getcwd();
                    echo '<script> location.href="../View/admin.php"; </script>';
                    break;
                case '2':
                    $_SESSION['user']=$nombre;
                    $_SESSION['pass']=$clave;
                    $_SESSION['UserType']="Monitor";
                    $_SESSION['login_time'] = date('Y-m-d H:i:s');
                    echo '<script> location.href="../View/monitor.php"; </script>';
                        break;
                case '3':
                    $_SESSION['user']=$nombre;
                    $_SESSION['pass']=$clave;
                    $_SESSION['UserType']="Supervisor";
                    $_SESSION['login_time'] = date('Y-m-d H:i:s');
                    echo '<script> location.href="../View/supervisor.php"; </script>';
                        break;
                default:
                    # code...
                    break;
            }

        }
        else{
            echo 'El nombre o la contraseña invalida';
        }
        
    }else{
        echo 'Error campo vacío<br>Intente nuevamente';
    }
    //echo 'Error nombre o contraseña inválido';
    echo '<script>';
    echo 'console.log(' .  $_SESSION['user'] . ');';
    echo '</script>';

?>



