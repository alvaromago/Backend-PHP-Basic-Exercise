<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Editar Niño</title>
</head>

<body class="text-center px-0">
    <h1 class="py-3">Editar Niño</h1>
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
    ?>
            <!-- Formulario HTML para editar los datos del niño -->
            <form action="editarNino.php?id=<?php echo $idNino; ?>" method="post">
                <input type="hidden" name="idNino" value="<?php echo $idNino; ?>">

                <label for="nombre">Nombre: </label>
                <input type="text" name="nombre" value="<?php echo $nino['nombreNino'] ?>" class="my-2" required><br>

                <label for="apellidos">Apellidos: </label>
                <input type="text" name="apellidos" value="<?php echo $nino['apellidosNino'] ?>" class="my-2" required><br>

                <label for="fechaNacimiento">Fecha de Nacimiento: </label>
                <input type="date" name="fechaNacimiento" value="<?php echo $nino['fechaNacimientoNino']; ?>" class="my-2" required><br>

                <label for="bueno">Bueno: </label>
                <input type="radio" name="bueno" value="Sí" <?php echo ($nino['buenoNino'] == 'Sí') ? 'checked' : ''; ?> required class="my-2">
                <label>Sí</label>
                <input type="radio" name="bueno" value="No" <?php echo ($nino['buenoNino'] == 'No') ? 'checked' : ''; ?> required class="my-2">
                <label>No</label><br>

                <input type="submit" value="Actualizar Niño" class="btn btn-success">
                <a href="ninos.php" class="my-3 btn btn-danger">Cancelar</a>
            </form>
    <?php
            // Verificar si se enviaron los datos del formulario
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Validar y escapar los datos proporcionados
                $idNino = $conexion->real_escape_string($_POST['idNino']);
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
        } else {
            echo "<p>Niño no encontrado.</p>";
        }
    } else {
        echo "<p>ID de niño no proporcionado.</p>";
    }
    ?>

</body>

</html>