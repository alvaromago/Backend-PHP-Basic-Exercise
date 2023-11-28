<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Borrar Niño</title>
</head>

<body class="text-center">
    <?php
    require_once "conexion.php";

    // Verificar si se recibió el ID del niño a borrar
    if (isset($_GET["id"])) {
        $idNino = $_GET["id"];

        // Lógica para borrar el niño con el ID proporcionado
        $conexion = Conexion::conectar();
        $sql = "delete from ninos where idNino = $idNino";

        if ($conexion->query($sql) === TRUE) {
            echo "<h4 class='pt-2'>Niño borrado exitosamente.</h4>";
        } else {
            echo "<h4>Error al borrar el niño: " . $conexion->error . "</h4>";
        }
    } else {
        echo "<h4>ID de niño no proporcionado.</h4>";
    }
    ?>
    <a href="ninos.php" class="btn btn-danger">Volver al menú</a>
</body>

</html>