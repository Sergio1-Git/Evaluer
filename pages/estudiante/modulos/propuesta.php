<?php

include_once("../../../model/Metodos.php");
include("../../../model/UserModel.php");
$obj = new User();


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

    <title>Propuesta de grado</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/unicons.css">
    <link rel="stylesheet" href="../../../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../../../css/owl.theme.default.min.css">
    <link rel="stylesheet" href="../../../utilities/loading/carga.css">
    <!-- MAIN STYLE -->
    <link rel="stylesheet" href="../../../css/propuesta.css">
    <link rel="stylesheet" href="../../../css/scrollbar.css">
    <link rel="stylesheet" href="../../../css/header.css">
    <link rel="stylesheet" href="../../../css/scrollbar.css">
    <link rel="stylesheet" href="../../../font/fontawesome-free-6.1.1-web/css/all.css">

    <script src="../../../font/fontawesome-free-6.0.0-web/js/solid.js"></script>
    <script src="../../../font/fontawesome-free-6.0.0-web/js/solid.min.js"></script>
    <script src="../../../font/fontawesome-free-6.0.0-web/js/brands.js"></script>
    <script src="../../../font/fontawesome-free-6.0.0-web/js/brands.min.js"></script>
    <script src="../../../font/9390efa2c5.js"></script>

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
    <div class="grid-view">
        <div class="formulario">
            <form action="../../../controller/send-propuesta.php" method="POST" id="envio">
                <div class="seccion-inscripcion">
                    <div class="grid-form">
                        <?php
                        $res = new Metodos();
                        $fecha = date("Y-m-d H:i:s");
                        $getTime = $res->restrictPropuesta();
                        ?>
                        <div class="subtitulo">
                            <i class="fas fa-network-wired"></i>
                            <h3 class="">Propuesta de grado</h3>
                        </div>
                        <p class="info">
                            Diligencie la informaci??n correspondiente a su propuesta de grado, con los datos requeridos para evaluar un anteproyecto.
                        </p>

                        <label class="lbl-titulo">T??tulo del proyecto:</label>
                        <div class="titulo" id="contenedorInput">
                            <input class="" <?php echo (time() < $getTime) ? "disabled" : ''; ?> type="text" class="campotexto" name="titulo">
                            <i class="fa-solid fa-font"></i>
                        </div>

                        <label class="lbl-linea">Linea de investigaci??n:</label>
                        <div class="linea" id="contenedorInput">
                            <input class="" <?php echo (time() < $getTime) ? "disabled" : ''; ?> type="text" class="campotexto" name="linea">
                            <i class="fa-solid fa-diagram-project"></i>
                        </div>


                        <label class="lbl-asesor">Nombre del asesor:</label>
                        <div class="asesor" id="contenedorInput">
                            <input class="" <?php echo (time() < $getTime) ? "disabled" : ''; ?> type="text" class="campotexto" name="tutor">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>

                        <label class="lbl-lider">Nombre del lider:</label>
                        <div class="lider" id="contenedorInput">
                            <input class="" <?php echo (time() < $getTime) ? "disabled" : ''; ?> type="text" class="campotexto" name="lider">
                            <i class="fa-solid fa-user-pen"></i>
                        </div>

                        <label class="lbl-programa">Programa:</label>
                        <div class="programa" id="contenedorInput">
                            <select class="" name="id_programa[]">
                                <?php
                                $buscar_programa = "SELECT programa,programa_id,semestre FROM estudiante WHERE usuario =" . $_SESSION['usuario'];
                                $datos = $res->listar($buscar_programa);

                                foreach ($datos as $p_selected) {
                                    echo '<option selected value="' . $p_selected['programa_id'] . '">' . $p_selected['programa'] . '</option>';
                                }
                                ?>
                            </select>
                            <i class="fa-solid fa-list-ol"></i>
                        </div>
                        <label class="lbl-semsetre">Semestre:</label>
                        <div class="semestre" id="contenedorInput">
                            <input class="" readonly type="number" max="9" min="1" class="camponumero" id="disable" name="semestre" value="<?php echo $p_selected['semestre']; ?>">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <div class="descripcion">
                            <label>Descripci??n:</label>
                            <textarea <?php echo (time() < $getTime) ? "disabled" : ''; ?> cols="30" rows="6" name="description"></textarea>
                            <i class="fa-solid fa-rectangle-list"></i>
                        </div>
                    </div>
                </div>
                <div class="miembros">
                    <h3><i class="bi bi-people-fill"></i> Equipo</h3>
                    <label>N??mero de integrantes:</label>
                    <div id="contenedorInput">
                        <select id="listaIntegrantes" name="listaIntegrantes">
                            <option value="0">Selecciona una opcion</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <label>Nombre del integrante #1:</label>
                    <div id="contenedorInput">
                        <input class="" <?php echo (time() < $getTime) ? "disabled" : ''; ?> type="text" class="campotexto" name="miembro1">
                        <i class="fa-solid fa-user-pen"></i>
                    </div>
                    <div id="interacion"></div>
                </div>

                <div class="contenedor-btn">
                    <input type="datetime" name="fecha" hidden value="<?php echo $fecha; ?>">
                    <input <?php echo (time() < $getTime) ? "disabled" : ''; ?> type="submit" name="send" value="Enviar" class="btn-enviar btn btn-primary mb-4">
                </div>
            </form>
        </div>
        <form method="GET">
            <div class="details">
                <label><i class="fas fa-bell"></i> Detalles y notificaciones</label>

                <?php
                $listar = "SELECT * FROM propuesta WHERE remitente =" . $_SESSION['usuario'] . " ORDER BY fecha";
                $prop = $res->listar($listar);
                if ($prop >= 1) {
                    if (time() < $getTime) {
                ?>
                        <div class="noti">
                            <div><i style="font-size: 20px;" class="bi bi-info-circle-fill"></i> Su propuesta ha sido enviada</div>
                        </div>
                    <?php
                    }
                    foreach ($prop as $propuesta_state) {
                    ?>
                        <div class="notif">
                            <input hidden type="text" name="remitente" value="<?php echo $propuesta_state['remitente']; ?>">
                            <div> <label><?php echo $propuesta_state['titulo'] ?></label> </div>
                            <div class="action-edit">
                                <a href=""><i class="edit fas fa-edit"></i></a>
                            </div>
                            <div class="action-delete">
                                <a href="../../../controller/eliminar-propuesta.php?remitente=<?php echo $propuesta_state['remitente'] ?>"><i class="trash fas fa-trash-alt"></i></a>
                            </div>
                            <div>
                                <p class="<?php echo $propuesta_state['estado'] === 'aprobada' ? 'aprobada' : 'reprobada'; ?>">Estado: <?php echo $propuesta_state['estado']; ?></p>
                            </div>
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <div class="nothing">
                        <div><i style="font-size: 20px;" class="bi bi-info-circle-fill"></i> No hay notificaciones por el momento</div>
                    </div>
                <?php
                }
                ?>
            </div>
        </form>
    </div>
    <script src="../../../js/jquery-3.3.1.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // var second_select = document.getElementById('second-select').value;
            // $('#listaIntegrantes').val(1);
            recargarLista();

            $('#listaIntegrantes').change(function() {
                recargarLista();
            });
        })
    </script>
    <script type="text/javascript">
        function recargarLista() {
            $.ajax({
                type: "POST",
                url: "../../../utilities/datosInt.php",
                data: "numero=" + $('#listaIntegrantes').val(),
                success: function(r) {
                    $('#interacion').html(r);
                }
            });
        }
    </script>
    <script src="../../../utilities/loading/load.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
</body>

</html>