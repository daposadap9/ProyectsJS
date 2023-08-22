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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="home.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<form method="post" action="../respuestas/Respuestas.php">
    <?php
    include("../../controllers/controllerRespuestas.php");
    include("../../controllers/procesarRespuestas.php");
    // Recuperar el cuestionario para el usuario especificado
    $nombre_usuario = $_SESSION['usuario_id'];
    $id_cuestionario = 1;
    recuperar_cuestionario($nombre_usuario, $id_cuestionario);

    // Verificar si el usuario ya ha enviado respuestas para este cuestionario
    $sql = "SELECT COUNT(*) as num_respuestas FROM respuestas WHERE usuario_id = $nombre_usuario AND pregunta_id IN (SELECT id FROM preguntas WHERE cuestionario_id = $id_cuestionario)";
    $resultado = $conexion->query($sql);
    $row = $resultado->fetch_assoc();
    if ($row['num_respuestas'] > 0) {
        // El usuario ya ha enviado respuestas para este cuestionario
        // No mostrar el formulario de cuestionario
        // Mostrar las respuestas del usuario
        recuperar_preguntas_y_respuestas($nombre_usuario, $id_cuestionario);
        echo "<button id='boton-reiniciar2' class='boton-reiniciar2'><h4>Reintentar cuestionario</h4></button>";
    } else {
        // El usuario no ha enviado respuestas para este cuestionario
        // Mostrar el formulario de cuestionario
        recuperar_preguntas($nombre_usuario, $id_cuestionario);
        echo '<input class="buttonEnviar" type="submit" value="Enviar respuestas">';
    }
    ?>
    <script>
    $("#boton-reiniciar2").click(function() {
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
            location.reload();
        }
    });
    });
    </script>
</form>
</body>
</html>

