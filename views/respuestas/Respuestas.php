<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    // El usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
    header("location:../Login/index.php");
}
include("../header/header.php");
include("../../conexion_bd.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Respuesta.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
</head>
        <?php
        include("../../controllers/procesarRespuestas.php");
        include("../../controllers/controllerRespuestas.php");
        $nombre_usuario = $_SESSION['usuario_id'];
        $id_cuestionario = 1;
        recuperar_cuestionario($nombre_usuario, $id_cuestionario);
        recuperar_preguntas_y_respuestas($nombre_usuario, $id_cuestionario);
        ?>
<body>
<div>
<button id="boton-reiniciar" class="boton-reiniciar"><h4>Reintentar cuestionario</h4></button>
</div>
<script>
    $("#boton-reiniciar").click(function() {
    event.preventDefault()
    $.ajax({
        url: "../../reintentarCuestionario.php",
        type: "POST",
        data: {
            nombre_usuario: "<?php echo $_SESSION['usuario_id']; ?>",
            id_cuestionario: "1"
        },
        success: function(respuesta) {
            console.log(respuesta);
            window.location.href = "../Home/Home.php"
        }
    });
});

</script>

</body>
</html>