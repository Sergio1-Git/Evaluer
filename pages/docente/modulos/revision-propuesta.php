<?php
include("../../../model/conexion.php");
session_start();
error_reporting(0);
$variable_sesion = $_SESSION['usuario'];

if ($variable_sesion == null || $variable_sesion = '') {
    // echo "NO TIENE AUTORIZACIÓN";
    header("location: ../../../index.php");
    die();
}
include_once  '../../../controller/nombre.php';
?>
<!doctype html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="../../../evaluer.ico">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Propuestas</title>

    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/unicons.css">
    <link rel="stylesheet" href="../../../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../../../css/owl.theme.default.min.css">
    <link rel="stylesheet" href="../../../utilities/loading/carga.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <!-- MAIN STYLE -->
    <link rel="stylesheet" href="../../../css/revision-propuesta.css">

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

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <h3>DOCENTE</h3>
                <ul class="navbar-nav mx-auto">

                </ul>
                <ul class="log">
                    <li>
                        <a class="navbar-brand" href=""><i class='uil uil-user'></i>
                            <?php echo $nombre_usuario;
                            ?></a>
                        <ul>
                            <li><a class="out" href="">Perfil</a></li>
                            <li><a class="out" href="../../../support/change-password.php">Cambiar contraseña</a></li>
                            <li><a class="out" href="../../../controller/logout.php">Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="lista-propuestas">
        <h3>Propuestas de grado</h3>
        <label>Filtro de busqueda:</label>
        <div class="search-registro">
            <div class="contenedor">
                <input type="search" id="search" placeholder="Search..." />
                <button class="icon" name="buscar"><i class="fa fa-search"></i></button>
            </div>
        </div>
        <div class="contenedor-titulo">
            <table class="">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th hidden>Linea de investigación</th>
                        <th>No. integrantes</th>
                        <th hidden>Asesor</th>
                        <th hidden>Lider</th>
                        <th>Programa</th>
                        <th>Semestre</th>
                        <th hidden>Descripción</th>
                        <th>Fecha y hora</th>
                        <th>Calificación</th>
                        <th>Acción</th>
                        <th hidden>Programa_id</th>
                    </tr>
                </thead>
                <tbody id="contenido_tabla">
                    <?php
                    $buscar = "SELECT * FROM docente WHERE usuario =" . $_SESSION['usuario'];
                    $dato = mysqli_query($conexion, $buscar);
                    $registro = mysqli_fetch_array($dato);
                    ?>

                    <?php
                    $mostrar_by_fecha = "SELECT * FROM propuesta WHERE programa_id=" . $registro['programa_id'] . " ORDER BY fecha";
                    $result = mysqli_query($conexion, $mostrar_by_fecha);

                    while ($filas = mysqli_fetch_array($result)) {
                        $id_registro = $filas['id'];
                    ?>
                        <tr>
                            <td style="max-width: 600px;"><?php echo $filas['titulo'] ?></td>
                            <td hidden><?php echo $filas['linea'] ?></td>
                            <td style="text-align: center;"><?php echo $filas['integrantes'] ?></td>
                            <td hidden><?php echo $filas['tutor'] ?></td>
                            <td hidden><?php echo $filas['lider'] ?></td>
                            <td><?php echo $filas['programa'] ?></td>
                            <td style="text-align: center;"><?php echo $filas['semestre'] ?></td>
                            <td hidden><?php echo $filas['descripcion'] ?></td>
                            <td hidden><?php echo $filas['grupo'] ?></td>
                            <td><?php echo $filas['fecha'] ?></td>
                            <form action="../../../controller/evaluate-propuesta.php" method="POST">
                                <td id="celdaCalif">
                                    <input type="text" name="getIdPropuesta" hidden value="<?php echo $filas['id'] ?>">
                                    <input type="text" class="estado" name="estado" style="text-transform:uppercase;" value="<?php echo $filas['estado'] ?>">
                                </td>
                                <td>
                                    <input name="id_p" type="text" hidden value="<?php echo $filas['id'] ?>">

                                    <button class="editbtn" type="button" data-target="#panel-propuesta">
                                        <button type="button" class="editbtn btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            Ver
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="linea">
                                                            <label class="lbl-linea">Linea de investigación:</label>
                                                            <p id="linea"></p>
                                                        </div>
                                                        <div class="programa">
                                                            <label class="lbl-programa">Programa:</label>
                                                            <p id="program"></p>
                                                        </div>
                                                        <div class="semestre">
                                                            <label class="lbl-semestre">Semestre:</label>
                                                            <p id="semestre"></p>
                                                        </div>
                                                        <div class="integrantes">
                                                            <label class="lbl-integrantes">Número de integrantes:</label>
                                                            <p id="num"></p>
                                                        </div>
                                                        <div class="tutor">
                                                            <label class="lbl-tutor">Nombre del asesor:</label>
                                                            <p id="tutor"></p>
                                                        </div>
                                                        <div class="lider">
                                                            <label class="lbl-lider">Nombre del lider:</label>
                                                            <p id="lid"></p>
                                                        </div>
                                                        <div class="descripcion">
                                                            <label>Descripción:</label>
                                                            <textarea name="lider" readonly id="descrip" cols="30" rows="4" name="description" value=""></textarea>
                                                        </div>
                                                        <div class="equipo">
                                                            <label class="lbl-equipo">Nombre de los integrantes:</label>
                                                            <p id="n_integrantes"></p>
                                                        </div>
                                                        <div class="dat">
                                                            <label class="lbl-fecha">Fecha y hora:</label>
                                                            <p id="time"></p>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                    <!-- | -->
                                    <input hidden type="submit" name="calificar" value="Calificar" class="btn-estado" id="calificarN">
                                </td>
                            </form>
                            <td hidden><?php echo $filas['programa_id'] ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const myModal = document.getElementById('myModal');
        const myInput = document.getElementById('myInput');

        myModal.addEventListener('shown.bs.modal', () => {
            myInput.focus();
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#contenido_tabla tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>

    <script>
        $('.editbtn').on('click', function() {
            $tr = $(this).closest('tr');
            var datos = $tr.children("td").map(function() {
                return $(this).text();
            });
            $('#exampleModalLabel').html(datos[0]);
            $('#linea').html(datos[1]);
            $('#num').html(datos[2]);
            $('#tutor').html(datos[3]);
            $('#lid').html(datos[4]);
            $('#program').html(datos[5]);
            $('#semestre').html(datos[6]);
            $('#descrip').html(datos[7]);
            $('#n_integrantes').html(datos[8]);
            $('#time').html(datos[9]);

        });
    </script>
    <script src="../../../utilities/loading/load.js"></script>
    <script src="../../../font/9390efa2c5.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>

    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/popper.min.js"></script>
    <script src="../../../js/bootstrap.min.js"></script>
    <script src="../../../js/Headroom.js"></script>
    <script src="../../../js/jQuery.headroom.js"></script>
    <script src="../../../js/owl.carousel.min.js"></script>
    <script src="../../../js/smoothscroll.js"></script>
    <script src="../../../js/custom.js"></script>

</body>

</html>