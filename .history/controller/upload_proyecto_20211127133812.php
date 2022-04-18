<?php

include("../model/conexion.php");
include_once 'nombre.php';

if (isset($_POST['enviar'])) {
    $fecha = $_POST['fecha'];
    $nombre = $_FILES['archivo']['name'];
    $guardado = $_FILES['archivo']['tmp_name'];

    $nombre_final =  date("d-m-y") . "-" . date("H:m:s") . "-" . $nombre;
    $ruta = "../files/proyectos_de_grado/" . $nombre_final;

    if (!file_exists('../files/proyectos_de_grado')) {
        mkdir('../files/proyectos_de_grado', 0777, true);
        if (file_exists('../files/proyectos_de_grado')) {
            if (move_uploaded_file($guardado, '../files/proyectos_de_grado/' . $nombre)) {

                include_once("../pages/estudiante/proyecto-final-estudiante.php");
            } else {
                echo "Archivo no se pudo guardar";
            }
        }
    } else {
        if (move_uploaded_file($guardado, '../files/proyectos_de_grado/' . $nombre)) {
            // Se inserta la dirección y detalles del archivo enviado
            $conexion->query("INSERT INTO proyecto_grado(nombre,documento,remitente,fecha) VALUES('$nombre','$ruta','" . $_SESSION['usuario'] . "','$fecha')");

            $conexion->query("UPDATE proyecto_grado p
            JOIN estudiante es ON p.remitente = es.usuario 
            SET p.programa_id = es.programa_id");

            $conexion->query("UPDATE proyecto_grado p
            JOIN estudiante es ON p.programa_id = es.programa_id 
            SET p.programa = es.programa");

            include("../pages/main-estudiante.php");
?>
            <p style="position: absolute; padding: 10px;border-radius: 10px; top: 20%; left: 650px;opacity: 1;
            text-align: center; width: 20%; background: #abff96; color: #1e9700; border: 1px #1e9700 solid;" id="success">Archivo enviado con éxito</p>
            <script>
                setTimeout(function() {
                    $('#success').fadeOut('fast');
                }, 2000); // <-- time in milliseconds
            </script>
        <?php
        } else {
        ?>
            <p style="position: absolute; padding: 10px;border-radius: 10px; top: 20%; left: 650px;opacity: 1;
		text-align: center; width: 14%; background: rgb(255, 133, 133); color: rgb(184, 0, 0); border: 1px #1e9700 solid;" id="fail">No se envió el archivo</p>
            <script>
                setTimeout(function() {
                    $('#fail').fadeOut('fast');
                }, 2000); // <-- time in milliseconds
            </script>
<?php
        }
    }
}
