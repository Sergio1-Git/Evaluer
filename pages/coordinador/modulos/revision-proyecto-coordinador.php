<?php
include("../../../model/conexion.php");
session_start();
error_reporting(0);
$variable_sesion = $_SESSION['usuario'];

if ($variable_sesion == null || $variable_sesion = '') {
    header("location: ../index.php");
    die();
}
include("../../../controller/nombre.php");
?>

<!doctype html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="../../../evaluer.ico">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Asignar asesor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/unicons.css">
    <link rel="stylesheet" href="../../../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../../../css/owl.theme.default.min.css">
    <link rel="stylesheet" href="../../../utilities/loading/carga.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- MAIN STYLE -->
    <link rel="stylesheet" href="../../../css/rev-proyecto-coordinador.css">
    <link rel="stylesheet" href="../../../css/header.css">
    <link rel="stylesheet" href="../../../css/scrollbar.css">
</head>

<body>
    <!-- Pantalla de carga -->
    <div id="contenedor_carga">
        <div id="carga"></div>
    </div>
    <!-- MENU -->
    <nav class="navbar navbar-expand-sm navbar-light">
        <img src="../../../img/aunar.png" class="aunar_logo">
        <a class="navbar-brand" href="../index.php"><img class="logo" src="../../../img/logo_p.png"></a>
        <div class="container">

            <div class="collapse navbar-collapse" id="navbarNav">
                <h3>COORDINADOR</h3>
                <ul class="navbar-nav mx-auto">

                </ul>
                <ul class="log">
                    <li>
                        <a class="navbar-brand" href=""><i class='uil uil-user'></i><label for=""><?php echo $nombre_usuario ?></label></a>
                        <ul>
                            <li><a class="out" href="">Perfil</a></li>
                            <li><a class="out" href="../../../support/account.php">Cambiar contrase??a</a></li>
                            <li><a class="out" href="../../../controller/Logout.php">Cerrar sesi??n</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <h3 class="title">Historial de proyectos de grado</h3>
    <div class="contenedor-titulo">
        <table id="tabla" class="ent">
            <thead>
                <tr>
                    <th>#</th>
                    <th>T??tulo</th>
                    <th>Archivo</th>
                    <th>Programa</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th hidden>Acci??n</th>
                </tr>
            </thead>

            <?php
            $mostrar_by_fecha = "SELECT * FROM proyecto_grado ORDER BY fecha";
            $result = mysqli_query($conexion, $mostrar_by_fecha);

            while ($filas = mysqli_fetch_array($result)) {
                $id_registro = $filas['0'];
            ?>
                <tr>
                    <form action="../../../controller/evaluate-proyecto.php" method="POST">
                        <td><?php echo $filas['0']; ?></td>
                        <td><?php echo $filas['titulo']; ?></td>
                        <td><a href="<?php echo $filas['documento']; ?>" target="_blank"><?php echo $filas['nombre']; ?></a></td>
                        <td><?php echo $filas['programa']; ?></td>
                        <td><?php echo $filas['fecha']; ?></td>
                        <td><input type="text" name="estado" readonly value="<?php echo $filas['estado'] ?>" style="text-transform:uppercase;"></td>

                        <td hidden>
                            <input name="getIdProyecto" type="text" hidden value="<?php echo $filas['0'] ?>">
                            <input type="submit" name="evaluar" value="Evaluar" class="btn-nota">

                            <script>
                                // $("#tabla").click(function() {
                                //     $("#resultados").submit();
                                // });
                            </script>
                        </td>
                    </form>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
    <script src="../../../utilities/loading/load.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/popper.min.js"></script>
    <script src="../../../js/bootstrap.min.js"></script>
    <script src="../../../js/Headroom.js"></script>
    <script src="../../../js/jQuery.headroom.js"></script>
    <script src="../../../js/owl.carousel.min.js"></script>
    <script src="../../../js/smoothscroll.js"></script>
    <script src="../../../js/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

</body>

</html>