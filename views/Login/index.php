<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="container_1">
           <h1>Iniciar sesion</h1>
        </div>
        <div class="container_2">
            <form action="" method="post">
               <div class="inputs__container_2">
               <?php 
           include("../../conexion_bd.php");
           include("../../controllers/controllerLogin.php");
           ?>
                <label for=""><h3>Usuario</h3></label>
                <input type="text" name="user" id="user" placeholder="ingrese su usuario aqui">
                <label for=""><h3>Contraseña</h3></label>
                <input type="password" name="password" id="password" placeholder="ingrese su contraseña aqui">
            </div>
            <div class="button__container_2">
                <input type="submit" name="btningresar" value="iniciar sesion">
            </div>
            </form>
        </div>
    </div>
    
</body>
</html>