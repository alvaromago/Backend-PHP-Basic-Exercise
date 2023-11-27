<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Añadir Niño</title>
</head>

<body class="text-center px-0">
    <h1 class="py-3">Añadir un nuevo Niño</h1>
    <?php
    require_once "conexion.php";

    class AddNino
    {
        // Método para agregar un nuevo niño a la base de datos
        public static function agregarNino($nombre, $apellidos, $fechaNacimiento, $bueno)
        {
            $conexion = Conexion::conectar();

            // Escapar y validar los datos proporcionados
            $nombre = $conexion->real_escape_string($nombre);
            $apellidos = $conexion->real_escape_string($apellidos);
            $fechaNacimiento = $conexion->real_escape_string($fechaNacimiento);
            $bueno = $conexion->real_escape_string($bueno);

            // Query para insertar un nuevo niño
            $sql = "insert into ninos (nombreNino, apellidosNino, fechaNacimientoNino, buenoNino) values ('$nombre', '$apellidos', '$fechaNacimiento', '$bueno')";

            if ($conexion->query($sql) === TRUE) {
                echo "<p>Niño añadido exitosamente.</p>";
            } else {
                echo "<p>Error al añadir el niño: " . $conexion->error . "</p>";
            }
        }
    }
    ?>
    <form action="addNino.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" class="my-2" required><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" class="my-2" required><br>

        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="my-2" required><br>

        <label>Bueno: </label>
        <input type="radio" id="Sí" name="bueno" value="Sí">
        <label for="Sí">Sí</label>
        <input type="radio" id="No" name="bueno" value="No">
        <label for="No">No</label><br>

        <input type="submit" value="Añadir Niño" class="my-3 btn btn-success">
        <input type="reset" value="Limpiar" class="my-3 btn btn-warning">
        <a href="ninos.php" class="my-3 btn btn-danger">Cancelar</a>

    </form>
    <?php
    // Verificar si se recibieron los datos del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificar si se enviaron todos los datos necesarios
        if (isset($_POST['nombre']) && isset($_POST['apellidos']) && isset($_POST['fecha_nacimiento']) && isset($_POST['bueno'])) {
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $fechaNacimiento = $_POST['fecha_nacimiento'];
            if ($bueno = $_POST['bueno'] == "Sí") {
                $bueno = 1;
            } else {
                $bueno = 0;
            }

            // Llamar al método para agregar un nuevo niño
            AddNino::agregarNino($nombre, $apellidos, $fechaNacimiento, $bueno);
        } else {
            echo "<p>Todos los campos son obligatorios.</p>";
        }
    }
    ?>
</body>

</html>