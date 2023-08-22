<?php
include("../../conexion_bd.php");

function recuperar_cuestionario($nombre_usuario, $id_cuestionario) {
    global $conexion;
    $sql = "SELECT c.titulo, c.descripcion
            FROM cuestionarios c
            INNER JOIN usuario_cuestionario uc ON c.id = uc.cuestionario_id
            WHERE uc.usuario_id = '$nombre_usuario' AND c.id = $id_cuestionario";
    $resultado = $conexion->query($sql);
    if ($resultado->num_rows > 0) {
        echo "<style>
                .pregunta { margin: 5px 0;}
                .opcion { margin: 5px 0; padding-left: 20px;}
                input[type='radio'] { margin-right: 5px; }
              </style>";
        while($row = $resultado->fetch_assoc()) {
            echo "<div class='cuestionario'><b><h1>".$row["titulo"]."</h1></b>" .
            "<br><h3>" ."Descripcion: " . $row["descripcion"]. "</h3><br></div>";
        }
    } else {
        echo "No se encontraron resultados";
    }
}

$orden_opciones = [];

function recuperar_preguntas($nombre_usuario, $id_cuestionario) {
    global $conexion, $orden_opciones;
    $sql = "SELECT p.texto_pregunta, o.texto, o.id
        FROM preguntas p
        INNER JOIN opciones o ON p.id = o.pregunta_id
        INNER JOIN cuestionarios c ON p.cuestionario_id = c.id
        INNER JOIN usuario_cuestionario uc ON c.id = uc.cuestionario_id
        WHERE uc.usuario_id = '$nombre_usuario' AND c.id = $id_cuestionario
        ORDER BY p.id, RAND()";
    $resultado = $conexion->query($sql);
    if ($resultado->num_rows > 0) {
        $preguntas = [];
        while($row = $resultado->fetch_assoc()) {
            if (!isset($preguntas[$row["texto_pregunta"]])) {
                $preguntas[$row["texto_pregunta"]] = [];
            }
            $preguntas[$row["texto_pregunta"]][] = ["texto" => $row["texto"], "id" => $row["id"]];
        }
        // Almacenar el orden inicial de las opciones
        foreach ($preguntas as $texto_pregunta => $opciones) {
            foreach ($opciones as $opcion) {
                $orden_opciones[] = $opcion["id"];
            }
        }
        // Mostrar las preguntas y opciones
        $incrementador = 1;
        foreach ($preguntas as $texto_pregunta => $opciones) {
            echo "<div class='pregunta' style='color:#352F44;'><b>".$incrementador++.". ¿".$texto_pregunta."</b></div><br>";
            foreach ($opciones as $opcion) {
                echo "<div class='opcion'><input type='radio' name='$texto_pregunta' value='".$opcion["id"]."'required>".$opcion["texto"]."</div><br>";
            }
        }
    } else {
        echo "No se encontraron resultados";
    }
}
?>
