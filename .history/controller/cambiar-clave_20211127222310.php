<?php

include("../model/conexion.php");

if (isset($_POST['cambiar'])) {

    $usuario = $_POST['user'];
    $clave_actual = $_POST['c_actual'];
    $nueva = $_POST['clave'];
    $repetir_nueva = $_POST['clave2'];

    if ($nueva == $repetir_nueva) {
        $conexion->query("UPDATE usuarios SET contraseña ='$nueva' WHERE usuario = '$usuario'");
?>
        <p style="position: absolute; padding: 10px;border-radius: 10px; top: 20%; left: 650px;opacity: 1;
		text-align: center; width: 20%; background: #abff96; color: #1e9700; border: 1px #1e9700 solid;" id="success">Cambios guardados con éxito</p>
        <script>
            setTimeout(function() {
                $('#success').fadeOut('fast');
            }, 2000); // <-- time in milliseconds
        </script>
<?php
        $consulta_rol = $conexion->query("SELECT * FROM usuarios WHERE usuario = '$usuario'");
        $tupla = mysqli_fetch_array($consulta_rol);

        if ($tupla['id_rol'] == 1) {
            include("../admin/index.php");
        } else if ($tupla['id_rol'] == 2) {
            include("../pages/main-coordinador.php");
        } else if ($tupla['id_rol'] == 3) {
            include("../pages/main-estudiante.php");
        } else if ($tupla['id_rol'] == 4) {
            include("../pages/main-docente.php");
        }
        mysqli_close($conexion);
    } else {
    }
}

?>