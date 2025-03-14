<?php
    session_start();
    include '../Model/configServer.php';
    include '../Model/consulSQL.php';

    $nombre=consultasSQL::clean_string($_POST['username']);
    $clave=consultasSQL::clean_string($_POST['password']);
   
   echo ("hola mundo");
    if($nombre != "" && $clave != ""){
        $existe = ejecutarSQL::consultar("SELECT * FROM Usuario WHERE Usuario='$nombre' AND Contra='$clave'");
        $verdadero = mysqli_num_rows($existe);
        if($verdadero>0){
            if($radio == "option2"){
                $existeRolAdmin = ejecutarSQL::consultar("SELECT * FROM Rol WHERE Usuario = '$nombre' AND Rol = 'Administrador' ");
                $verdaderoRolAdmin = mysqli_num_rows($existeRolAdmin);
                if($verdaderoRolAdmin>0){
                    $filaU=mysqli_fetch_array($existeRolAdmin, MYSQLI_ASSOC);
                    $_SESSION['nombreAdmin']=$nombre;
                    $_SESSION['claveAdmin']=$clave;
                    $_SESSION['UserType']="Admin";
                    $_SESSION['adminID']=$nombre;
                    $directorio_actual = getcwd();
                    echo '<script> location.href="index.php"; </script>';
                }else{
                    echo 'Ocurrio un error con el usuario, no tiene el rol que indicas';
                }
               
            }
            if($radio == "option1"){
                $existeRolUser = ejecutarSQL::consultar("SELECT * FROM Rol WHERE Usuario = '$nombre' AND Rol = 'Comprador' ");
                $verdaderoRolUser = mysqli_num_rows($existeRolUser);
                if($verdaderoRolUser>0){
                    $_SESSION['nombreUser']=$nombre;
                    $_SESSION['claveUser']=$clave;
                    $_SESSION['UserType']="User";
                    $_SESSION['UserNIT']=$nombre;
                    echo '<script> location.href="index.php"; </script>';
                }else{
                    echo 'Ocurrio un error con el usuario, no tiene el rol que indicas';
                }
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
    echo 'console.log(' . json_encode($_SESSION) . ');';
    echo '</script>';

?>



