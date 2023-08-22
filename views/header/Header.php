<?php
if (!isset($_SESSION['usuario_id'])) {
    // El usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
    header("location:../Login/index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../header.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="header">
        <div><h4>Cuestionario de preguntas</h4></div>
        <button id="logoutBoton" class="buttonLogout"><h4>Cerrar sesion</h4></button>
    </div>

    <script>
        $("#logoutBoton").click(function() {
            $.ajax({
                url: "../../logout.php",
                type: "POST",
                success: function(){
                    window.location.href="../Login/index.php"
                }
            });
            console.log("se ejecuto correctamente")
        });
    </script>
</body>
</html>
