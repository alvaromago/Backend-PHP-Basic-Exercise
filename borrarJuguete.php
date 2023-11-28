<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Borrar Juguete</title>
</head>

<body class="text-center">
    <?php
    require_once "conexion.php";

    // Verificar si se recibió el ID del juguete a borrar
    if (isset($_GET["id"])) {
        $idJuguete = $_GET["id"];

        // Lógica para borrar el juguete con el ID proporcionado
        $conexion = Conexion::conectar();
        $sql = "delete from juguetes where idJuguete = $idJuguete";

        if ($conexion->query($sql) === TRUE) {
            echo "<h4 class='pt-2'>Juguete borrado exitosamente.</h4>";
        } else {
            echo "<h4>Error al borrar el juguete: " . $conexion->error . "</h4>";
        }
    } else {
        echo "<h4>ID del juguete no proporcionado.</h4>";
    }
    ?>
    <a href="regalos.php" class="btn btn-danger">Volver al menú</a>
</body>

</html>