<?php
// Conectar a la base de datos
include("../../conexion_bd.php");
// Este es el archivo procesar_respuestas.php que procesará los datos del formulario

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar el ID del usuario
    $usuario_id = $_SESSION['usuario_id'];
    
    // Verificar si el usuario ya ha enviado respuestas para este cuestionario
    $sql = "SELECT COUNT(*) as num_respuestas FROM respuestas WHERE usuario_id = $usuario_id";
    $resultado = $conexion->query($sql);
    $row = $resultado->fetch_assoc();
    if ($row['num_respuestas'] > 0) {
        // El usuario ya ha enviado respuestas para este cuestionario
        // No insertar nuevas respuestas en la tabla "respuestas"
    }else if($row['num_respuestas'] <= 0){
        // El usuario no ha enviado respuestas para este cuestionario
        // Insertar las respuestas en la tabla "respuestas"
        // Recuperar los valores de las opciones seleccionadas
        $opcion1 = $_POST["Cual_es_la_capital_de_Colombia?"];
        $opcion2 = $_POST['Quien_escribio_Cien_years_de_soledad?'];
        $opcion3 = $_POST['Cual_es_el_rio_mas_largo_del_mundo?'];
        $opcion4 = $_POST['En_que_year_comenzo_la_Segunda_Guerra_Mundial?'];
        $opcion5 = $_POST['Cual_es_el_planeta_mas_cercano_al_sol?'];
        
        // Insertar los valores en la tabla "respuestas"
        $sql = "insert into respuestas (usuario_id, pregunta_id, opcion_id) values
                ($usuario_id, 1, $opcion1),
                ($usuario_id, 2, $opcion2),
                ($usuario_id, 3, $opcion3),
                ($usuario_id, 4, $opcion4),
                ($usuario_id, 5, $opcion5)         
                ";
        $conexion->query($sql);
    }
}
function recuperar_preguntas_y_respuestas($nombre_usuario, $id_cuestionario) {
    global $conexion;
    $sql = "SELECT p.texto_pregunta, o.texto, o.id, r.opcion_id as respuesta_usuario, o.es_correcta
        FROM preguntas p
        INNER JOIN opciones o ON p.id = o.pregunta_id
        INNER JOIN cuestionarios c ON p.cuestionario_id = c.id
        INNER JOIN usuario_cuestionario uc ON c.id = uc.cuestionario_id
        LEFT JOIN respuestas r ON p.id = r.pregunta_id AND r.usuario_id = uc.usuario_id
        WHERE uc.usuario_id = '$nombre_usuario' AND c.id = $id_cuestionario
        ORDER BY p.id, RAND()";
    $resultado = $conexion->query($sql);
    if ($resultado->num_rows > 0) {
        $preguntas = [];
        while($row = $resultado->fetch_assoc()) {
            if (!isset($preguntas[$row["texto_pregunta"]])) {
                $preguntas[$row["texto_pregunta"]] = [];
            }
            $preguntas[$row["texto_pregunta"]][] = ["texto" => $row["texto"], "id" => $row["id"], "respuesta_usuario" => $row["respuesta_usuario"], "es_correcta" => $row["es_correcta"]];
        }
        // Calcular el puntaje del usuario
        $puntaje = 0;
        foreach ($preguntas as $texto_pregunta => $opciones) {
            foreach ($opciones as $opcion) {
                if ($opcion["id"] == $opcion["respuesta_usuario"] && $opcion["es_correcta"]) {
                    // La respuesta es correcta
                    $puntaje += 1;
                }
            }
        }
        echo "<div><b>Puntaje: </b>$puntaje</div><br>";
        // Mostrar las preguntas y opciones
        foreach ($preguntas as $texto_pregunta => $opciones) {
            echo "<div class='pregunta'><b>¿".$texto_pregunta."</b></div><br>";
            foreach ($opciones as $opcion) {
                if ($opcion["id"] == $opcion["respuesta_usuario"]) {
                    if ($opcion["es_correcta"]) {
                        // La respuesta es correcta
                        echo "<div class='opcion' style='background-color: lightgreen; color: darkgreen;'><input type='radio' name='$texto_pregunta' value='".$opcion["id"]."' checked disabled>".$opcion["texto"]."<div>Es la correcta</div></div><br>";
                    } else {
                        // La respuesta es incorrecta
                        echo "<div class='opcion' style='background-color: lightcoral; color: darkred;'><input type='radio' name='$texto_pregunta' value='".$opcion["id"]."' checked disabled>".$opcion["texto"]."<div>Es incorrecta</div></div><br>";
                    }
                } else {
                    if ($opcion["es_correcta"]) {
                        // La respuesta es correcta pero no fue seleccionada por el usuario
                        echo "<div class='opcion' style='color: darkgreen;'><input type='radio' name='$texto_pregunta' value='".$opcion["id"]."' disabled>".$opcion["texto"]."<div>Es la correcta</div></div><br>";
                    } else {
                        // La respuesta es incorrecta y no fue seleccionada por el usuario
                        echo "<div class='opcion'><input type='radio' name='$texto_pregunta' value='".$opcion["id"]."' disabled>".$opcion["texto"]."</div><br>";
                    }
                }
            }
        }
    } else {
        echo "No se encontraron resultados";
    }
}


?>

