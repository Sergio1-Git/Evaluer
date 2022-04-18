<?php
include("../../model/conexion.php");
session_start();
error_reporting(0);

$variable_sesion = $_SESSION['usuario'];

if ($variable_sesion == null || $variable_sesion = '') {
    header("location: ../index.php");
    die();
}
<!doctype html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="../../evaluer.ico">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Modificar Estudiante</title>

    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/unicons.css">
    <link rel="stylesheet" href="../../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../../css/owl.theme.default.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- MAIN STYLE -->
    <link rel="stylesheet" href="../css/mod-est.css">
    <!-- <script src="../js/action/tab.js" defer></script> -->
</head>

<body>
    <!-- MENU -->
    <nav class="navbar navbar-expand-sm navbar-light">
        <img src="../../img/aunar.png" class="aunar_logo">
        <a class="navbar-brand" href="../index.php"><img class="logo" src="../../img/logo_p.png"></a>
        <div class="container">


            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <h3>ADMINISTRADOR</h3>
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                    </li>
                </ul>

                <ul class="log">
                    <li class="">
                        <a class="navbar-brand" href=""><i class='uil uil-user'></i><?php echo $_SESSION['usuario'] ?></a>
                        <ul>
                            <li><a class="out" href="">Perfil</a></li>
                            <li><a class="out" href="../../support/change-password.php">Cambiar contraseña</a></li>
                            <li><a class="out" href="../../controller/logout.php">Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- <div class="imagen_fondo"> -->
    <section class="alfa">
    <?php include("../../controller/modificar.php") ?>
        <form method="POST">
            <div class="formulario-edit-user">
                <h3>Modificar usuario</h3>
                <div class="fila">
                    <div><label>Nombre:</label></div><input type="text" class="campotexto" name="nombre" value="<?= $nombre ?>">
                    <div><label>Primer apellido:</label></div><input type="text" class="campotexto" name="p_apellido" value="<?= $p_apellido ?>">
                    <div><label>Segundo apellido:</label></div><input type="text" class="campotexto" name="s_apellido" value="<?= $s_apellido ?>">
                </div>
                <div class="fila">
                    <div><label>Documento de identidad:</label></div><input type="text" class="campotexto" name="cedula" value="<?= $id_n ?>">
                    <div><label>Programa:</label></div>
                    <select name="programa_id[]" class="programa-s">

                        <?php
                        $buscar_programa_seleccionado = "SELECT programa FROM estudiante WHERE cedula = '$id_n'";
                        $result = mysqli_query($conexion, $buscar_programa_seleccionado);
                        $dato = mysqli_fetch_array($result);
                        echo '<option selected value="' . $dato['0'] . '">' . $dato['0'] . '</option>';
                        ?>
                        <option value="1">Seleccione...</option>
                        <?php
                        $buscar_programa = "SELECT * FROM programas";
                        $resultado = mysqli_query($conexion, $buscar_programa);

                        while ($filas = mysqli_fetch_array($resultado)) {
                            echo '<option value="' . $filas['identificador'] . '">' . $filas['nombre'] . '</option>';
                        }
                        ?>
                    </select>
                    <div><label>Semestre:</label></div><input type="number" max="9" min="6" class="camponumero" name="semestre" value="<?= $semestre ?>">

                </div>
                <input type="text" hidden value="<?= $id ?>" name="id">
                <input type="submit" name="modificar-estudiante" class="btn-modificar" value="Guardar">
            </div>
        </form>
    </section>
    <!-- </div> -->
    <script src="../../js/jquery-3.3.1.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/Headroom.js"></script>
    <script src="../../js/jQuery.headroom.js"></script>
    <script src="../../js/owl.carousel.min.js"></script>
    <script src="../../js/smoothscroll.js"></script>
    <script src="../../js/custom.js"></script>

</body>

</html>