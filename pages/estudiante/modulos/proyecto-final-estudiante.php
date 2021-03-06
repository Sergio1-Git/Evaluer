<?php
include_once("../../../model/Metodos.php");
include("../../../model/UserModel.php");
$obj = new User();
$res = new Metodos();
session_start();
error_reporting(0);
$sesion = $_SESSION['usuario'];
$getProfile = $obj->getProfileUser();
$userP = mysqli_fetch_array($getProfile);

if ($sesion == null || $sesion = '') {
    header("location: ../../../index.php");
    die();
}
?>
<!doctype html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="../../../evaluer.ico">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Subir Proyecto de Grado</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/unicons.css">
    <link rel="stylesheet" href="../../../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../../../css/owl.theme.default.min.css">
    <link rel="stylesheet" href="../../../utilities/loading/carga.css">
    <!-- MAIN STYLE -->
    <link rel="stylesheet" href="../../../css/proyecto-estudiante.css">
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

        <div class="collapse navbar-collapse" id="navbarNav">
            <h3>ESTUDIANTE</h3>
            <ul class="navbar-nav mx-auto">
                <li class="principal">
                    <a href="../index.php" class="nav-link"><span data-hover="Principal"><label for="">Principal</label></a>
                </li>
                <li class="fecha">

                </li>
            </ul>

            <ul class="log">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img style="width: 40px; height: 40px; border-radius: 50%;" src="../../../files/photos/<?php echo $userP['foto'] == null ? 'default.png' :  $userP['foto']; ?>" alt="">
                        <?php echo $userP['nombre']; ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Perfil</a></li>
                        <li><a class="dropdown-item" href="../../../support/account.php">Cambiar contrase??a</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../../../controller/Logout.php">Cerrar sesi??n</a></li>
                    </ul>
                </li>
            </ul>
        </div>

    </nav>

    <form action="../../../controller/upload_proyecto.php" method="POST" enctype="multipart/form-data">
        <div class="format">
            <div class="cont-titulo">
                <h3 class="titulo1">Subir proyecto de grado</h3>
            </div>
            <div class="seccion-proyecto">

                <div class="detalles">
                    <div style="display: flex;">
                        <i class="activity fas fa-chalkboard-teacher"></i>
                        <p>Adjuntar la entrega del proyecto de grado en este espacio.</p>
                    </div>
                    <label for="">Descripci??n:</label>
                    <label for="">Fecha de entrega:</label>
                </div>
                <div class="archivo">
                    <div class="container-input">
                        <?php
                        $fecha = date("Y-m-d H:i:s");
                        $getTime = $res->restrictProyecto();
                        ?>
                        <input type="file" name="archivo" <?php echo (time() < $getTime) ? "disabled" : ''; ?> id="file-5" class="inputfile inputfile-5" data-multiple-caption="{count} archivos seleccionados" multiple />
                        <label for="file-5">
                            <figure>
                                <svg xmlns="http://www.w3.org/2000/svg" class="iborrainputfile" width="20" height="17" viewBox="0 0 20 17">
                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                                </svg>
                            </figure>
                            <span class="iborrainputfile">Seleccionar archivo</span>
                        </label>
                    </div>
                    <input type="datetime" name="fecha" hidden value="<?php echo $fecha; ?>">
                    <input type="submit" <?php echo (time() < $getTime) ? "disabled" : ''; ?> value="Enviar" name="enviar" class="btn-enviar">
                </div>
            </div>
            <div class="cont-titulo">
                <h3 class="titulo2">Entregas</h3>
            </div>
            <div class="historial">
                <?php
                $listarP = "SELECT * FROM proyecto_grado WHERE remitente =" . $_SESSION['usuario'] . " ORDER BY fecha";
                $data = $res->listar($listarP);
                foreach ($data as $archivados) {
                ?>
                    <div class="cont-entregas">
                        <div class="detalle_entrega">
                            <i class="fas fa-file-alt"></i>
                            <div class="datos">
                                <a href="../<?php echo $archivados['documento'] ?>" download="<?php echo $archivados['nombre'] ?>"><?php echo $archivados['nombre'] ?></a>
                                <label>Fecha: <?php echo $archivados['fecha'] ?></label>
                            </div>
                            <div class="evaluacion">
                                <label for="">Estado: <?php echo $archivados['estado'] ?></label>
                                <label for="">Calificaci??n: <?php echo $archivados['calificacion'] ?></label>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="guia_arbol">
                <ul>
                    <li>
                        <i class="fas fa-folder" style="margin-right: 3px;"></i><label>Guia de investigaci??n</label>
                        <ul>
                            <li>
                                <i class="fas fa-file-alt"></i>
                                <a href="">Propuesta de grado</a>
                            </li>
                            <li>
                                <i class="fas fa-file-alt"></i>
                                <a href="">Anteproyecto</a>
                            </li>
                            <li>
                                <i class="fas fa-file-alt"></i>
                                <a href="../../../guide/guia_ing.pdf" download="Guia_proyecto_inv_ing.pdf">Proyecto de grado</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </form>
    <script>
        'use strict';

        ;
        (function(document, window, index) {
            var inputs = document.querySelectorAll('.inputfile');
            Array.prototype.forEach.call(inputs, function(input) {
                var label = input.nextElementSibling,
                    labelVal = label.innerHTML;

                input.addEventListener('change', function(e) {
                    var fileName = '';
                    if (this.files && this.files.length > 1)
                        fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
                    else
                        fileName = e.target.value.split('\\').pop();

                    if (fileName)
                        label.querySelector('span').innerHTML = fileName;
                    else
                        label.innerHTML = labelVal;
                });
            });
        }(document, window, 0));
    </script>
    <?php
    if (time() < $getTime) {
    ?>
        <div id="fail" class="alert alert-danger" role="alert" style="z-index: 9999999999999999; position:absolute; top:2%;
  				left: 50%;
  				transform: translate(-50%, 0%);">
            No puedes enviar archivos hasta la proxima fecha, en 15 d??as
        </div>
        <script>
            setTimeout(function() {
                $('#fail').fadeOut('fast');
            }, 7000); // <-- time in milliseconds
        </script>
    <?php
    }
    ?>
    <script src="../../../utilities/loading/load.js"></script>
    <script src="../../../font/9390efa2c5.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
</body>

</html>