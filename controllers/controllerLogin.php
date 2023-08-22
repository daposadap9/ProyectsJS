<?php
if(!empty($_POST["btningresar"])){
    if(empty($_POST["user"]) || empty($_POST["password"])){
        echo "Debes llenar todos los campos";
    }else{
        $usuario=$_POST["user"];
        $password=$_POST["password"];
        $sql=$conexion->query("select * from usuarios where nombre='$usuario' and password='$password'");
        if($datos=$sql->fetch_object()){
        session_start();
            $_SESSION['usuario_id'] = $datos->id;
            header("location:../Home/Home.php");
        }else{
            echo "Usuario y/o contraseña incorrectos";
        }
    }
}
?>