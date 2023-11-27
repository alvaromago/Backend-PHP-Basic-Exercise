<?php
require_once "conexion.php";

// Verificar si se recibió el ID del niño a editar
if (isset($_GET["id"])) {
    $idNino = $_GET["id"];

    // Lógica para cargar los datos del niño con el ID proporcionado
    $conexion = Conexion::conectar();
    $sql = "select * from ninos where idNino = $idNino";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows == 1) {
        $nino = $resultado->fetch_assoc();

        // Verificar si se enviaron los datos del formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validar y escapar los datos proporcionados
            $nombre = $conexion->real_escape_string($_POST['nombre']);
            $apellidos = $conexion->real_escape_string($_POST['apellidos']);
            $fechaNacimiento = $conexion->real_escape_string($_POST['fechaNacimiento']);
            $bueno = $conexion->real_escape_string($_POST['bueno']);

            // Query para actualizar los datos del niño
            $sql_update = "update ninos set 
                            nombreNino = '$nombre',
                            apellidosNino = '$apellidos',
                            fechaNacimientoNino = '$fechaNacimiento',
                            buenoNino = '$bueno'
                            where idNino = $idNino";

            if ($conexion->query($sql_update) === TRUE) {
                echo "<p>Niño actualizado exitosamente.</p>";
            } else {
                echo "<p>Error al actualizar el niño: " . $conexion->error . "</p>";
            }
        }
?>

        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Editar Niño</title>
        </head>

        <body>
            <h2>Editar Niño</h2>
            <!-- Formulario HTML para editar los datos del niño -->
            <form action="editarNino.php" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $niño['nombreNino']; ?>" required><br>

                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" value="<?php echo $niño['apellidosNino']; ?>" required><br>

                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="fechaNacimiento" name="fechaNacimiento" value="<?php echo $niño['fechaNacimientoNino']; ?>" required><br>

                <label for="bueno">¿Bueno? (Sí/No):</label>
                <input type="text" id="bueno" name="bueno" value="<?php echo $niño['buenoNino']; ?>" required><br>

                <input type="submit" value="Actualizar Niño">
            </form>
        </body>

        </html>

<?php
    } else {
        echo "<p>Niño no encontrado.</p>";
    }
} else {
    echo "<p>ID de niño no proporcionado.</p>";
}
?>