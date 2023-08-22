<?php
include("conexion_bd.php");

if (isset($_POST['nombre_usuario']) && isset($_POST['id_cuestionario'])) {
    $nombre_usuario = $_POST['nombre_usuario'];
    $id_cuestionario = $_POST['id_cuestionario'];
    reiniciar_formulario($nombre_usuario);
}

function reiniciar_formulario($nombre_usuario) {
    global $conexion;
    // Eliminar las respuestas previas del usuario
    $sql = "DELETE FROM respuestas WHERE usuario_id = '$nombre_usuario'";
    $conexion->query($sql);
}
?>
