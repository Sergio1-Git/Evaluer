<?php
require_once 'db.php';
class User extends DataBase
{
    public function __construct()
    {
        parent::__construct();
    }

    //Obtener usuario para inicio de sesión
    public function getUser($username, $password)
    {
        $sql = "SELECT * FROM usuarios WHERE usuario = '$username'";
        $result = $this->con->query($sql);

        $numrows = $result->num_rows;

        // $contador = 0;
        $array = mysqli_fetch_array($result);
        if (($numrows == 1) && (password_verify($password, $array['contraseña']))) {
            if ($array) {
                // Condición para iniciar sesión con los diferentes roles de la plataforma
                if ($array['id_rol'] == 1) { //Administrador
                    header("location: admin/index.php");
                } else if ($array['id_rol'] == 2) { //Coordinador
                    header("location: pages/coordinador/index.php");
                } else if ($array['id_rol'] == 3) { //Estudiante
                    header("location: pages/estudiante/index.php");
                } else if ($array['id_rol'] == 4) { //Docente
                    header("location: pages/docente/index.php");
                } else {
                    header("index.php");
                }
            } else {
                echo '<div id="alerta" class="alert alert-danger" role="alert" style="z-index: 9999999999999999; position:absolute; top:2%;
             left: 50%;transform: translate(-50%, 0%);">
                 Usuario no existe
             </div>';
            }
            return true;
        } else {
            return false;
        }
    }

    public function getStudent()
    {
        $result = $this->con->query("SELECT * FROM estudiante");
        //convertir a arreglo $result
        $listaStudent = $result->fetch_all(MYSQLI_ASSOC);
        return $listaStudent;
    }
    public function listar($sql)
    {
        $result = $this->con->query($sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    /*
    Función para agregar un usuario a la base de datos de evaluer, acción que se
    ejecuta cuando el administrador digite los datos requeridos para crear un usuario
    con datos y credenciales de sesión.
    */
    public function createUser($nombre, $email, $usuario, $contraseña, $id_rol)
    {
        $new_user = "INSERT INTO usuarios(nombre,email,usuario,contraseña,id_rol)
        VALUES ('$nombre','$email','$usuario','$contraseña','$id_rol')";
        $this->con->query($new_user);

        mysqli_close($this->con);
    }

    /*
    Función para agregar un usuario de tipo estudiante a la base de datos, este posee atributos y datos
    que le permiten interactuar con el sistema de entregas en el campo de investigación.
    */
    public function agregarEstudiante($nombre, $p_apellido, $s_apellido, $cedula, $programa_id, $semestre, $usuario)
    {
        $this->con->query("INSERT INTO estudiante(nombre,p_apellido,s_apellido,programa_id,cedula,semestre,usuario,time_propuesta, time_anteproyecto, time_proyecto)
        VALUES ('$nombre','$p_apellido','$s_apellido','$cedula','$programa_id','$semestre','$usuario','100000000','100000000','100000000')");

        $this->con->query("UPDATE estudiante e
          JOIN programas p ON e.programa_id = p.identificador
          SET e.programa = p.nombre");

        // $this->con->query("UPDATE estudiante e
        //   JOIN usuarios u ON e.usuario = u.usuario
        //   SET e.id_usuario = u.id");
        mysqli_close($this->con);
    }
    /*
     
    */
    public function createCoordinador($nombre, $p_apellido, $s_apellido, $cedula, $programa_id, $usuario)
    {
        $coordinator = "INSERT INTO coordinador(nombres,p_apellido,s_apellido,cedula,programa_id,usuario)
                VALUES ('$nombre','$p_apellido','$s_apellido','$cedula','$programa_id','$usuario')";
        $this->con->query($coordinator);

        $this->con->query("UPDATE coordinador cr JOIN programas p
        ON cr.programa_id = p.identificador
        SET cr.programa = p.nombre");

        // $this->con->query("UPDATE coordinador cr
        // JOIN usuarios u ON cr.usuario = u.usuario
        // SET cr.id_usuario = u.id");

        mysqli_close($this->con);
    }
    /*
Función para agregar un usuario de tipo asesor de investigación a la base de datos, este posee atributos y
     datos que le permiten interactuar con el rol docente o asesor de seguimiento para el cumplimiento de las
     metas realizadas.
    */
    public function createAsesor($nombre, $p_apellido, $s_apellido, $cedula, $programa_id, $usuario)
    {
        $new_tutor = "INSERT INTO docente(nombres,p_apellido,s_apellido,cedula,programa_id,usuario)
                VALUES ('$nombre','$p_apellido','$s_apellido','$cedula','$programa_id','$usuario')";
        $this->con->query($new_tutor);

        $this->con->query("UPDATE docente e JOIN programas p
        ON e.programa_id = p.identificador
        SET e.programa = p.nombre");

        // $this->con->query("UPDATE docente e
        // JOIN usuarios u ON e.usuario = u.usuario
        // SET e.id_usuario = u.id");

        mysqli_close($this->con);
        return true;
    }



    public function editUser($nombre,  $usuario, $id)
    {
        $sql = "UPDATE usuarios SET nombre='$nombre',usuario='$usuario' WHERE id = '$id'";
        $this->con->query($sql);
        mysqli_close($this->con);
    }

    public function editEstudiante($id, $nombre, $p_apellido, $s_apellido, $cedula, $programa_id, $semestre)
    {
        $sql = "UPDATE estudiante SET nombre='$nombre', p_apellido='$p_apellido', s_apellido='$s_apellido', cedula='$cedula',
        programa_id='$programa_id',semestre='$semestre',usuario='$cedula' WHERE id = '$id'";
        $this->con->query($sql);

        $sql2 = "UPDATE usuarios SET nombre='$nombre', usuario = '$cedula' WHERE id='$id'";
        $this->con->query($sql2);

        $this->con->query("UPDATE estudiante e
        JOIN programas p ON e.programa_id = p.identificador
        SET e.programa = p.nombre");

        $this->con->query("UPDATE usuarios u JOIN estudiante e
        ON u.id = e.id_usuario
        SET u.usuario = e.cedula");

        if (!$sql) {
            echo '<div id="fail" class="alert alert-danger" role="alert" style="z-index: 9999999999999999; position:absolute; top:2%;left: 50%;transform: translate(-50%, 0%);">
                      No se guardaron los cambios
                  </div>';
            echo "<script>
            setTimeout(function() {
                $('#fail').fadeOut('fast');
            }, 2000); // <-- time in milliseconds
            </script>";
        } else {
            echo '<div id="success" class="alert alert-success" role="alert" style="z-index: 9999999999999999; position:absolute; top:2%; left: 50%; transform: translate(-50%, 0%);">
            Cambios guardados con éxito
            </div>';
            echo "<script>
            setTimeout(function() {
                $('#success').fadeOut('fast');
            }, 2000); // <-- time in milliseconds
        </script>";
        }
        mysqli_close($this->con);
    }

    public function editAsesor($id, $nombre, $p_apellido, $s_apellido, $cedula, $programa_id)
    {
        $sql = "UPDATE docente SET nombres='$nombre', p_apellido='$p_apellido', s_apellido='$s_apellido', cedula='$cedula',
        programa_id='$programa_id',usuario='$cedula' WHERE id = '$id'";
        $this->con->query($sql);

        $this->con->query("UPDATE docente e
        JOIN programas p ON e.programa_id = p.identificador
        SET e.programa = p.nombre");

        $this->con->query("UPDATE usuarios u JOIN docente e
        ON u.id = e.id_usuario
        SET u.usuario = e.cedula");
        if (!$sql) {
            echo '<div id="fail" class="alert alert-danger" role="alert" style="z-index: 9999999999999999; position:absolute; top:2%;left: 50%;transform: translate(-50%, 0%);">
                      No se guardaron los cambios
                  </div>';
            echo "<script>
            setTimeout(function() {
                $('#fail').fadeOut('fast');
            }, 2000); // <-- time in milliseconds
            </script>";
        } else {
            echo '<div id="success" class="alert alert-success" role="alert" style="z-index: 9999999999999999; position:absolute; top:2%; left: 50%; transform: translate(-50%, 0%);">
            Cambios guardados con éxito
            </div>';
            echo "<script>
            setTimeout(function() {
                $('#success').fadeOut('fast');
            }, 2000); // <-- time in milliseconds
        </script>";
        }
        mysqli_close($this->con);
    }
    public function editCoordinador($id, $nombre, $p_apellido, $s_apellido, $cedula, $programa_id)
    {
        $sql = "UPDATE coordinador SET nombre='$nombre', p_apellido='$p_apellido', s_apellido='$s_apellido', cedula='$cedula',
        programa_id='$programa_id',usuario='$cedula' WHERE id = '$id'";
        $this->con->query($sql);

        $this->con->query("UPDATE coordinador e
        JOIN programas p ON e.programa_id = p.identificador
        SET e.programa = p.nombre");

        $this->con->query("UPDATE usuarios u JOIN coordinador e
        ON u.id = e.id_usuario
        SET u.usuario = e.cedula");
        if (!$sql) {
            echo '<div id="fail" class="alert alert-danger" role="alert" style="z-index: 9999999999999999; position:absolute; top:2%;left: 50%;transform: translate(-50%, 0%);">
                      No se guardaron los cambios
                  </div>';
            echo "<script>
            setTimeout(function() {
                $('#fail').fadeOut('fast');
            }, 2000); // <-- time in milliseconds
            </script>";
        } else {
            echo '<div id="success" class="alert alert-success" role="alert" style="z-index: 9999999999999999; position:absolute; top:2%; left: 50%; transform: translate(-50%, 0%);">
            Cambios guardados con éxito
            </div>';
            echo "<script>
            setTimeout(function() {
                $('#success').fadeOut('fast');
            }, 2000); // <-- time in milliseconds
        </script>";
        }
        mysqli_close($this->con);
    }
    /*
        Metodos para obtener datos de los usuarios y roles que iniciaron sesión
    */

    public function getProfileUser()
    {
        $result = $this->con->query("SELECT * FROM usuarios WHERE usuario = " . $_SESSION['usuario']);
        return $result;
    }
    public function getDocenteProfile()
    {
        $resultado = $this->con->query("SELECT * FROM docente WHERE usuario = " . $_SESSION['usuario']);
        return $resultado;
    }



    /* 
        Cerrar sesión
    */

    public function cerrarSesion()
    {
        @session_start();
        session_destroy();
        header("location: ../index.php");
        exit();
    }
}
